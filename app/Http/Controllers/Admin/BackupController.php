<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    /**
     * Display backup list from Google Drive.
     */
    public function index()
    {
        $backups = [];
        $error = null;

        try {
            if ($this->isGoogleDriveConfigured()) {
                $files = Storage::disk('google')->files('/');

                foreach ($files as $file) {
                    $backups[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'size' => $this->formatBytes(Storage::disk('google')->size($file)),
                        'date' => date('Y-m-d H:i:s', Storage::disk('google')->lastModified($file)),
                    ];
                }

                // Sort by date descending
                usort($backups, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));
            } else {
                $error = 'Google Drive belum dikonfigurasi. Silakan tambahkan credentials di file .env';
            }
        } catch (\Exception $e) {
            Log::error('Backup list error: ' . $e->getMessage());
            $error = 'Gagal mengambil daftar backup: ' . $e->getMessage();
        }

        return view('admin.backups.index', compact('backups', 'error'));
    }

    /**
     * Create a new backup and upload to Google Drive.
     */
    public function create()
    {
        try {
            if (!$this->isGoogleDriveConfigured()) {
                return back()->with('error', 'Google Drive belum dikonfigurasi.');
            }

            $timestamp = now()->format('Y-m-d_H-i-s');
            $filename = "backup_{$timestamp}.sql";
            $tempPath = storage_path("app/private/{$filename}");

            // Dump database
            $this->dumpDatabase($tempPath);

            if (!file_exists($tempPath) || filesize($tempPath) === 0) {
                return back()->with('error', 'Gagal membuat backup database.');
            }

            // Upload to Google Drive
            Storage::disk('google')->put($filename, file_get_contents($tempPath));

            // Clean up local temp file
            @unlink($tempPath);

            return back()->with('success', "Backup '{$filename}' berhasil dibuat dan diupload ke Google Drive!");
        } catch (\Exception $e) {
            Log::error('Backup create error: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    /**
     * Download a backup file from Google Drive.
     */
    public function download($filename)
    {
        try {
            if (!Storage::disk('google')->exists($filename)) {
                return back()->with('error', 'File backup tidak ditemukan.');
            }

            $content = Storage::disk('google')->get($filename);
            $mimeType = 'application/sql';

            return response($content)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (\Exception $e) {
            Log::error('Backup download error: ' . $e->getMessage());
            return back()->with('error', 'Gagal download backup: ' . $e->getMessage());
        }
    }

    /**
     * Delete a backup file from Google Drive.
     */
    public function destroy($filename)
    {
        try {
            if (!Storage::disk('google')->exists($filename)) {
                return back()->with('error', 'File backup tidak ditemukan.');
            }

            Storage::disk('google')->delete($filename);
            return back()->with('success', "Backup '{$filename}' berhasil dihapus.");
        } catch (\Exception $e) {
            Log::error('Backup delete error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus backup: ' . $e->getMessage());
        }
    }

    /**
     * Dump the database to a file.
     */
    private function dumpDatabase(string $path): void
    {
        $connection = config('database.default');
        $config = config("database.connections.{$connection}");

        $host = $config['host'];
        $port = $config['port'] ?? 3306;
        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];

        // Try to find mysqldump
        $mysqldump = $this->findMysqldump();

        if ($mysqldump) {
            // Use mysqldump binary
            $command = sprintf(
                '"%s" --host=%s --port=%s --user=%s --password=%s %s > "%s"',
                $mysqldump,
                escapeshellarg($host),
                $port,
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($database),
                $path
            );

            exec($command . ' 2>&1', $output, $returnVar);

            if ($returnVar !== 0) {
                // Fallback to PHP-based dump
                $this->phpDumpDatabase($path, $config);
            }
        } else {
            // Use PHP-based dump
            $this->phpDumpDatabase($path, $config);
        }
    }

    /**
     * PHP-based database dump (fallback when mysqldump is not available).
     */
    private function phpDumpDatabase(string $path, array $config): void
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = $config['database'];
        $key = "Tables_in_{$dbName}";

        $sql = "-- Database Backup\n";
        $sql .= "-- Generated: " . now()->toDateTimeString() . "\n";
        $sql .= "-- Database: {$dbName}\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$key;

            // Get CREATE TABLE statement
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createTable[0]->{'Create Table'} . ";\n\n";

            // Get table data
            $rows = DB::table($tableName)->get();
            if ($rows->count() > 0) {
                $columns = array_keys((array) $rows->first());
                $columnList = implode('`, `', $columns);

                foreach ($rows as $row) {
                    $values = array_map(function ($value) {
                        if (is_null($value)) return 'NULL';
                        return "'" . addslashes($value) . "'";
                    }, (array) $row);

                    $sql .= "INSERT INTO `{$tableName}` (`{$columnList}`) VALUES (" . implode(', ', $values) . ");\n";
                }
                $sql .= "\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        file_put_contents($path, $sql);
    }

    /**
     * Try to find mysqldump binary.
     */
    private function findMysqldump(): ?string
    {
        $paths = [
            'mysqldump',
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
            '/usr/local/mysql/bin/mysqldump',
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe',
        ];

        foreach ($paths as $path) {
            if (PHP_OS_FAMILY === 'Windows') {
                exec("where \"{$path}\" 2>NUL", $output, $returnVar);
            } else {
                exec("which \"{$path}\" 2>/dev/null", $output, $returnVar);
            }
            if ($returnVar === 0) return $path;
        }

        return null;
    }

    /**
     * Check if Google Drive is configured.
     */
    private function isGoogleDriveConfigured(): bool
    {
        return !empty(config('filesystems.disks.google.clientId'))
            && !empty(config('filesystems.disks.google.clientSecret'))
            && !empty(config('filesystems.disks.google.refreshToken'));
    }

    /**
     * Format bytes to human readable format.
     */
    private function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
