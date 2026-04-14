<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tata Surya Interaktif - Jelajahi Planet!</title>
    <meta name="description" content="Animasi tata surya interaktif untuk belajar tentang planet-planet di sistem tata surya kita. Cocok untuk anak SD!">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #000011;
            overflow: hidden;
            height: 100vh; width: 100vw;
            font-family: 'Inter', sans-serif;
            color: #fff;
            cursor: default;
        }

        canvas { position: fixed; top: 0; left: 0; width: 100%; height: 100%; }

        .back-btn {
            position: fixed; top: 16px; left: 16px; z-index: 200;
            background: rgba(0, 30, 80, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(100, 180, 255, 0.3);
            border-radius: 30px; padding: 10px 20px;
            color: #8ec8ff; text-decoration: none;
            font-size: 13px; font-weight: 600;
            transition: all 0.3s;
        }
        .back-btn:hover { background: rgba(0,60,150,0.5); color: #fff; transform: scale(1.05); }

        /* Planet Info Card */
        #info-card {
            position: fixed; right: 30px; top: 50%; transform: translateY(-50%);
            width: 320px; z-index: 100;
            background: rgba(5, 10, 30, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(100, 180, 255, 0.25);
            border-radius: 24px; padding: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
            opacity: 0; pointer-events: none;
            transition: opacity 0.4s, transform 0.4s;
        }
        #info-card.visible { opacity: 1; pointer-events: auto; transform: translateY(-50%) scale(1); }
        #info-card.hidden-card { transform: translateY(-50%) scale(0.9); }

        #info-card .planet-icon {
            width: 70px; height: 70px; border-radius: 50%;
            margin: 0 auto 16px; display: block;
            box-shadow: 0 0 30px var(--planet-glow, rgba(100,180,255,0.5));
        }
        #info-card h2 { text-align: center; font-size: 1.5rem; margin-bottom: 4px; }
        #info-card .subtitle { text-align: center; font-size: 0.8rem; color: rgba(255,255,255,0.4); margin-bottom: 20px; }

        .fact-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            font-size: 0.85rem;
        }
        .fact-row:last-child { border-bottom: none; }
        .fact-label { color: rgba(255,255,255,0.5); }
        .fact-value { font-weight: 600; color: #8ec8ff; }

        .fun-fact {
            margin-top: 16px; padding: 14px;
            background: rgba(100, 180, 255, 0.08);
            border-radius: 14px;
            border-left: 3px solid #4facfe;
            font-size: 0.82rem; line-height: 1.5;
            color: rgba(255,255,255,0.75);
        }
        .fun-fact strong { color: #ffd700; }

        #close-card {
            position: absolute; top: 12px; right: 14px;
            background: rgba(255,255,255,0.1); border: none;
            color: rgba(255,255,255,0.5); cursor: pointer;
            font-size: 18px; width: 30px; height: 30px;
            border-radius: 50%; transition: all 0.2s;
        }
        #close-card:hover { background: rgba(255,255,255,0.2); color: #fff; }

        /* Title HUD */
        #title-hud {
            position: fixed; top: 16px; left: 50%; transform: translateX(-50%);
            z-index: 100; text-align: center;
            pointer-events: none;
        }
        #title-hud h1 {
            font-size: 1.1rem; font-weight: 700; letter-spacing: 3px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        #title-hud p { font-size: 0.7rem; color: rgba(255,255,255,0.35); margin-top: 4px; }

        /* Speed Control */
        #speed-control {
            position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
            z-index: 100; display: flex; gap: 8px; align-items: center;
            background: rgba(5,10,30,0.6); backdrop-filter: blur(10px);
            padding: 10px 20px; border-radius: 30px;
            border: 1px solid rgba(100,180,255,0.15);
        }
        #speed-control label { font-size: 0.75rem; color: rgba(255,255,255,0.5); }
        #speed-slider {
            -webkit-appearance: none; appearance: none;
            width: 120px; height: 4px;
            background: rgba(100,180,255,0.2); border-radius: 4px; outline: none;
        }
        #speed-slider::-webkit-slider-thumb {
            -webkit-appearance: none; appearance: none;
            width: 14px; height: 14px; border-radius: 50%;
            background: #4facfe; cursor: pointer;
        }
        #speed-label { font-size: 0.75rem; color: #8ec8ff; font-weight: 600; min-width: 30px; }

        /* Hover hint */
        #hover-hint {
            position: fixed; bottom: 70px; left: 50%; transform: translateX(-50%);
            font-size: 0.75rem; color: rgba(255,255,255,0.25);
            z-index: 100; pointer-events: none;
            animation: fade-hint 3s ease-in-out infinite;
        }
        @keyframes fade-hint { 0%,100%{opacity:0.3} 50%{opacity:0.7} }

        @media (max-width: 768px) {
            #info-card {
                right: 10px; left: 10px; width: auto;
                top: auto; bottom: 80px; transform: none;
                max-height: 50vh; overflow-y: auto;
            }
            #info-card.visible { transform: none; }
            #info-card.hidden-card { transform: translateY(20px); }
        }
    </style>
</head>
<body>

    <a href="{{ route('home') }}" class="back-btn">← Kembali ke Blog</a>

    <div id="title-hud">
        <h1>TATA SURYA INTERAKTIF</h1>
        <p>Klik planet untuk belajar!</p>
    </div>

    <canvas id="solar-canvas"></canvas>

    <div id="hover-hint">🖱️ Klik planet manapun untuk melihat informasi</div>

    <div id="speed-control">
        <label>Kecepatan:</label>
        <input type="range" id="speed-slider" min="0" max="300" value="100">
        <span id="speed-label">1x</span>
    </div>

    <!-- Planet Info Card -->
    <div id="info-card" class="hidden-card">
        <button id="close-card">✕</button>
        <canvas class="planet-icon" id="planet-icon-canvas" width="70" height="70"></canvas>
        <h2 id="card-name"></h2>
        <div class="subtitle" id="card-type"></div>
        <div id="card-facts"></div>
        <div class="fun-fact" id="card-fun"></div>
    </div>

    <script>
    (function() {
        const canvas = document.getElementById('solar-canvas');
        const ctx = canvas.getContext('2d');
        const infoCard = document.getElementById('info-card');
        const iconCanvas = document.getElementById('planet-icon-canvas');
        const iconCtx = iconCanvas.getContext('2d');
        const speedSlider = document.getElementById('speed-slider');
        const speedLabel = document.getElementById('speed-label');

        let W, H, CX, CY;
        let time = 0;
        let speedMult = 1;
        let selectedPlanet = null;
        let hoverPlanet = null;

        function resize() {
            W = window.innerWidth; H = window.innerHeight;
            CX = W / 2; CY = H / 2;
            canvas.width = W; canvas.height = H;
        }
        resize();
        window.addEventListener('resize', resize);

        speedSlider.addEventListener('input', () => {
            speedMult = speedSlider.value / 100;
            speedLabel.textContent = speedMult.toFixed(1) + 'x';
        });

        // ─── Planet Data ────────────────────────────────────────
        const planets = [
            {
                name: 'Matahari', type: 'Bintang', orbitR: 0, size: 40,
                color: '#FDB813', glow: '#ff8800', speed: 0,
                facts: [
                    { label: 'Tipe', value: 'Bintang Katai Kuning' },
                    { label: 'Diameter', value: '1.392.700 km' },
                    { label: 'Suhu Permukaan', value: '5.500 °C' },
                    { label: 'Umur', value: '4,6 miliar tahun' },
                ],
                funFact: '<strong>Tahukah kamu?</strong> Matahari sangat besar! Kamu bisa memasukkan <strong>1,3 juta bumi</strong> ke dalamnya. Matahari memberikan cahaya dan kehangatan agar makhluk hidup bisa bertahan di bumi. 🌞'
            },
            {
                name: 'Merkurius', type: 'Planet Kebumian', orbitR: 70, size: 6,
                color: '#8c7e6d', glow: '#a09080', speed: 4.15,
                facts: [
                    { label: 'Urutan', value: 'Planet ke-1' },
                    { label: 'Diameter', value: '4.879 km' },
                    { label: 'Jarak dari Matahari', value: '58 juta km' },
                    { label: 'Lama 1 Tahun', value: '88 hari' },
                ],
                funFact: '<strong>Tahukah kamu?</strong> Merkurius adalah planet <strong>tercepat</strong>! Ia mengelilingi Matahari hanya dalam 88 hari. Tapi satu harinya lebih lama dari satu tahunnya lho! 🏃‍♂️'
            },
            {
                name: 'Venus', type: 'Planet Kebumian', orbitR: 100, size: 9,
                color: '#e8cda0', glow: '#ddc090', speed: 1.62,
                facts: [
                    { label: 'Urutan', value: 'Planet ke-2' },
                    { label: 'Diameter', value: '12.104 km' },
                    { label: 'Jarak dari Matahari', value: '108 juta km' },
                    { label: 'Lama 1 Tahun', value: '225 hari' },
                ],
                funFact: '<strong>Tahukah kamu?</strong> Venus adalah planet <strong>terpanas</strong> di tata surya (462°C)! Lebih panas dari Merkurius yang lebih dekat ke Matahari. Venus juga disebut <strong>Bintang Kejora</strong>. ⭐'
            },
            {
                name: 'Bumi', type: 'Planet Kebumian', orbitR: 140, size: 10,
                color: '#4a90d9', glow: '#2070cc', speed: 1.0,
                facts: [
                    { label: 'Urutan', value: 'Planet ke-3' },
                    { label: 'Diameter', value: '12.742 km' },
                    { label: 'Jarak dari Matahari', value: '150 juta km' },
                    { label: 'Lama 1 Tahun', value: '365 hari' },
                ],
                funFact: '<strong>Tahukah kamu?</strong> Bumi adalah satu-satunya planet yang memiliki <strong>air cair</strong> dan <strong>kehidupan</strong>! 71% permukaan Bumi tertutup air. Bumi punya 1 bulan bernama <strong>Bulan</strong>. 🌍'
            },
            {
                name: 'Mars', type: 'Planet Kebumian', orbitR: 185, size: 8,
                color: '#c1440e', glow: '#cc3300', speed: 0.53,
                facts: [
                    { label: 'Urutan', value: 'Planet ke-4' },
                    { label: 'Diameter', value: '6.779 km' },
                    { label: 'Jarak dari Matahari', value: '228 juta km' },
                    { label: 'Lama 1 Tahun', value: '687 hari' },
                ],
                funFact: '<strong>Tahukah kamu?</strong> Mars dijuluki <strong>Planet Merah</strong> karena tanahnya berwarna kemerahan. Mars punya gunung tertinggi di tata surya bernama <strong>Olympus Mons</strong> setinggi 22 km! 🏔️'
            },
            {
                name: 'Jupiter', type: 'Planet Gas Raksasa', orbitR: 250, size: 25,
                color: '#c88b3a', glow: '#cc7700', speed: 0.084,
                facts: [
                    { label: 'Urutan', value: 'Planet ke-5' },
                    { label: 'Diameter', value: '139.820 km' },
                    { label: 'Jarak dari Matahari', value: '778 juta km' },
                    { label: 'Jumlah Bulan', value: '95 bulan!' },
                ],
                funFact: '<strong>Tahukah kamu?</strong> Jupiter adalah planet <strong>terbesar</strong>! Ia bisa memuat <strong>1.300 Bumi</strong> di dalamnya. Jupiter punya bintik merah raksasa yang sebenarnya adalah badai super besar! 🌪️'
            },
            {
                name: 'Saturnus', type: 'Planet Gas Raksasa', orbitR: 320, size: 21,
                color: '#ead6a6', glow: '#ddbb66', speed: 0.034, hasRings: true,
                facts: [
                    { label: 'Urutan', value: 'Planet ke-6' },
                    { label: 'Diameter', value: '116.460 km' },
                    { label: 'Jarak dari Matahari', value: '1,4 miliar km' },
                    { label: 'Jumlah Bulan', value: '146 bulan!' },
                ],
                funFact: '<strong>Tahukah kamu?</strong> Saturnus terkenal dengan <strong>cincinnya yang indah</strong>! Cincinnya terbuat dari es dan batuan. Saturnus sangat ringan — kalau ada kolam renang raksasa, Saturnus akan <strong>mengapung</strong>! 💍'
            },
            {
                name: 'Uranus', type: 'Planet Es Raksasa', orbitR: 385, size: 15,
                color: '#72b5c7', glow: '#55aacc', speed: 0.012,
                facts: [
                    { label: 'Urutan', value: 'Planet ke-7' },
                    { label: 'Diameter', value: '50.724 km' },
                    { label: 'Jarak dari Matahari', value: '2,9 miliar km' },
                    { label: 'Lama 1 Tahun', value: '84 tahun Bumi' },
                ],
                funFact: '<strong>Tahukah kamu?</strong> Uranus <strong>berputar miring</strong> — seolah-olah menggelinding seperti bola! Uranus juga merupakan planet <strong>terdingin</strong> di tata surya dengan suhu -224°C. 🥶'
            },
            {
                name: 'Neptunus', type: 'Planet Es Raksasa', orbitR: 440, size: 14,
                color: '#3f5fc4', glow: '#2244cc', speed: 0.006,
                facts: [
                    { label: 'Urutan', value: 'Planet ke-8' },
                    { label: 'Diameter', value: '49.528 km' },
                    { label: 'Jarak dari Matahari', value: '4,5 miliar km' },
                    { label: 'Lama 1 Tahun', value: '165 tahun Bumi' },
                ],
                funFact: '<strong>Tahukah kamu?</strong> Neptunus punya angin <strong>tercepat</strong> di tata surya, bisa sampai <strong>2.100 km/jam</strong>! Planet ini berwarna biru indah karena gas metana di atmosfernya. 💨'
            }
        ];

        // ─── Stars Background ──────────────────────────────────
        const STAR_COUNT = 500;
        const stars = [];
        for (let i = 0; i < STAR_COUNT; i++) {
            stars.push({
                x: Math.random(), y: Math.random(),
                r: Math.random() * 1.5 + 0.3,
                twinkle: Math.random() * Math.PI * 2,
                speed: Math.random() * 0.01 + 0.002
            });
        }

        function drawStars() {
            stars.forEach(s => {
                s.twinkle += s.speed;
                const alpha = 0.3 + Math.sin(s.twinkle) * 0.3;
                ctx.beginPath();
                ctx.arc(s.x * W, s.y * H, s.r, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(200, 210, 255, ${alpha})`;
                ctx.fill();
            });
        }

        // ─── Draw Planet ───────────────────────────────────────
        function drawPlanet(p, x, y) {
            // Glow
            const glowSize = p.size * 2.5;
            const grad = ctx.createRadialGradient(x, y, p.size * 0.5, x, y, glowSize);
            grad.addColorStop(0, p.glow + '40');
            grad.addColorStop(1, p.glow + '00');
            ctx.beginPath();
            ctx.arc(x, y, glowSize, 0, Math.PI * 2);
            ctx.fillStyle = grad;
            ctx.fill();

            // Planet body
            const bodyGrad = ctx.createRadialGradient(x - p.size * 0.3, y - p.size * 0.3, 0, x, y, p.size);
            bodyGrad.addColorStop(0, lightenColor(p.color, 40));
            bodyGrad.addColorStop(0.7, p.color);
            bodyGrad.addColorStop(1, darkenColor(p.color, 40));
            ctx.beginPath();
            ctx.arc(x, y, p.size, 0, Math.PI * 2);
            ctx.fillStyle = bodyGrad;
            ctx.fill();

            // Saturn rings
            if (p.hasRings) {
                ctx.save();
                ctx.translate(x, y);
                ctx.scale(1, 0.35);
                ctx.beginPath();
                ctx.arc(0, 0, p.size * 1.7, 0, Math.PI * 2);
                ctx.strokeStyle = 'rgba(220, 200, 160, 0.5)';
                ctx.lineWidth = 4;
                ctx.stroke();
                ctx.beginPath();
                ctx.arc(0, 0, p.size * 2.0, 0, Math.PI * 2);
                ctx.strokeStyle = 'rgba(200, 180, 140, 0.3)';
                ctx.lineWidth = 3;
                ctx.stroke();
                ctx.restore();
            }

            // Earth special: blue + green patches + tiny moon
            if (p.name === 'Bumi') {
                // Green continent patches
                ctx.beginPath();
                ctx.arc(x - 2, y - 1, p.size * 0.4, 0.3, 1.8);
                ctx.fillStyle = 'rgba(60, 160, 60, 0.4)';
                ctx.fill();
                ctx.beginPath();
                ctx.arc(x + 3, y + 2, p.size * 0.3, 0, 1.2);
                ctx.fillStyle = 'rgba(60, 140, 60, 0.3)';
                ctx.fill();

                // Tiny moon orbiting Earth
                const moonAngle = time * 3;
                const moonDist = p.size * 2.2;
                const mx = x + Math.cos(moonAngle) * moonDist;
                const my = y + Math.sin(moonAngle) * moonDist * 0.6;
                ctx.beginPath();
                ctx.arc(mx, my, 2.5, 0, Math.PI * 2);
                ctx.fillStyle = '#ccc';
                ctx.fill();
            }

            // Sun special: corona + flares
            if (p.name === 'Matahari') {
                ctx.shadowBlur = 40;
                ctx.shadowColor = '#ff8800';
                ctx.beginPath();
                ctx.arc(x, y, p.size, 0, Math.PI * 2);
                ctx.fillStyle = bodyGrad;
                ctx.fill();
                ctx.shadowBlur = 0;

                // Solar flares
                for (let i = 0; i < 12; i++) {
                    const angle = (i / 12) * Math.PI * 2 + time * 0.5;
                    const flareLen = p.size * (1.3 + Math.sin(time * 3 + i) * 0.3);
                    const fx = x + Math.cos(angle) * flareLen;
                    const fy = y + Math.sin(angle) * flareLen;
                    ctx.beginPath();
                    ctx.moveTo(x + Math.cos(angle) * p.size, y + Math.sin(angle) * p.size);
                    ctx.lineTo(fx, fy);
                    ctx.strokeStyle = `rgba(255, 200, 50, ${0.15 + Math.sin(time*2+i)*0.1})`;
                    ctx.lineWidth = 1.5;
                    ctx.stroke();
                }
            }

            // Hover indicator
            if (hoverPlanet === p && p.name !== 'Matahari') {
                ctx.beginPath();
                ctx.arc(x, y, p.size + 6, 0, Math.PI * 2);
                ctx.strokeStyle = 'rgba(255,255,255,0.4)';
                ctx.lineWidth = 1.5;
                ctx.setLineDash([4, 4]);
                ctx.stroke();
                ctx.setLineDash([]);

                // Name label
                ctx.font = '600 12px Inter, sans-serif';
                ctx.fillStyle = 'rgba(255,255,255,0.8)';
                ctx.textAlign = 'center';
                ctx.fillText(p.name, x, y - p.size - 10);
            }

            // Selected highlight
            if (selectedPlanet === p) {
                ctx.beginPath();
                ctx.arc(x, y, p.size + 8, 0, Math.PI * 2);
                ctx.strokeStyle = '#4facfe';
                ctx.lineWidth = 2;
                ctx.stroke();
            }
        }

        function lightenColor(hex, percent) {
            const num = parseInt(hex.replace('#',''), 16);
            const r = Math.min(255, (num >> 16) + percent);
            const g = Math.min(255, ((num >> 8) & 0x00FF) + percent);
            const b = Math.min(255, (num & 0x0000FF) + percent);
            return `rgb(${r},${g},${b})`;
        }

        function darkenColor(hex, percent) {
            const num = parseInt(hex.replace('#',''), 16);
            const r = Math.max(0, (num >> 16) - percent);
            const g = Math.max(0, ((num >> 8) & 0x00FF) - percent);
            const b = Math.max(0, (num & 0x0000FF) - percent);
            return `rgb(${r},${g},${b})`;
        }

        // ─── Compute Positions ─────────────────────────────────
        function getScale() {
            const minDim = Math.min(W, H);
            return minDim / 1000;
        }

        function getPlanetPos(p) {
            if (p.orbitR === 0) return { x: CX, y: CY }; // Sun
            const scale = getScale();
            const angle = time * p.speed * 0.5;
            return {
                x: CX + Math.cos(angle) * p.orbitR * scale,
                y: CY + Math.sin(angle) * p.orbitR * scale * 0.45 // Elliptical
            };
        }

        // ─── Draw Info Card ────────────────────────────────────
        function showInfoCard(p) {
            selectedPlanet = p;
            infoCard.style.setProperty('--planet-glow', p.glow);

            document.getElementById('card-name').textContent = p.name;
            document.getElementById('card-type').textContent = p.type;

            // Draw planet icon
            iconCtx.clearRect(0, 0, 70, 70);
            const iGrad = iconCtx.createRadialGradient(28, 28, 0, 35, 35, 35);
            iGrad.addColorStop(0, lightenColor(p.color, 50));
            iGrad.addColorStop(0.7, p.color);
            iGrad.addColorStop(1, darkenColor(p.color, 50));
            iconCtx.beginPath();
            iconCtx.arc(35, 35, 30, 0, Math.PI * 2);
            iconCtx.fillStyle = iGrad;
            iconCtx.fill();

            // Facts
            const factsEl = document.getElementById('card-facts');
            factsEl.innerHTML = p.facts.map(f =>
                `<div class="fact-row"><span class="fact-label">${f.label}</span><span class="fact-value">${f.value}</span></div>`
            ).join('');

            document.getElementById('card-fun').innerHTML = p.funFact;

            infoCard.classList.remove('hidden-card');
            infoCard.classList.add('visible');
        }

        document.getElementById('close-card').addEventListener('click', () => {
            infoCard.classList.remove('visible');
            infoCard.classList.add('hidden-card');
            selectedPlanet = null;
        });

        // ─── Mouse Interaction ─────────────────────────────────
        let mouseX = -1, mouseY = -1;

        canvas.addEventListener('mousemove', e => {
            mouseX = e.clientX; mouseY = e.clientY;
            hoverPlanet = null;
            for (let i = planets.length - 1; i >= 0; i--) {
                const pos = getPlanetPos(planets[i]);
                const dx = mouseX - pos.x, dy = mouseY - pos.y;
                const hitR = Math.max(planets[i].size + 10, 20);
                if (dx * dx + dy * dy < hitR * hitR) {
                    hoverPlanet = planets[i];
                    break;
                }
            }
            canvas.style.cursor = hoverPlanet ? 'pointer' : 'default';
        });

        canvas.addEventListener('click', () => {
            if (hoverPlanet) {
                showInfoCard(hoverPlanet);
            }
        });

        // Touch support
        canvas.addEventListener('touchstart', e => {
            const touch = e.touches[0];
            mouseX = touch.clientX; mouseY = touch.clientY;
            for (let i = planets.length - 1; i >= 0; i--) {
                const pos = getPlanetPos(planets[i]);
                const dx = mouseX - pos.x, dy = mouseY - pos.y;
                const hitR = Math.max(planets[i].size + 15, 25);
                if (dx * dx + dy * dy < hitR * hitR) {
                    showInfoCard(planets[i]);
                    break;
                }
            }
        });

        // ─── Main Loop ─────────────────────────────────────────
        function loop() {
            requestAnimationFrame(loop);
            time += 0.008 * speedMult;

            // Clear
            ctx.fillStyle = '#000011';
            ctx.fillRect(0, 0, W, H);

            drawStars();

            const scale = getScale();

            // Draw orbit paths
            for (let i = 1; i < planets.length; i++) {
                const p = planets[i];
                ctx.save();
                ctx.translate(CX, CY);
                ctx.scale(1, 0.45);
                ctx.beginPath();
                ctx.arc(0, 0, p.orbitR * scale, 0, Math.PI * 2);
                ctx.strokeStyle = 'rgba(100, 150, 255, 0.08)';
                ctx.lineWidth = 1;
                ctx.stroke();
                ctx.restore();
            }

            // Draw planets (Sun first, then by orbit order)
            planets.forEach(p => {
                const pos = getPlanetPos(p);
                drawPlanet(p, pos.x, pos.y);
            });
        }

        loop();
    })();
    </script>
</body>
</html>
