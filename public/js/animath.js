const videoElement = document.querySelector('.input_video');
const canvasElement = document.querySelector('.output_canvas');
const canvasCtx = canvasElement.getContext('2d');

let width = window.innerWidth;
let height = window.innerHeight;
canvasElement.width = width;
canvasElement.height = height;

window.addEventListener('resize', () => {
    width = window.innerWidth;
    height = window.innerHeight;
    canvasElement.width = width;
    canvasElement.height = height;
});

// Audio Context
let audioCtx;
const initAudio = () => {
    if (!audioCtx) {
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
};

const playSound = (type) => {
    if (!audioCtx) return;
    const osc = audioCtx.createOscillator();
    const gain = audioCtx.createGain();
    osc.connect(gain);
    gain.connect(audioCtx.destination);

    if (type === 'zap') {
        osc.type = 'sawtooth';
        osc.frequency.setValueAtTime(800, audioCtx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(40, audioCtx.currentTime + 0.1);
        gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.1);
        osc.start();
        osc.stop(audioCtx.currentTime + 0.1);
    } else if (type === 'boing') {
        osc.type = 'sine';
        osc.frequency.setValueAtTime(150, audioCtx.currentTime);
        osc.frequency.linearRampToValueAtTime(300, audioCtx.currentTime + 0.1);
        osc.frequency.linearRampToValueAtTime(100, audioCtx.currentTime + 0.3);
        gain.gain.setValueAtTime(0.5, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
        osc.start();
        osc.stop(audioCtx.currentTime + 0.3);
    } else if (type === 'woosh') {
        // Simple noise for woosh
        const bufferSize = audioCtx.sampleRate * 0.5; // 0.5 seconds
        const buffer = audioCtx.createBuffer(1, bufferSize, audioCtx.sampleRate);
        const data = buffer.getChannelData(0);
        const noiseSource = audioCtx.createBufferSource();
        noiseSource.buffer = buffer;
        const noiseFilter = audioCtx.createBiquadFilter();
        noiseFilter.type = 'lowpass';
        noiseFilter.frequency.setValueAtTime(1000, audioCtx.currentTime);
        noiseFilter.frequency.linearRampToValueAtTime(100, audioCtx.currentTime + 0.5);
        
        noiseSource.connect(noiseFilter);
        noiseFilter.connect(gain);
        gain.gain.setValueAtTime(0.5, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.5);
        noiseSource.start();
    } else if (type === 'pop') {
        osc.type = 'sine';
        osc.frequency.setValueAtTime(600, audioCtx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(100, audioCtx.currentTime + 0.1);
        gain.gain.setValueAtTime(1.0, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.1);
        osc.start();
        osc.stop(audioCtx.currentTime + 0.1);
    }
};

// Game State
let gameState = {
    score: 0,
    level: 1, // 1: +-, 2: x/, 3: mixed
    streak: 0,
    timer: 0,
    question: null,
    answers: [], // {x, y, value, radius, color, isCorrect}
    isPlaying: false,
    particles: [],
    animations: [],
    lastPinchState: false,
    cursorPos: {x: 0, y: 0},
    skipCooldown: 0
};

// Colors
const colors = ['#ff0055', '#00ffcc', '#aa00ff', '#ffcc00'];

const generateQuestion = () => {
    let operator, num1, num2, correctAnswer;
    
    // Level Logic
    let currentOps = [];
    if (gameState.level === 1) currentOps = ['+', '-'];
    else if (gameState.level === 2) currentOps = ['*', '/'];
    else currentOps = ['+', '-', '*', '/'];

    operator = currentOps[Math.floor(Math.random() * currentOps.length)];

    if (operator === '+') {
        num1 = Math.floor(Math.random() * 20) + 1;
        num2 = Math.floor(Math.random() * 20) + 1;
        correctAnswer = num1 + num2;
    } else if (operator === '-') {
        num1 = Math.floor(Math.random() * 20) + 5;
        num2 = Math.floor(Math.random() * num1);
        correctAnswer = num1 - num2;
    } else if (operator === '*') {
        num1 = Math.floor(Math.random() * 10) + 1;
        num2 = Math.floor(Math.random() * 10) + 1;
        correctAnswer = num1 * num2;
    } else if (operator === '/') {
        num2 = Math.floor(Math.random() * 10) + 1;
        correctAnswer = Math.floor(Math.random() * 10) + 1;
        num1 = num2 * correctAnswer;
    }

    gameState.question = { num1, num2, operator, correctAnswer, text: `${num1} ${operator.replace('*', '×').replace('/', '÷')} ${num2}` };

    // Generate Answers
    gameState.answers = [];
    const answersSet = new Set();
    answersSet.add(correctAnswer);

    const totalBalloons = 8; // Ditingkatkan dari 4 menjadi 8
    
    while(answersSet.size < totalBalloons) {
        let offset = Math.floor(Math.random() * 20) - 10; // Jarak angka yang salah diperlebar
        if (offset === 0) offset = 1;
        let wrongAnswer = correctAnswer + offset;
        if (wrongAnswer < 0 && operator !== '-') wrongAnswer = Math.abs(wrongAnswer);
        answersSet.add(wrongAnswer);
    }

    const answersArray = Array.from(answersSet).sort(() => Math.random() - 0.5);
    
    // Position them around the center portal
    const centerX = width / 2;
    const centerY = height / 2;
    const radius = Math.min(width, height) * 0.35; // Jari-jari lingkaran diperbesar agar tidak bertumpuk

    answersArray.forEach((ans, i) => {
        const angle = (i / totalBalloons) * Math.PI * 2 + (Math.random() * 0.2);
        gameState.answers.push({
            value: ans,
            isCorrect: ans === correctAnswer,
            x: centerX + Math.cos(angle) * radius,
            y: centerY + Math.sin(angle) * radius,
            targetX: centerX + Math.cos(angle) * radius,
            targetY: centerY + Math.sin(angle) * radius,
            radius: 40, // Ukuran balon sedikit diperkecil agar muat
            color: colors[i % colors.length],
            vy: 0,
            isBouncing: false
        });
    });

    if (gameState.level === 3) {
        gameState.timer = 15; // 15 seconds for mixed level
    }
};

const createParticles = (x, y, color, count, type) => {
    for (let i = 0; i < count; i++) {
        gameState.particles.push({
            x, y,
            vx: (Math.random() - 0.5) * 15,
            vy: (Math.random() - 0.5) * 15,
            life: 1.0,
            color,
            size: Math.random() * 5 + 2,
            type
        });
    }
};

const handleCorrectAnswer = (answerObj) => {
    playSound('pop');
    gameState.score += 10;
    gameState.streak++;
    
    if (gameState.streak >= 5 && gameState.level < 3) {
        gameState.level++;
        gameState.streak = 0;
        document.getElementById('ui-level').innerText = gameState.level === 3 ? 'Mixed' : gameState.level;
    }
    document.getElementById('ui-score').innerText = gameState.score;

    // Balloon Pop Animation
    createParticles(answerObj.x, answerObj.y, answerObj.color, 50, 'pop');
    gameState.animations.push({ type: 'pop_ring', x: answerObj.x, y: answerObj.y, life: 1.0, color: answerObj.color });

    setTimeout(generateQuestion, 1500);
    gameState.answers = []; // clear current answers
};

const handleWrongAnswer = (answerObj) => {
    playSound('boing');
    gameState.streak = 0;
    answerObj.isBouncing = true;
    answerObj.vy = -15; // bounce up
};

const updatePhysics = () => {
    // Particles
    for (let i = gameState.particles.length - 1; i >= 0; i--) {
        let p = gameState.particles[i];
        p.x += p.vx;
        p.y += p.vy;
        p.life -= 0.02;
        if (p.type === 'pop') p.vy += 0.5; // gravity
        
        if (p.life <= 0) {
            gameState.particles.splice(i, 1);
        }
    }

    // Animations
    for (let i = gameState.animations.length - 1; i >= 0; i--) {
        let a = gameState.animations[i];
        a.life -= 0.02;
        if (a.life <= 0) gameState.animations.splice(i, 1);
    }

    // Floating/Bouncing Answers
    gameState.answers.forEach(ans => {
        if (ans.isBouncing) {
            ans.y += ans.vy;
            ans.vy += 1; // gravity
            if (ans.y > ans.targetY) {
                ans.y = ans.targetY;
                ans.vy *= -0.5; // dampening bounce
                if (Math.abs(ans.vy) < 1) ans.isBouncing = false;
            }
        } else {
            // Float around target
            ans.x = ans.targetX + Math.sin(Date.now() / 500 + ans.value) * 10;
            ans.y = ans.targetY + Math.cos(Date.now() / 600 + ans.value) * 10;
        }
    });

    if (gameState.skipCooldown > 0) gameState.skipCooldown--;
};

const drawPortal = () => {
    if (!gameState.isPlaying || !gameState.question) return;

    const cx = width / 2;
    const cy = height / 2;

    // Portal glowing rings
    const time = Date.now() / 1000;
    canvasCtx.save();
    canvasCtx.translate(cx, cy);
    canvasCtx.rotate(time * 0.5);
    
    for (let i = 0; i < 3; i++) {
        canvasCtx.beginPath();
        canvasCtx.arc(0, 0, 100 + i * 15, 0, Math.PI * 2);
        canvasCtx.strokeStyle = `hsla(${time * 50 + i * 40}, 100%, 60%, 0.5)`;
        canvasCtx.lineWidth = 5 + Math.sin(time * 2 + i) * 3;
        canvasCtx.setLineDash([20, 15]);
        canvasCtx.stroke();
    }
    canvasCtx.restore();

    // Portal Text
    canvasCtx.fillStyle = '#fff';
    canvasCtx.font = 'bold 60px Inter';
    canvasCtx.textAlign = 'center';
    canvasCtx.textBaseline = 'middle';
    canvasCtx.shadowColor = '#00ffcc';
    canvasCtx.shadowBlur = 20;
    canvasCtx.fillText(gameState.question.text, cx, cy);
    canvasCtx.shadowBlur = 0;

    // Timer if level 3
    if (gameState.level === 3) {
        canvasCtx.fillStyle = gameState.timer < 5 ? '#ff0055' : '#00ffcc';
        canvasCtx.font = '30px Inter';
        canvasCtx.fillText(Math.ceil(gameState.timer) + 's', cx, cy + 80);
    }
};

const drawAnswers = () => {
    gameState.answers.forEach(ans => {
        canvasCtx.beginPath();
        canvasCtx.arc(ans.x, ans.y, ans.radius, 0, Math.PI * 2);
        canvasCtx.fillStyle = `rgba(20, 25, 40, 0.8)`;
        canvasCtx.fill();
        canvasCtx.lineWidth = 4;
        canvasCtx.strokeStyle = ans.color;
        canvasCtx.shadowColor = ans.color;
        canvasCtx.shadowBlur = 15;
        canvasCtx.stroke();
        canvasCtx.shadowBlur = 0;

        canvasCtx.fillStyle = '#fff';
        canvasCtx.font = 'bold 40px Inter';
        canvasCtx.textAlign = 'center';
        canvasCtx.textBaseline = 'middle';
        canvasCtx.fillText(ans.value, ans.x, ans.y);
    });
};

const drawParticlesAndAnimations = () => {
    // Particles
    gameState.particles.forEach(p => {
        canvasCtx.beginPath();
        canvasCtx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
        canvasCtx.fillStyle = p.color;
        canvasCtx.globalAlpha = p.life;
        canvasCtx.fill();
    });
    canvasCtx.globalAlpha = 1.0;

    // Animations
    gameState.animations.forEach(a => {
        if (a.type === 'cloner') {
            canvasCtx.globalAlpha = a.life;
            canvasCtx.fillStyle = '#fff';
            canvasCtx.font = 'bold 30px Inter';
            for(let i=0; i<8; i++) {
                const angle = (i / 8) * Math.PI * 2;
                const dist = (1 - a.life) * 150;
                canvasCtx.fillText(a.val, a.x + Math.cos(angle)*dist, a.y + Math.sin(angle)*dist);
            }
        } else if (a.type === 'slicer') {
            canvasCtx.globalAlpha = a.life;
            canvasCtx.beginPath();
            canvasCtx.moveTo(a.x - 100, a.y - 100);
            canvasCtx.lineTo(a.x + 100, a.y + 100);
            canvasCtx.strokeStyle = '#fff';
            canvasCtx.lineWidth = 5;
            canvasCtx.shadowColor = '#00ffcc';
            canvasCtx.shadowBlur = 20;
            canvasCtx.stroke();
        } else if (a.type === 'push') {
            canvasCtx.globalAlpha = a.life;
            canvasCtx.beginPath();
            canvasCtx.arc(a.x, a.y, (1 - a.life) * 300, 0, Math.PI * 2);
            canvasCtx.strokeStyle = '#00ffcc';
            canvasCtx.lineWidth = 10 * a.life;
            canvasCtx.stroke();
        } else if (a.type === 'pop_ring') {
            canvasCtx.globalAlpha = a.life;
            canvasCtx.beginPath();
            canvasCtx.arc(a.x, a.y, (1 - a.life) * 150, 0, Math.PI * 2);
            canvasCtx.strokeStyle = a.color;
            canvasCtx.lineWidth = 15 * a.life;
            canvasCtx.stroke();
        }
    });
    canvasCtx.globalAlpha = 1.0;
};

// --- MEDIAPIPE GESTURE LOGIC ---
const getDist = (p1, p2) => {
    return Math.hypot((p1.x - p2.x) * width, (p1.y - p2.y) * height);
};

const mapToCanvas = (point) => {
    // Flip X (1 - point.x) because the webcam video is mirrored via CSS scaleX(-1)
    // This ensures the cursor moves in the same direction as the hand on screen.
    return { x: (1 - point.x) * width, y: point.y * height };
};

// Variable to store smoothed cursor position
let smoothedCursor = { x: width/2, y: height/2 };
const SMOOTHING = 0.35; // Value between 0-1. Lower = smoother but slower. 0.35 is responsive yet smooth.

function onResults(results) {
    canvasCtx.save();
    canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);

    updatePhysics();

    if (gameState.isPlaying) {
        drawPortal();
        drawAnswers();
        drawParticlesAndAnimations();
    }

    if (results.multiHandLandmarks && results.multiHandLandmarks.length > 0) {
        const hand = results.multiHandLandmarks[0]; // Primary hand
        
        // Map landmarks
        const rawIndexTip = mapToCanvas(hand[8]);
        
        // Initialize smoothedCursor if it's way off (e.g., first detection)
        if (Math.abs(smoothedCursor.x - rawIndexTip.x) > width / 2) {
            smoothedCursor.x = rawIndexTip.x;
            smoothedCursor.y = rawIndexTip.y;
        }

        // Apply Linear Interpolation (LERP) for smoothing
        smoothedCursor.x += (rawIndexTip.x - smoothedCursor.x) * SMOOTHING;
        smoothedCursor.y += (rawIndexTip.y - smoothedCursor.y) * SMOOTHING;
        
        const indexTip = { x: smoothedCursor.x, y: smoothedCursor.y };

        const thumbTip = mapToCanvas(hand[4]);
        const middleTip = mapToCanvas(hand[12]);
        const ringTip = mapToCanvas(hand[16]);
        const pinkyTip = mapToCanvas(hand[20]);
        const wrist = mapToCanvas(hand[0]);

        // Draw Cursor (Index Tip)
        gameState.cursorPos = indexTip;
        canvasCtx.beginPath();
        canvasCtx.arc(indexTip.x, indexTip.y, 25, 0, Math.PI * 2);
        canvasCtx.fillStyle = 'rgba(0, 255, 204, 0.4)';
        canvasCtx.strokeStyle = '#00ffcc';
        canvasCtx.lineWidth = 3;
        canvasCtx.shadowColor = '#00ffcc';
        canvasCtx.shadowBlur = 15;
        canvasCtx.fill();
        canvasCtx.stroke();
        canvasCtx.shadowBlur = 0;
        // No trailing particles anymore

        // Detect Gestures
        if (gameState.isPlaying && gameState.answers.length > 0) {
            
            // 1. PINCH (Select Answer)
            const pinchDist = getDist(hand[8], hand[4]);
            const isPinching = pinchDist < 50; // pixels

            if (isPinching && !gameState.lastPinchState) {
                // Check collision with answers
                for (let i = 0; i < gameState.answers.length; i++) {
                    const ans = gameState.answers[i];
                    const distToAns = Math.hypot(indexTip.x - ans.x, indexTip.y - ans.y);
                    if (distToAns < ans.radius + 20) {
                        if (ans.isCorrect) {
                            handleCorrectAnswer(ans);
                        } else {
                            handleWrongAnswer(ans);
                        }
                        break;
                    }
                }
            }
            gameState.lastPinchState = isPinching;

            // 2. PALM PUSH (Skip Question)
            // Heuristic: All fingers extended and palm moving forward (simulated by distance between wrist and tips)
            const isPalmOpen = 
                getDist(hand[8], hand[0]) > 150 && 
                getDist(hand[12], hand[0]) > 150 &&
                getDist(hand[16], hand[0]) > 150 &&
                getDist(hand[20], hand[0]) > 120;
            
            if (isPalmOpen && gameState.skipCooldown === 0) {
                // We'll require user to hold open palm near center to trigger skip to prevent accidents
                if (Math.hypot(wrist.x - width/2, wrist.y - height/2) < 200) {
                    playSound('woosh');
                    gameState.animations.push({ type: 'push', x: width/2, y: height/2, life: 1.0 });
                    gameState.skipCooldown = 120; // 2 seconds at 60fps
                    gameState.streak = 0; // reset streak on skip
                    generateQuestion();
                }
            }
        }
    }

    canvasCtx.restore();
}

// Timer Loop
setInterval(() => {
    if (gameState.isPlaying && gameState.level === 3 && gameState.timer > 0) {
        gameState.timer -= 0.1;
        if (gameState.timer <= 0) {
            playSound('boing');
            gameState.streak = 0;
            generateQuestion();
        }
    }
}, 100);

const hands = new Hands({locateFile: (file) => {
    return `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`;
}});
hands.setOptions({
    maxNumHands: 1,
    modelComplexity: 1,
    minDetectionConfidence: 0.7,
    minTrackingConfidence: 0.5
});
hands.onResults(onResults);

const camera = new Camera(videoElement, {
    onFrame: async () => {
        await hands.send({image: videoElement});
    },
    width: 640,
    height: 480
});

// UI Event Listeners
document.getElementById('startBtn').addEventListener('click', () => {
    initAudio();
    document.getElementById('startOverlay').classList.add('hidden');
    document.getElementById('hud').classList.remove('hidden');
    document.getElementById('backBtn').classList.remove('hidden');
    
    gameState.isPlaying = true;
    gameState.level = 1;
    gameState.score = 0;
    gameState.streak = 0;
    document.getElementById('ui-level').innerText = gameState.level;
    document.getElementById('ui-score').innerText = gameState.score;
    
    generateQuestion();
});

// Start camera immediately on page load to trigger permission prompt (matches Particle 3D behavior)
camera.start();
