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

// vocabBank & catLabels loaded from vocab-data.js

// Track last word to avoid repeats
let lastWordEn = '';

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

    if (type === 'pop') {
        osc.type = 'sine';
        osc.frequency.setValueAtTime(600, audioCtx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(100, audioCtx.currentTime + 0.1);
        gain.gain.setValueAtTime(0.8, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.1);
        osc.start();
        osc.stop(audioCtx.currentTime + 0.1);
    } else if (type === 'fizz') {
        const bufferSize = audioCtx.sampleRate * 0.2;
        const buffer = audioCtx.createBuffer(1, bufferSize, audioCtx.sampleRate);
        const data = buffer.getChannelData(0);
        for (let i = 0; i < bufferSize; i++) data[i] = Math.random() * 2 - 1;
        const noiseSource = audioCtx.createBufferSource();
        noiseSource.buffer = buffer;
        const noiseFilter = audioCtx.createBiquadFilter();
        noiseFilter.type = 'highpass';
        noiseFilter.frequency.setValueAtTime(2000, audioCtx.currentTime);
        noiseSource.connect(noiseFilter);
        noiseFilter.connect(gain);
        gain.gain.setValueAtTime(0.5, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.2);
        noiseSource.start();
    } else if (type === 'woosh') {
        const bufferSize = audioCtx.sampleRate * 0.5;
        const buffer = audioCtx.createBuffer(1, bufferSize, audioCtx.sampleRate);
        const data = buffer.getChannelData(0);
        for (let i = 0; i < bufferSize; i++) data[i] = Math.random() * 2 - 1;
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
    } else if (type === 'success') {
        osc.type = 'triangle';
        osc.frequency.setValueAtTime(440, audioCtx.currentTime);
        osc.frequency.setValueAtTime(554, audioCtx.currentTime + 0.1);
        osc.frequency.setValueAtTime(659, audioCtx.currentTime + 0.2);
        osc.frequency.setValueAtTime(880, audioCtx.currentTime + 0.3);
        gain.gain.setValueAtTime(0.5, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.6);
        osc.start();
        osc.stop(audioCtx.currentTime + 0.6);
    }
};

const speakWord = (word) => {
    if ('speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance(word);
        utterance.lang = 'en-US';
        utterance.rate = 0.9; // Slightly slower for kids
        window.speechSynthesis.speak(utterance);
    }
};

// Game State
let gameState = {
    score: 0,
    level: 1,
    wordsCompleted: 0,
    timer: 0,
    currentWord: null,
    targetWord: '',
    spelledWord: '',
    bubbles: [], 
    particles: [],
    animations: [],
    isPlaying: false,
    lastPinchState: false,
    skipCooldown: 0,
    lastBubbleSpawn: 0,
    wordStartTime: 0
};

const spawnBubble = () => {
    if (!gameState.isPlaying || !gameState.currentWord) return;

    // Calculate level params
    // Max balloons ditambah lagi agar layar terlihat ramai ("banyak yang turun")
    const levelConfig = {
        1: { speed: 1.0, max: 20 },
        2: { speed: 1.8, max: 25 },
        3: { speed: 2.5, max: 30 }
    };
    const conf = levelConfig[gameState.level];

    if (gameState.bubbles.length >= conf.max) return;

    // Determine what letter to spawn
    // 40% chance to spawn a needed letter, 60% chance for random (if not already fully spelled)
    let charToSpawn;
    let neededLetters = [];
    for(let i=0; i<gameState.targetWord.length; i++) {
        if(gameState.spelledWord[i] === '_') neededLetters.push(gameState.targetWord[i]);
    }

    if (neededLetters.length > 0 && Math.random() < 0.4) {
        // Pick a random needed letter
        charToSpawn = neededLetters[Math.floor(Math.random() * neededLetters.length)];
    } else {
        // Random uppercase letter
        const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        charToSpawn = alphabet[Math.floor(Math.random() * alphabet.length)];
    }

    // Hint system: if >10s elapsed on current word, increase chance of needed letter
    const timeElapsed = (Date.now() - gameState.wordStartTime) / 1000;
    let isHint = false;
    if (timeElapsed > 10 && neededLetters.includes(charToSpawn)) {
        isHint = true;
    }

    gameState.bubbles.push({
        char: charToSpawn,
        x: Math.random() * (width - 100) + 50,
        y: -50,
        radius: 35,
        vy: conf.speed + (Math.random() * 0.8), // Variance diperkecil agar kecepatan antar balon lebih seragam
        color: `hsl(${Math.random() * 360}, 80%, 60%)`,
        isHint: isHint
    });
};

const setupWord = () => {
    const list = vocabBank[gameState.level];
    // Pick a random word, but avoid repeating the last one
    let pick;
    do {
        pick = list[Math.floor(Math.random() * list.length)];
    } while (pick.en === lastWordEn && list.length > 1);
    lastWordEn = pick.en;

    gameState.currentWord = pick;
    gameState.targetWord = gameState.currentWord.en;
    gameState.spelledWord = '_'.repeat(gameState.targetWord.length);
    gameState.bubbles = [];
    gameState.wordStartTime = Date.now();

    // Setup UI
    document.getElementById('card-emoji').innerText = gameState.currentWord.emoji;
    document.getElementById('card-translation').innerText = gameState.currentWord.id;
    const catEl = document.getElementById('card-category');
    if (catEl && gameState.currentWord.cat && catLabels) {
        catEl.innerText = catLabels[gameState.currentWord.cat] || '';
        catEl.style.display = 'block';
    }
    
    const spellingBox = document.getElementById('spelling-box');
    spellingBox.innerHTML = '';
    for(let i=0; i<gameState.targetWord.length; i++) {
        const slot = document.createElement('div');
        slot.className = 'letter-slot';
        slot.id = `slot-${i}`;
        slot.innerText = '';
        spellingBox.appendChild(slot);
    }

    if (gameState.level === 1) {
        document.getElementById('timer-container').style.display = 'none';
        gameState.timer = 0;
    } else if (gameState.level === 2) {
        document.getElementById('timer-container').style.display = 'block';
        gameState.timer = 20;
    } else {
        document.getElementById('timer-container').style.display = 'block';
        gameState.timer = 15;
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

const handleCorrectLetter = (bubble, slotIndex) => {
    playSound('pop');
    
    // Update spelling state
    let newSpelled = gameState.spelledWord.split('');
    newSpelled[slotIndex] = bubble.char;
    gameState.spelledWord = newSpelled.join('');

    // Update UI Slot
    const slot = document.getElementById(`slot-${slotIndex}`);
    slot.innerText = bubble.char;
    slot.classList.add('filled');

    // Visual Effect: absorb
    createParticles(bubble.x, bubble.y, bubble.color, 20, 'pop');
    gameState.animations.push({ type: 'absorb', x: bubble.x, y: bubble.y, char: bubble.char, life: 1.0, targetSlot: slotIndex });

    // Check if word complete
    if (gameState.spelledWord === gameState.targetWord) {
        setTimeout(handleWordComplete, 500);
    }
};

const handleWrongLetter = (bubble) => {
    playSound('fizz');
    createParticles(bubble.x, bubble.y, '#ffffff', 15, 'fizz');
};

const handleWordComplete = () => {
    playSound('success');
    speakWord(gameState.targetWord);
    gameState.score += gameState.targetWord.length * 10;
    document.getElementById('ui-score').innerText = gameState.score;
    
    // Mark all slots complete
    for(let i=0; i<gameState.targetWord.length; i++) {
        document.getElementById(`slot-${i}`).classList.add('complete');
    }

    // Fireworks
    createParticles(width/2, height/3, '#ffb703', 100, 'firework');
    
    // Animate Card
    const card = document.getElementById('magic-card');
    card.style.transform = 'translateX(-50%) scale(1.2)';
    setTimeout(() => { card.style.transform = 'translateX(-50%) scale(1)'; }, 500);

    // Level progression
    gameState.wordsCompleted++;
    if (gameState.wordsCompleted >= 5 && gameState.level < 3) {
        gameState.level++;
        gameState.wordsCompleted = 0;
        document.getElementById('ui-level').innerText = gameState.level;
    }

    // Clear bubbles and wait before next word
    gameState.bubbles = [];
    setTimeout(setupWord, 3000);
};

const updatePhysics = () => {
    // Spawn logic
    // Jarak waktu antar spawn dipercepat (dari 800ms ke 400ms) agar balon lebih rapat/dekat
    if (Date.now() - gameState.lastBubbleSpawn > 400) {
        spawnBubble();
        gameState.lastBubbleSpawn = Date.now();
    }

    // Bubbles
    for (let i = gameState.bubbles.length - 1; i >= 0; i--) {
        let b = gameState.bubbles[i];
        b.y += b.vy;
        
        // Wobble horizontally
        b.x += Math.sin(Date.now() / 300 + b.y) * 1.5;

        // If hits bottom
        if (b.y > height + 50) {
            createParticles(b.x, height - 20, '#8ecaee', 10, 'splash');
            gameState.bubbles.splice(i, 1);
        }
    }

    // Particles
    for (let i = gameState.particles.length - 1; i >= 0; i--) {
        let p = gameState.particles[i];
        p.x += p.vx;
        p.y += p.vy;
        p.life -= 0.02;
        if (p.type === 'fizz') p.vy -= 0.5; // smoke goes up
        else if (p.type === 'firework') p.vy += 0.2; // gravity
        
        if (p.life <= 0) {
            gameState.particles.splice(i, 1);
        }
    }

    // Animations
    for (let i = gameState.animations.length - 1; i >= 0; i--) {
        let a = gameState.animations[i];
        a.life -= 0.03;
        if (a.life <= 0) gameState.animations.splice(i, 1);
    }

    if (gameState.skipCooldown > 0) gameState.skipCooldown--;
};

const drawGame = () => {
    // Bubbles
    gameState.bubbles.forEach(b => {
        canvasCtx.beginPath();
        canvasCtx.arc(b.x, b.y, b.radius, 0, Math.PI * 2);
        
        // Gradient fill
        let grad = canvasCtx.createRadialGradient(b.x - 10, b.y - 10, 5, b.x, b.y, b.radius);
        grad.addColorStop(0, 'rgba(255,255,255,0.8)');
        grad.addColorStop(1, b.color);
        
        canvasCtx.fillStyle = grad;
        canvasCtx.fill();
        canvasCtx.lineWidth = 2;
        canvasCtx.strokeStyle = 'rgba(255,255,255,0.5)';
        canvasCtx.stroke();

        // Hint blink
        if (b.isHint && Math.floor(Date.now() / 200) % 2 === 0) {
            canvasCtx.shadowColor = '#fff';
            canvasCtx.shadowBlur = 20;
        }

        canvasCtx.fillStyle = '#fff';
        canvasCtx.font = 'bold 36px Fredoka One';
        canvasCtx.textAlign = 'center';
        canvasCtx.textBaseline = 'middle';
        canvasCtx.fillText(b.char, b.x, b.y + 2); // tiny y-adjust for font
        canvasCtx.shadowBlur = 0;
    });

    // Particles & Animations
    gameState.particles.forEach(p => {
        canvasCtx.beginPath();
        canvasCtx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
        canvasCtx.fillStyle = p.color;
        canvasCtx.globalAlpha = p.life;
        canvasCtx.fill();
    });
    canvasCtx.globalAlpha = 1.0;

    gameState.animations.forEach(a => {
        if (a.type === 'absorb') {
            // Draw a flying letter towards the top center
            const progress = 1 - a.life;
            // Approximate slot position (top center area)
            const targetX = width / 2; 
            const targetY = 50; 
            
            const currX = a.x + (targetX - a.x) * progress;
            const currY = a.y + (targetY - a.y) * progress;
            
            canvasCtx.fillStyle = `rgba(255, 255, 255, ${a.life})`;
            canvasCtx.font = 'bold 40px Fredoka One';
            canvasCtx.fillText(a.char, currX, currY);
            
            // Trail
            createParticles(currX, currY, '#ffb703', 1, 'trail');
        } else if (a.type === 'push') {
            canvasCtx.globalAlpha = a.life;
            canvasCtx.beginPath();
            canvasCtx.moveTo(0, a.y);
            canvasCtx.lineTo(width, a.y - (1-a.life)*300);
            canvasCtx.strokeStyle = 'rgba(255,255,255,0.5)';
            canvasCtx.lineWidth = 50 * a.life;
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
    // Flip X for mirror match
    return { x: (1 - point.x) * width, y: point.y * height };
};

let smoothedCursor = { x: width/2, y: height/2 };
const SMOOTHING = 0.2; // Diturunkan dari 0.35 ke 0.2 agar pergerakan jauh lebih halus (mengurangi getaran)

function onResults(results) {
    canvasCtx.save();
    canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);

    if (gameState.isPlaying) {
        updatePhysics();
        drawGame();
    }

    if (results.multiHandLandmarks && results.multiHandLandmarks.length > 0) {
        const hand = results.multiHandLandmarks[0]; 
        
        const rawIndexTip = mapToCanvas(hand[8]);
        
        if (Math.abs(smoothedCursor.x - rawIndexTip.x) > width / 2) {
            smoothedCursor.x = rawIndexTip.x;
            smoothedCursor.y = rawIndexTip.y;
        }

        smoothedCursor.x += (rawIndexTip.x - smoothedCursor.x) * SMOOTHING;
        smoothedCursor.y += (rawIndexTip.y - smoothedCursor.y) * SMOOTHING;
        const indexTip = { x: smoothedCursor.x, y: smoothedCursor.y };

        const wrist = mapToCanvas(hand[0]);

        // Draw Cursor 
        canvasCtx.beginPath();
        canvasCtx.arc(indexTip.x, indexTip.y, 25, 0, Math.PI * 2);
        canvasCtx.fillStyle = 'rgba(255, 183, 3, 0.4)'; // Orange/Yellow accent
        canvasCtx.strokeStyle = '#ffb703';
        canvasCtx.lineWidth = 3;
        canvasCtx.shadowColor = '#ffb703';
        canvasCtx.shadowBlur = 15;
        canvasCtx.fill();
        canvasCtx.stroke();
        canvasCtx.shadowBlur = 0;

        if (gameState.isPlaying && gameState.targetWord !== gameState.spelledWord) {
            
            // 1. PINCH
            const pinchDist = getDist(hand[8], hand[4]);
            const isPinching = pinchDist < 65; // Dinaikkan dari 50 ke 65 agar lebih mudah mendeteksi cubitan

            if (isPinching && !gameState.lastPinchState) {
                // Collision with bubbles (reverse order to catch top-most visually)
                for (let i = gameState.bubbles.length - 1; i >= 0; i--) {
                    const b = gameState.bubbles[i];
                    const distToBubble = Math.hypot(indexTip.x - b.x, indexTip.y - b.y);
                    
                    if (distToBubble < b.radius + 40) { // Margin of error diperbesar (dari 20 ke 40) agar lebih akurat menangkap
                        
                        // Check if letter is needed
                        let letterNeeded = false;
                        let slotTarget = -1;
                        for(let j=0; j<gameState.targetWord.length; j++) {
                            if (gameState.targetWord[j] === b.char && gameState.spelledWord[j] === '_') {
                                letterNeeded = true;
                                slotTarget = j;
                                break; // Only fill first empty matching slot
                            }
                        }

                        if (letterNeeded) {
                            handleCorrectLetter(b, slotTarget);
                            // Hanya hancurkan balon jika hurufnya benar
                            gameState.bubbles.splice(i, 1);
                        } else {
                            handleWrongLetter(b);
                            // Balon yang salah tidak meledak, akan terus turun
                        }
                        
                        break; 
                    }
                }
            }
            gameState.lastPinchState = isPinching;

            // 2. PALM PUSH (Sweep Bubbles)
            const isPalmOpen = 
                getDist(hand[8], hand[0]) > 150 && 
                getDist(hand[12], hand[0]) > 150 &&
                getDist(hand[16], hand[0]) > 150 &&
                getDist(hand[20], hand[0]) > 120;
            
            if (isPalmOpen && gameState.skipCooldown === 0) {
                if (Math.hypot(wrist.x - width/2, wrist.y - height/2) < 200) {
                    playSound('woosh');
                    gameState.animations.push({ type: 'push', x: width/2, y: height/2, life: 1.0 });
                    
                    // Pop all bubbles
                    gameState.bubbles.forEach(b => createParticles(b.x, b.y, '#fff', 5, 'fizz'));
                    gameState.bubbles = [];
                    
                    gameState.skipCooldown = 180; // 3 seconds
                }
            }
        }
    }

    canvasCtx.restore();
}

// Timer Loop
setInterval(() => {
    if (gameState.isPlaying && gameState.level > 1 && gameState.timer > 0 && gameState.targetWord !== gameState.spelledWord) {
        gameState.timer -= 0.1;
        document.getElementById('ui-timer').innerText = Math.ceil(gameState.timer) + 's';
        
        if (gameState.timer <= 0) {
            playSound('fizz');
            // Timeout - setup new word
            setupWord();
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
    width: 1280,
    height: 720
});

// UI Event Listeners
document.getElementById('startBtn').addEventListener('click', async () => {
    initAudio();
    document.getElementById('startOverlay').classList.add('hidden');
    document.getElementById('hud').classList.remove('hidden');
    document.getElementById('magic-card').classList.remove('hidden');
    document.getElementById('backBtn').classList.remove('hidden');
    
    gameState.isPlaying = true;
    gameState.level = 1;
    gameState.score = 0;
    gameState.wordsCompleted = 0;
    document.getElementById('ui-level').innerText = gameState.level;
    document.getElementById('ui-score').innerText = gameState.score;
    
    setupWord();
});

// Start camera immediately on page load to trigger permission prompt (matches Particle 3D behavior)
camera.start();
