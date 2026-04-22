<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jutsu Tangan — Kekuatan Naruto & Sasuke</title>
    <meta name="description" content="Hand tracking interaktif dengan efek kekuatan Naruto (Rasengan) dan Sasuke (Chidori). Buka tangan untuk mengaktifkan jutsu!">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            overflow: hidden;
            background-color: black;
            font-family: 'Inter', sans-serif;
        }

        #v_src, #out {
            position: absolute;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            object-fit: cover;
            transform: scaleX(-1);
        }
        #out {
            z-index: 2;
            pointer-events: none;
        }

        .darkness {
            position: absolute;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            background: rgba(10, 5, 0, 0.3);
            mix-blend-mode: multiply;
            pointer-events: none;
            z-index: 5;
        }

        .fx {
            position: absolute;
            height: auto;
            top: 0; left: 0;
            transform: translate(-50%, -50%);
            pointer-events: none;
            display: none;
            mix-blend-mode: screen;
            z-index: 20;
        }
        #n { width: 1600px; }
        #s { width: 2400px; }

        /* ── Start Overlay ── */
        #startOverlay {
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse at center, rgba(5, 5, 20, 0.94), rgba(0, 0, 0, 0.98));
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
            font-size: 4rem;
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
            background: linear-gradient(135deg, #ff6a00, #ff3d00, #00d4ff, #00fbff);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: ninjShift 4s ease infinite;
            margin-bottom: 10px;
            text-align: center;
        }
        @keyframes ninjShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .start-subtitle {
            color: rgba(255, 255, 255, 0.45);
            font-size: 0.9rem;
            margin-bottom: 12px;
            text-align: center;
            max-width: 440px;
            line-height: 1.7;
            padding: 0 20px;
        }

        .start-powers {
            display: flex;
            gap: 32px;
            margin-bottom: 36px;
        }
        .power-card {
            text-align: center;
            padding: 16px 24px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .power-card .emoji { font-size: 2rem; margin-bottom: 6px; }
        .power-card .label {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.7rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .power-card.naruto .label { color: #ff8c00; }
        .power-card.sasuke .label { color: #00d4ff; }
        .power-card .desc {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 4px;
        }

        .start-btn {
            padding: 15px 44px;
            font-size: 1rem;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            background: linear-gradient(135deg, #ff4500, #00d4ff);
            border: none;
            color: white;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 0 30px rgba(255, 69, 0, 0.3), 0 0 30px rgba(0, 212, 255, 0.3);
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
            background: linear-gradient(135deg, #ff4500, #00d4ff, #ff4500);
            background-size: 200% 200%;
            animation: ninjShift 3s ease infinite;
            z-index: -1;
            filter: blur(8px);
            opacity: 0.5;
        }
        .start-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 40px rgba(255, 69, 0, 0.5), 0 0 40px rgba(0, 212, 255, 0.5);
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
            border: 3px solid rgba(0, 212, 255, 0.15);
            border-top: 3px solid #00d4ff;
            border-right: 3px solid #ff4500;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 18px;
        }
        .loading-text {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.85rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #00d4ff;
            text-shadow: 0 0 15px rgba(0, 212, 255, 0.4);
            animation: pulse 1.5s infinite alternate;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes pulse { from { opacity: 0.5; } to { opacity: 1; } }

        /* ── Back Button ── */
        .back-btn {
            position: fixed;
            top: 20px; left: 20px;
            z-index: 100;
            background: rgba(10, 10, 20, 0.5);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 212, 255, 0.25);
            border-radius: 30px;
            padding: 10px 22px;
            color: #00d4ff;
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 0 16px rgba(0, 212, 255, 0.15);
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeInUI 0.5s ease 1s forwards;
        }
        .back-btn:hover {
            background: rgba(0, 212, 255, 0.15);
            border-color: rgba(0, 212, 255, 0.5);
            box-shadow: 0 0 25px rgba(0, 212, 255, 0.3);
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
        .dot.tracking { background: #00ff88; }
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
            background: rgba(5, 5, 15, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 212, 255, 0.15);
            border-left: 3px solid #00d4ff;
            border-radius: 12px;
            padding: 14px 22px;
            color: #b8e8ff;
            min-width: 260px;
        }
        .hud-panel h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.82rem;
            color: #00d4ff;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }
        .hud-panel p {
            font-size: 0.75rem;
            opacity: 0.7;
            line-height: 1.6;
        }

        /* ── Power Meters ── */
        #powerMeters {
            position: fixed;
            bottom: 24px; right: 24px;
            z-index: 100;
            display: flex;
            gap: 12px;
            opacity: 0;
            animation: fadeInUI 0.5s ease 1.6s forwards;
        }
        .meter {
            width: 44px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }
        .meter-bar-wrapper {
            width: 8px;
            height: 100px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }
        .meter-fill {
            position: absolute;
            bottom: 0;
            width: 100%;
            border-radius: 10px;
            transition: height 0.15s ease;
        }
        .meter.naruto .meter-fill {
            background: linear-gradient(to top, #ff4500, #ff8c00);
            box-shadow: 0 0 10px rgba(255, 69, 0, 0.5);
        }
        .meter.sasuke .meter-fill {
            background: linear-gradient(to top, #0066ff, #00d4ff);
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }
        .meter-label {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.55rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .meter.naruto .meter-label { color: #ff8c00; }
        .meter.sasuke .meter-label { color: #00d4ff; }
        .meter-icon { font-size: 1.2rem; }

        /* ── Chakra burst flash ── */
        #chakraFlash {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 30;
            opacity: 0;
            transition: opacity 0.1s ease;
        }

        @keyframes fadeInUI {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Missing Asset Notice ── */
        #assetNotice {
            position: fixed;
            top: 70px; left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            background: rgba(255, 100, 0, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 100, 0, 0.3);
            border-radius: 12px;
            padding: 10px 20px;
            color: #ffcc80;
            font-size: 0.75rem;
            text-align: center;
            max-width: 500px;
            display: none;
            opacity: 0;
            animation: fadeInUI 0.5s ease 2s forwards;
        }
    </style>
</head>
<body>

    <!-- Start Overlay -->
    <div id="startOverlay">
        <div class="start-icon">🥷</div>
        <div class="start-title">JUTSU TANGAN</div>
        <p class="start-subtitle">Aktifkan kekuatan ninja menggunakan tangan Anda. Buka tangan untuk melepaskan jutsu!</p>

        <div class="start-powers">
            <div class="power-card naruto">
                <div class="emoji">🌀</div>
                <div class="label">Naruto</div>
                <div class="desc">Tangan Kiri → Rasengan</div>
            </div>
            <div class="power-card sasuke">
                <div class="emoji">⚡</div>
                <div class="label">Sasuke</div>
                <div class="desc">Tangan Kanan → Chidori</div>
            </div>
        </div>

        <button class="start-btn" id="startBtn">Aktifkan Jutsu</button>
    </div>

    <!-- Loading -->
    <div id="loading-ui">
        <div class="loading-spinner"></div>
        <div class="loading-text">Menyiapkan Chakra...</div>
    </div>

    <!-- Asset Notice -->
    <div id="assetNotice">
        ⚠️ Video efek (naruto.mp4 / sasuke.mp4) belum ditemukan. Letakkan file di <strong>public/assets/</strong>
    </div>

    <video id="v_src" autoplay playsinline></video>
    <canvas id="out"></canvas>
    <div class="darkness"></div>
    <div id="chakraFlash"></div>

    <video id="n" class="fx" src="{{ asset('assets/naruto.mp4') }}" muted autoplay loop playsinline></video>
    <video id="s" class="fx" src="{{ asset('assets/sasuke.mp4') }}" muted autoplay loop playsinline></video>

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
            <h2>Jutsu Tangan</h2>
            <p>
                ✋ Buka tangan kiri → <strong style="color:#ff8c00">Rasengan</strong><br>
                🤚 Buka tangan kanan → <strong style="color:#00d4ff">Chidori</strong><br>
                Kepalkan tangan untuk menonaktifkan
            </p>
        </div>
    </div>

    <!-- Power Meters -->
    <div id="powerMeters">
        <div class="meter naruto">
            <div class="meter-icon">🌀</div>
            <div class="meter-bar-wrapper">
                <div class="meter-fill" id="narutoFill" style="height: 0%"></div>
            </div>
            <div class="meter-label">Naruto</div>
        </div>
        <div class="meter sasuke">
            <div class="meter-icon">⚡</div>
            <div class="meter-bar-wrapper">
                <div class="meter-fill" id="sasukeFill" style="height: 0%"></div>
            </div>
            <div class="meter-label">Sasuke</div>
        </div>
    </div>

    <script>
        const vElement = document.getElementById('v_src');
        const cElement = document.getElementById('out');
        const ctx = cElement.getContext('2d');
        const nVid = document.getElementById('n');
        const sVid = document.getElementById('s');
        const loadingUI = document.getElementById('loading-ui');
        const startOverlay = document.getElementById('startOverlay');
        const trackDot = document.getElementById('trackDot');
        const statusText = document.getElementById('statusText');
        const narutoFill = document.getElementById('narutoFill');
        const sasukeFill = document.getElementById('sasukeFill');
        const chakraFlash = document.getElementById('chakraFlash');
        const assetNotice = document.getElementById('assetNotice');

        let pwr = [0, 0];
        let wasOpen = [false, false];

        // Check if video assets loaded
        let narutoLoaded = false;
        let sasukeLoaded = false;

        nVid.addEventListener('canplay', () => { narutoLoaded = true; });
        sVid.addEventListener('canplay', () => { sasukeLoaded = true; });
        nVid.addEventListener('error', () => { assetNotice.style.display = 'block'; });
        sVid.addEventListener('error', () => { assetNotice.style.display = 'block'; });

        function checkOpen(pts) {
            let count = 0;
            const wrist = pts[0];
            const tips = [8, 12, 16, 20];
            const pips = [6, 10, 14, 18];
            for (let i = 0; i < tips.length; i++) {
                const tip = pts[tips[i]];
                const pip = pts[pips[i]];
                if (Math.hypot(tip.x - wrist.x, tip.y - wrist.y) > Math.hypot(pip.x - wrist.x, pip.y - wrist.y)) count++;
            }
            return count >= 3;
        }

        function triggerChakraBurst(color) {
            chakraFlash.style.background = `radial-gradient(circle, ${color}33 0%, transparent 70%)`;
            chakraFlash.style.opacity = '1';
            setTimeout(() => { chakraFlash.style.opacity = '0'; }, 150);
        }

        function onResults(res) {
            cElement.width = vElement.videoWidth;
            cElement.height = vElement.videoHeight;
            ctx.save();
            ctx.clearRect(0, 0, cElement.width, cElement.height);

            // Hide loading
            if (loadingUI.style.display !== 'none') {
                loadingUI.style.display = 'none';
            }

            let fL = false;
            let fR = false;

            nVid.style.display = 'none';
            sVid.style.display = 'none';

            // Update tracking status
            const handsDetected = res.multiHandLandmarks && res.multiHandLandmarks.length > 0;
            trackDot.classList.toggle('tracking', handsDetected);
            statusText.textContent = handsDetected
                ? `${res.multiHandLandmarks.length} tangan terdeteksi`
                : 'Menunggu tangan...';

            if (res.multiHandLandmarks && res.multiHandedness) {
                res.multiHandLandmarks.forEach((pts, i) => {
                    const label = res.multiHandedness[i].label;
                    const isR = label === 'Right';
                    const idx = isR ? 1 : 0;

                    // Bright blue skeleton
                    ctx.save();
                    ctx.shadowBlur = 10;
                    ctx.shadowColor = '#00fbff';
                    drawConnectors(ctx, pts, HAND_CONNECTIONS, { color: '#00d4ff', lineWidth: 3 });
                    drawLandmarks(ctx, pts, { color: '#ffffff', lineWidth: 1, radius: 2 });
                    ctx.restore();

                    const open = checkOpen(pts);
                    pwr[idx] += open ? 0.05 : -0.15;
                    pwr[idx] = Math.max(0, Math.min(1, pwr[idx]));

                    // Trigger video restart + chakra burst on hand open
                    if (open && !wasOpen[idx]) {
                        const vid = isR ? sVid : nVid;
                        vid.currentTime = 0;
                        vid.play().catch(() => {});
                        triggerChakraBurst(isR ? '#00d4ff' : '#ff4500');
                    }
                    wasOpen[idx] = open;

                    const wrist = pts[0];
                    const knk = pts[9];

                    if (pwr[idx] > 0.01) {
                        if (isR) {
                            fR = true;
                            const tx = (wrist.x + knk.x) / 2;
                            const ty = (wrist.y + knk.y) / 2;
                            sVid.style.left = `${(1 - tx) * window.innerWidth}px`;
                            sVid.style.top = `${ty * window.innerHeight}px`;
                            sVid.style.display = 'block';
                            sVid.style.opacity = pwr[idx];
                        } else {
                            fL = true;
                            const dx = knk.x - wrist.x;
                            const dy = knk.y - wrist.y;
                            const tx = knk.x + (dx * 0.8);
                            const ty = knk.y + (dy * 0.8);
                            nVid.style.left = `${(1 - tx) * window.innerWidth}px`;
                            nVid.style.top = `${(ty * window.innerHeight) - 120}px`;
                            nVid.style.display = 'block';
                            nVid.style.opacity = pwr[idx];
                        }
                    }
                });
            }

            if (!fL) {
                pwr[0] = Math.max(0, pwr[0] - 0.15);
                if (pwr[0] > 0.01) { nVid.style.display = 'block'; nVid.style.opacity = pwr[0]; }
                wasOpen[0] = false;
            }
            if (!fR) {
                pwr[1] = Math.max(0, pwr[1] - 0.15);
                if (pwr[1] > 0.01) { sVid.style.display = 'block'; sVid.style.opacity = pwr[1]; }
                wasOpen[1] = false;
            }

            // Update power meters
            narutoFill.style.height = `${Math.round(pwr[0] * 100)}%`;
            sasukeFill.style.height = `${Math.round(pwr[1] * 100)}%`;

            ctx.restore();
        }

        function initApp() {
            loadingUI.style.display = 'block';

            const h = new Hands({
                locateFile: (f) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${f}`
            });

            h.setOptions({
                maxNumHands: 2,
                modelComplexity: 1,
                minDetectionConfidence: 0.65,
                minTrackingConfidence: 0.65
            });

            h.onResults(onResults);

            const cam = new Camera(vElement, {
                onFrame: async () => { await h.send({ image: vElement }); },
                width: 640,
                height: 480
            });
            cam.start();
        }

        // Start Button
        document.getElementById('startBtn').addEventListener('click', () => {
            startOverlay.classList.add('hidden');
            initApp();
        });
    </script>
</body>
</html>
