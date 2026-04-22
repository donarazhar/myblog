<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speak English — Latihan Pengucapan - DnrAzhr Blog</title>
    <meta name="description" content="Latihan pengucapan bahasa Inggris dengan speech recognition. Ucapkan kalimat yang ditampilkan dan lihat hasilnya!">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <script src="{{ asset('js/sentence-data.js') }}?v={{ time() }}"></script>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter',sans-serif;background:#0a0e1a;color:#e2e8f0;min-height:100vh;overflow-x:hidden}

        /* Animated BG */
        .bg-glow{position:fixed;inset:0;z-index:0;pointer-events:none}
        .bg-glow::before,.bg-glow::after{content:'';position:absolute;border-radius:50%;filter:blur(120px);opacity:.15}
        .bg-glow::before{width:500px;height:500px;background:#6366f1;top:-100px;right:-100px;animation:drift 15s ease-in-out infinite}
        .bg-glow::after{width:400px;height:400px;background:#06b6d4;bottom:-100px;left:-100px;animation:drift 18s ease-in-out infinite reverse}
        @keyframes drift{0%,100%{transform:translate(0,0)}50%{transform:translate(60px,40px)}}

        /* Back btn */
        .back-btn{position:fixed;top:20px;left:20px;z-index:100;background:rgba(15,20,40,.6);backdrop-filter:blur(12px);border:1px solid rgba(99,102,241,.25);border-radius:30px;padding:10px 22px;color:#818cf8;text-decoration:none;font-size:.82rem;font-weight:600;display:flex;align-items:center;gap:8px;transition:all .3s}
        .back-btn:hover{background:rgba(99,102,241,.15);border-color:rgba(99,102,241,.5);color:#fff;transform:translateY(-2px)}

        /* Main container */
        .main{position:relative;z-index:1;max-width:800px;margin:0 auto;padding:80px 20px 40px}

        /* Header */
        .header{text-align:center;margin-bottom:40px}
        .header h1{font-family:'Outfit',sans-serif;font-size:clamp(1.8rem,5vw,2.8rem);font-weight:900;background:linear-gradient(135deg,#818cf8,#06b6d4,#818cf8);background-size:300% 300%;-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:gradShift 4s ease infinite;margin-bottom:8px}
        .header p{color:rgba(255,255,255,.45);font-size:.9rem}
        @keyframes gradShift{0%,100%{background-position:0% 50%}50%{background-position:100% 50%}}

        /* Category tabs */
        .tabs{display:flex;gap:8px;flex-wrap:wrap;justify-content:center;margin-bottom:32px}
        .tab{padding:8px 18px;border-radius:25px;font-size:.75rem;font-weight:600;border:1px solid rgba(99,102,241,.2);background:rgba(15,20,40,.5);color:#818cf8;cursor:pointer;transition:all .3s}
        .tab:hover,.tab.active{background:rgba(99,102,241,.2);border-color:rgba(99,102,241,.6);box-shadow:0 0 15px rgba(99,102,241,.15)}

        /* Sentence Card */
        .card{background:rgba(15,20,40,.6);backdrop-filter:blur(16px);border:1px solid rgba(99,102,241,.2);border-radius:24px;padding:36px 32px;margin-bottom:24px;text-align:center;transition:all .3s}
        .card-label{font-size:.7rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#818cf8;margin-bottom:16px}
        .sentence-en{font-family:'Outfit',sans-serif;font-size:clamp(1.3rem,3.5vw,1.8rem);font-weight:700;color:#fff;line-height:1.5;margin-bottom:12px;min-height:60px}
        .sentence-id{font-size:.9rem;color:rgba(255,255,255,.4);font-style:italic;margin-bottom:24px}

        /* Speaker btn */
        .speak-btn{display:inline-flex;align-items:center;gap:8px;padding:12px 28px;border-radius:30px;border:1px solid rgba(99,102,241,.3);background:rgba(99,102,241,.1);color:#818cf8;font-size:.85rem;font-weight:600;cursor:pointer;transition:all .3s;margin-bottom:8px}
        .speak-btn:hover{background:rgba(99,102,241,.25);transform:scale(1.05);box-shadow:0 0 20px rgba(99,102,241,.2)}

        /* Mic btn */
        .mic-area{margin-top:20px}
        .mic-btn{width:80px;height:80px;border-radius:50%;border:3px solid rgba(99,102,241,.3);background:rgba(15,20,40,.8);color:#818cf8;font-size:2rem;cursor:pointer;transition:all .3s;display:inline-flex;align-items:center;justify-content:center;position:relative}
        .mic-btn:hover{border-color:#818cf8;box-shadow:0 0 30px rgba(99,102,241,.3);transform:scale(1.08)}
        .mic-btn.recording{border-color:#ef4444;background:rgba(239,68,68,.15);color:#ef4444;animation:pulse-rec 1.5s infinite}
        .mic-btn.recording::after{content:'';position:absolute;inset:-8px;border-radius:50%;border:2px solid rgba(239,68,68,.3);animation:ripple 1.5s infinite}
        @keyframes pulse-rec{0%,100%{box-shadow:0 0 20px rgba(239,68,68,.2)}50%{box-shadow:0 0 40px rgba(239,68,68,.4)}}
        @keyframes ripple{0%{transform:scale(1);opacity:.6}100%{transform:scale(1.4);opacity:0}}
        .mic-label{display:block;margin-top:10px;font-size:.75rem;color:rgba(255,255,255,.4)}

        /* Result area */
        .result{margin-top:24px;display:none}
        .result.show{display:block;animation:fadeUp .4s ease}
        @keyframes fadeUp{from{opacity:0;transform:translateY(15px)}to{opacity:1;transform:translateY(0)}}
        .result-text{font-size:1rem;color:rgba(255,255,255,.7);margin-bottom:16px;line-height:1.6;padding:16px;border-radius:16px;background:rgba(15,20,40,.5);border:1px solid rgba(99,102,241,.1)}
        .result-text .correct{color:#34d399;font-weight:600}
        .result-text .wrong{color:#f87171;text-decoration:line-through;font-weight:600}

        /* Score bar */
        .score-bar{margin-top:16px}
        .score-label{display:flex;justify-content:space-between;font-size:.8rem;margin-bottom:6px}
        .score-label span:first-child{color:rgba(255,255,255,.5)}
        .score-label .pct{font-weight:700;color:#818cf8}
        .bar-track{height:8px;background:rgba(99,102,241,.1);border-radius:8px;overflow:hidden}
        .bar-fill{height:100%;border-radius:8px;transition:width .8s ease;background:linear-gradient(90deg,#818cf8,#06b6d4)}

        /* Stats */
        .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:24px}
        .stat-box{background:rgba(15,20,40,.5);border:1px solid rgba(99,102,241,.12);border-radius:16px;padding:16px;text-align:center}
        .stat-num{font-family:'Outfit',sans-serif;font-size:1.6rem;font-weight:800;color:#818cf8}
        .stat-lbl{font-size:.65rem;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:1px;margin-top:4px}

        /* Actions */
        .actions{display:flex;gap:12px;justify-content:center;margin-top:20px;flex-wrap:wrap}
        .act-btn{padding:10px 24px;border-radius:25px;font-size:.8rem;font-weight:600;border:1px solid rgba(99,102,241,.2);background:rgba(15,20,40,.5);color:#818cf8;cursor:pointer;transition:all .3s}
        .act-btn:hover{background:rgba(99,102,241,.15);border-color:rgba(99,102,241,.5)}
        .act-btn.primary{background:linear-gradient(135deg,#6366f1,#818cf8);color:#fff;border:none}
        .act-btn.primary:hover{transform:scale(1.05);box-shadow:0 0 20px rgba(99,102,241,.3)}

        /* Unsupported warning */
        .unsupported{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:16px;padding:20px;text-align:center;color:#fca5a5;margin-top:20px;display:none}
    </style>
</head>
<body>
    <div class="bg-glow"></div>

    <a href="{{ route('home') }}" class="back-btn" id="backBtn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    <div class="main">
        <div class="header">
            <h1>🎤 Speak English</h1>
            <p>Dengarkan, ucapkan, dan latih pengucapan bahasa Inggrismu!</p>
        </div>

        <div class="tabs" id="tabs"></div>

        <div class="card">
            <div class="card-label" id="cardLabel">Sapaan</div>
            <div class="sentence-en" id="sentenceEn">Loading...</div>
            <div class="sentence-id" id="sentenceId"></div>

            <button class="speak-btn" id="listenBtn" title="Dengarkan pengucapan">
                🔊 Dengarkan
            </button>

            <div class="mic-area">
                <button class="mic-btn" id="micBtn" title="Tekan untuk mulai bicara">🎤</button>
                <span class="mic-label" id="micLabel">Tekan untuk bicara</span>
            </div>

            <div class="result" id="resultArea">
                <div class="result-text" id="resultText"></div>
                <div class="score-bar">
                    <div class="score-label"><span>Akurasi</span><span class="pct" id="scorePct">0%</span></div>
                    <div class="bar-track"><div class="bar-fill" id="barFill" style="width:0%"></div></div>
                </div>
            </div>
        </div>

        <div class="actions">
            <button class="act-btn" id="retryBtn">🔄 Ulang</button>
            <button class="act-btn primary" id="nextBtn">Selanjutnya ➡️</button>
        </div>

        <div class="stats">
            <div class="stat-box"><div class="stat-num" id="statTotal">0</div><div class="stat-lbl">Total</div></div>
            <div class="stat-box"><div class="stat-num" id="statCorrect">0</div><div class="stat-lbl">Benar</div></div>
            <div class="stat-box"><div class="stat-num" id="statAvg">0%</div><div class="stat-lbl">Rata-rata</div></div>
        </div>

        <div class="unsupported" id="unsupported">
            ⚠️ Browser Anda tidak mendukung Speech Recognition. Gunakan Google Chrome untuk pengalaman terbaik.
        </div>
    </div>

    <script>
    (function() {
        // Check support
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (!SpeechRecognition) {
            document.getElementById('unsupported').style.display = 'block';
            document.getElementById('micBtn').style.display = 'none';
            document.getElementById('micLabel').style.display = 'none';
        }

        // State
        let currentCat = 'greetings';
        let currentSentence = null;
        let recognition = null;
        let isRecording = false;
        let stats = { total: 0, correct: 0, totalPct: 0 };
        let lastIdx = -1;

        const sentenceEn = document.getElementById('sentenceEn');
        const sentenceId = document.getElementById('sentenceId');
        const cardLabel = document.getElementById('cardLabel');
        const micBtn = document.getElementById('micBtn');
        const micLabel = document.getElementById('micLabel');
        const listenBtn = document.getElementById('listenBtn');
        const resultArea = document.getElementById('resultArea');
        const resultText = document.getElementById('resultText');
        const scorePct = document.getElementById('scorePct');
        const barFill = document.getElementById('barFill');

        // Build tabs
        const tabsEl = document.getElementById('tabs');
        Object.keys(sentenceCatLabels).forEach(function(key) {
            var cat = sentenceCatLabels[key];
            var btn = document.createElement('button');
            btn.className = 'tab' + (key === currentCat ? ' active' : '');
            btn.textContent = cat.emoji + ' ' + cat.label;
            btn.addEventListener('click', function() {
                currentCat = key;
                document.querySelectorAll('.tab').forEach(function(t) { t.classList.remove('active'); });
                btn.classList.add('active');
                lastIdx = -1;
                loadSentence();
            });
            tabsEl.appendChild(btn);
        });

        function loadSentence() {
            var list = sentenceBank[currentCat];
            var idx;
            do { idx = Math.floor(Math.random() * list.length); } while (idx === lastIdx && list.length > 1);
            lastIdx = idx;
            currentSentence = list[idx];

            var catInfo = sentenceCatLabels[currentCat];
            cardLabel.textContent = catInfo.emoji + ' ' + catInfo.label;
            sentenceEn.textContent = currentSentence.en;
            sentenceId.textContent = currentSentence.id;
            resultArea.classList.remove('show');
            barFill.style.width = '0%';
            scorePct.textContent = '0%';
            micLabel.textContent = 'Tekan untuk bicara';
        }

        // TTS
        listenBtn.addEventListener('click', function() {
            if (!currentSentence) return;
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                var utt = new SpeechSynthesisUtterance(currentSentence.en);
                utt.lang = 'en-US';
                utt.rate = 0.85;
                window.speechSynthesis.speak(utt);
            }
        });

        // Speech Recognition
        function startRecording() {
            if (!SpeechRecognition || isRecording) return;
            recognition = new SpeechRecognition();
            recognition.lang = 'en-US';
            recognition.interimResults = false;
            recognition.maxAlternatives = 3;
            recognition.continuous = false;

            recognition.onstart = function() {
                isRecording = true;
                micBtn.classList.add('recording');
                micLabel.textContent = '🔴 Sedang mendengarkan...';
                resultArea.classList.remove('show');
            };

            recognition.onresult = function(event) {
                var bestMatch = '';
                var bestScore = 0;
                for (var i = 0; i < event.results[0].length; i++) {
                    var transcript = event.results[0][i].transcript.trim();
                    var score = calcScore(currentSentence.en, transcript);
                    if (score > bestScore) {
                        bestScore = score;
                        bestMatch = transcript;
                    }
                }
                showResult(bestMatch, bestScore);
            };

            recognition.onerror = function(event) {
                isRecording = false;
                micBtn.classList.remove('recording');
                if (event.error === 'no-speech') {
                    micLabel.textContent = 'Tidak terdengar suara, coba lagi';
                } else if (event.error === 'not-allowed') {
                    micLabel.textContent = 'Izin mikrofon ditolak';
                } else {
                    micLabel.textContent = 'Error: ' + event.error;
                }
            };

            recognition.onend = function() {
                isRecording = false;
                micBtn.classList.remove('recording');
            };

            recognition.start();
        }

        function stopRecording() {
            if (recognition && isRecording) {
                recognition.stop();
            }
        }

        micBtn.addEventListener('click', function() {
            if (isRecording) { stopRecording(); } else { startRecording(); }
        });

        // Score calculation
        function normalize(str) {
            return str.toLowerCase().replace(/[^a-z0-9\s]/g, '').replace(/\s+/g, ' ').trim();
        }

        function calcScore(target, spoken) {
            var tWords = normalize(target).split(' ');
            var sWords = normalize(spoken).split(' ');
            var matched = 0;
            var used = {};
            for (var i = 0; i < tWords.length; i++) {
                for (var j = 0; j < sWords.length; j++) {
                    if (!used[j] && tWords[i] === sWords[j]) {
                        matched++;
                        used[j] = true;
                        break;
                    }
                }
            }
            return tWords.length > 0 ? Math.round((matched / tWords.length) * 100) : 0;
        }

        function showResult(spoken, score) {
            var tWords = normalize(currentSentence.en).split(' ');
            var sWords = normalize(spoken).split(' ');

            // Build highlighted comparison
            var html = '<strong>Kamu bilang:</strong><br>"';
            var sUsed = {};
            for (var i = 0; i < tWords.length; i++) {
                var found = false;
                for (var j = 0; j < sWords.length; j++) {
                    if (!sUsed[j] && tWords[i] === sWords[j]) {
                        found = true;
                        sUsed[j] = true;
                        break;
                    }
                }
                if (found) {
                    html += '<span class="correct">' + tWords[i] + '</span> ';
                } else {
                    html += '<span class="wrong">' + tWords[i] + '</span> ';
                }
            }
            html += '"';

            if (spoken) {
                html += '<br><br><strong>Terdengar:</strong> "' + spoken + '"';
            }

            resultText.innerHTML = html;
            scorePct.textContent = score + '%';
            barFill.style.width = score + '%';

            if (score >= 80) {
                barFill.style.background = 'linear-gradient(90deg,#34d399,#06b6d4)';
                micLabel.textContent = '🎉 Hebat! Pengucapanmu sangat bagus!';
            } else if (score >= 50) {
                barFill.style.background = 'linear-gradient(90deg,#fbbf24,#f59e0b)';
                micLabel.textContent = '👍 Lumayan! Coba lagi untuk hasil lebih baik.';
            } else {
                barFill.style.background = 'linear-gradient(90deg,#f87171,#ef4444)';
                micLabel.textContent = '💪 Ayo coba lagi! Dengarkan dulu lalu ucapkan.';
            }

            resultArea.classList.add('show');

            // Update stats
            stats.total++;
            if (score >= 80) stats.correct++;
            stats.totalPct += score;
            document.getElementById('statTotal').textContent = stats.total;
            document.getElementById('statCorrect').textContent = stats.correct;
            document.getElementById('statAvg').textContent = Math.round(stats.totalPct / stats.total) + '%';
        }

        // Next / Retry
        document.getElementById('nextBtn').addEventListener('click', loadSentence);
        document.getElementById('retryBtn').addEventListener('click', function() {
            resultArea.classList.remove('show');
            barFill.style.width = '0%';
            micLabel.textContent = 'Tekan untuk bicara';
        });

        // Init
        loadSentence();
    })();
    </script>
</body>
</html>
