<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/logo.jpeg') }}" type="image/png">
    <title>Masuk — Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

    <style>
        :root {
            --ocean: #062233;
            --teal: #0e9f8e;
            --teal-light: #14c4b0;
            --sand: #f5e6c8;
            --glass: rgba(255,255,255,0.06);
            --glass-border: rgba(255,255,255,0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* === BG IMAGE WITH OVERLAY === */
        .bg-layer {
            position: fixed;
            inset: 0;
            background-image: url({{ asset('assets/bg-pasar-ikan2.jpg') }});
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: brightness(0.35) saturate(0.8);
            z-index: 0;
            transform: scale(1.05);
            animation: bgBreath 20s ease-in-out infinite;
        }

        @keyframes bgBreath {
            0%,100% { transform: scale(1.05) translateX(0); }
            50% { transform: scale(1.08) translateX(-8px); }
        }

        /* Teal gradient sweep over the bg */
        .bg-tint {
            position: fixed;
            inset: 0;
            z-index: 1;
            background: linear-gradient(
                135deg,
                rgba(6,34,51,0.7) 0%,
                rgba(14,159,142,0.12) 50%,
                rgba(6,34,51,0.85) 100%
            );
        }

        /* Animated shimmer lines */
        .shimmer-lines {
            position: fixed;
            inset: 0;
            z-index: 2;
            overflow: hidden;
            pointer-events: none;
        }

        .shimmer-lines::before,
        .shimmer-lines::after {
            content: '';
            position: absolute;
            left: -100%;
            width: 60%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(20,196,176,0.4), transparent);
            animation: shimmerMove 8s ease-in-out infinite;
        }

        .shimmer-lines::before { top: 30%; animation-delay: 0s; }
        .shimmer-lines::after  { top: 70%; animation-delay: 4s; }

        @keyframes shimmerMove {
            0%   { left: -60%; }
            100% { left: 160%; }
        }

        /* === LAYOUT === */
        .page {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* === BACK BUTTON === */
        .back-btn {
            position: fixed;
            top: 1.2rem;
            left: 1.2rem;
            z-index: 50;
            width: 42px; height: 42px;
            border-radius: 12px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            color: white;
            text-decoration: none;
            opacity: 0;
            animation: fadeIn 0.5s ease 0.1s forwards;
        }

        .back-btn:hover {
            background: rgba(14,196,176,0.15);
            border-color: rgba(14,196,176,0.4);
            transform: translateX(-2px);
        }

        /* === CARD === */
        .card-wrap {
            width: 100%;
            max-width: 420px;
            opacity: 0;
            animation: riseUp 0.8s cubic-bezier(0.22,1,0.36,1) 0.3s forwards;
        }

        @keyframes riseUp {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0)    scale(1); }
        }

        /* Brand cap above card */
        .brand-cap {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .brand-dot {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 14px;
            background: rgba(14,196,176,0.12);
            border: 1px solid rgba(14,196,176,0.25);
            border-radius: 100px;
            margin-bottom: 0.85rem;
        }

        .brand-dot-circle {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--teal-light);
            box-shadow: 0 0 8px var(--teal-light);
            animation: blink 2.5s ease-in-out infinite;
        }

        @keyframes blink {
            0%,100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .brand-dot span {
            font-size: 0.68rem;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--teal-light);
        }

        .brand-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 700;
            color: white;
            line-height: 1.1;
        }

        .brand-title em {
            font-style: normal;
            background: linear-gradient(135deg, var(--teal-light), #a8f0e8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-sub {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.4);
            margin-top: 0.35rem;
            font-weight: 300;
        }

        /* Glass card */
        .glass-card {
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 24px;
            padding: 2.25rem 2rem;
            box-shadow:
                0 32px 64px rgba(0,0,0,0.4),
                0 0 0 1px rgba(255,255,255,0.05) inset,
                0 1px 0 rgba(255,255,255,0.15) inset;
        }

        .card-header {
            margin-bottom: 1.75rem;
        }

        .card-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
        }

        .card-header p {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.38);
            margin-top: 0.3rem;
            font-weight: 300;
        }

        /* === FORM === */
        .field-group { display: flex; flex-direction: column; gap: 1rem; }

        .field { display: flex; flex-direction: column; gap: 0.4rem; }

        .field label {
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: rgba(255,255,255,0.25);
            display: flex;
            align-items: center;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-wrap input {
            width: 100%;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 0.85rem 1rem 0.85rem 2.75rem;
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.92rem;
            outline: none;
            transition: all 0.25s ease;
        }

        .input-wrap input::placeholder { color: rgba(255,255,255,0.2); }

        .input-wrap input:focus {
            background: rgba(14,196,176,0.08);
            border-color: rgba(14,196,176,0.5);
            box-shadow: 0 0 0 3px rgba(14,196,176,0.1);
        }

        .input-wrap input:focus + .input-focus-ring { opacity: 1; }

        .input-wrap:focus-within .input-icon { color: var(--teal-light); }

        /* password toggle */
        .pw-toggle {
            position: absolute;
            right: 14px;
            color: rgba(255,255,255,0.25);
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .pw-toggle:hover { color: var(--teal-light); }

        /* === ERROR ALERT === */
        .error-alert {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            color: #fca5a5;
            font-size: 0.83rem;
        }

        .error-close {
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.2s;
            background: none; border: none; color: inherit;
        }

        .error-close:hover { opacity: 1; }

        /* === SUBMIT BUTTON === */
        .btn-submit {
            margin-top: 1.5rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0.95rem 1.5rem;
            background: linear-gradient(135deg, var(--teal) 0%, var(--teal-light) 100%);
            border: none;
            border-radius: 14px;
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(14,159,142,0.35), 0 2px 6px rgba(0,0,0,0.25);
            transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1);
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: opacity 0.25s;
        }

        .btn-submit:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 14px 36px rgba(14,159,142,0.45), 0 4px 10px rgba(0,0,0,0.3);
        }

        .btn-submit:hover::before { opacity: 1; }
        .btn-submit:active { transform: translateY(0) scale(0.99); }

        .btn-arrow {
            width: 26px; height: 26px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            transition: transform 0.25s;
        }

        .btn-submit:hover .btn-arrow { transform: translateX(4px); }

        /* === DIVIDER === */
        .divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.5rem 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.08);
        }

        .divider span {
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.2);
        }

        /* === REGISTER LINK === */
        .register-row {
            text-align: center;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.35);
        }

        .register-row a {
            color: var(--teal-light);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            border-bottom: 1px solid transparent;
        }

        .register-row a:hover {
            border-bottom-color: var(--teal-light);
        }

        /* === MISC === */
        @keyframes fadeIn {
            from { opacity: 0; } to { opacity: 1; }
        }

        /* Scrollable on small heights */
        @media (max-height: 680px) {
            .page { align-items: flex-start; padding-top: 4rem; overflow-y: auto; }
            body { overflow: auto; }
        }
    </style>
</head>

<body>
    <!-- Background layers -->
    <div class="bg-layer"></div>
    <div class="bg-tint"></div>
    <div class="shimmer-lines"></div>

    <!-- Back button -->
    <a href="{{ route('home') }}" class="back-btn">
        <span class="iconify" data-icon="weui:back-outlined" data-width="22" data-height="22"></span>
    </a>

    <!-- Main -->
    <main class="page">
        <div class="card-wrap">

            <!-- Brand cap -->
            <div class="brand-cap">
                <div>
                    <div class="brand-dot">
                        <div class="brand-dot-circle"></div>
                        <span>Fishery Hub</span>
                    </div>
                </div>
                <h1 class="brand-title">Selamat <em>Datang</em> Kembali</h1>
                <p class="brand-sub">Masuk untuk melanjutkan ke dashboard Anda</p>
            </div>

            <!-- Glass card -->
            <div class="glass-card">
                <div class="card-header">
                    <h2>Masuk ke Akun</h2>
                    <p>Masukkan email &amp; password terdaftar</p>
                </div>

                <form action="/login" method="POST">
                    @csrf

                    {{-- Error alert --}}
                    @if ($errors->any())
                        <div class="error-alert">
                            <span>{{ $errors->first() }}</span>
                            <button type="button" class="error-close"
                                onclick="this.closest('.error-alert').remove()">
                                <span class="iconify" data-icon="mdi:close" data-width="16" data-height="16"></span>
                            </button>
                        </div>
                    @endif

                    <div class="field-group">
                        <!-- Email -->
                        <div class="field">
                            <label for="email">Email</label>
                            <div class="input-wrap">
                                <div class="input-icon">
                                    <span class="iconify" data-icon="mdi:email-outline" data-width="18" data-height="18"></span>
                                </div>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    placeholder="nama@email.com"
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="field">
                            <label for="password">Password</label>
                            <div class="input-wrap">
                                <div class="input-icon">
                                    <span class="iconify" data-icon="mdi:lock-outline" data-width="18" data-height="18"></span>
                                </div>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="••••••••"
                                    autocomplete="current-password"
                                    required
                                >
                                <div class="pw-toggle" id="pwToggle" title="Tampilkan password">
                                    <span class="iconify" id="pwIcon" data-icon="mdi:eye-outline" data-width="18" data-height="18"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>Masuk Sekarang</span>
                        <div class="btn-arrow">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                <path d="M2 6.5H11M11 6.5L7.5 3M11 6.5L7.5 10" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </button>
                </form>

                <div class="divider">
                    <div class="divider-line"></div>
                    <span>atau</span>
                    <div class="divider-line"></div>
                </div>

                <div class="register-row">
                    Belum punya akun?
                    <a href="{{ route('registration') }}">Daftar sekarang</a>
                </div>
            </div>

        </div>
    </main>

    <script>
        // Password visibility toggle
        const toggle = document.getElementById('pwToggle');
        const input  = document.getElementById('password');
        const icon   = document.getElementById('pwIcon');

        toggle.addEventListener('click', () => {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            icon.setAttribute('data-icon', show ? 'mdi:eye-off-outline' : 'mdi:eye-outline');
        });
    </script>
</body>

</html>