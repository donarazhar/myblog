<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisasi Suara - Gelombang Kosmis</title>
    <meta name="description" content="Visualisasi suara interaktif yang merespons musik dan suara secara real-time dengan efek visual kosmis yang memukau.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #000;
            overflow: hidden;
            height: 100vh;
            width: 100vw;
            font-family: 'Inter', sans-serif;
            color: #fff;
        }

        canvas {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
        }

        /* Back Button */
        .back-btn {
            position: fixed; top: 20px; left: 20px;
            z-index: 100;
            background: rgba(80, 0, 180, 0.2);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(160, 80, 255, 0.35);
            border-radius: 30px; padding: 10px 20px;
            color: #d4b0ff; text-decoration: none;
            font-size: 14px; font-weight: 600;
            display: flex; align-items: center; gap: 8px;
            box-shadow: 0 0 20px rgba(120, 40, 200, 0.3);
            transition: all 0.3s;
        }
        .back-btn:hover {
            background: rgba(120, 0, 255, 0.3);
            box-shadow: 0 0 30px rgba(150, 60, 255, 0.5);
            transform: scale(1.05);
            color: #fff;
        }

        /* Start Overlay */
        #start-overlay {
            position: fixed; inset: 0;
            background: rgba(0, 0, 0, 0.92);
            backdrop-filter: blur(20px);
            z-index: 200;
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            transition: opacity 0.6s ease;
        }
        #start-overlay.hidden {
            opacity: 0; pointer-events: none;
        }

        #start-overlay h1 {
            font-size: 2.5rem; font-weight: 700;
            letter-spacing: 6px; margin-bottom: 12px;
            background: linear-gradient(135deg, #a855f7, #ec4899, #3b82f6);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        #start-overlay p {
            color: rgba(255,255,255,0.5); margin-bottom: 40px;
            font-size: 0.95rem; max-width: 400px; text-align: center;
            line-height: 1.6;
        }

        .start-btn {
            padding: 16px 44px;
            font-size: 1.1rem;
            background: linear-gradient(135deg, #7c3aed, #ec4899);
            border: none; color: white;
            border-radius: 50px; cursor: pointer;
            box-shadow: 0 0 30px rgba(124, 58, 237, 0.5);
            font-weight: 700; text-transform: uppercase;
            letter-spacing: 3px;
            transition: transform 0.2s, box-shadow 0.3s;
        }
        .start-btn:hover {
            transform: scale(1.06);
            box-shadow: 0 0 50px rgba(124, 58, 237, 0.7);
        }

        /* HUD */
        #hud {
            position: fixed; bottom: 30px; left: 50%;
            transform: translateX(-50%);
            z-index: 100; pointer-events: none;
            background: rgba(10, 0, 30, 0.5);
            backdrop-filter: blur(12px);
            padding: 14px 28px;
            border-radius: 20px;
            border: 1px solid rgba(160, 80, 255, 0.3);
            text-align: center;
            opacity: 0; transition: opacity 0.5s;
        }
        #hud.visible { opacity: 1; }
        #hud h2 {
            font-size: 0.85rem; font-weight: 600;
            color: #c084fc; letter-spacing: 2px;
            text-transform: uppercase; margin-bottom: 4px;
        }
        #hud p {
            font-size: 0.75rem; color: rgba(255,255,255,0.5);
        }

        /* Mode Toggle */
        #mode-bar {
            position: fixed; top: 20px; right: 20px;
            z-index: 100; display: flex; gap: 8px;
            opacity: 0; transition: opacity 0.5s;
        }
        #mode-bar.visible { opacity: 1; }

        .mode-btn {
            background: rgba(80, 0, 180, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(160, 80, 255, 0.3);
            color: rgba(255,255,255,0.6);
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px; font-weight: 600;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s;
        }
        .mode-btn:hover { color: #fff; border-color: rgba(160,80,255,0.6); }
        .mode-btn.active {
            background: rgba(124, 58, 237, 0.4);
            border-color: rgba(180, 120, 255, 0.6);
            color: #fff; text-shadow: 0 0 10px rgba(180,120,255,0.5);
        }

        /* Volume Level */
        #vol-bar {
            position: fixed; left: 20px; bottom: 50%;
            transform: translateY(50%);
            width: 4px; height: 120px;
            background: rgba(255,255,255,0.08);
            border-radius: 4px;
            z-index: 100;
            opacity: 0; transition: opacity 0.5s;
        }
        #vol-bar.visible { opacity: 1; }
        #vol-fill {
            position: absolute; bottom: 0; left: 0;
            width: 100%; border-radius: 4px;
            background: linear-gradient(to top, #7c3aed, #ec4899);
            transition: height 0.05s;
        }
    </style>
</head>
<body>

    <a href="{{ route('home') }}" class="back-btn">← Kembali ke Blog</a>

    <!-- Start Overlay -->
    <div id="start-overlay">
        <h1>VISUALISASI SUARA</h1>
        <p>Izinkan akses mikrofon untuk menikmati pengalaman visual yang merespons suara dan musik di sekitar Anda secara langsung.</p>
        <button class="start-btn" id="start-btn">Mulai Pengalaman</button>
    </div>

    <canvas id="vis-canvas"></canvas>

    <!-- HUD -->
    <div id="hud">
        <h2>Gelombang Kosmis</h2>
        <p>Bicaralah atau putar musik untuk melihat keajaiban</p>
    </div>

    <!-- Mode Switcher -->
    <div id="mode-bar">
        <button class="mode-btn active" data-mode="0">Cincin</button>
        <button class="mode-btn" data-mode="1">Gelombang</button>
        <button class="mode-btn" data-mode="2">Galaksi</button>
    </div>

    <!-- Volume Bar -->
    <div id="vol-bar"><div id="vol-fill"></div></div>

    <script>
    (function() {
        const canvas = document.getElementById('vis-canvas');
        const ctx = canvas.getContext('2d');
        const startOverlay = document.getElementById('start-overlay');
        const startBtn = document.getElementById('start-btn');
        const hudEl = document.getElementById('hud');
        const modeBar = document.getElementById('mode-bar');
        const volBar = document.getElementById('vol-bar');
        const volFill = document.getElementById('vol-fill');

        let W, H, CX, CY;
        let audioCtx, analyser, dataArray, bufferLength;
        let timeDataArray;
        let running = false;
        let time = 0;
        let currentMode = 0; // 0=Ring, 1=Wave, 2=Galaxy
        let smoothVolume = 0;

        // Starfield for background
        const STAR_COUNT = 300;
        const stars = [];

        function resize() {
            W = window.innerWidth;
            H = window.innerHeight;
            CX = W / 2;
            CY = H / 2;
            canvas.width = W;
            canvas.height = H;
        }
        resize();
        window.addEventListener('resize', resize);

        // Init stars
        for (let i = 0; i < STAR_COUNT; i++) {
            stars.push({
                x: Math.random() * W,
                y: Math.random() * H,
                r: Math.random() * 1.5 + 0.3,
                speed: Math.random() * 0.3 + 0.05,
                twinkle: Math.random() * Math.PI * 2
            });
        }

        // Mode buttons
        document.querySelectorAll('.mode-btn').forEach(btn => {
            btn.addEventListener('click', e => {
                document.querySelectorAll('.mode-btn').forEach(b => b.classList.remove('active'));
                e.target.classList.add('active');
                currentMode = parseInt(e.target.getAttribute('data-mode'));
            });
        });

        // Start Experience
        startBtn.addEventListener('click', async () => {
            try {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                const source = audioCtx.createMediaStreamSource(stream);

                analyser = audioCtx.createAnalyser();
                analyser.fftSize = 512;
                analyser.smoothingTimeConstant = 0.82;
                bufferLength = analyser.frequencyBinCount;
                dataArray = new Uint8Array(bufferLength);
                timeDataArray = new Uint8Array(analyser.fftSize);

                source.connect(analyser);

                startOverlay.classList.add('hidden');
                hudEl.classList.add('visible');
                modeBar.classList.add('visible');
                volBar.classList.add('visible');
                running = true;
                loop();
            } catch (e) {
                console.error('Gagal mengakses mikrofon:', e);
                startBtn.textContent = 'Gagal: Izinkan Mikrofon';
                startBtn.style.background = 'rgba(220,50,50,0.5)';
            }
        });

        function getAverageVolume() {
            if (!dataArray) return 0;
            let sum = 0;
            for (let i = 0; i < bufferLength; i++) sum += dataArray[i];
            return sum / bufferLength;
        }

        function getBassLevel() {
            if (!dataArray) return 0;
            let sum = 0;
            const bassRange = Math.floor(bufferLength * 0.15);
            for (let i = 0; i < bassRange; i++) sum += dataArray[i];
            return sum / bassRange;
        }

        function getMidLevel() {
            if (!dataArray) return 0;
            let sum = 0;
            const start = Math.floor(bufferLength * 0.15);
            const end = Math.floor(bufferLength * 0.5);
            for (let i = start; i < end; i++) sum += dataArray[i];
            return sum / (end - start);
        }

        function getTrebleLevel() {
            if (!dataArray) return 0;
            let sum = 0;
            const start = Math.floor(bufferLength * 0.5);
            for (let i = start; i < bufferLength; i++) sum += dataArray[i];
            return sum / (bufferLength - start);
        }

        // ─── Background ────────────────────────────────────────────
        function drawBackground(volume) {
            // Fading trail
            ctx.fillStyle = `rgba(0, 0, 0, ${0.15 + volume * 0.001})`;
            ctx.fillRect(0, 0, W, H);

            // Draw stars
            const bassNorm = getBassLevel() / 255;
            stars.forEach(s => {
                s.twinkle += 0.02;
                const alpha = 0.3 + Math.sin(s.twinkle) * 0.3 + bassNorm * 0.4;
                const size = s.r + bassNorm * 1.5;
                ctx.beginPath();
                ctx.arc(s.x, s.y, size, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(200, 180, 255, ${Math.min(1, alpha)})`;
                ctx.fill();

                // Slow drift
                s.y += s.speed;
                if (s.y > H + 5) { s.y = -5; s.x = Math.random() * W; }
            });
        }

        // ─── Mode 0: Cosmic Ring ───────────────────────────────────
        function drawRingMode(volume, bass, mid, treble) {
            const baseRadius = Math.min(W, H) * 0.2;
            const bars = bufferLength;

            // Outer glowing ring
            for (let ring = 0; ring < 3; ring++) {
                const rMult = 1 + ring * 0.15;
                ctx.beginPath();
                for (let i = 0; i <= bars; i++) {
                    const angle = (i / bars) * Math.PI * 2 - Math.PI / 2;
                    const val = dataArray[i % bars] / 255;
                    const r = baseRadius * rMult + val * 120 * (1 - ring * 0.25);

                    const x = CX + Math.cos(angle + time * (0.1 + ring * 0.05)) * r;
                    const y = CY + Math.sin(angle + time * (0.1 + ring * 0.05)) * r;

                    if (i === 0) ctx.moveTo(x, y);
                    else ctx.lineTo(x, y);
                }
                ctx.closePath();

                const hue = (time * 30 + ring * 40) % 360;
                ctx.strokeStyle = `hsla(${hue}, 80%, 65%, ${0.6 - ring * 0.15})`;
                ctx.lineWidth = 2.5 - ring * 0.5;
                ctx.shadowBlur = 15;
                ctx.shadowColor = `hsla(${hue}, 90%, 60%, 0.6)`;
                ctx.stroke();
            }
            ctx.shadowBlur = 0;

            // Center pulsating core
            const coreSize = 10 + bass * 0.3;
            const coreGrad = ctx.createRadialGradient(CX, CY, 0, CX, CY, coreSize * 3);
            coreGrad.addColorStop(0, `rgba(255, 255, 255, ${0.3 + volume/255 * 0.5})`);
            coreGrad.addColorStop(0.4, `rgba(180, 100, 255, ${0.2 + volume/255 * 0.3})`);
            coreGrad.addColorStop(1, 'rgba(80, 0, 180, 0)');
            ctx.beginPath();
            ctx.arc(CX, CY, coreSize * 3, 0, Math.PI * 2);
            ctx.fillStyle = coreGrad;
            ctx.fill();

            // Inner frequency bars (radial)
            for (let i = 0; i < bars; i += 2) {
                const angle = (i / bars) * Math.PI * 2 - Math.PI / 2;
                const val = dataArray[i] / 255;
                const innerR = baseRadius * 0.6;
                const outerR = innerR + val * 60;

                const x1 = CX + Math.cos(angle) * innerR;
                const y1 = CY + Math.sin(angle) * innerR;
                const x2 = CX + Math.cos(angle) * outerR;
                const y2 = CY + Math.sin(angle) * outerR;

                const hue = (i / bars * 360 + time * 20) % 360;
                ctx.beginPath();
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.strokeStyle = `hsla(${hue}, 90%, 70%, ${0.4 + val * 0.6})`;
                ctx.lineWidth = 2;
                ctx.stroke();
            }
        }

        // ─── Mode 1: Wave ──────────────────────────────────────────
        function drawWaveMode(volume, bass, mid, treble) {
            analyser.getByteTimeDomainData(timeDataArray);
            const sliceWidth = W / analyser.fftSize;

            // Multiple colorful wave layers
            for (let layer = 0; layer < 4; layer++) {
                ctx.beginPath();
                let x = 0;
                for (let i = 0; i < analyser.fftSize; i++) {
                    const v = timeDataArray[i] / 128.0;
                    const amp = 1 + layer * 0.6;
                    const yOffset = layer * 8;
                    const y = CY + (v - 1) * (H * 0.3) * amp + yOffset + Math.sin(time * 2 + i * 0.01) * 5;
                    if (i === 0) ctx.moveTo(x, y);
                    else ctx.lineTo(x, y);
                    x += sliceWidth;
                }

                const hue = (270 + layer * 50 + time * 15) % 360;
                ctx.strokeStyle = `hsla(${hue}, 85%, 65%, ${0.6 - layer * 0.12})`;
                ctx.lineWidth = 3 - layer * 0.5;
                ctx.shadowBlur = 12;
                ctx.shadowColor = `hsla(${hue}, 90%, 60%, 0.5)`;
                ctx.stroke();
            }
            ctx.shadowBlur = 0;

            // Frequency bars at the bottom
            const barWidth = W / bufferLength * 2;
            for (let i = 0; i < bufferLength; i++) {
                const val = dataArray[i] / 255;
                const barHeight = val * H * 0.15;
                const hue = (i / bufferLength * 360 + time * 30) % 360;

                ctx.fillStyle = `hsla(${hue}, 80%, 60%, ${0.3 + val * 0.5})`;
                ctx.fillRect(i * barWidth, H - barHeight, barWidth - 1, barHeight);

                // Mirror on top
                ctx.fillStyle = `hsla(${hue}, 80%, 60%, ${0.15 + val * 0.2})`;
                ctx.fillRect(i * barWidth, 0, barWidth - 1, barHeight * 0.5);
            }
        }

        // ─── Mode 2: Galaxy ────────────────────────────────────────
        function drawGalaxyMode(volume, bass, mid, treble) {
            const numArms = 5;
            const pointsPerArm = 120;
            const maxR = Math.min(W, H) * 0.42;
            const bassNorm = bass / 255;
            const midNorm = mid / 255;

            for (let arm = 0; arm < numArms; arm++) {
                const armAngleOffset = (arm / numArms) * Math.PI * 2;

                for (let i = 0; i < pointsPerArm; i++) {
                    const ratio = i / pointsPerArm;
                    const freqIdx = Math.floor(ratio * (bufferLength - 1));
                    const val = dataArray[freqIdx] / 255;

                    const spiralAngle = ratio * Math.PI * 4 + armAngleOffset + time * 0.3;
                    const r = ratio * maxR * (0.8 + val * 0.4);

                    // Add jitter based on audio
                    const jitterX = (Math.random() - 0.5) * val * 15;
                    const jitterY = (Math.random() - 0.5) * val * 15;

                    const x = CX + Math.cos(spiralAngle) * r + jitterX;
                    const y = CY + Math.sin(spiralAngle) * r + jitterY;

                    const hue = (arm * 60 + ratio * 120 + time * 20) % 360;
                    const size = 1 + val * 4 + bassNorm * 2;
                    const alpha = 0.3 + val * 0.7;

                    ctx.beginPath();
                    ctx.arc(x, y, size, 0, Math.PI * 2);
                    ctx.fillStyle = `hsla(${hue}, 85%, 70%, ${alpha})`;
                    ctx.fill();

                    // Glow on loud particles
                    if (val > 0.6) {
                        ctx.shadowBlur = 10;
                        ctx.shadowColor = `hsla(${hue}, 90%, 60%, 0.8)`;
                        ctx.beginPath();
                        ctx.arc(x, y, size * 0.5, 0, Math.PI * 2);
                        ctx.fillStyle = '#fff';
                        ctx.fill();
                        ctx.shadowBlur = 0;
                    }
                }
            }

            // Center nebula core
            const nebulaSize = 30 + bassNorm * 50;
            const nebGrad = ctx.createRadialGradient(CX, CY, 0, CX, CY, nebulaSize);
            const nhue = (time * 25) % 360;
            nebGrad.addColorStop(0, `hsla(${nhue}, 80%, 80%, ${0.4 + bassNorm * 0.4})`);
            nebGrad.addColorStop(0.5, `hsla(${nhue + 30}, 70%, 50%, ${0.15 + midNorm * 0.2})`);
            nebGrad.addColorStop(1, 'rgba(0,0,0,0)');
            ctx.beginPath();
            ctx.arc(CX, CY, nebulaSize, 0, Math.PI * 2);
            ctx.fillStyle = nebGrad;
            ctx.fill();
        }

        // ─── Main Loop ─────────────────────────────────────────────
        function loop() {
            if (!running) return;
            requestAnimationFrame(loop);

            time += 0.016;
            analyser.getByteFrequencyData(dataArray);

            const volume = getAverageVolume();
            const bass = getBassLevel();
            const mid = getMidLevel();
            const treble = getTrebleLevel();

            // Smooth volume for UI
            smoothVolume += (volume - smoothVolume) * 0.15;
            volFill.style.height = Math.min(100, smoothVolume / 255 * 100 * 2.5) + '%';

            drawBackground(volume);

            switch (currentMode) {
                case 0: drawRingMode(volume, bass, mid, treble); break;
                case 1: drawWaveMode(volume, bass, mid, treble); break;
                case 2: drawGalaxyMode(volume, bass, mid, treble); break;
            }
        }

        // Idle animation before start
        function idleLoop() {
            if (running) return;
            requestAnimationFrame(idleLoop);
            time += 0.008;
            ctx.fillStyle = 'rgba(0,0,0,0.08)';
            ctx.fillRect(0, 0, W, H);
            stars.forEach(s => {
                s.twinkle += 0.015;
                const alpha = 0.2 + Math.sin(s.twinkle) * 0.2;
                ctx.beginPath();
                ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(180, 150, 255, ${alpha})`;
                ctx.fill();
                s.y += s.speed;
                if (s.y > H + 5) { s.y = -5; s.x = Math.random() * W; }
            });
        }
        idleLoop();
    })();
    </script>
</body>
</html>
