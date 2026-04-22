<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sihir Visual - Latihan Dimensi</title>
    <meta name="description" content="Animasi mantra sihir interaktif menggunakan hand-tracking dengan efek visual elemen api bersinar.">
    <style>
        body { 
            margin: 0; overflow: hidden; background-color: #020202; color: #fff; font-family: 'Inter', sans-serif; 
        }
        .container { position: relative; width: 100vw; height: 100vh; }
        
        /* Video tersembunyi, hanya sebagai umpan untuk MediaPipe */
        #video-input {
            position: absolute; top: -1000px; opacity: 0;
        }

        /* Canvas Merender Sihir */
        #magic-canvas {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
            transform: scaleX(-1); /* Mirror canvas */
            z-index: 5;
            mix-blend-mode: screen; 
        }

        /* UI Overlays */
        .back-btn {
            position: absolute; top: 20px; left: 20px;
            z-index: 100;
            background: rgba(255, 160, 0, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 200, 0, 0.4);
            border-radius: 30px; padding: 10px 20px;
            color: #ffda75; text-decoration: none;
            font-size: 14px; font-weight: 600;
            display: flex; align-items: center; gap: 8px;
            box-shadow: 0 0 20px rgba(255, 120, 0, 0.4);
            transition: all 0.3s;
        }
        .back-btn:hover { 
            background: rgba(255, 160, 0, 0.3);
            box-shadow: 0 0 30px rgba(255, 150, 0, 0.6);
            transform: scale(1.05); 
            color: #ffffff;
        }

        #loading-ui {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.5rem; letter-spacing: 4px;
            text-transform: uppercase;
            color: #ffaa00; text-shadow: 0 0 20px #ff5500;
            animation: pulse-glow 1.5s infinite alternate;
            z-index: 50;
        }

        #hud {
            position: absolute; bottom: 30px; left: 30px;
            z-index: 10; pointer-events: none;
            background: rgba(20, 5, 0, 0.6); padding: 15px 25px;
            border-radius: 15px; border-left: 4px solid #ff7700;
            backdrop-filter: blur(10px); color: #ffdcb5;
        }
        #hud h1 { margin: 0; font-size: 1.1rem; color: #ffaa00; text-transform: uppercase; letter-spacing: 1px;}
        #hud p { margin: 5px 0 0; font-size: 0.85rem; opacity: 0.8; }
        
        @keyframes pulse-glow {
            from { text-shadow: 0 0 10px #ff4400, 0 0 20px #ff2200; opacity: 0.6;}
            to { text-shadow: 0 0 15px #ffaa00, 0 0 30px #ff8800; opacity: 1;}
        }

        /* Screen flash for shockwave */
        #flash {
            position: fixed; inset: 0; background: #fff; z-index: 40;
            opacity: 0; pointer-events: none; transition: opacity 0.1s;
        }
    </style>
    
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <a href="{{ route('home') }}" class="back-btn">← Kembali ke Blog</a>
        
        <div id="loading-ui">Membangkitkan Mantra...</div>
        <div id="flash"></div>

        <video id="video-input" autoplay playsinline></video>
        <canvas id="magic-canvas"></canvas>

        <div id="hud">
            <h1>Lingkaran Sihir</h1>
            <p>Buka Tangan: Perbesar Mantra | Kepalkan: Perkecil | Dekatkan Kedua Tangan: Ledakan Energi</p>
        </div>
    </div>

    <script>
        const videoElement = document.getElementById('video-input');
        const canvasElement = document.getElementById('magic-canvas');
        const ctx = canvasElement.getContext('2d');
        const loadingUi = document.getElementById('loading-ui');
        const flashUi = document.getElementById('flash');

        let W = window.innerWidth;
        let H = window.innerHeight;
        
        window.addEventListener('resize', () => {
            W = window.innerWidth;
            H = window.innerHeight;
            canvasElement.width = W;
            canvasElement.height = H;
        });
        
        canvasElement.width = W;
        canvasElement.height = H;

        let time = 0;
        let activeHands = [];
        let particles = [];
        let lastShockwave = 0;

        // Custom Runes for the Magic Circle
        const RUNES = "ᚠᚢᚦᚨᚱᚲᚷᚹᚺᚾᛁᛃᛇᛈᛉᛊᛏᛒᛖᛗᛚᛜᛟᛞ";

        function createSparks(x, y, colorStr, amount = 1) {
            for (let i = 0; i < amount; i++) {
                particles.push({
                    x: x, y: y,
                    vx: (Math.random() - 0.5) * 6,
                    vy: (Math.random() - 0.5) * 6 - 2, // Slight upward draft
                    life: 1.0,
                    size: Math.random() * 4 + 1,
                    color: colorStr
                });
            }
        }

        function drawMagicCircle(x, y, radius, handIndex) {
            const rotSpeed = handIndex === 0 ? time : -time;
            const primaryColor = handIndex === 0 ? 'rgba(255, 140, 0, 0.9)' : 'rgba(255, 60, 0, 0.9)';
            const secondaryColor = 'rgba(255, 220, 50, 0.8)';
            const glowColor = handIndex === 0 ? '#ff5500' : '#ff0000';

            // Glow / Shadow Config
            ctx.shadowBlur = 20;
            ctx.shadowColor = glowColor;

            ctx.save();
            ctx.translate(x, y);

            // Inner solid circle
            ctx.rotate(rotSpeed * 0.5);
            ctx.beginPath();
            ctx.arc(0, 0, radius * 0.3, 0, 2 * Math.PI);
            ctx.lineWidth = 2;
            ctx.strokeStyle = primaryColor;
            ctx.stroke();

            // Geometric star / octagon inside the main circle
            ctx.rotate(rotSpeed * 0.8);
            ctx.beginPath();
            const sides = 8;
            for (let i = 0; i < sides; i++) {
                const px = Math.cos((i / sides) * Math.PI * 2) * radius * 0.8;
                const py = Math.sin((i / sides) * Math.PI * 2) * radius * 0.8;
                if (i === 0) ctx.moveTo(px, py);
                else ctx.lineTo(px, py);
            }
            ctx.closePath();
            ctx.strokeStyle = secondaryColor;
            ctx.lineWidth = 1.5;
            ctx.stroke();

            // Intersecting Triangles (like a star)
            ctx.beginPath();
            for (let i = 0; i < 3; i++) {
                let a = (i/3)*Math.PI*2;
                ctx.moveTo(Math.cos(a)*radius*0.7, Math.sin(a)*radius*0.7);
                ctx.lineTo(Math.cos(a+2.1)*radius*0.7, Math.sin(a+2.1)*radius*0.7);
            }
            ctx.strokeStyle = primaryColor;
            ctx.stroke();

            // Outer Ring with Runes
            ctx.rotate(-rotSpeed * 1.5); // Reverse rotation
            ctx.beginPath();
            ctx.arc(0, 0, radius, 0, 2 * Math.PI);
            ctx.lineWidth = 3;
            ctx.strokeStyle = primaryColor;
            ctx.stroke();

            // Draw Runes
            ctx.font = `${Math.max(10, radius * 0.15)}px Arial`;
            ctx.fillStyle = secondaryColor;
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            const numRunes = 20;
            for (let i = 0; i < numRunes; i++) {
                const angle = (i / numRunes) * Math.PI * 2;
                const rx = Math.cos(angle) * radius * 0.88;
                const ry = Math.sin(angle) * radius * 0.88;
                const runeChar = RUNES[i % RUNES.length];
                
                ctx.save();
                ctx.translate(rx, ry);
                ctx.rotate(angle + Math.PI/2);
                ctx.fillText(runeChar, 0, 0);
                ctx.restore();
            }

            // Outer decorative dash line
            ctx.beginPath();
            ctx.setLineDash([10, 15]);
            ctx.arc(0, 0, radius * 1.1, 0, 2 * Math.PI);
            ctx.lineWidth = 1;
            ctx.strokeStyle = secondaryColor;
            ctx.stroke();
            ctx.setLineDash([]);

            ctx.restore();
            ctx.shadowBlur = 0; // Reset
        }

        // Logic Rendering (Frame rate independent-ish)
        function renderLoop() {
            // Fading trail effect for motion blur
            ctx.globalCompositeOperation = 'destination-out';
            ctx.fillStyle = 'rgba(0, 0, 0, 0.4)';
            ctx.fillRect(0, 0, W, H);
            
            ctx.globalCompositeOperation = 'screen';
            time += 0.05;

            // Update particles
            for(let i=particles.length-1; i>=0; i--) {
                let p = particles[i];
                p.x += p.vx;
                p.y += p.vy;
                p.vy += 0.1; // gravity
                p.life -= 0.03;
                
                if (p.life <= 0) {
                    particles.splice(i, 1);
                } else {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(255, 180, 50, ${p.life})`;
                    ctx.shadowBlur = 10;
                    ctx.shadowColor = p.color;
                    ctx.fill();
                    ctx.shadowBlur = 0;
                }
            }

            // Draw Magic Circles based on Hand Tracking Data
            if (activeHands.length > 0) {
                let handCenters = [];

                activeHands.forEach((hand, idx) => {
                    // Coordinates logic
                    const palm = hand[9]; // Middle finger MCP (center point)
                    const thumb = hand[4];
                    const indexTip = hand[8];
                    
                    const cx = palm.x * W;
                    const cy = palm.y * H;
                    handCenters.push({x: cx, y: cy});

                    // Distance between thumb and index controls scale
                    const dist = Math.hypot(thumb.x - indexTip.x, thumb.y - indexTip.y);
                    // dist is roughly 0.02 (pinched) to 0.2 (wide open)
                    const normalizedScale = Math.max(0.1, Math.min(1.0, dist * 5)); 
                    const circleRadius = 50 + (100 * normalizedScale);

                    // Draw the magic circle
                    drawMagicCircle(cx, cy, circleRadius, idx);

                    // Emit particles from fingertips (thumb, index, middle, ring, pinky)
                    [4, 8, 12, 16, 20].forEach(fingerIndex => {
                        const tipX = hand[fingerIndex].x * W;
                        const tipY = hand[fingerIndex].y * H;
                        
                        // Small glowing dot on the fingertip
                        ctx.beginPath();
                        ctx.arc(tipX, tipY, 3, 0, Math.PI*2);
                        ctx.fillStyle = '#ffffff';
                        ctx.fill();

                        if (Math.random() > 0.4) {
                            createSparks(tipX, tipY, idx === 0 ? '#ff5500' : '#ff0000', 1);
                        }
                    });
                });

                // Detect two hands merging for shockwave
                if (activeHands.length === 2 && (performance.now() - lastShockwave > 2000)) {
                    const dist = Math.hypot(handCenters[0].x - handCenters[1].x, handCenters[0].y - handCenters[1].y);
                    if (dist < 150) { // Hands are very close
                        triggerShockwave((handCenters[0].x + handCenters[1].x)/2, (handCenters[0].y + handCenters[1].y)/2);
                        lastShockwave = performance.now();
                    }
                }
            }

            ctx.globalCompositeOperation = 'source-over';
            requestAnimationFrame(renderLoop);
        }

        function triggerShockwave(x, y) {
            flashUi.style.opacity = '0.8';
            setTimeout(() => { flashUi.style.opacity = '0'; }, 100);
            
            // Large explosion of sparks
            createSparks(x, y, '#ffaa00', 150);

            // Expanding Ring (rendered once, but will fade over physics loop)
            particles.push({
                x: x, y: y, vx: 0, vy: 0, life: 1.5, size: 200, color: '#ffffff',
                isRing: true // Could implement a specific ring particle logic, but sparks are enough
            });
        }

        // --- MediaPipe Hand Tracking Init ---
        const hands = new Hands({locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`});
        hands.setOptions({
            maxNumHands: 2,
            modelComplexity: 1, 
            minDetectionConfidence: 0.7,
            minTrackingConfidence: 0.7
        });

        hands.onResults((results) => {
            if (loadingUi.style.display !== 'none') {
                loadingUi.style.display = 'none';
            }
            activeHands = results.multiHandLandmarks || [];
        });

        const camera = new Camera(videoElement, {
            onFrame: async () => {
                await hands.send({image: videoElement});
            },
            width: 1280,
            height: 720,
            facingMode: 'user'
        });
        
        // Request explicit camera permission first
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            stream.getTracks().forEach(track => track.stop()); // Stop immediately to free hardware for MediaPipe
            camera.start();
        } catch (error) {
            console.error("Camera permission denied:", error);
            alert("Mohon izinkan akses kamera untuk melanjutkan.");
        }
        renderLoop();
    </script>
</body>
</html>
