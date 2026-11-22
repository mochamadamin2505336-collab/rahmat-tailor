<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Masuk | Rahmat Tailor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <style>
        * { box-sizing: border-box; }
        html, body { margin: 0; min-height: 100%; }
        body {
            min-height: 100vh;
            background: rgba(20, 23, 26, 0.82);
            color: #14171A;
            font-family: "Plus Jakarta Sans", Arial, sans-serif;
        }
        .login-overlay {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .login-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(20, 23, 26, 0.75);
            backdrop-filter: blur(4px);
        }
        .login-card {
            position: relative;
            width: 100%;
            max-width: 440px;
            max-height: calc(100vh - 48px);
            overflow-y: auto;
            background: #FAF8F5;
            border: 1px solid #E5DFD5;
            border-radius: 12px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.28);
            padding: 32px;
        }
        .login-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }
        .login-title {
            margin: 0;
            font-family: "Playfair Display", Georgia, serif;
            font-size: 28px;
            line-height: 1.2;
        }
        .login-description {
            margin: 8px 0 0;
            color: #737373;
            font-size: 14px;
        }
        .login-close {
            flex: 0 0 44px;
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #737373;
            border-radius: 8px;
            text-decoration: none;
        }
        .login-close:hover,
        .login-close:focus-visible {
            color: #14171A;
            background: rgba(229, 223, 213, 0.6);
            outline: 3px solid rgba(186, 139, 78, 0.25);
            outline-offset: 2px;
        }
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 24px;
        }
        .login-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .login-field label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .login-field input {
            width: 100%;
            min-height: 44px;
            padding: 10px 12px;
            background: #fff;
            border: 1px solid #E5DFD5;
            border-radius: 8px;
            color: #14171A;
            font: inherit;
            font-size: 14px;
        }
        .login-field input:focus {
            border-color: #BA8B4E;
            outline: 3px solid rgba(186, 139, 78, 0.18);
            outline-offset: 1px;
        }
        .login-error {
            padding: 12px;
            background: #FEF2F2;
            border: 1px solid #FCA5A5;
            border-radius: 8px;
            color: #B91C1C;
            font-size: 14px;
        }
        .login-submit {
            width: 100%;
            min-height: 44px;
            border: 0;
            border-radius: 8px;
            background: #BA8B4E;
            color: #fff;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }
        .login-submit:hover { background: #A67A3F; }
        .login-submit:disabled { cursor: not-allowed; opacity: 0.65; }
        .login-register {
            margin: 20px 0 0;
            color: #737373;
            font-size: 14px;
        }
        .login-register a {
            color: #94682A;
            font-weight: 700;
        }
        .hidden { display: none; }
        @media (max-width: 640px) {
            .login-overlay { padding: 16px; }
            .login-card { max-height: calc(100vh - 32px); padding: 24px 20px; }
        }
        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; }
        }
    </style>
</head>
<body>
    <main class="login-overlay" role="dialog" aria-modal="true" aria-labelledby="login-title">
        <div class="login-backdrop" aria-hidden="true"></div>

        <section class="login-card">
            <div class="login-header">
                <div>
                    <h1 id="login-title" class="login-title">Masuk ke akun</h1>
                    <p class="login-description">Masuk sebelum membuat pemesanan online.</p>
                </div>
                <a href="{{ route('beranda') }}" class="login-close" aria-label="Tutup dan kembali ke beranda">
                    <span class="material-symbols-outlined" aria-hidden="true">close</span>
                </a>
            </div>

            <form id="login-form" class="login-form">
                <div class="login-field">
                    <label for="login-email">Email</label>
                    <input id="login-email" name="email" type="email" autocomplete="email" required />
                </div>
                <div class="login-field">
                    <label for="login-password">Kata sandi</label>
                    <input id="login-password" name="kata_sandi" type="password" autocomplete="current-password" required />
                </div>
                <div id="login-error" class="login-error hidden" role="alert"></div>
                <button id="login-submit" class="login-submit" type="submit">Masuk</button>
            </form>

            <p class="login-register">
                Belum punya akun?
                <a href="{{ route('daftar') }}">Daftar pelanggan</a>
            </p>
        </section>
    </main>

    <script>
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') window.location.href = @json(route('beranda'));
    });

    document.getElementById('login-form')?.addEventListener('submit', async (event) => {
        event.preventDefault();
        const form = event.currentTarget;
        const button = document.getElementById('login-submit');
        const error = document.getElementById('login-error');
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        button.disabled = true;
        error.classList.add('hidden');

        try {
            const response = await fetch('/api/masuk', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token || ''
                },
                body: JSON.stringify({
                    email: form.email.value,
                    kata_sandi: form.kata_sandi.value,
                    ingat_saya: false
                })
            });
            const result = await response.json();

            if (!response.ok) {
                error.textContent = result.errors ? Object.values(result.errors).flat().join(' ') : (result.message || 'Masuk gagal.');
                error.classList.remove('hidden');
                button.disabled = false;
                return;
            }

            window.location.href = @json(route('pemesanan'));
        } catch (errorResponse) {
            error.textContent = 'Masuk gagal. Periksa koneksi Anda.';
            error.classList.remove('hidden');
            button.disabled = false;
        }
    });
    </script>
</body>
</html>
