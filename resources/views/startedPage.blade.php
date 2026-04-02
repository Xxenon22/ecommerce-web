<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fishery Hub</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --ocean-deep: #0a1628;
            --ocean-mid: #0d2240;
            --teal: #0e9f8e;
            --teal-light: #14c4b0;
            --sand: #f5e6c8;
            --foam: #e8f7f5;
            --accent: #ff6b35;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--ocean-deep);
            color: white;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* === ANIMATED OCEAN BACKGROUND === */
        .ocean-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: linear-gradient(160deg, #071222 0%, #0d2240 40%, #0a3352 70%, #0e5c6b 100%);
        }

        .wave-layer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200%;
            height: 220px;
            animation: waveFlow linear infinite;
        }

        .wave-layer:nth-child(1) { animation-duration: 12s; opacity: 0.5; bottom: 0; }
        .wave-layer:nth-child(2) { animation-duration: 18s; opacity: 0.3; bottom: 20px; animation-direction: reverse; }
        .wave-layer:nth-child(3) { animation-duration: 25s; opacity: 0.2; bottom: 40px; }

        @keyframes waveFlow {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Floating particles */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: var(--teal-light);
            opacity: 0;
            animation: floatUp linear infinite;
        }

        @keyframes floatUp {
            0%   { opacity: 0; transform: translateY(0) scale(0); }
            20%  { opacity: 0.6; }
            80%  { opacity: 0.3; }
            100% { opacity: 0; transform: translateY(-100vh) scale(1.5); }
        }

        /* Noise texture overlay */
        .noise {
            position: fixed;
            inset: 0;
            z-index: 1;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* === LAYOUT === */
        .page {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding: 2.5rem 1.5rem 3rem;
        }

        /* === NAV === */
        .nav {
            width: 100%;
            max-width: 480px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0;
            animation: fadeDown 0.7s ease 0.2s forwards;
        }

        .nav-dot {
            width: 8px; height: 8px;
            background: var(--teal-light);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--teal-light);
        }

        .nav-label {
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--teal-light);
        }

        .nav-badge {
            font-size: 0.65rem;
            font-weight: 500;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0.1em;
            border: 1px solid rgba(255,255,255,0.1);
            padding: 4px 12px;
            border-radius: 100px;
            opacity: 0;
            animation: fadeDown 0.7s ease 0.4s forwards;
        }

        /* === HERO IMAGE === */
        .hero-img-wrap {
            position: relative;
            width: 260px;
            height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            animation: scaleIn 0.9s cubic-bezier(0.34,1.56,0.64,1) 0.5s forwards;
        }

        .hero-img-wrap::before {
            content: '';
            position: absolute;
            inset: -20px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(14,159,142,0.25) 0%, transparent 70%);
            animation: pulseGlow 3s ease-in-out infinite;
        }

        .hero-img-wrap::after {
            content: '';
            position: absolute;
            inset: -40px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(14,159,142,0.08) 0%, transparent 65%);
            animation: pulseGlow 3s ease-in-out 1.5s infinite;
        }

        @keyframes pulseGlow {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.7; }
        }

        .ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(14,196,176,0.2);
            animation: ringExpand 4s ease-in-out infinite;
        }

        .ring-1 { inset: -30px; animation-delay: 0s; }
        .ring-2 { inset: -55px; animation-delay: 1s; opacity: 0.5; }
        .ring-3 { inset: -80px; animation-delay: 2s; opacity: 0.25; }

        @keyframes ringExpand {
            0%, 100% { transform: scale(1); opacity: 0.4; }
            50% { transform: scale(1.04); opacity: 0.15; }
        }

        .hero-img-wrap img {
            width: 200px;
            height: 200px;
            object-fit: contain;
            filter: drop-shadow(0 20px 40px rgba(14,159,142,0.4)) drop-shadow(0 4px 12px rgba(0,0,0,0.5));
            animation: floatImage 5s ease-in-out infinite;
            position: relative;
            z-index: 2;
        }

        @keyframes floatImage {
            0%, 100% { transform: translateY(0px) rotate(-1deg); }
            50% { transform: translateY(-14px) rotate(1deg); }
        }

        /* === TEXT BLOCK === */
        .text-block {
            text-align: center;
            max-width: 360px;
            opacity: 0;
            animation: fadeUp 0.8s ease 0.9s forwards;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--teal-light);
            margin-bottom: 1rem;
        }

        .eyebrow-line {
            width: 24px; height: 1px;
            background: var(--teal-light);
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.8rem, 10vw, 4rem);
            font-weight: 900;
            line-height: 1.05;
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
        }

        h1 span {
            background: linear-gradient(135deg, var(--teal-light) 0%, #7ee8dc 50%, var(--sand) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .tagline {
            font-size: 0.95rem;
            font-weight: 300;
            color: rgba(255,255,255,0.55);
            line-height: 1.7;
            letter-spacing: 0.01em;
        }

        /* === STATS === */
        .stats-row {
            display: flex;
            gap: 2rem;
            justify-content: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        .stat {
            text-align: center;
        }

        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--teal-light);
        }

        .stat-label {
            font-size: 0.65rem;
            font-weight: 400;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
            margin-top: 2px;
        }

        /* === CTA === */
        .cta-area {
            width: 100%;
            max-width: 360px;
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
            opacity: 0;
            animation: fadeUp 0.8s ease 1.2s forwards;
        }

        .btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 1.05rem 2rem;
            background: linear-gradient(135deg, var(--teal) 0%, var(--teal-light) 100%);
            border-radius: 16px;
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.01em;
            box-shadow: 0 8px 30px rgba(14,159,142,0.4), 0 2px 8px rgba(0,0,0,0.3);
            transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 16px 40px rgba(14,159,142,0.5), 0 4px 12px rgba(0,0,0,0.3);
        }

        .btn-primary:hover::before { opacity: 1; }
        .btn-primary:active { transform: translateY(0) scale(0.98); }

        .btn-arrow {
            width: 28px; height: 28px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            transition: transform 0.3s;
        }

        .btn-primary:hover .btn-arrow { transform: translateX(4px); }

        .btn-secondary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0.85rem 2rem;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 16px;
            text-decoration: none;
            color: rgba(255,255,255,0.6);
            font-weight: 400;
            font-size: 0.9rem;
            letter-spacing: 0.02em;
            transition: all 0.25s ease;
            backdrop-filter: blur(8px);
        }

        .btn-secondary:hover {
            border-color: rgba(14,196,176,0.4);
            color: var(--teal-light);
            background: rgba(14,196,176,0.05);
        }

        /* === FOOTER NOTE === */
        .footer-note {
            margin-top: 1rem;
            font-size: 0.7rem;
            color: rgba(255,255,255,0.2);
            text-align: center;
            letter-spacing: 0.05em;
        }

        /* === KEYFRAMES === */
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.8); }
            to   { opacity: 1; transform: scale(1); }
        }

        /* === RESPONSIVE === */
        @media (min-width: 640px) {
            .page { padding: 3rem 2rem 4rem; }
            .hero-img-wrap { width: 300px; height: 300px; }
            .hero-img-wrap img { width: 240px; height: 240px; }
        }

        @media (min-width: 768px) {
            .page {
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-template-rows: auto 1fr auto;
                align-items: center;
                max-width: 900px;
                margin: 0 auto;
                gap: 2rem;
            }
            .nav { grid-column: 1 / -1; max-width: 100%; }
            .hero-img-wrap {
                grid-column: 1;
                grid-row: 2;
                justify-self: center;
                width: 340px; height: 340px;
            }
            .hero-img-wrap img { width: 280px; height: 280px; }
            .content-col {
                grid-column: 2;
                grid-row: 2 / 4;
                display: flex;
                flex-direction: column;
                gap: 2rem;
                align-self: center;
            }
            .text-block { text-align: left; max-width: 100%; }
            .eyebrow { justify-content: flex-start; }
            .stats-row { justify-content: flex-start; }
            .cta-area { max-width: 100%; }
            .footer-note { grid-column: 1; grid-row: 3; }
        }
    </style>
</head>

<body>

    <!-- Ocean background -->
    <div class="ocean-bg">
        <!-- Wave SVGs -->
        <svg class="wave-layer" viewBox="0 0 1440 220" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path fill="rgba(14,159,142,0.12)" d="M0,160 C360,220 720,80 1080,160 C1260,200 1380,100 1440,140 L1440,220 L0,220 Z"/>
        </svg>
        <svg class="wave-layer" viewBox="0 0 1440 220" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path fill="rgba(14,196,176,0.08)" d="M0,100 C200,180 500,60 800,120 C1000,160 1250,40 1440,100 L1440,220 L0,220 Z"/>
        </svg>
        <svg class="wave-layer" viewBox="0 0 1440 220" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path fill="rgba(7,18,34,0.6)" d="M0,140 C300,80 600,200 900,140 C1100,100 1300,180 1440,120 L1440,220 L0,220 Z"/>
        </svg>
    </div>

    <div class="noise"></div>

    <!-- Particles (generated via JS) -->
    <div id="particles" style="position:fixed;inset:0;z-index:2;pointer-events:none;overflow:hidden;"></div>

    <!-- Page Content -->
    <div class="page">

        <!-- Navbar -->
        <nav class="nav">
            <div class="nav-logo">
                <div class="nav-dot"></div>
                <span class="nav-label">Fishery Hub</span>
            </div>
            {{-- <span class="nav-badge">v1.0 Beta</span> --}}
        </nav>

        <!-- Hero Image (desktop: left col) -->
        <div class="hero-img-wrap">
            <div class="ring ring-1"></div>
            <div class="ring ring-2"></div>
            {{-- <div class="ring ring-3"></div> --}}
            <img src="{{ asset('assets/pasar-ikan.png') }}" alt="Fishery Hub Illustration" />
        </div>

        <!-- Desktop: right column wrapper -->
        <div class="content-col" style="display: contents;">

            <!-- Text Block -->
            <div class="text-block">
                <div class="eyebrow">
                    <span class="eyebrow-line"></span>
                    Platform Perikanan Digital
                    <span class="eyebrow-line"></span>
                </div>

                <h1>
                    Segar dari <span>Laut,</span><br>
                    Langsung ke Anda
                </h1>

                <p class="tagline">
                    Temukan ikan segar berkualitas terbaik langsung dari nelayan lokal. Cepat, terpercaya, dan tanpa perantara.
                </p>

                <div class="stats-row">
                    <div class="stat">
                        <div class="stat-num">500+</div>
                        <div class="stat-label">Nelayan</div>
                    </div>
                    <div class="stat">
                        <div class="stat-num">50+</div>
                        <div class="stat-label">Jenis Ikan</div>
                    </div>
                    <div class="stat">
                        <div class="stat-num">12k+</div>
                        <div class="stat-label">Pelanggan</div>
                    </div>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="cta-area">
                <a href="/home" class="btn-primary">
                    <span>Mulai Sekarang</span>
                    <div class="btn-arrow">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M2 7H12M12 7L8 3M12 7L8 11" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </a>
                {{-- <a href="/about" class="btn-secondary">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <circle cx="7" cy="7" r="6" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M7 6.5V10M7 4.5V5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Pelajari Selengkapnya
                </a> --}}

                <p class="footer-note">Gratis untuk digunakan &nbsp;·&nbsp; Tanpa biaya pendaftaran</p>
            </div>

        </div><!-- /content-col -->

    </div>

    <script>
        // Generate floating particles
        const container = document.getElementById('particles');
        for (let i = 0; i < 18; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            const size = Math.random() * 4 + 2;
            p.style.cssText = `
                width:${size}px; height:${size}px;
                left:${Math.random()*100}%;
                bottom: ${Math.random()*20}%;
                animation-delay:${Math.random()*14}s;
                animation-duration:${Math.random()*12+10}s;
            `;
            container.appendChild(p);
        }

        // On desktop, re-wrap text-block and cta-area into content-col
        function reorganize() {
            const col = document.querySelector('.content-col');
            const text = document.querySelector('.text-block');
            const cta  = document.querySelector('.cta-area');
            const footNote = document.querySelector('.footer-note');
            if (window.innerWidth >= 768) {
                col.style.display = 'flex';
                col.style.flexDirection = 'column';
                col.style.gap = '2rem';
                if (!col.contains(text)) col.appendChild(text);
                if (!col.contains(cta))  col.appendChild(cta);
            } else {
                col.style.display = 'contents';
            }
        }

        reorganize();
        window.addEventListener('resize', reorganize);
    </script>

</body>
</html>