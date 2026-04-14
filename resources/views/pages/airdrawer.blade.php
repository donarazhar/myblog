<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Neon Air Draw - AI Powered</title>
    <meta name="description" content="Draw in the air with hand gestures using AI-powered hand tracking. Neon glow drawing, erase, move, scale and rotate strokes.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- MediaPipe Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils/control_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: #0f172a;
            font-family: 'Outfit', sans-serif;
            -webkit-font-smoothing: antialiased;
            color: white;
            overflow: hidden;
            touch-action: none;
            width: 100vw;
            height: 100vh;
        }

        .font-mono { font-family: 'JetBrains Mono', monospace; }

        /* Camera */
        #camera-container {
            position: fixed; inset: 0;
            z-index: -1; background: #000;
        }
        #webcam {
            width: 100%; height: 100%;
            object-fit: cover;
            transform: scaleX(-1);
        }

        /* Drawing Canvas */
        #drawCanvas {
            position: fixed; inset: 0;
            z-index: 10;
            pointer-events: none;
        }

        /* Glass Panel */
        .glass-meta {
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.01) 100%);
            backdrop-filter: blur(24px) saturate(150%);
            -webkit-backdrop-filter: blur(24px) saturate(150%);
            border-top: 1px solid rgba(255,255,255,0.2);
            border-left: 1px solid rgba(255,255,255,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            border-right: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 12px 40px 0 rgba(0,0,0,0.5), inset 0 0 0 1px rgba(255,255,255,0.05);
        }

        /* Control Panel */
        #controlPanel {
            position: fixed; right: 24px; top: 24px;
            z-index: 100;
            display: flex; flex-direction: column;
            gap: 12px; align-items: flex-end;
        }

        .toggle-btn {
            width: 48px; height: 48px;
            border-radius: 16px;
            display: flex; justify-content: center; align-items: center;
            cursor: pointer; border: none; color: white;
            transition: transform 0.15s;
        }
        .toggle-btn:hover { transform: scale(1.05); }
        .toggle-btn:active { transform: scale(0.95); }

        #settingsPanel {
            border-radius: 24px; padding: 24px;
            width: 280px; color: #fff;
            display: flex; flex-direction: column; gap: 20px;
            transition: opacity 0.3s, transform 0.3s;
        }
        #settingsPanel.hidden {
            opacity: 0; transform: translateX(20px) scale(0.95);
            pointer-events: none;
        }

        .section-label {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 10px; font-size: 14px;
            font-weight: 600; color: rgba(255,255,255,0.7);
        }

        /* Color Swatches */
        .color-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; }
        .color-swatch {
            width: 32px; height: 32px; border-radius: 8px;
            cursor: pointer; border: 2px solid transparent;
            transition: transform 0.15s, border-color 0.15s, box-shadow 0.15s;
        }
        .color-swatch:hover { transform: scale(1.2); }
        .color-swatch.active { border-color: #fff; }

        /* Sliders */
        .slider-group { display: flex; flex-direction: column; gap: 4px; }
        .slider-label {
            font-size: 12px; color: rgba(255,255,255,0.5);
        }
        input[type=range] {
            -webkit-appearance: none; appearance: none;
            width: 100%; height: 4px;
            background: rgba(255,255,255,0.1);
            border-radius: 2px; outline: none; margin: 8px 0;
        }
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none; appearance: none;
            width: 16px; height: 16px;
            background: #fff; border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(255,255,255,0.5);
        }

        /* Action Buttons */
        .action-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .action-btn {
            border-radius: 12px; padding: 10px;
            color: #fff; display: flex; flex-direction: column;
            align-items: center; gap: 4px; cursor: pointer;
            font-size: 10px; border: none;
            transition: transform 0.15s;
        }
        .action-btn:hover { transform: scale(1.05); }
        .action-btn:active { transform: scale(0.95); }

        /* Back Button */
        .back-btn {
            position: fixed; top: 24px; left: 24px;
            z-index: 100;
            border-radius: 16px; padding: 12px 20px;
            color: white; text-decoration: none;
            font-size: 13px; font-weight: 500;
            display: flex; align-items: center; gap: 8px;
            transition: transform 0.2s;
            border: none;
        }
        .back-btn:hover { transform: scale(1.05); }

        /* Gesture Status */
        #gestureStatus {
            position: fixed; bottom: 40px; left: 50%;
            transform: translateX(-50%);
            padding: 12px 24px; border-radius: 999px;
            color: #fff; font-weight: 700;
            font-size: 14px; letter-spacing: 2px;
            text-transform: uppercase; z-index: 50;
            transition: opacity 0.3s;
            pointer-events: none;
        }
        #gestureStatus.hidden { opacity: 0; }

        /* Overlay Message */
        #overlayMessage {
            position: fixed; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            color: rgba(255,255,255,0.5);
            font-size: 24px; font-weight: 300;
            letter-spacing: 1px; text-align: center;
            pointer-events: none; z-index: 5;
            transition: opacity 0.5s;
        }
        #overlayMessage.hidden { opacity: 0; }

        /* Fingertip Indicators */
        .fingertip {
            position: fixed; border-radius: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none; z-index: 40;
            transition: width 0.1s, height 0.1s;
        }

        /* Help Panel */
        #helpOverlay {
            position: fixed; inset: 0; z-index: 200;
            display: flex; align-items: center; justify-content: center;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(8px);
            transition: opacity 0.3s;
        }
        #helpOverlay.hidden { opacity: 0; pointer-events: none; }
        #helpContent {
            width: 380px; max-height: 80vh; overflow-y: auto;
            border-radius: 20px; padding: 24px; color: #fff;
        }
        .help-section-title {
            font-size: 11px; font-weight: 600;
            color: rgba(255,255,255,0.45);
            text-transform: uppercase; letter-spacing: 0.1em;
            margin-bottom: 8px;
        }
        .help-item {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px; border-radius: 10px;
            margin-bottom: 4px;
            background: rgba(255,255,255,0.04);
        }
        .help-emoji { font-size: 20px; width: 28px; text-align: center; }
        .help-gesture { font-size: 13px; font-weight: 600; }
        .help-action { font-size: 11px; color: rgba(255,255,255,0.5); }

        /* SVG Icons inline */
        .icon { width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .icon-sm { width: 16px; height: 16px; }
    </style>
</head>
<body>

    <!-- Camera -->
    <div id="camera-container">
        <video id="webcam" autoplay playsinline muted></video>
    </div>

    <!-- Drawing Canvas -->
    <canvas id="drawCanvas"></canvas>

    <!-- Fingertip Indicators (created dynamically) -->
    <div id="fingertips-container"></div>

    <!-- Back to Blog -->
    <a href="{{ route('home') }}" class="back-btn glass-meta">← Back to Blog</a>

    <!-- Control Panel -->
    <div id="controlPanel">
        <button class="toggle-btn glass-meta" id="toggleSettings" title="Settings">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
        </button>

        <div id="settingsPanel" class="glass-meta">
            <!-- Color Palette -->
            <div>
                <div class="section-label">
                    <svg class="icon icon-sm" viewBox="0 0 24 24"><circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/><circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12" r=".5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
                    Color Palette
                </div>
                <div class="color-grid" id="colorGrid"></div>
            </div>

            <!-- Sliders -->
            <div style="display:flex;flex-direction:column;gap:16px">
                <div class="slider-group">
                    <label class="slider-label">Brush Thickness: <span id="thicknessVal">8</span>px</label>
                    <input type="range" id="thicknessSlider" min="1" max="50" value="8">
                </div>
                <div class="slider-group">
                    <label class="slider-label">Glow Intensity: <span id="glowVal">20</span></label>
                    <input type="range" id="glowSlider" min="0" max="50" value="20">
                </div>
            </div>

            <!-- Actions -->
            <div class="action-grid">
                <button class="action-btn glass-meta" id="btnUndo">
                    <svg class="icon" viewBox="0 0 24 24"><path d="M3 7v6h6"/><path d="M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13"/></svg>
                    Undo
                </button>
                <button class="action-btn glass-meta" id="btnRedo">
                    <svg class="icon" viewBox="0 0 24 24"><path d="M21 7v6h-6"/><path d="M3 17a9 9 0 0 1 9-9 9 9 0 0 1 6 2.3L21 13"/></svg>
                    Redo
                </button>
                <button class="action-btn glass-meta" id="btnClear">
                    <svg class="icon" viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    Clear
                </button>
                <button class="action-btn glass-meta" id="btnSave">
                    <svg class="icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Save
                </button>
                <button class="action-btn glass-meta" id="btnToggleCam">
                    <svg class="icon" viewBox="0 0 24 24" id="camIcon"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    <span id="camLabel">Hide Cam</span>
                </button>
                <button class="action-btn glass-meta" id="btnToggleGestures">
                    <svg class="icon" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    <span id="gestureLabel">Gestures On</span>
                </button>
                <button class="action-btn glass-meta" id="btnHelp">
                    <svg class="icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Help
                </button>
            </div>
        </div>
    </div>

    <!-- Gesture Status -->
    <div id="gestureStatus" class="glass-meta hidden"></div>

    <!-- Overlay Message -->
    <div id="overlayMessage">👋 Raise your hand to start drawing</div>

    <!-- Help Panel -->
    <div id="helpOverlay" class="hidden">
        <div id="helpContent" class="glass-meta">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
                <div style="display:flex;align-items:center;gap:8px">
                    <svg class="icon" viewBox="0 0 24 24" style="color:#00ffff"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <span style="font-size:16px;font-weight:700;letter-spacing:0.05em">Gesture Guide</span>
                </div>
                <button id="closeHelp" style="background:none;border:none;color:rgba(255,255,255,0.6);cursor:pointer;padding:4px;display:flex">
                    <svg class="icon" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <!-- Right Hand -->
            <div style="margin-bottom:16px">
                <div class="help-section-title">Right Hand (Draw)</div>
                <div class="help-item"><span class="help-emoji">☝️</span><div><div class="help-gesture">Index finger up</div><div class="help-action">Draw strokes</div></div></div>
                <div class="help-item"><span class="help-emoji">🤏</span><div><div class="help-gesture">Pinch (thumb + index)</div><div class="help-action">Erase nearby strokes</div></div></div>
                <div class="help-item"><span class="help-emoji">✊</span><div><div class="help-gesture">Fist</div><div class="help-action">Clear all</div></div></div>
            </div>

            <!-- Left Hand -->
            <div style="margin-bottom:16px">
                <div class="help-section-title">Left Hand (Control)</div>
                <div class="help-item"><span class="help-emoji">✌️</span><div><div class="help-gesture">Two fingers up</div><div class="help-action">Select & Move stroke</div></div></div>
                <div class="help-item"><span class="help-emoji">🤏</span><div><div class="help-gesture">Pinch + spread/close</div><div class="help-action">Scale stroke</div></div></div>
                <div class="help-item"><span class="help-emoji">🖐️</span><div><div class="help-gesture">Open palm + twist</div><div class="help-action">Rotate stroke</div></div></div>
            </div>

            <!-- Tips -->
            <div>
                <div class="help-section-title">Tips</div>
                <div class="help-item"><span class="help-emoji">💡</span><div><div class="help-gesture">One hand only</div><div class="help-action">Auto-assigned as draw hand</div></div></div>
                <div class="help-item"><span class="help-emoji">📐</span><div><div class="help-gesture">Release rotate</div><div class="help-action">Snaps to nearest 45°</div></div></div>
                <div class="help-item"><span class="help-emoji">🌀</span><div><div class="help-gesture">Release move</div><div class="help-action">Slight inertia drift</div></div></div>
            </div>
        </div>
    </div>

<script>
(function() {
    'use strict';

    // ============================================================
    // SETTINGS
    // ============================================================
    const settings = { color: '#00ffff', lineWidth: 8, glowIntensity: 20 };
    const COLORS = ['#00ffff', '#ff00ff', '#ffff00', '#00ff00', '#ff0000', '#ffffff'];

    // ============================================================
    // DOM ELEMENTS
    // ============================================================
    const webcam = document.getElementById('webcam');
    const drawCanvas = document.getElementById('drawCanvas');
    const ctx = drawCanvas.getContext('2d');
    const cameraContainer = document.getElementById('camera-container');
    const gestureStatus = document.getElementById('gestureStatus');
    const overlayMessage = document.getElementById('overlayMessage');
    const colorGrid = document.getElementById('colorGrid');
    const thicknessSlider = document.getElementById('thicknessSlider');
    const glowSlider = document.getElementById('glowSlider');
    const thicknessVal = document.getElementById('thicknessVal');
    const glowVal = document.getElementById('glowVal');

    // ============================================================
    // STROKE MANAGER
    // ============================================================
    class StrokeManager {
        constructor() { this.strokes = []; this.redoStack = []; this._nextId = 1; }

        addStroke(points, color, lineWidth, glowIntensity) {
            const s = { id: this._nextId++, points: [...points], color, lineWidth, glowIntensity, transform: { tx: 0, ty: 0, scale: 1, rotation: 0 } };
            this.strokes.push(s); this.redoStack = []; return s;
        }
        removeStroke(id) { this.strokes = this.strokes.filter(s => s.id !== id); }
        undo() { if (this.strokes.length > 0) this.redoStack.push(this.strokes.pop()); }
        redo() { if (this.redoStack.length > 0) this.strokes.push(this.redoStack.pop()); }
        clear() { this.strokes = []; this.redoStack = []; }
        getAllStrokes() { return this.strokes; }
        getStroke(id) { return this.strokes.find(s => s.id === id); }
        moveStroke(id, dx, dy) { const s = this.getStroke(id); if (!s) return; for (const p of s.points) { p.x += dx; p.y += dy; } }

        findIntersecting(x, y, radius) {
            const hits = [];
            for (const s of this.strokes) {
                for (let i = 0; i < s.points.length - 1; i++) {
                    if (distToSeg(x, y, s.points[i].x, s.points[i].y, s.points[i+1].x, s.points[i+1].y) <= radius + s.lineWidth/2) { hits.push(s.id); break; }
                }
                if (s.points.length === 1) { const dx = x-s.points[0].x, dy = y-s.points[0].y; if (Math.sqrt(dx*dx+dy*dy) <= radius + s.lineWidth/2) hits.push(s.id); }
            }
            return hits;
        }

        findNearest(x, y, threshold) {
            let nearId = null, minD = threshold;
            for (const s of this.strokes) {
                const pts = s.transform ? getTransformedPoints(s) : s.points;
                for (let i = 0; i < pts.length - 1; i++) { const d = distToSeg(x, y, pts[i].x, pts[i].y, pts[i+1].x, pts[i+1].y); if (d < minD) { minD = d; nearId = s.id; } }
                if (pts.length === 1) { const d = Math.sqrt((x-pts[0].x)**2 + (y-pts[0].y)**2); if (d < minD) { minD = d; nearId = s.id; } }
            }
            return nearId;
        }
    }

    function distToSeg(px, py, x1, y1, x2, y2) {
        const dx = x2-x1, dy = y2-y1;
        if (dx === 0 && dy === 0) return Math.sqrt((px-x1)**2 + (py-y1)**2);
        const t = Math.max(0, Math.min(1, ((px-x1)*dx + (py-y1)*dy) / (dx*dx+dy*dy)));
        const nx = x1+t*dx, ny = y1+t*dy;
        return Math.sqrt((px-nx)**2 + (py-ny)**2);
    }

    function getTransformedPoints(stroke) {
        const { tx, ty, scale, rotation } = stroke.transform;
        let cx = 0, cy = 0;
        for (const p of stroke.points) { cx += p.x; cy += p.y; }
        cx /= stroke.points.length; cy /= stroke.points.length;
        return stroke.points.map(p => {
            let x = (p.x - cx) * scale, y = (p.y - cy) * scale;
            const cos = Math.cos(rotation), sin = Math.sin(rotation);
            return { x: x*cos - y*sin + cx + tx, y: x*sin + y*cos + cy + ty };
        });
    }

    // ============================================================
    // TRANSFORM ENGINE
    // ============================================================
    class TransformEngine {
        constructor(sm) {
            this.sm = sm; this.selectedId = null;
            this.lastX = null; this.lastY = null;
            this.vx = 0; this.vy = 0; this.inertiaActive = false; this._frame = null;
        }
        selectNearest(x, y) {
            if (this.selectedId !== null) return;
            this.selectedId = this.sm.findNearest(x, y, 60);
            if (this.selectedId !== null) { this.lastX = x; this.lastY = y; this._stopInertia(); }
        }
        getSelectedId() { return this.selectedId; }
        handleMove(x, y) {
            if (this.selectedId === null) { this.selectNearest(x, y); return; }
            const s = this.sm.getStroke(this.selectedId); if (!s) return;
            if (this.lastX !== null) { const dx = x-this.lastX, dy = y-this.lastY; s.transform.tx += dx; s.transform.ty += dy; this.vx = dx; this.vy = dy; }
            this.lastX = x; this.lastY = y;
        }
        handleScale(delta) {
            if (this.selectedId === null) return;
            const s = this.sm.getStroke(this.selectedId); if (!s) return;
            s.transform.scale = Math.max(0.1, Math.min(5, s.transform.scale * (1 + delta * 8)));
        }
        handleRotate(delta) {
            if (this.selectedId === null) return;
            const s = this.sm.getStroke(this.selectedId); if (!s) return;
            s.transform.rotation += delta;
        }
        releaseAll() {
            if (this.selectedId !== null) {
                const s = this.sm.getStroke(this.selectedId);
                if (s) { const snap = Math.PI/4; s.transform.rotation = Math.round(s.transform.rotation / snap) * snap; }
                if (Math.abs(this.vx) > 0.5 || Math.abs(this.vy) > 0.5) this._startInertia();
            }
            this.selectedId = null; this.lastX = null; this.lastY = null;
        }
        _startInertia() {
            const id = this.selectedId; this.inertiaActive = true;
            const tick = () => {
                const s = this.sm.getStroke(id);
                if (!s || !this.inertiaActive) { this.inertiaActive = false; return; }
                this.vx *= 0.92; this.vy *= 0.92;
                s.transform.tx += this.vx; s.transform.ty += this.vy;
                if (Math.abs(this.vx) < 0.1 && Math.abs(this.vy) < 0.1) { this.inertiaActive = false; return; }
                this._frame = requestAnimationFrame(tick);
            };
            this._frame = requestAnimationFrame(tick);
        }
        _stopInertia() { this.inertiaActive = false; if (this._frame) { cancelAnimationFrame(this._frame); this._frame = null; } this.vx = 0; this.vy = 0; }
    }

    // ============================================================
    // GESTURE DETECTION
    // ============================================================
    const GESTURES = { IDLE: 'IDLE', DRAW: 'DRAW', ERASE: 'ERASE', CLEAR: 'CLEAR', MOVE: 'MOVE' };
    const CTRL = { IDLE: 'CTRL_IDLE', MOVE: 'CTRL_MOVE', SCALE: 'CTRL_SCALE', ROTATE: 'CTRL_ROTATE' };

    function isFingerUp(lm, fi) { return lm[fi*4+4].y < lm[fi*4+2].y; }

    // --- Gesture debounce: prevents flickering between DRAW/IDLE/ERASE ---
    let _lastPrimaryGesture = GESTURES.IDLE;
    let _primaryGestureCandidate = GESTURES.IDLE;
    let _primaryGestureCount = 0;
    const PRIMARY_DEBOUNCE_FRAMES = 3; // Need 3 consecutive frames to change gesture

    function detectPrimaryRaw(lm) {
        if (!lm) return GESTURES.IDLE;
        const d = Math.sqrt((lm[4].x-lm[8].x)**2 + (lm[4].y-lm[8].y)**2);
        if (d < 0.05) return GESTURES.ERASE;
        const idx = isFingerUp(lm,1), mid = isFingerUp(lm,2), ring = isFingerUp(lm,3), pinky = isFingerUp(lm,4), thumb = isFingerUp(lm,0);
        if (!idx && !mid && !ring && !pinky && !thumb) return GESTURES.CLEAR;
        if (idx && mid && !ring && !pinky) return GESTURES.MOVE;
        if (idx && !mid && !ring && !pinky) return GESTURES.DRAW;
        return GESTURES.IDLE;
    }

    function detectPrimary(lm) {
        const raw = detectPrimaryRaw(lm);
        if (raw === _primaryGestureCandidate) {
            _primaryGestureCount++;
        } else {
            _primaryGestureCandidate = raw;
            _primaryGestureCount = 1;
        }
        // Only switch gesture after enough consecutive frames confirm it
        // Exception: switching FROM DRAW to IDLE needs more frames (prevents accidental drops)
        const threshold = (_lastPrimaryGesture === GESTURES.DRAW && raw === GESTURES.IDLE) ? 5 : PRIMARY_DEBOUNCE_FRAMES;
        if (_primaryGestureCount >= threshold) {
            _lastPrimaryGesture = raw;
        }
        return _lastPrimaryGesture;
    }

    let lastPinchDist = null, lastHandAngle = null;
    let _lastCtrl = CTRL.IDLE, _idleCount = 0;

    function detectSecondary(lm) {
        const result = { gesture: CTRL.IDLE, pinchDelta: 0, angleDelta: 0 };
        if (!lm) { lastPinchDist = null; lastHandAngle = null; return result; }

        const idx = isFingerUp(lm,1), mid = isFingerUp(lm,2), ring = isFingerUp(lm,3), pinky = isFingerUp(lm,4);
        const pDist = Math.sqrt((lm[4].x-lm[8].x)**2 + (lm[4].y-lm[8].y)**2);
        const hAngle = Math.atan2(lm[9].y-lm[0].y, lm[9].x-lm[0].x);

        if (pDist < 0.06) {
            result.gesture = CTRL.SCALE;
            if (lastPinchDist !== null) result.pinchDelta = pDist - lastPinchDist;
            lastPinchDist = pDist; lastHandAngle = null; return smoothCtrl(result);
        }
        lastPinchDist = null;

        if (idx && mid && ring && pinky) {
            result.gesture = CTRL.ROTATE;
            if (lastHandAngle !== null) { result.angleDelta = hAngle - lastHandAngle; if (Math.abs(result.angleDelta) > Math.PI) result.angleDelta = 0; }
            lastHandAngle = hAngle; return smoothCtrl(result);
        }
        lastHandAngle = null;

        if (idx && mid && !ring && !pinky) { result.gesture = CTRL.MOVE; return smoothCtrl(result); }
        return smoothCtrl(result);
    }

    function smoothCtrl(r) {
        if (r.gesture === CTRL.IDLE) { _idleCount++; if (_idleCount < 4 && _lastCtrl !== CTRL.IDLE) r.gesture = _lastCtrl; else _lastCtrl = CTRL.IDLE; }
        else { _idleCount = 0; _lastCtrl = r.gesture; }
        return r;
    }

    // ============================================================
    // INIT
    // ============================================================
    const sm = new StrokeManager();
    const te = new TransformEngine(sm);
    let currentPath = null, lastPt = null;
    let cameraVisible = true, gesturesEnabled = true;
    let currentGesture = GESTURES.IDLE, currentCtrlGesture = CTRL.IDLE;
    let primaryLandmark = null, controlLandmark = null;
    let primaryTips = [], controlTips = [];

    // --- Position smoothing buffer (Exponential Moving Average) ---
    // Reduces hand-tracking jitter for much smoother drawing
    let smoothedX = null, smoothedY = null;
    const EMA_ALPHA = 0.4; // Lower = smoother but more lag. 0.4 is a good balance.
    const MIN_DRAW_DISTANCE = 3; // Minimum pixel distance to add a new point

    function resize() { drawCanvas.width = window.innerWidth; drawCanvas.height = window.innerHeight; }
    resize(); window.addEventListener('resize', resize);

    // ============================================================
    // COLOR GRID
    // ============================================================
    COLORS.forEach(c => {
        const el = document.createElement('div');
        el.className = 'color-swatch' + (c === settings.color ? ' active' : '');
        el.style.backgroundColor = c;
        if (c === settings.color) el.style.boxShadow = `0 0 15px ${c}`;
        el.onclick = () => {
            settings.color = c;
            document.querySelectorAll('.color-swatch').forEach(s => { s.classList.remove('active'); s.style.boxShadow = 'none'; });
            el.classList.add('active'); el.style.boxShadow = `0 0 15px ${c}`;
        };
        colorGrid.appendChild(el);
    });

    // ============================================================
    // UI EVENTS
    // ============================================================
    thicknessSlider.oninput = () => { settings.lineWidth = parseInt(thicknessSlider.value); thicknessVal.textContent = settings.lineWidth; };
    glowSlider.oninput = () => { settings.glowIntensity = parseInt(glowSlider.value); glowVal.textContent = settings.glowIntensity; };

    document.getElementById('toggleSettings').onclick = () => { document.getElementById('settingsPanel').classList.toggle('hidden'); };
    document.getElementById('btnUndo').onclick = () => sm.undo();
    document.getElementById('btnRedo').onclick = () => sm.redo();
    document.getElementById('btnClear').onclick = () => sm.clear();
    document.getElementById('btnSave').onclick = () => {
        const url = drawCanvas.toDataURL('image/png');
        const a = document.createElement('a'); a.href = url; a.download = `air-drawing-${Date.now()}.png`; a.click();
    };
    document.getElementById('btnToggleCam').onclick = () => {
        cameraVisible = !cameraVisible;
        cameraContainer.style.display = cameraVisible ? 'block' : 'none';
        document.getElementById('camLabel').textContent = cameraVisible ? 'Hide Cam' : 'Show Cam';
    };
    document.getElementById('btnToggleGestures').onclick = () => {
        gesturesEnabled = !gesturesEnabled;
        document.getElementById('gestureLabel').textContent = gesturesEnabled ? 'Gestures On' : 'Gestures Off';
    };
    document.getElementById('btnHelp').onclick = () => document.getElementById('helpOverlay').classList.remove('hidden');
    document.getElementById('closeHelp').onclick = () => document.getElementById('helpOverlay').classList.add('hidden');
    document.getElementById('helpOverlay').onclick = (e) => { if (e.target === document.getElementById('helpOverlay')) document.getElementById('helpOverlay').classList.add('hidden'); };

    // ============================================================
    // SAVE CURRENT PATH
    // ============================================================
    function saveCurrentPath() {
        if (currentPath) { sm.addStroke(currentPath.points, currentPath.color, currentPath.lineWidth, currentPath.glowIntensity); currentPath = null; lastPt = null; }
    }

    // ============================================================
    // MEDIAPIPE HAND TRACKING
    // ============================================================
    function onResults(results) {
        if (!gesturesEnabled) {
            currentGesture = GESTURES.IDLE; primaryLandmark = null; primaryTips = [];
            currentCtrlGesture = CTRL.IDLE; controlLandmark = null; controlTips = [];
            return;
        }

        let pLm = null, sLm = null;
        if (results.multiHandLandmarks && results.multiHandLandmarks.length === 1) {
            pLm = results.multiHandLandmarks[0];
        } else if (results.multiHandLandmarks && results.multiHandLandmarks.length >= 2) {
            let pIdx = 0, sIdx = 1;
            const h = results.multiHandedness || [];
            if (h.length >= 2 && (h[0]?.label || '') === 'Right') { pIdx = 1; sIdx = 0; }
            pLm = results.multiHandLandmarks[pIdx];
            sLm = results.multiHandLandmarks[sIdx];
        }

        // Primary
        if (pLm) {
            currentGesture = detectPrimary(pLm);
            primaryLandmark = pLm[8];
            primaryTips = [4,8,12,16,20].map(i => pLm[i]);
        } else { currentGesture = GESTURES.IDLE; primaryLandmark = null; primaryTips = []; }

        // Secondary
        if (sLm) {
            const r = detectSecondary(sLm);
            currentCtrlGesture = r.gesture;
            controlLandmark = sLm[8];
            controlTips = [4,8,12,16,20].map(i => sLm[i]);
            processControl(r);
        } else {
            currentCtrlGesture = CTRL.IDLE; controlLandmark = null; controlTips = [];
            lastPinchDist = null; lastHandAngle = null; _lastCtrl = CTRL.IDLE; _idleCount = 0;
            te.releaseAll();
        }

        // Process primary gesture
        if (primaryLandmark) {
            const x = (1 - primaryLandmark.x) * drawCanvas.width;
            const y = primaryLandmark.y * drawCanvas.height;
            processPrimary(x, y);
        } else { saveCurrentPath(); }
    }

    function processPrimary(rawX, rawY) {
        // Apply EMA smoothing to raw hand position to reduce jitter
        if (smoothedX === null) { smoothedX = rawX; smoothedY = rawY; }
        else { smoothedX = smoothedX * (1 - EMA_ALPHA) + rawX * EMA_ALPHA; smoothedY = smoothedY * (1 - EMA_ALPHA) + rawY * EMA_ALPHA; }
        const x = smoothedX, y = smoothedY;

        switch (currentGesture) {
            case 'DRAW':
                if (!currentPath) {
                    currentPath = { points: [{x,y}], color: settings.color, lineWidth: settings.lineWidth, glowIntensity: settings.glowIntensity };
                    lastPt = {x,y};
                } else {
                    // Only add point if finger moved enough (reduces noise)
                    const dx = x - lastPt.x, dy = y - lastPt.y;
                    const dist = Math.sqrt(dx*dx + dy*dy);
                    if (dist >= MIN_DRAW_DISTANCE) {
                        currentPath.points.push({x, y});
                        lastPt = {x, y};
                    }
                }
                break;
            case 'ERASE':
                saveCurrentPath();
                smoothedX = null; smoothedY = null;
                const hits = sm.findIntersecting(rawX, rawY, 30);
                hits.forEach(id => sm.removeStroke(id));
                break;
            case 'CLEAR':
                saveCurrentPath();
                smoothedX = null; smoothedY = null;
                sm.clear();
                break;
            default:
                saveCurrentPath();
                smoothedX = null; smoothedY = null;
                break;
        }
    }

    function processControl(r) {
        if (!controlLandmark) { te.releaseAll(); return; }
        const x = (1 - controlLandmark.x) * drawCanvas.width;
        const y = controlLandmark.y * drawCanvas.height;
        switch (r.gesture) {
            case CTRL.MOVE: te.handleMove(x, y); break;
            case CTRL.SCALE: te.selectNearest(x, y); te.handleScale(r.pinchDelta); break;
            case CTRL.ROTATE: te.selectNearest(x, y); te.handleRotate(r.angleDelta); break;
            default: te.releaseAll(); break;
        }
    }

    // ============================================================
    // RENDER LOOP
    // ============================================================
    function renderLoop() {
        ctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
        const selectedId = te.getSelectedId();
        const allStrokes = [...sm.getAllStrokes()];
        if (currentPath) allStrokes.push(currentPath);

        allStrokes.forEach(stroke => {
            if (!stroke.points || stroke.points.length === 0) return;
            const pts = stroke.transform ? getTransformedPoints(stroke) : stroke.points;
            if (pts.length < 1) return;
            const isSel = selectedId !== null && stroke.id === selectedId;

            ctx.save();
            if (pts.length === 1) {
                ctx.beginPath(); ctx.arc(pts[0].x, pts[0].y, stroke.lineWidth/2, 0, Math.PI*2);
                ctx.fillStyle = isSel ? '#fff' : stroke.color; ctx.fill(); ctx.restore(); return;
            }
            // Use quadratic curves for smooth rendering instead of jagged lineTo
            ctx.beginPath(); ctx.moveTo(pts[0].x, pts[0].y);
            if (pts.length === 2) {
                ctx.lineTo(pts[1].x, pts[1].y);
            } else {
                for (let i = 1; i < pts.length - 1; i++) {
                    const cpx = (pts[i].x + pts[i+1].x) / 2;
                    const cpy = (pts[i].y + pts[i+1].y) / 2;
                    ctx.quadraticCurveTo(pts[i].x, pts[i].y, cpx, cpy);
                }
                // Last segment
                const last = pts[pts.length - 1];
                ctx.lineTo(last.x, last.y);
            }
            ctx.strokeStyle = isSel ? '#fff' : stroke.color;
            ctx.lineWidth = stroke.lineWidth * (stroke.transform?.scale || 1);
            ctx.lineCap = 'round'; ctx.lineJoin = 'round';
            ctx.shadowBlur = isSel ? (stroke.glowIntensity||15)*2.5 : (stroke.glowIntensity||0);
            ctx.shadowColor = isSel ? '#fff' : stroke.color;
            ctx.stroke(); ctx.shadowBlur = 0;

            if (isSel) drawSelectionGuide(ctx, pts, stroke);
            ctx.restore();
        });

        updateUI();
        requestAnimationFrame(renderLoop);
    }

    function drawSelectionGuide(ctx, pts, stroke) {
        let cx = 0, cy = 0;
        for (const p of pts) { cx += p.x; cy += p.y; }
        cx /= pts.length; cy /= pts.length;
        let maxR = 0;
        for (const p of pts) { const d = Math.sqrt((p.x-cx)**2 + (p.y-cy)**2); if (d > maxR) maxR = d; }
        const r = maxR + 20;
        ctx.save();
        ctx.beginPath(); ctx.arc(cx, cy, r, 0, Math.PI*2);
        ctx.setLineDash([6,6]); ctx.strokeStyle = 'rgba(255,255,255,0.3)'; ctx.lineWidth = 1.5; ctx.stroke(); ctx.setLineDash([]);
        ctx.restore();
    }

    function updateUI() {
        // Gesture status
        const mode = currentCtrlGesture !== CTRL.IDLE ? currentCtrlGesture.replace('CTRL_','') : currentGesture;
        if (mode !== 'IDLE' && mode !== CTRL.IDLE) { gestureStatus.textContent = mode + ' MODE'; gestureStatus.classList.remove('hidden'); }
        else { gestureStatus.classList.add('hidden'); }

        // Overlay
        if (!primaryLandmark && !controlLandmark) overlayMessage.classList.remove('hidden');
        else overlayMessage.classList.add('hidden');

        // Fingertips
        const container = document.getElementById('fingertips-container');
        container.innerHTML = '';

        primaryTips.forEach((tip, i) => {
            if (!tip) return;
            const el = document.createElement('div'); el.className = 'fingertip';
            const x = (1 - tip.x) * window.innerWidth, y = tip.y * window.innerHeight;
            let size = 10, opacity = 0.6, color = settings.color, shadow = `0 0 10px 2px ${color}`, border = 'none';
            if (i === 1) { if (currentGesture === 'ERASE') { size = 60; color = 'transparent'; shadow = '0 0 15px 4px rgba(255,0,0,0.8), inset 0 0 10px 2px rgba(255,0,0,0.5)'; opacity = 1; border = '2px solid rgba(255,50,50,0.8)'; } else { size = 16; opacity = 1; shadow = `0 0 15px 4px ${settings.color}`; } }
            Object.assign(el.style, { left: x+'px', top: y+'px', width: size+'px', height: size+'px', backgroundColor: color, boxShadow: shadow, opacity, border });
            container.appendChild(el);
        });

        controlTips.forEach((tip, i) => {
            if (!tip) return;
            const el = document.createElement('div'); el.className = 'fingertip';
            const x = (1 - tip.x) * window.innerWidth, y = tip.y * window.innerHeight;
            let size = 10, opacity = 0.5, color = 'transparent', shadow = '0 0 8px 2px rgba(255,165,0,0.5)', border = '1.5px solid rgba(255,165,0,0.6)';
            if (i === 1) { size = 18; opacity = 1; if (currentCtrlGesture === CTRL.MOVE) { shadow = '0 0 20px 4px rgba(100,180,255,0.8)'; border = '2px solid rgba(100,180,255,0.8)'; } else if (currentCtrlGesture === CTRL.SCALE) { shadow = '0 0 20px 4px rgba(0,255,200,0.8)'; border = '2px solid rgba(0,255,200,0.8)'; } else if (currentCtrlGesture === CTRL.ROTATE) { shadow = '0 0 20px 4px rgba(255,165,0,0.8)'; border = '2px solid rgba(255,165,0,0.8)'; } }
            Object.assign(el.style, { left: x+'px', top: y+'px', width: size+'px', height: size+'px', backgroundColor: color, boxShadow: shadow, opacity, border });
            container.appendChild(el);
        });
    }

    // ============================================================
    // START
    // ============================================================
    async function start() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: { width: { ideal: 1280 }, height: { ideal: 720 }, facingMode: 'user' } });
            webcam.srcObject = stream;
            await webcam.play();

            const hands = new Hands({ locateFile: f => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${f}` });
            hands.setOptions({ maxNumHands: 2, modelComplexity: 1, minDetectionConfidence: 0.5, minTrackingConfidence: 0.5 });
            hands.onResults(onResults);

            const processFrame = async () => {
                if (webcam.readyState === 4) await hands.send({ image: webcam });
                requestAnimationFrame(processFrame);
            };
            processFrame();
        } catch (err) { console.error('Camera error:', err); }
    }

    start();
    renderLoop();

})();
</script>
</body>
</html>
