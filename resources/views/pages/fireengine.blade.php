<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinematic Fire Engine | Dark Mode & Dynamic Lighting</title>
    <meta name="description" content="Efek kamera web sinematik dengan kontrol tangan - Api, Es, Petir, dan efek warna dinamis menggunakan hand tracking.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #000;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        canvas {
            position: absolute;
            top: 0;
            left: 0;
            transform: scaleX(-1);
        }

        video { display: none; }

        /* ── Start Overlay ── */
        #startOverlay {
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse at center, rgba(10, 5, 20, 0.92), rgba(0, 0, 0, 0.98));
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
        .start-title {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(1.8rem, 5vw, 3.2rem);
            font-weight: 900;
            letter-spacing: 6px;
            background: linear-gradient(135deg, #ff6a00, #ff3d00, #00b4ff, #00ffcc);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShift 4s ease infinite;
            margin-bottom: 12px;
            text-align: center;
        }
        .start-subtitle {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.95rem;
            margin-bottom: 40px;
            text-align: center;
            max-width: 400px;
            line-height: 1.6;
        }
        .start-btn {
            padding: 16px 48px;
            font-size: 1.1rem;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            background: linear-gradient(135deg, #ff4500, #ff8c00);
            border: none;
            color: white;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 0 30px rgba(255, 69, 0, 0.5), 0 0 60px rgba(255, 69, 0, 0.2);
            text-transform: uppercase;
            letter-spacing: 3px;
            transition: transform 0.2s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }
        .start-btn::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 52px;
            background: linear-gradient(135deg, #ff4500, #00b4ff, #ff4500);
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
            z-index: -1;
            filter: blur(8px);
            opacity: 0.6;
        }
        .start-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 40px rgba(255, 69, 0, 0.7), 0 0 80px rgba(255, 69, 0, 0.3);
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* ── Loading UI ── */
        #loading-ui {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 150;
            text-align: center;
            display: none;
        }
        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 3px solid rgba(255, 100, 0, 0.15);
            border-top: 3px solid #ff6a00;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        .loading-text {
            font-family: 'Orbitron', sans-serif;
            font-size: 1rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #ff8c00;
            text-shadow: 0 0 20px rgba(255, 100, 0, 0.5);
            animation: pulse-glow 1.5s infinite alternate;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes pulse-glow {
            from { opacity: 0.5; text-shadow: 0 0 10px rgba(255, 100, 0, 0.3); }
            to { opacity: 1; text-shadow: 0 0 25px rgba(255, 100, 0, 0.7); }
        }

        /* ── Back Button ── */
        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 100;
            background: rgba(20, 10, 5, 0.5);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 140, 0, 0.3);
            border-radius: 30px;
            padding: 10px 22px;
            color: #ffcc80;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 0 20px rgba(255, 100, 0, 0.2);
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeInUI 0.5s ease 1s forwards;
        }
        .back-btn:hover {
            background: rgba(255, 100, 0, 0.2);
            border-color: rgba(255, 160, 0, 0.6);
            box-shadow: 0 0 30px rgba(255, 120, 0, 0.4);
            transform: translateY(-2px);
            color: #fff;
        }

        /* ── HUD Panel ── */
        #hud {
            position: fixed;
            bottom: 24px;
            left: 24px;
            z-index: 100;
            pointer-events: none;
            opacity: 0;
            animation: fadeInUI 0.5s ease 1.2s forwards;
        }
        .hud-panel {
            background: rgba(10, 5, 2, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 140, 0, 0.2);
            border-left: 3px solid #ff7700;
            border-radius: 12px;
            padding: 14px 22px;
            color: #ffdcb5;
            min-width: 260px;
        }
        .hud-panel h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.85rem;
            color: #ffaa00;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 6px;
        }
        .hud-panel p {
            font-size: 0.78rem;
            opacity: 0.75;
            line-height: 1.5;
        }
        .hud-panel .power-label {
            font-size: 0.75rem;
            color: #ff8c00;
            margin-top: 8px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        /* ── Power Mode Selector ── */
        #powerSelector {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 8px;
            opacity: 0;
            animation: fadeInUI 0.5s ease 1.4s forwards;
        }
        .power-btn {
            padding: 10px 20px;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: rgba(255, 255, 255, 0.7);
            background: rgba(30, 20, 10, 0.5);
            min-width: 140px;
            text-align: center;
        }
        .power-btn:hover {
            transform: scale(1.05);
        }
        .power-btn.active {
            color: #fff;
            text-shadow: 0 0 10px currentColor;
        }
        .power-btn[data-power="fire_ice"] {
            --pw-color: #ff6a00;
        }
        .power-btn[data-power="fire_ice"].active {
            background: rgba(255, 100, 0, 0.25);
            border-color: rgba(255, 140, 0, 0.6);
            box-shadow: 0 0 20px rgba(255, 100, 0, 0.3);
        }
        .power-btn[data-power="lightning"] {
            --pw-color: #00bfff;
        }
        .power-btn[data-power="lightning"].active {
            background: rgba(0, 150, 255, 0.2);
            border-color: rgba(0, 190, 255, 0.6);
            box-shadow: 0 0 20px rgba(0, 190, 255, 0.3);
        }
        .power-btn[data-power="red_blue"] {
            --pw-color: #cc00ff;
        }
        .power-btn[data-power="red_blue"].active {
            background: rgba(150, 0, 255, 0.2);
            border-color: rgba(200, 0, 255, 0.5);
            box-shadow: 0 0 20px rgba(180, 0, 255, 0.3);
        }

        @keyframes fadeInUI {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Status Indicator ── */
        #statusDot {
            position: fixed;
            top: 28px;
            right: 24px;
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
            opacity: 0;
            animation: fadeInUI 0.5s ease 1.6s forwards;
        }
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ff3300;
            animation: dotPulse 1.5s ease infinite;
        }
        .dot.tracking {
            background: #00ff88;
        }
        @keyframes dotPulse {
            0%, 100% { opacity: 1; box-shadow: 0 0 4px currentColor; }
            50% { opacity: 0.5; box-shadow: 0 0 10px currentColor; }
        }
    </style>
</head>
<body>

    <!-- Start Overlay -->
    <div id="startOverlay">
        <div class="start-title">FIRE ENGINE</div>
        <p class="start-subtitle">Efek kamera sinematik dengan kontrol tangan — Api, Es, Petir, dan aura warna dinamis. Izinkan akses kamera untuk memulai.</p>
        <button class="start-btn" id="startBtn">Mulai</button>
    </div>

    <!-- Loading -->
    <div id="loading-ui">
        <div class="loading-spinner"></div>
        <div class="loading-text">Memuat Model...</div>
    </div>

    <video id="input_video" autoplay playsinline></video>
    <canvas id="output_canvas"></canvas>

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

    <!-- HUD -->
    <div id="hud">
        <div class="hud-panel">
            <h2>Fire Engine</h2>
            <p>Buka tangan untuk mengaktifkan efek.<br>Cubit (pinch) untuk menggambar jejak.<br>Tekan <strong>1 / 2 / 3</strong> atau gunakan tombol di kanan.</p>
            <div class="power-label" id="powerLabel">Mode: Api & Es</div>
        </div>
    </div>

    <!-- Power Mode Selector -->
    <div id="powerSelector">
        <button class="power-btn active" data-power="fire_ice">🔥 Api & Es</button>
        <button class="power-btn" data-power="lightning">⚡ Petir</button>
        <button class="power-btn" data-power="red_blue">🔴🔵 Merah & Biru</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js"></script>

    <script>
        const videoElement = document.getElementById('input_video');
        const canvasElement = document.getElementById('output_canvas');
        const canvasCtx = canvasElement.getContext('2d');
        const loadingUI = document.getElementById('loading-ui');
        const startOverlay = document.getElementById('startOverlay');
        const startBtn = document.getElementById('startBtn');
        const powerLabel = document.getElementById('powerLabel');
        const trackDot = document.getElementById('trackDot');
        const statusText = document.getElementById('statusText');

        let startTime = null;
        let particles = [];
        let lightningBolts = [];
        let isStarted = false;

        // State
        let currentPower = 'fire_ice';
        let lightningIntensity = 0;
        let lastTip = { x: 0, y: 0, active: false };

        // Intensity for each hand
        let handIntensities = [0, 0];
        let handSurges = [0, 0];
        let lastHandOpenState = [false, false];

        const HAND_CONNECTIONS = [[0,1],[1,2],[2,3],[3,4],[0,5],[5,6],[6,7],[7,8],[5,9],[9,10],[10,11],[11,12],[9,13],[13,14],[14,15],[15,16],[13,17],[17,18],[18,19],[19,20],[0,17]];

        const powerLabels = {
            'fire_ice': 'Mode: Api & Es',
            'lightning': 'Mode: Petir',
            'red_blue': 'Mode: Merah & Biru'
        };

        // ── Power Mode Buttons ──
        document.querySelectorAll('.power-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.power-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentPower = btn.getAttribute('data-power');
                powerLabel.textContent = powerLabels[currentPower];
            });
        });

        // ── Keyboard Shortcuts ──
        document.addEventListener('keydown', (e) => {
            if (e.key === '1') setPower('fire_ice');
            if (e.key === '2') setPower('lightning');
            if (e.key === '3') setPower('red_blue');
        });

        function setPower(power) {
            currentPower = power;
            powerLabel.textContent = powerLabels[power];
            document.querySelectorAll('.power-btn').forEach(b => {
                b.classList.toggle('active', b.getAttribute('data-power') === power);
            });
        }

        // ── Particle Spawners ──
        function spawnFire(x, y, isDrawing = false) {
            if (!isDrawing && Math.random() > handIntensities[0]) return;
            let count = isDrawing ? 2 : 1;
            for (let i = 0; i < count; i++) {
                particles.push({
                    x: x + (Math.random() - 0.5) * (isDrawing ? 10 : 15),
                    y: y + (Math.random() - 0.5) * (isDrawing ? 10 : 15),
                    vx: isDrawing ? 0 : (Math.random() - 0.5) * 4,
                    vy: isDrawing ? 0 : ((Math.random() * -10) - 4) - (handSurges[0] * 20),
                    life: 1.0,
                    decay: isDrawing ? 0.0055 : 0.06,
                    size: isDrawing ? (Math.random() * 20 + 20) : (Math.random() * 22 + 8),
                    type: 'fire'
                });
            }
        }

        function spawnIce(x, y, isDrawing = false) {
            if (!isDrawing && Math.random() > handIntensities[1]) return;
            let count = isDrawing ? 2 : 1;
            for (let i = 0; i < count; i++) {
                particles.push({
                    x: x + (Math.random() - 0.5) * (isDrawing ? 10 : 15),
                    y: y + (Math.random() - 0.5) * (isDrawing ? 10 : 15),
                    vx: isDrawing ? 0 : (Math.random() - 0.5) * 4,
                    vy: isDrawing ? 0 : ((Math.random() * -5) - 2) - (handSurges[1] * 15),
                    life: 1.0,
                    decay: isDrawing ? 0.0055 : 0.06,
                    size: isDrawing ? (Math.random() * 20 + 20) : (Math.random() * 20 + 5),
                    type: 'ice'
                });
            }
        }

        function spawnRed(x, y, isDrawing = false) {
            if (!isDrawing && Math.random() > handIntensities[0]) return;
            let count = isDrawing ? 2 : 1;
            for (let i = 0; i < count; i++) {
                particles.push({
                    x: x + (Math.random() - 0.5) * (isDrawing ? 10 : 15),
                    y: y + (Math.random() - 0.5) * (isDrawing ? 10 : 15),
                    vx: isDrawing ? 0 : (Math.random() - 0.5) * 4,
                    vy: isDrawing ? 0 : ((Math.random() * -10) - 4) - (handSurges[0] * 20),
                    life: 1.0,
                    decay: isDrawing ? 0.0055 : 0.06,
                    size: isDrawing ? (Math.random() * 20 + 20) : (Math.random() * 22 + 8),
                    type: 'red'
                });
            }
        }

        function spawnBlue(x, y, isDrawing = false) {
            if (!isDrawing && Math.random() > handIntensities[1]) return;
            let count = isDrawing ? 2 : 1;
            for (let i = 0; i < count; i++) {
                particles.push({
                    x: x + (Math.random() - 0.5) * (isDrawing ? 10 : 15),
                    y: y + (Math.random() - 0.5) * (isDrawing ? 10 : 15),
                    vx: isDrawing ? 0 : (Math.random() - 0.5) * 4,
                    vy: isDrawing ? 0 : ((Math.random() * -5) - 2) - (handSurges[1] * 15),
                    life: 1.0,
                    decay: isDrawing ? 0.0055 : 0.06,
                    size: isDrawing ? (Math.random() * 20 + 20) : (Math.random() * 20 + 5),
                    type: 'blue'
                });
            }
        }

        function spawnLightning(x, y) {
            if (Math.random() > lightningIntensity) return;
            const bolt = [];
            let cx = x;
            let cy = y;
            for (let i = 0; i < 25; i++) {
                bolt.push({ x: cx, y: cy });
                cx += (Math.random() - 0.5) * 80;
                cy += (Math.random() - 0.8) * 80;
            }
            lightningBolts.push({
                path: bolt,
                life: 1.0,
                color: Math.random() > 0.5 ? '#e0ffff' : '#00bfff'
            });
        }

        // ── Gesture Detection ──
        const pointingState = {
            left: { frames: 0, active: false, lastWrist: null },
            right: { frames: 0, active: false, lastWrist: null }
        };

        function isPinchingInternal(landmarks, state) {
            const thumb = landmarks[4];
            const index = landmarks[8];
            const wrist = landmarks[0];

            let velocity = 0;
            if (state.lastWrist) {
                velocity = Math.hypot(wrist.x - state.lastWrist.x, wrist.y - state.lastWrist.y);
            }
            state.lastWrist = { x: wrist.x, y: wrist.y };
            if (velocity > 0.05) return false;

            const fingers = [12, 16, 20];
            const pips = [10, 14, 18];
            let openCount = 0;
            for (let i = 0; i < 3; i++) {
                const tip = landmarks[fingers[i]];
                const pip = landmarks[pips[i]];
                const dTip = Math.hypot(tip.x - wrist.x, tip.y - wrist.y);
                const dPip = Math.hypot(pip.x - wrist.x, pip.y - wrist.y);
                if (dTip > dPip) openCount++;
            }
            if (openCount < 2) return false;

            const pinchDist = Math.hypot(thumb.x - index.x, thumb.y - index.y);
            const midPip = landmarks[9];
            const handSize = Math.hypot(midPip.x - wrist.x, midPip.y - wrist.y);
            return pinchDist < handSize * 0.35;
        }

        function isPinching(landmarks, isRightHand) {
            const state = isRightHand ? pointingState.right : pointingState.left;
            const raw = isPinchingInternal(landmarks, state);
            if (raw) {
                state.frames = 5;
                state.active = true;
            } else {
                state.frames--;
                if (state.frames <= 0) state.active = false;
            }
            return state.active;
        }

        function isHandOpen(landmarks) {
            let open = 0;
            const wrist = landmarks[0];
            const tips = [8, 12, 16, 20];
            const pips = [6, 10, 14, 18];
            for (let i = 0; i < tips.length; i++) {
                const tip = landmarks[tips[i]];
                const pip = landmarks[pips[i]];
                const dTip = Math.hypot(tip.x - wrist.x, tip.y - wrist.y);
                const dPip = Math.hypot(pip.x - wrist.x, pip.y - wrist.y);
                if (dTip > dPip) open++;
            }
            return open >= 3;
        }

        // ── Main Render Pipeline ──
        function onResults(results) {
            canvasElement.width = window.innerWidth;
            canvasElement.height = window.innerHeight;

            if (!startTime) startTime = Date.now();

            // Hide loading on first result
            if (loadingUI.style.display !== 'none') {
                loadingUI.style.display = 'none';
            }

            canvasCtx.save();
            canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
            canvasCtx.drawImage(results.image, 0, 0, canvasElement.width, canvasElement.height);

            // Cinematic darkening
            canvasCtx.globalCompositeOperation = 'multiply';
            canvasCtx.fillStyle = 'rgba(10, 5, 0, 0.5)';
            canvasCtx.fillRect(0, 0, canvasElement.width, canvasElement.height);
            canvasCtx.globalCompositeOperation = 'source-over';

            // Update tracking status
            const handsDetected = results.multiHandLandmarks && results.multiHandLandmarks.length > 0;
            trackDot.classList.toggle('tracking', handsDetected);
            statusText.textContent = handsDetected
                ? `${results.multiHandLandmarks.length} tangan terdeteksi`
                : 'Menunggu tangan...';

            if (results.multiHandLandmarks) {
                let anyHandOpen = false;
                results.multiHandLandmarks.forEach((landmarks) => {
                    if (isHandOpen(landmarks)) anyHandOpen = true;
                });

                // Lightning intensity management
                if (currentPower === 'lightning') {
                    lightningIntensity += anyHandOpen ? 0.08 : -0.05;
                } else {
                    lightningIntensity -= 0.1;
                }
                lightningIntensity = Math.max(0, Math.min(1, lightningIntensity));

                // Lightning flash effect
                if (lightningIntensity > 0.01) {
                    if (Math.random() < 0.5 * lightningIntensity) {
                        canvasCtx.fillStyle = `rgba(200, 220, 255, ${0.25 * lightningIntensity})`;
                        canvasCtx.fillRect(0, 0, canvasElement.width, canvasElement.height);
                    }

                    results.multiHandLandmarks.forEach((landmarks) => {
                        if (!isHandOpen(landmarks)) return;
                        const tips = [4, 8, 12, 16, 20];
                        tips.forEach(tipIdx => {
                            const pt = landmarks[tipIdx];
                            if (Math.random() < 0.07) spawnLightning(pt.x * canvasElement.width, pt.y * canvasElement.height);
                        });
                        HAND_CONNECTIONS.forEach(([s, e]) => {
                            if (Math.random() < 0.005) {
                                const start = landmarks[s];
                                spawnLightning(start.x * canvasElement.width, start.y * canvasElement.height);
                            }
                        });
                    });
                }

                // Process each hand
                results.multiHandLandmarks.forEach((landmarks, index) => {
                    const label = results.multiHandedness[index].label;
                    const isRightHand = label === 'Right';
                    const targetIndex = isRightHand ? 1 : 0;

                    const isOpen = isHandOpen(landmarks);
                    const isPinch = isPinching(landmarks, isRightHand);

                    if (currentPower === 'fire_ice' || currentPower === 'red_blue') {
                        handIntensities[targetIndex] += (isOpen || isPinch) ? 0.05 : -0.15;
                        if (isOpen && !lastHandOpenState[targetIndex]) {
                            handSurges[targetIndex] = 1.0;
                        }
                    } else {
                        handIntensities[targetIndex] -= 0.15;
                    }
                    lastHandOpenState[targetIndex] = isOpen;

                    handSurges[targetIndex] *= 0.92;
                    if (handSurges[targetIndex] < 0.01) handSurges[targetIndex] = 0;
                    handIntensities[targetIndex] = Math.max(0, Math.min(1, handIntensities[targetIndex]));

                    const intensity = handIntensities[targetIndex];
                    if (intensity <= 0.01) return;

                    const palm = landmarks[9];
                    const lx = palm.x * canvasElement.width;
                    const ly = palm.y * canvasElement.height;

                    // Pinch drawing
                    if (isPinch) {
                        const indexTip = landmarks[8];
                        const thumbTip = landmarks[4];
                        const tx = ((indexTip.x + thumbTip.x) / 2) * canvasElement.width;
                        const ty = ((indexTip.y + thumbTip.y) / 2) * canvasElement.height;

                        if (currentPower === 'fire_ice') {
                            const elapsed = Date.now() - startTime;
                            if (elapsed > 10000) {
                                if (!isRightHand) spawnFire(tx, ty, true);
                                else spawnIce(tx, ty, true);
                            }
                        }
                    }

                    // Glow and particle effects per power mode
                    if (currentPower === 'red_blue') {
                        if (!isRightHand) {
                            let flicker = Math.sin(Date.now() * 0.02) * 25;
                            let redGlow = canvasCtx.createRadialGradient(lx, ly, 0, lx, ly, 550 + flicker);
                            redGlow.addColorStop(0, `rgba(255, 0, 0, ${0.45 * intensity})`);
                            redGlow.addColorStop(0.5, `rgba(200, 0, 0, ${0.15 * intensity})`);
                            redGlow.addColorStop(1, 'rgba(0, 0, 0, 0)');
                            canvasCtx.globalCompositeOperation = 'screen';
                            canvasCtx.fillStyle = redGlow;
                            canvasCtx.fillRect(0, 0, canvasElement.width, canvasElement.height);
                            landmarks.forEach(pt => spawnRed(pt.x * canvasElement.width, pt.y * canvasElement.height));
                            HAND_CONNECTIONS.forEach(([s, e]) => {
                                const start = landmarks[s]; const end = landmarks[e];
                                spawnRed(((start.x + end.x) / 2) * canvasElement.width, ((start.y + end.y) / 2) * canvasElement.height);
                            });
                        } else {
                            let flicker = Math.sin(Date.now() * 0.01) * 20;
                            let blueGlow = canvasCtx.createRadialGradient(lx, ly, 0, lx, ly, 400 + flicker);
                            blueGlow.addColorStop(0, `rgba(0, 0, 255, ${0.4 * intensity})`);
                            blueGlow.addColorStop(0.5, `rgba(0, 50, 255, ${0.1 * intensity})`);
                            blueGlow.addColorStop(1, 'rgba(0, 0, 0, 0)');
                            canvasCtx.globalCompositeOperation = 'screen';
                            canvasCtx.fillStyle = blueGlow;
                            canvasCtx.fillRect(0, 0, canvasElement.width, canvasElement.height);
                            landmarks.forEach(pt => spawnBlue(pt.x * canvasElement.width, pt.y * canvasElement.height));
                            HAND_CONNECTIONS.forEach(([s, e]) => {
                                const start = landmarks[s]; const end = landmarks[e];
                                spawnBlue(((start.x + end.x) / 2) * canvasElement.width, ((start.y + end.y) / 2) * canvasElement.height);
                            });
                        }
                    } else if (currentPower === 'fire_ice') {
                        if (!isRightHand) {
                            let flicker = Math.sin(Date.now() * 0.02) * 25;
                            let heatGlow = canvasCtx.createRadialGradient(lx, ly, 0, lx, ly, 550 + flicker);
                            heatGlow.addColorStop(0, `rgba(255, 60, 0, ${0.45 * intensity})`);
                            heatGlow.addColorStop(0.5, `rgba(255, 30, 0, ${0.15 * intensity})`);
                            heatGlow.addColorStop(1, 'rgba(0, 0, 0, 0)');
                            canvasCtx.globalCompositeOperation = 'screen';
                            canvasCtx.fillStyle = heatGlow;
                            canvasCtx.fillRect(0, 0, canvasElement.width, canvasElement.height);
                            landmarks.forEach(pt => spawnFire(pt.x * canvasElement.width, pt.y * canvasElement.height));
                            HAND_CONNECTIONS.forEach(([s, e]) => {
                                const start = landmarks[s]; const end = landmarks[e];
                                spawnFire(((start.x + end.x) / 2) * canvasElement.width, ((start.y + end.y) / 2) * canvasElement.height);
                            });
                        } else {
                            let flicker = Math.sin(Date.now() * 0.01) * 20;
                            let coldGlow = canvasCtx.createRadialGradient(lx, ly, 0, lx, ly, 400 + flicker);
                            coldGlow.addColorStop(0, `rgba(100, 200, 255, ${0.4 * intensity})`);
                            coldGlow.addColorStop(0.5, `rgba(0, 100, 255, ${0.1 * intensity})`);
                            coldGlow.addColorStop(1, 'rgba(0, 0, 0, 0)');
                            canvasCtx.globalCompositeOperation = 'screen';
                            canvasCtx.fillStyle = coldGlow;
                            canvasCtx.fillRect(0, 0, canvasElement.width, canvasElement.height);
                            landmarks.forEach(pt => spawnIce(pt.x * canvasElement.width, pt.y * canvasElement.height));
                            HAND_CONNECTIONS.forEach(([s, e]) => {
                                const start = landmarks[s]; const end = landmarks[e];
                                spawnIce(((start.x + end.x) / 2) * canvasElement.width, ((start.y + end.y) / 2) * canvasElement.height);
                            });
                        }
                    }
                });
            }

            // ── Draw Particles ──
            canvasCtx.globalCompositeOperation = 'lighter';
            particles.forEach((p, index) => {
                p.x += p.vx;
                p.y += p.vy;
                p.life -= (p.decay || 0.06);

                if (p.life <= 0) {
                    particles.splice(index, 1);
                } else {
                    let gradient = canvasCtx.createRadialGradient(p.x, p.y, 0, p.x, p.y, p.size);
                    if (p.type === 'ice') {
                        gradient.addColorStop(0, `rgba(255, 255, 255, ${p.life})`);
                        gradient.addColorStop(0.3, `rgba(180, 240, 255, ${p.life * 0.8})`);
                        gradient.addColorStop(0.6, `rgba(0, 150, 255, ${p.life * 0.4})`);
                    } else if (p.type === 'red') {
                        gradient.addColorStop(0, `rgba(255, 200, 200, ${p.life})`);
                        gradient.addColorStop(0.3, `rgba(255, 0, 0, ${p.life * 0.8})`);
                        gradient.addColorStop(0.6, `rgba(100, 0, 0, ${p.life * 0.4})`);
                    } else if (p.type === 'blue') {
                        gradient.addColorStop(0, `rgba(200, 200, 255, ${p.life})`);
                        gradient.addColorStop(0.3, `rgba(0, 0, 255, ${p.life * 0.8})`);
                        gradient.addColorStop(0.6, `rgba(0, 0, 100, ${p.life * 0.4})`);
                    } else {
                        gradient.addColorStop(0, `rgba(255, 255, 220, ${p.life})`);
                        gradient.addColorStop(0.2, `rgba(255, 180, 0, ${p.life * 0.8})`);
                        gradient.addColorStop(0.5, `rgba(255, 40, 0, ${p.life * 0.4})`);
                    }
                    gradient.addColorStop(1, 'rgba(0, 0, 0, 0)');
                    canvasCtx.fillStyle = gradient;
                    canvasCtx.beginPath();
                    canvasCtx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                    canvasCtx.fill();
                }
            });

            // ── Draw Lightning Bolts ──
            lightningBolts.forEach((b, index) => {
                b.life -= 0.1;
                if (b.life <= 0) {
                    lightningBolts.splice(index, 1);
                } else {
                    if (b.path.length === 0) return;

                    canvasCtx.beginPath();
                    canvasCtx.moveTo(b.path[0].x, b.path[0].y);
                    for (let i = 1; i < b.path.length; i++) {
                        canvasCtx.lineTo(b.path[i].x, b.path[i].y);
                    }

                    // Outer glow pass
                    canvasCtx.save();
                    canvasCtx.globalCompositeOperation = 'lighter';
                    canvasCtx.strokeStyle = b.color;
                    canvasCtx.lineWidth = 20;
                    canvasCtx.globalAlpha = b.life * 0.3;
                    canvasCtx.shadowBlur = 30;
                    canvasCtx.shadowColor = b.color;
                    canvasCtx.stroke();
                    canvasCtx.restore();

                    // Mid pass
                    canvasCtx.save();
                    canvasCtx.globalCompositeOperation = 'lighter';
                    canvasCtx.strokeStyle = b.color;
                    canvasCtx.lineWidth = 8;
                    canvasCtx.globalAlpha = b.life * 0.6;
                    canvasCtx.stroke();
                    canvasCtx.restore();

                    // Core white pass
                    canvasCtx.save();
                    canvasCtx.globalCompositeOperation = 'source-over';
                    canvasCtx.strokeStyle = '#ffffff';
                    canvasCtx.lineWidth = 2;
                    canvasCtx.globalAlpha = b.life;
                    canvasCtx.stroke();
                    canvasCtx.restore();
                }
            });

            canvasCtx.restore();
        }

        // ── MediaPipe Initialization ──
        const hands = new Hands({
            locateFile: (file) => {
                return `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`;
            }
        });

        hands.setOptions({
            maxNumHands: 2,
            modelComplexity: 1,
            minDetectionConfidence: 0.65,
            minTrackingConfidence: 0.65
        });

        hands.onResults(onResults);

        const camera = new Camera(videoElement, {
            onFrame: async () => {
                await hands.send({ image: videoElement });
            },
            width: 640,
            height: 480
        });
        camera.start();

        // ── Start Button ──
        startBtn.addEventListener('click', () => {
            startOverlay.classList.add('hidden');
            isStarted = true;
        });
    </script>
</body>
</html>
