<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three.js Hand-Tracked Particles</title>
    <meta name="description" content="Interactive 3D particle shapes controlled by hand gestures using MediaPipe and Three.js">
    <style>
        body { margin: 0; overflow: hidden; background-color: #050505; color: #fff; font-family: 'Inter', sans-serif; }
        canvas { display: block; filter: contrast(1.2) brightness(1.1); }
        #videoElement {
            position: absolute; top: 20px; right: 20px;
            width: 220px; height: 165px;
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transform: scaleX(-1);
            object-fit: cover;
            z-index: 100;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            background: #000;
        }
        #loading {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.2rem; letter-spacing: 2px;
            text-transform: uppercase;
            color: #00f2fe; animation: pulse 2s infinite;
        }
        #ui {
            position: absolute; bottom: 30px; left: 30px;
            z-index: 10; pointer-events: none;
            background: rgba(0,0,0,0.4); padding: 15px 25px;
            border-radius: 15px; border-left: 4px solid #4facfe;
            backdrop-filter: blur(5px);
        }
        #ui h1 { margin: 0; font-size: 1.2rem; opacity: 0.9; }
        #ui p { margin: 5px 0 0; font-size: 0.9rem; opacity: 0.6; }
        @keyframes pulse { 0%, 100% { opacity: 0.3; } 50% { opacity: 1; } }

        .back-btn {
            position: absolute; top: 20px; left: 20px;
            z-index: 100;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 12px; padding: 10px 18px;
            color: white; text-decoration: none;
            font-size: 13px; font-weight: 500;
            display: flex; align-items: center; gap: 8px;
            transition: transform 0.2s, background 0.2s;
        }
        .back-btn:hover { transform: scale(1.05); background: rgba(0,0,0,0.7); }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>
</head>
<body>
    <a href="{{ route('home') }}" class="back-btn">← Kembali ke Blog</a>
    <div id="loading">Sinkronisasi Data Tangan...</div>
    <video id="videoElement" autoplay playsinline></video>
    <div id="ui">
        <h1 id="shape-name">Bentuk: Bola</h1>
        <p>Cubit Jempol & Telunjuk: Zoom | Dekatkan Tangan: Tolak Partikel | Kepalkan: Ganti Bentuk</p>
    </div>

    <script>
        // --- 1. THREE.JS SETUP ---
        const scene = new THREE.Scene();
        scene.fog = new THREE.FogExp2(0x000000, 0.0015);

        const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 1, 2000);
        let currentZoom = 350;
        let targetZoom = 350;
        camera.position.z = currentZoom;

        const renderer = new THREE.WebGLRenderer({ antialias: true, powerPreference: "high-performance" });
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

        // --- 2. PARTICLE SYSTEM ---
        const particleCount = 6000;
        const geometry = new THREE.BufferGeometry();
        
        const positions = new Float32Array(particleCount * 3);
        const targetPositions = new Float32Array(particleCount * 3);
        const velocities = new Float32Array(particleCount * 3);
        const colors = new Float32Array(particleCount * 3);
        
        for(let i = 0; i < particleCount; i++) {
            positions[i*3] = (Math.random() - 0.5) * 800;
            positions[i*3+1] = (Math.random() - 0.5) * 800;
            positions[i*3+2] = (Math.random() - 0.5) * 800;
            
            targetPositions[i*3] = positions[i*3];
            targetPositions[i*3+1] = positions[i*3+1];
            targetPositions[i*3+2] = positions[i*3+2];

            const mix = Math.random();
            if (mix > 0.6) {
                colors[i*3] = 0.0; colors[i*3+1] = 0.95; colors[i*3+2] = 1.0;
            } else if (mix > 0.3) {
                colors[i*3] = 0.6; colors[i*3+1] = 0.2; colors[i*3+2] = 1.0;
            } else {
                colors[i*3] = 1.0; colors[i*3+1] = 0.1; colors[i*3+2] = 0.5;
            }
        }

        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));

        const material = new THREE.PointsMaterial({
            size: 2.2,
            vertexColors: true,
            blending: THREE.AdditiveBlending,
            transparent: true,
            opacity: 0.7,
            depthWrite: false
        });

        const particleSystem = new THREE.Points(geometry, material);
        scene.add(particleSystem);

        // --- 3. SHAPES ---
        const shapes = {
            bola: () => {
                for(let i = 0; i < particleCount; i++) {
                    const phi = Math.acos(-1 + (2 * i) / particleCount);
                    const theta = Math.sqrt(particleCount * Math.PI) * phi;
                    const r = 120 + Math.random() * 5;
                    targetPositions[i*3] = r * Math.cos(theta) * Math.sin(phi);
                    targetPositions[i*3+1] = r * Math.sin(theta) * Math.sin(phi);
                    targetPositions[i*3+2] = r * Math.cos(phi);
                }
            },
            spiral: () => {
                for(let i = 0; i < particleCount; i++) {
                    const ratio = i / particleCount;
                    const angle = 0.1 * i;
                    const r = mixVal(0, 150, ratio);
                    targetPositions[i*3] = r * Math.cos(angle);
                    targetPositions[i*3+1] = (ratio - 0.5) * 300;
                    targetPositions[i*3+2] = r * Math.sin(angle);
                }
            },
            donat: () => {
                const majorR = 100;
                const minorR = 40;
                for(let i = 0; i < particleCount; i++) {
                    const u = Math.random() * Math.PI * 2;
                    const v = Math.random() * Math.PI * 2;
                    targetPositions[i*3] = (majorR + minorR * Math.cos(v)) * Math.cos(u);
                    targetPositions[i*3+1] = (majorR + minorR * Math.cos(v)) * Math.sin(u);
                    targetPositions[i*3+2] = minorR * Math.sin(v);
                }
            },
            hati: () => {
                for(let i = 0; i < particleCount; i++) {
                    const t = Math.random() * Math.PI * 2;
                    const x = 16 * Math.pow(Math.sin(t), 3);
                    const y = 13 * Math.cos(t) - 5 * Math.cos(2*t) - 2 * Math.cos(3*t) - Math.cos(4*t);
                    const z = (Math.random() - 0.5) * 10;
                    const scale = 8;
                    targetPositions[i*3] = x * scale;
                    targetPositions[i*3+1] = y * scale;
                    targetPositions[i*3+2] = z * scale;
                }
            }
        };

        function mixVal(a, b, t) { return a * (1 - t) + b * t; }

        const shapeKeys = Object.keys(shapes);
        let currentShapeIndex = 0;

        function nextShape() {
            currentShapeIndex = (currentShapeIndex + 1) % shapeKeys.length;
            const name = shapeKeys[currentShapeIndex];
            shapes[name]();
            document.getElementById('shape-name').innerText = "Bentuk: " + name.charAt(0).toUpperCase() + name.slice(1);
        }

        let shapeInterval = setInterval(nextShape, 8000);
        shapes.bola();

        // --- 4. MEDIAPIPE HAND TRACKING ---
        const videoElement = document.getElementById('videoElement');
        let repelPoint = new THREE.Vector3(0, 0, 0);
        let isHandDetected = false;
        let lastGestureTime = 0;
        let gestureCooldown = 800;

        function onResults(results) {
            document.getElementById('loading').style.display = 'none';
            if (results.multiHandLandmarks && results.multiHandLandmarks.length > 0) {
                isHandDetected = true;
                const landmarks = results.multiHandLandmarks[0];
                
                const thumbTip = landmarks[4];
                const indexTip = landmarks[8];
                const midHand = landmarks[9];

                const dxZoom = thumbTip.x - indexTip.x;
                const dyZoom = thumbTip.y - indexTip.y;
                const distZoom = Math.sqrt(dxZoom * dxZoom + dyZoom * dyZoom);
                targetZoom = THREE.MathUtils.mapLinear(distZoom, 0.05, 0.4, 150, 600);
                targetZoom = Math.max(100, Math.min(targetZoom, 650));

                repelPoint.x = (midHand.x - 0.5) * -400;
                repelPoint.y = (midHand.y - 0.5) * -400;
                repelPoint.z = 0;

                const now = Date.now();
                if (now - lastGestureTime > gestureCooldown) {
                    if (isFist(landmarks)) {
                        nextShape();
                        lastGestureTime = now;
                        clearInterval(shapeInterval);
                        shapeInterval = setInterval(nextShape, 8000);
                    }
                }
            } else {
                isHandDetected = false;
                targetZoom = 350;
            }
        }

        function isFist(landmarks) {
            const fingerTips = [8, 12, 16, 20];
            const fingerMCPs = [5, 9, 13, 17];
            
            let closedCount = 0;
            for (let i = 0; i < 4; i++) {
                const tip = landmarks[fingerTips[i]];
                const mcp = landmarks[fingerMCPs[i]];
                const d = Math.sqrt((tip.x-mcp.x)**2 + (tip.y-mcp.y)**2 + (tip.z-mcp.z)**2);
                if (d < 0.1) closedCount++;
            }
            return closedCount === 4;
        }

        const hands = new Hands({ locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}` });
        hands.setOptions({ maxNumHands: 1, modelComplexity: 1, minDetectionConfidence: 0.6, minTrackingConfidence: 0.6 });
        hands.onResults(onResults);

        const cameraCV = new Camera(videoElement, {
            onFrame: async () => { await hands.send({image: videoElement}); },
            width: 640, height: 480
        });
        cameraCV.start();

        // --- 5. ANIMATION LOOP ---
        const clock = new THREE.Clock();
        const posAttr = particleSystem.geometry.attributes.position;
        const colorAttr = particleSystem.geometry.attributes.color;

        function animate() {
            requestAnimationFrame(animate);
            const time = clock.getElapsedTime();

            for(let i = 0; i < particleCount; i++) {
                const i3 = i * 3;
                
                const ax = (targetPositions[i3] - positions[i3]) * 0.04;
                const ay = (targetPositions[i3+1] - positions[i3+1]) * 0.04;
                const az = (targetPositions[i3+2] - positions[i3+2]) * 0.04;

                velocities[i3] += ax;
                velocities[i3+1] += ay;
                velocities[i3+2] += az;

                if (isHandDetected) {
                    const dx = positions[i3] - repelPoint.x;
                    const dy = positions[i3+1] - repelPoint.y;
                    const dz = positions[i3+2] - repelPoint.z;
                    const distSq = dx*dx + dy*dy + dz*dz;
                    const repelDist = 80;
                    if (distSq < repelDist * repelDist) {
                        const dist = Math.sqrt(distSq) || 1;
                        const force = (1 - dist/repelDist) * 15;
                        velocities[i3] += (dx / dist) * force;
                        velocities[i3+1] += (dy / dist) * force;
                        velocities[i3+2] += (dz / dist) * force;
                    }
                }

                velocities[i3] *= 0.92;
                velocities[i3+1] *= 0.92;
                velocities[i3+2] *= 0.92;

                positions[i3] += velocities[i3];
                positions[i3+1] += velocities[i3+1];
                positions[i3+2] += velocities[i3+2];

                positions[i3+1] += Math.sin(time * 1.5 + i * 0.1) * 0.15;

                const speed = Math.sqrt(velocities[i3]**2 + velocities[i3+1]**2 + velocities[i3+2]**2);
                if (speed > 2) {
                    colorAttr.array[i3] += (1.0 - colorAttr.array[i3]) * 0.1;
                }
            }
            posAttr.needsUpdate = true;
            colorAttr.needsUpdate = true;

            particleSystem.rotation.y += 0.005;
            particleSystem.rotation.z += Math.sin(time * 0.2) * 0.001;

            currentZoom += (targetZoom - currentZoom) * 0.06;
            camera.position.z = currentZoom;

            renderer.render(scene, camera);
        }

        animate();

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    </script>
</body>
</html>
