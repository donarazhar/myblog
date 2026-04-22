<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WordCatcher: Spell Sorcerer - DnrAzhr Blog</title>
    <meta name="description" content="Permainan belajar bahasa Inggris interaktif dengan gestur tangan menggunakan teknologi MediaPipe AR.">

    <!-- MediaPipe Hands CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils/control_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Fredoka+One&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-color: #0b132b;
            --text-color: #ffffff;
            --glass-bg: rgba(28, 37, 65, 0.6);
            --glass-border: rgba(255, 255, 255, 0.1);
            --accent: #ffb703;
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
            filter: brightness(0.4) saturate(1.2); /* Darken bg so AR elements pop */
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
            border-radius: 15px;
            padding: 15px 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            min-width: 200px;
        }

        .stat {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
        }
        .stat:last-child { margin-bottom: 0; }
        .stat span.val { font-weight: 800; color: var(--accent); }

        /* The Magic Card (Top Center) */
        #magic-card {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            background: linear-gradient(135deg, rgba(28, 37, 65, 0.8), rgba(11, 19, 43, 0.9));
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 183, 3, 0.3);
            border-radius: 20px;
            padding: 15px 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6), 0 0 20px rgba(255, 183, 3, 0.2);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .card-emoji {
            font-size: 4rem;
            line-height: 1;
            margin-bottom: 5px;
            filter: drop-shadow(0 5px 10px rgba(0,0,0,0.5));
        }

        .card-translation {
            font-size: 1.2rem;
            color: #8ecaee;
            font-weight: 600;
            margin-bottom: 5px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .card-category {
            font-size: 0.75rem;
            color: rgba(255, 183, 3, 0.8);
            font-weight: 600;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
            padding: 2px 12px;
            background: rgba(255, 183, 3, 0.1);
            border: 1px solid rgba(255, 183, 3, 0.2);
            border-radius: 20px;
        }

        .spelling-box {
            display: flex;
            gap: 10px;
        }

        .letter-slot {
            width: 45px;
            height: 55px;
            background: rgba(0, 0, 0, 0.4);
            border: 2px dashed rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Fredoka One', cursive;
            font-size: 2rem;
            color: white;
            text-shadow: 0 2px 5px rgba(0,0,0,0.5);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .letter-slot.filled {
            background: rgba(255, 183, 3, 0.2);
            border: 2px solid var(--accent);
            box-shadow: 0 0 15px rgba(255, 183, 3, 0.5);
            color: var(--accent);
            transform: scale(1.1);
        }

        .letter-slot.complete {
            background: rgba(0, 255, 136, 0.2);
            border-color: #00ff88;
            color: #00ff88;
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.6);
        }

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
            background: rgba(11, 19, 43, 0.95);
            z-index: 100;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(10px);
        }

        #startOverlay h1 {
            font-family: 'Fredoka One', cursive;
            font-size: 4rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, #ffb703, #fb8500);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: center;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
        }

        .instructions {
            max-width: 600px;
            text-align: center;
            margin-bottom: 40px;
            color: #8ecaee;
            line-height: 1.6;
            font-size: 1.2rem;
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
            border-radius: 15px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.1);
            transition: transform 0.3s;
        }
        
        .control-card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.1);
        }

        .control-card h3 { 
            color: var(--accent); 
            margin-bottom: 10px;
            font-family: 'Fredoka One', cursive;
        }

        .start-btn {
            padding: 15px 50px;
            font-size: 1.5rem;
            font-family: 'Fredoka One', cursive;
            background: linear-gradient(45deg, #fb8500, #ffb703);
            border: none;
            color: white;
            border-radius: 40px;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 10px 20px rgba(251, 133, 0, 0.4);
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .start-btn:hover { 
            transform: scale(1.05) translateY(-2px); 
            box-shadow: 0 15px 25px rgba(251, 133, 0, 0.6);
        }

        .hidden { display: none !important; }
    </style>
</head>
<body>

    <div id="startOverlay">
        <h1>WordCatcher:<br>Spell Sorcerer</h1>
        <p class="instructions">Tangkap huruf yang jatuh dari langit untuk mengeja kata bahasa Inggris! Pastikan tangan terlihat jelas di kamera.</p>
        
        <div class="controls-grid">
            <div class="control-card">
                <h3 style="font-size: 2rem; margin-bottom: 10px;">👆</h3>
                <h3>Membidik</h3>
                <p>Gunakan telunjuk untuk menggerakkan kursor sihir.</p>
            </div>
            <div class="control-card">
                <h3 style="font-size: 2rem; margin-bottom: 10px;">🤏</h3>
                <h3>Menangkap</h3>
                <p>Cubit (jempol & telunjuk) untuk menangkap gelembung huruf.</p>
            </div>
            <div class="control-card">
                <h3 style="font-size: 2rem; margin-bottom: 10px;">🖐</h3>
                <h3>Menyapu</h3>
                <p>Dorong telapak tangan terbuka untuk menyapu/mengganti semua gelembung.</p>
            </div>
        </div>

        <button class="start-btn" id="startBtn">Mulai Bermain</button>
    </div>

    <div class="video-container">
        <video class="input_video" autoplay playsinline></video>
        <canvas class="output_canvas"></canvas>
    </div>

    <div id="hud" class="hidden">
        <div class="panel">
            <div class="stat">Level: <span class="val" id="ui-level">1</span></div>
            <div class="stat">Skor: <span class="val" id="ui-score">0</span></div>
            <div class="stat" id="timer-container" style="display:none;">Waktu: <span class="val" id="ui-timer" style="color:#ff0055;">--</span></div>
        </div>
    </div>

    <div id="magic-card" class="hidden">
        <div class="card-emoji" id="card-emoji">🍎</div>
        <div class="card-translation" id="card-translation">Apel</div>
        <div class="card-category" id="card-category"></div>
        <div class="spelling-box" id="spelling-box">
            <!-- Slots injected via JS -->
        </div>
    </div>

    <a href="{{ route('home') }}" class="back-btn hidden" id="backBtn">
        ← Kembali
    </a>

    <!-- Load vocab data then game logic -->
    <script src="{{ asset('js/vocab-data.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/wordcatcher.js') }}?v={{ time() }}"></script>

</body>
</html>
