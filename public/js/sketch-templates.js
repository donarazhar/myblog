// Sketch Templates for Pena Tangan
// All coordinates in 0-100 space, scaled to canvas at render time
(function() {
    function C(cx, cy, r, n) {
        n = n || 20;
        var p = [];
        for (var i = 0; i <= n; i++) {
            var a = (i / n) * Math.PI * 2;
            p.push([cx + r * Math.cos(a), cy + r * Math.sin(a)]);
        }
        return p;
    }
    function E(cx, cy, rx, ry, n) {
        n = n || 20;
        var p = [];
        for (var i = 0; i <= n; i++) {
            var a = (i / n) * Math.PI * 2;
            p.push([cx + rx * Math.cos(a), cy + ry * Math.sin(a)]);
        }
        return p;
    }
    function A(cx, cy, r, s, e, n) {
        n = n || 12;
        var p = [];
        for (var i = 0; i <= n; i++) {
            var a = s + (e - s) * (i / n);
            p.push([cx + r * Math.cos(a), cy + r * Math.sin(a)]);
        }
        return p;
    }

    var sunRays = [];
    for (var i = 0; i < 12; i++) {
        var a = (i / 12) * Math.PI * 2;
        sunRays.push([[50+20*Math.cos(a),50+20*Math.sin(a)],[50+30*Math.cos(a),50+30*Math.sin(a)]]);
    }

    var starPts = [];
    for (var i = 0; i < 10; i++) {
        var a = (i/10)*Math.PI*2 - Math.PI/2;
        var r = i%2===0 ? 28 : 12;
        starPts.push([50+r*Math.cos(a), 50+r*Math.sin(a)]);
    }
    starPts.push(starPts[0].slice());

    var heartPts = [];
    for (var i = 0; i <= 30; i++) {
        var t = (i/30)*Math.PI*2;
        var x = 16*Math.pow(Math.sin(t),3);
        var y = -(13*Math.cos(t)-5*Math.cos(2*t)-2*Math.cos(3*t)-Math.cos(4*t));
        heartPts.push([50+x*1.5, 50+y*1.5]);
    }

    window.sketchTemplates = [
        // === BINATANG ===
        { name:'Kucing', emoji:'🐱', cat:'animals', paths:[
            C(50,45,18), [[34,30],[28,14],[43,27]], [[57,27],[72,14],[66,30]],
            C(42,42,3), C(58,42,3), [[50,49],[47,53],[53,53],[50,49]],
            A(44,53,6,0,Math.PI,8), A(56,53,6,0,Math.PI,8),
            [[28,46],[40,49]],[[28,52],[40,52]],[[60,49],[72,46]],[[60,52],[72,52]],
            E(50,75,14,18)
        ]},
        { name:'Ikan', emoji:'🐟', cat:'animals', paths:[
            E(48,50,22,13), [[70,50],[85,35],[85,65],[70,50]], C(35,46,3),
            [[48,38],[55,28],[62,38]], [[26,50],[20,48]]
        ]},
        { name:'Burung', emoji:'🐦', cat:'animals', paths:[
            E(52,55,16,10), C(30,45,9), [[21,44],[12,42],[21,47]], C(27,43,2),
            [[48,47],[58,32],[70,47]], [[68,53],[80,46],[80,60],[68,56]],
            [[42,65],[42,78],[38,80]], [[52,65],[52,78],[48,80]]
        ]},
        { name:'Kupu-kupu', emoji:'🦋', cat:'animals', paths:[
            [[50,25],[50,70]], [[50,28],[42,16]], [[50,28],[58,16]],
            C(42,16,2), C(58,16,2),
            E(35,38,14,12), E(65,38,14,12), E(38,58,10,10), E(62,58,10,10)
        ]},
        // === ALAM ===
        { name:'Gunung', emoji:'⛰️', cat:'nature', paths:[
            [[5,78],[95,78]], [[8,78],[32,22],[56,78]], [[38,78],[62,30],[86,78]],
            [[27,30],[32,22],[37,30]], [[57,36],[62,30],[67,36]],
            C(82,18,7), [[82,8],[82,4]],[[82,28],[82,32]],[[72,18],[68,18]],[[92,18],[96,18]]
        ]},
        { name:'Pohon', emoji:'🌳', cat:'nature', paths:[
            [[44,92],[44,55],[56,55],[56,92]], C(50,35,20), C(35,42,12), C(65,42,12), C(50,22,12)
        ]},
        { name:'Bunga', emoji:'🌸', cat:'nature', paths:[
            [[50,90],[50,52]], E(38,68,5,8), E(62,75,5,8),
            C(50,40,6), E(50,25,5,9), E(50,55,5,9), E(36,40,9,5), E(64,40,9,5),
            E(40,30,7,5), E(60,30,7,5), E(40,50,7,5), E(60,50,7,5)
        ]},
        { name:'Matahari', emoji:'☀️', cat:'nature', paths:[
            C(50,50,15), C(44,46,2), C(56,46,2), A(50,52,6,0.2,Math.PI-0.2,8)
        ].concat(sunRays)},
        // === BENTUK ===
        { name:'Bintang', emoji:'⭐', cat:'shapes', paths:[starPts] },
        { name:'Hati', emoji:'❤️', cat:'shapes', paths:[heartPts] },
        { name:'Rumah', emoji:'🏠', cat:'shapes', paths:[
            [[25,85],[25,45],[75,45],[75,85],[25,85]], [[20,45],[50,18],[80,45]],
            [[42,85],[42,62],[58,62],[58,85]], [[30,52],[30,62],[40,62],[40,52],[30,52]],
            [[60,52],[60,62],[70,62],[70,52],[60,52]],
            [[35,52],[35,62]],[[30,57],[40,57]],[[65,52],[65,62]],[[60,57],[70,57]]
        ]},
        { name:'Mobil', emoji:'🚗', cat:'shapes', paths:[
            [[15,60],[15,50],[30,50],[40,35],[65,35],[75,50],[88,50],[88,60],[15,60]],
            C(30,62,8), C(72,62,8), [[40,50],[40,35]], [[65,50],[65,35]], [[40,50],[65,50]]
        ]}
    ];

    window.sketchCatLabels = {
        'animals': '🐱 Binatang',
        'nature': '🌄 Keindahan Alam',
        'shapes': '⭐ Bentuk Sederhana'
    };
})();
