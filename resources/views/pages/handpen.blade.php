<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pena Tangan — Gambar di Udara</title>
    <meta name="description" content="Gambar di udara menggunakan tangan Anda sebagai pena digital dengan teknologi hand tracking dan efek cahaya emas.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #050301;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        video { display: none; }

        canvas {
            width: 100%;
            height: 100%;
            transform: scaleX(-1);
            position: absolute;
            z-index: 1;
        }

        /* ── Start Overlay ── */
        #startOverlay {
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse at center, rgba(15, 10, 2, 0.94), rgba(0, 0, 0, 0.98));
            z-index: 200;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(20px);
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        #startOverlay.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .start-icon {
            font-size: 3.5rem;
            margin-bottom: 16px;
            animation: floatIcon 3s ease-in-out infinite;
        }
        @keyframes floatIcon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
        .start-title {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(1.6rem, 4.5vw, 2.8rem);
            font-weight: 900;
            letter-spacing: 5px;
            background: linear-gradient(135deg, #F5D061, #E8A317, #F5D061, #FFF8DC);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: goldShift 4s ease infinite;
            margin-bottom: 10px;
            text-align: center;
        }
        .start-subtitle {
            color: rgba(255, 255, 255, 0.45);
            font-size: 0.9rem;
            margin-bottom: 36px;
            text-align: center;
            max-width: 420px;
            line-height: 1.7;
            padding: 0 20px;
        }
        .start-btn {
            padding: 15px 44px;
            font-size: 1rem;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            background: linear-gradient(135deg, #E8A317, #F5D061);
            border: none;
            color: #1a0e00;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 0 30px rgba(245, 208, 97, 0.4), 0 0 60px rgba(245, 208, 97, 0.15);
            text-transform: uppercase;
            letter-spacing: 3px;
            transition: transform 0.2s, box-shadow 0.3s;
            position: relative;
        }
        .start-btn::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 52px;
            background: linear-gradient(135deg, #F5D061, #fff, #F5D061);
            background-size: 200% 200%;
            animation: goldShift 3s ease infinite;
            z-index: -1;
            filter: blur(8px);
            opacity: 0.4;
        }
        .start-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 40px rgba(245, 208, 97, 0.6), 0 0 80px rgba(245, 208, 97, 0.25);
        }

        @keyframes goldShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* ── Loading ── */
        #loading-ui {
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            z-index: 150;
            text-align: center;
            display: none;
        }
        .loading-spinner {
            width: 50px; height: 50px;
            border: 3px solid rgba(245, 208, 97, 0.15);
            border-top: 3px solid #F5D061;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 18px;
        }
        .loading-text {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.85rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #F5D061;
            text-shadow: 0 0 15px rgba(245, 208, 97, 0.4);
            animation: pulse 1.5s infinite alternate;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes pulse {
            from { opacity: 0.5; }
            to { opacity: 1; }
        }

        /* ── Back Button ── */
        .back-btn {
            position: fixed;
            top: 20px; left: 20px;
            z-index: 100;
            background: rgba(20, 15, 5, 0.5);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(245, 208, 97, 0.25);
            border-radius: 30px;
            padding: 10px 22px;
            color: #F5D061;
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 0 16px rgba(245, 208, 97, 0.15);
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeInUI 0.5s ease 1s forwards;
        }
        .back-btn:hover {
            background: rgba(245, 208, 97, 0.15);
            border-color: rgba(245, 208, 97, 0.5);
            box-shadow: 0 0 25px rgba(245, 208, 97, 0.3);
            transform: translateY(-2px);
            color: #fff;
        }

        /* ── Status Dot ── */
        #statusDot {
            position: fixed;
            top: 26px; right: 24px;
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.45);
            opacity: 0;
            animation: fadeInUI 0.5s ease 1.4s forwards;
        }
        .dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #ff3300;
            animation: dotPulse 1.5s ease infinite;
        }
        .dot.tracking { background: #F5D061; }
        @keyframes dotPulse {
            0%, 100% { opacity: 1; box-shadow: 0 0 4px currentColor; }
            50% { opacity: 0.5; box-shadow: 0 0 10px currentColor; }
        }

        /* ── HUD Panel ── */
        #hud {
            position: fixed;
            bottom: 24px; left: 24px;
            z-index: 100;
            pointer-events: none;
            opacity: 0;
            animation: fadeInUI 0.5s ease 1.2s forwards;
        }
        .hud-panel {
            background: rgba(15, 10, 2, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(245, 208, 97, 0.2);
            border-left: 3px solid #F5D061;
            border-radius: 12px;
            padding: 14px 22px;
            color: #fce8b5;
            min-width: 280px;
        }
        .hud-panel h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.82rem;
            color: #F5D061;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }
        .hud-panel p {
            font-size: 0.75rem;
            opacity: 0.7;
            line-height: 1.6;
        }
        .hud-panel .shortcut {
            display: inline-block;
            background: rgba(245, 208, 97, 0.15);
            border: 1px solid rgba(245, 208, 97, 0.3);
            border-radius: 5px;
            padding: 1px 7px;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.65rem;
            color: #F5D061;
            margin: 0 2px;
        }

        /* ── Toolbar ── */
        #toolbar {
            position: fixed;
            bottom: 24px; right: 24px;
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 8px;
            opacity: 0;
            animation: fadeInUI 0.5s ease 1.6s forwards;
        }
        .tool-btn {
            padding: 10px 18px;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: 1px solid rgba(245, 208, 97, 0.2);
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: #F5D061;
            background: rgba(20, 15, 5, 0.5);
            min-width: 130px;
            text-align: center;
        }
        .tool-btn:hover {
            background: rgba(245, 208, 97, 0.15);
            border-color: rgba(245, 208, 97, 0.5);
            box-shadow: 0 0 20px rgba(245, 208, 97, 0.2);
            transform: scale(1.05);
        }
        .tool-btn:active {
            transform: scale(0.98);
        }

        /* ── Draw Mode Indicator ── */
        #drawIndicator {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.75rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 8px 24px;
            border-radius: 25px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeInUI 0.5s ease 1.8s forwards;
        }
        #drawIndicator.idle {
            background: rgba(20, 15, 5, 0.5);
            border: 1px solid rgba(245, 208, 97, 0.15);
            color: rgba(245, 208, 97, 0.5);
        }
        #drawIndicator.drawing {
            background: rgba(245, 208, 97, 0.2);
            border: 1px solid rgba(245, 208, 97, 0.6);
            color: #F5D061;
            box-shadow: 0 0 20px rgba(245, 208, 97, 0.3);
            text-shadow: 0 0 10px rgba(245, 208, 97, 0.5);
        }

        /* ── Color Picker ── */
        #colorPicker {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            display: flex;
            gap: 8px;
            background: rgba(15, 10, 2, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(245, 208, 97, 0.15);
            border-radius: 30px;
            padding: 8px 14px;
            opacity: 0;
            animation: fadeInUI 0.5s ease 2s forwards;
        }
        .color-dot {
            width: 28px; height: 28px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            position: relative;
        }
        .color-dot:hover {
            transform: scale(1.2);
        }
        .color-dot.active {
            border-color: #fff;
            box-shadow: 0 0 12px currentColor;
            transform: scale(1.15);
        }

        @keyframes fadeInUI {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        #drawIndicator { animation: fadeInUI 0.5s ease 1.8s forwards; }
        #colorPicker { animation: fadeInUI 0.5s ease 2s forwards; }
    </style>
</head>
<body>

    <!-- Start Overlay -->
    <div id="startOverlay">
        <div class="start-icon">✍️</div>
        <div class="start-title">PENA TANGAN</div>
        <p class="start-subtitle">Gambar di udara menggunakan ujung jari Anda. Tahan <strong>Shift</strong> untuk menggambar, tekan <strong>Spasi</strong> untuk menghapus kanvas.</p>
        <button class="start-btn" id="startBtn">Mulai Menggambar</button>
    </div>

    <!-- Loading -->
    <div id="loading-ui">
        <div class="loading-spinner"></div>
        <div class="loading-text">Memuat Model...</div>
    </div>

    <video id="vid"></video>
    <canvas id="c"></canvas>

    <!-- Back Button -->
    <a href="{{ route('home') }}" class="back-btn" id="backBtn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    <!-- Status Indicator -->
    <div id="statusDot">
        <div class="dot" id="trackDot"></div>
        <span id="statusText">Menunggu tangan...</span>
    </div>

    <!-- Draw Mode Indicator -->
    <div id="drawIndicator" class="idle">Siap Menggambar</div>

    <!-- Color Picker -->
    <div id="colorPicker">
        <div class="color-dot active" data-color="#F5D061" data-shadow="#F5D061" style="background: #F5D061;" title="Emas"></div>
        <div class="color-dot" data-color="#FF6B6B" data-shadow="#FF6B6B" style="background: #FF6B6B;" title="Merah"></div>
        <div class="color-dot" data-color="#4ECDC4" data-shadow="#4ECDC4" style="background: #4ECDC4;" title="Cyan"></div>
        <div class="color-dot" data-color="#A78BFA" data-shadow="#A78BFA" style="background: #A78BFA;" title="Ungu"></div>
        <div class="color-dot" data-color="#34D399" data-shadow="#34D399" style="background: #34D399;" title="Hijau"></div>
        <div class="color-dot" data-color="#F472B6" data-shadow="#F472B6" style="background: #F472B6;" title="Merah Muda"></div>
        <div class="color-dot" data-color="#FFFFFF" data-shadow="#FFFFFF" style="background: #FFFFFF;" title="Putih"></div>
    </div>

    <!-- HUD -->
    <div id="hud">
        <div class="hud-panel">
            <h2>Pena Tangan</h2>
            <p>
                Tahan <span class="shortcut">Shift</span> untuk menggambar<br>
                Tekan <span class="shortcut">Spasi</span> untuk hapus kanvas<br>
                Arahkan jari telunjuk ke mana saja
            </p>
        </div>
    </div>

    <!-- Toolbar -->
    <div id="toolbar">
        <button class="tool-btn" id="clearBtn">🗑️ Hapus</button>
        <button class="tool-btn" id="undoBtn">↩️ Undo</button>
    </div>

    <script>
        const vid = document.getElementById('vid');
        const c = document.getElementById('c');
        const ctx = c.getContext('2d');
        const loadingUI = document.getElementById('loading-ui');
        const startOverlay = document.getElementById('startOverlay');
        const trackDot = document.getElementById('trackDot');
        const statusText = document.getElementById('statusText');
        const drawIndicator = document.getElementById('drawIndicator');

        let arr = [];
        let cur = [];
        let shift = false;
        let draw = false;
        let sx = null;
        let sy = null;

        // Current pen color
        let penColor = '#F5D061';
        let penShadow = '#F5D061';

        // ── Color Picker ──
        document.querySelectorAll('.color-dot').forEach(dot => {
            dot.addEventListener('click', () => {
                document.querySelectorAll('.color-dot').forEach(d => d.classList.remove('active'));
                dot.classList.add('active');
                penColor = dot.getAttribute('data-color');
                penShadow = dot.getAttribute('data-shadow');
            });
        });

        // ── Toolbar Buttons ──
        document.getElementById('clearBtn').addEventListener('click', () => {
            arr = [];
        });

        document.getElementById('undoBtn').addEventListener('click', () => {
            if (arr.length > 0) arr.pop();
        });

        // ── Keyboard Controls ──
        window.onkeydown = function(e) {
            if (e.key === 'Shift') {
                shift = true;
                drawIndicator.className = 'drawing';
                drawIndicator.textContent = '● Menggambar...';
            }
            if (e.code === 'Space') {
                e.preventDefault();
                arr = [];
            }
        };

        window.onkeyup = function(e) {
            if (e.key === 'Shift') {
                shift = false;
                drawIndicator.className = 'idle';
                drawIndicator.textContent = 'Siap Menggambar';
            }
        };

        // ── Main Render ──
        function run(res) {
            c.width = window.innerWidth;
            c.height = window.innerHeight;

            // Hide loading
            if (loadingUI.style.display !== 'none') {
                loadingUI.style.display = 'none';
            }

            // Draw camera feed with dark overlay
            ctx.drawImage(res.image, 0, 0, c.width, c.height);
            ctx.fillStyle = 'rgba(10, 6, 2, 0.85)';
            ctx.fillRect(0, 0, c.width, c.height);

            // Draw all strokes
            for (let i = 0; i < arr.length; i++) {
                const stroke = arr[i];
                if (stroke.points.length < 2) continue;

                ctx.shadowColor = stroke.shadow;
                ctx.shadowBlur = 15;
                ctx.strokeStyle = stroke.color;
                ctx.lineWidth = 6;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';

                ctx.beginPath();
                for (let j = 0; j < stroke.points.length; j++) {
                    if (j === 0) ctx.moveTo(stroke.points[j].x, stroke.points[j].y);
                    else ctx.lineTo(stroke.points[j].x, stroke.points[j].y);
                }
                ctx.stroke();
            }

            // Reset shadow for hand drawing
            ctx.shadowBlur = 0;

            // Update tracking status
            const handsDetected = res.multiHandLandmarks && res.multiHandLandmarks.length > 0;
            trackDot.classList.toggle('tracking', handsDetected);
            statusText.textContent = handsDetected ? 'Tangan terdeteksi' : 'Menunggu tangan...';

            if (handsDetected) {
                const lm = res.multiHandLandmarks[0];

                // Draw hand skeleton
                drawConnectors(ctx, lm, HAND_CONNECTIONS, {
                    color: 'rgba(245, 208, 97, 0.3)',
                    lineWidth: 2
                });
                drawLandmarks(ctx, lm, {
                    color: '#FFFFFF',
                    lineWidth: 1,
                    radius: 2
                });

                // Index finger tip tracking
                const ind = lm[8];
                const rx = ind.x * c.width;
                const ry = ind.y * c.height;

                if (sx === null) {
                    sx = rx;
                    sy = ry;
                } else {
                    sx += (rx - sx) * 0.45;
                    sy += (ry - sy) * 0.45;
                }

                // Draw cursor dot
                ctx.beginPath();
                ctx.arc(sx, sy, 6, 0, 2 * Math.PI);
                if (shift) {
                    ctx.fillStyle = '#FFFFFF';
                    ctx.shadowColor = penColor;
                    ctx.shadowBlur = 20;
                } else {
                    ctx.fillStyle = `${penColor}66`;
                    ctx.shadowBlur = 0;
                }
                ctx.fill();
                ctx.shadowBlur = 0;

                // Drawing logic
                if (shift) {
                    if (!draw) {
                        draw = true;
                        cur = { color: penColor, shadow: penShadow, points: [] };
                        arr.push(cur);
                    }
                    cur.points.push({ x: sx, y: sy });
                } else {
                    draw = false;
                }
            } else {
                draw = false;
                sx = null;
            }
        }

        // ── Init MediaPipe ──
        function initApp() {
            loadingUI.style.display = 'block';

            const h = new Hands({
                locateFile: (file) => {
                    return `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`;
                }
            });

            h.setOptions({
                maxNumHands: 1,
                modelComplexity: 1,
                minDetectionConfidence: 0.5,
                minTrackingConfidence: 0.5
            });

            h.onResults(run);

            const cam = new Camera(vid, {
                onFrame: async () => { await h.send({ image: vid }); },
                width: 1280,
                height: 720
            });

            cam.start();
        }

        // ── Start Button ──
        document.getElementById('startBtn').addEventListener('click', () => {
            startOverlay.classList.add('hidden');
            initApp();
        });
    </script>
</body>
</html>
