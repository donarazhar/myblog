<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animath: Hand Sorcerer - DnrAzhr Blog</title>
    <meta name="description" content="Kuis matematika interaktif dengan gestur tangan menggunakan teknologi MediaPipe AR.">

    <!-- MediaPipe Hands CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils/control_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-color: #0b0c10;
            --text-color: #ffffff;
            --glass-bg: rgba(20, 25, 40, 0.6);
            --glass-border: rgba(255, 255, 255, 0.1);
            --accent: #00ffcc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            overflow: hidden;
            width: 100vw;
            height: 100vh;
        }

        .video-container {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .input_video {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1); /* Mirror */
            filter: brightness(0.3) blur(2px); /* Darken bg so AR elements pop */
        }

        .output_canvas {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 5;
        }

        /* UI Overlays */
        #hud {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 10;
            display: flex;
            flex-direction: column;
            gap: 15px;
            pointer-events: none;
        }

        .panel {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 15px 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            min-width: 180px;
        }

        .stat {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
        }
        .stat:last-child { margin-bottom: 0; }
        .stat span.val { font-weight: bold; color: var(--accent); }

        /* Back to Blog Button */
        .back-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 10;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .back-btn:hover {
            background: rgba(255,255,255,0.2);
            transform: scale(1.05);
        }

        /* Start Overlay */
        #startOverlay {
            position: absolute;
            inset: 0;
            background: rgba(11, 12, 16, 0.9);
            z-index: 100;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(10px);
        }

        #startOverlay h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, #00ffcc, #ff0055);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .instructions {
            max-width: 600px;
            text-align: center;
            margin-bottom: 40px;
            color: #aaa;
            line-height: 1.6;
        }

        .controls-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
            width: 100%;
            max-width: 800px;
        }

        .control-card {
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .control-card h3 { color: var(--accent); margin-bottom: 10px;}

        .start-btn {
            padding: 15px 50px;
            font-size: 1.5rem;
            background: linear-gradient(45deg, #00ffcc, #3333ff);
            border: none;
            color: white;
            border-radius: 40px;
            cursor: pointer;
            font-weight: bold;
            transition: transform 0.2s;
            box-shadow: 0 0 20px rgba(0, 255, 204, 0.4);
        }
        .start-btn:hover { transform: scale(1.05); }

        .hidden { display: none !important; }
    </style>
</head>
<body>

    <div id="startOverlay">
        <h1>Animath: Hand Sorcerer</h1>
        <p class="instructions">Selesaikan kuis matematika menggunakan kekuatan tanganmu! Izinkan akses kamera untuk memulai.</p>
        
        <div class="controls-grid">
            <div class="control-card">
                <h3>👆 Menunjuk</h3>
                <p>Gunakan telunjuk untuk mengarahkan kursor ajaib.</p>
            </div>
            <div class="control-card">
                <h3>🤏 Mencubit</h3>
                <p>Cubit jempol & telunjuk untuk memilih bola jawaban.</p>
            </div>
            <div class="control-card">
                <h3>🖐 Mendorong</h3>
                <p>Dorong telapak tangan terbuka untuk skip soal.</p>
            </div>
        </div>

        <button class="start-btn" id="startBtn">Mulai Petualangan</button>
    </div>

    <div class="video-container">
        <video class="input_video" autoplay playsinline></video>
        <canvas class="output_canvas"></canvas>
    </div>

    <div id="hud" class="hidden">
        <div class="panel">
            <div class="stat">Skor: <span class="val" id="ui-score">0</span></div>
            <div class="stat">Level: <span class="val" id="ui-level">1</span></div>
        </div>
    </div>

    <a href="{{ route('home') }}" class="back-btn hidden" id="backBtn">
        ← Kembali
    </a>

    <!-- Load the JS logic -->
    <script src="{{ asset('js/animath.js') }}"></script>

</body>
</html>
