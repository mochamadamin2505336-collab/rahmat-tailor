<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Daftar Pelanggan | Rahmat Tailor</title>
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
        .register-overlay {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .register-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(20, 23, 26, 0.75);
            backdrop-filter: blur(4px);
        }
        .register-card {
            position: relative;
            width: 100%;
            max-width: 480px;
            max-height: calc(100vh - 48px);
            overflow-y: auto;
            background: #FAF8F5;
            border: 1px solid #E5DFD5;
            border-radius: 12px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.28);
            padding: 32px;
        }
        .register-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }
        .register-title {
            margin: 0;
            font-family: "Playfair Display", Georgia, serif;
            font-size: 28px;
            line-height: 1.2;
        }
        .register-description {
            margin: 8px 0 0;
            color: #737373;
            font-size: 14px;
        }
        .register-close {
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
        .register-close:hover,
        .register-close:focus-visible {
            color: #14171A;
            background: rgba(229, 223, 213, 0.6);
            outline: 3px solid rgba(186, 139, 78, 0.25);
            outline-offset: 2px;
        }
        .register-form {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 24px;
        }
        .register-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .register-field label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .register-field input {
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
        .register-field input:focus {
            border-color: #BA8B4E;
            outline: 3px solid rgba(186, 139, 78, 0.18);
            outline-offset: 1px;
        }
        .register-error {
            padding: 12px;
            background: #FEF2F2;
            border: 1px solid #FCA5A5;
            border-radius: 8px;
            color: #B91C1C;
            font-size: 14px;
        }
        .register-submit {
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
        .register-submit:hover { background: #A67A3F; }
        .register-submit:disabled { cursor: not-allowed; opacity: 0.65; }
        .register-login {
            margin: 20px 0 0;
            color: #737373;
            font-size: 14px;
        }
        .register-login a {
            color: #94682A;
            font-weight: 700;
        }
        .hidden { display: none; }
        @media (max-width: 640px) {
            .register-overlay { padding: 16px; }
            .register-card { max-height: calc(100vh - 32px); padding: 24px 20px; }
        }
        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; }
        }
    </style>
</head>
<body>
    <main class="register-overlay" role="dialog" aria-modal="true" aria-labelledby="register-title">
        <div class="register-backdrop" aria-hidden="true"></div>

        <section class="register-card">
            <div class="register-header">
                <div>
                    <h1 id="register-title" class="register-title">Daftar pelanggan</h1>
                    <p class="register-description">Buat akun untuk membuat pemesanan online.</p>
                </div>
                <a href="{{ route('beranda') }}" class="register-close" aria-label="Tutup dan kembali ke beranda">
                    <span class="material-symbols-outlined" aria-hidden="true">close</span>
                </a>
            </div>

            <form id="register-form" class="register-form">
                <div class="register-field">
                    <label for="register-name">Nama lengkap</label>
                    <input id="register-name" name="nama" type="text" autocomplete="name" required />
                </div>
                <div class="register-field">
                    <label for="register-email">Email</label>
                    <input id="register-email" name="email" type="email" autocomplete="email" required />
                </div>
                <div class="register-field">
                    <label for="register-whatsapp">Nomor WhatsApp</label>
                    <input id="register-whatsapp" name="no_whatsapp" type="tel" autocomplete="tel" required placeholder="812-xxxx-xxxx" />
                </div>
                <div class="register-field">
                    <label for="register-password">Kata sandi</label>
                    <input id="register-password" name="kata_sandi" type="password" autocomplete="new-password" minlength="8" required />
                </div>
                <div class="register-field">
                    <label for="register-password-confirm">Ulangi kata sandi</label>
                    <input id="register-password-confirm" name="kata_sandi_confirmation" type="password" autocomplete="new-password" minlength="8" required />
                </div>
                <div id="register-error" class="register-error hidden" role="alert"></div>
                <button id="register-submit" class="register-submit" type="submit">Daftar dan masuk</button>
            </form>

            <p class="register-login">
                Sudah punya akun?
                <a href="{{ route('login') }}">Masuk</a>
            </p>
        </section>
    </main>

    <script>
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') window.location.href = @json(route('beranda'));
    });

    document.getElementById('register-form')?.addEventListener('submit', async (event) => {
        event.preventDefault();
        const form = event.currentTarget;
        const button = document.getElementById('register-submit');
        const error = document.getElementById('register-error');
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        button.disabled = true;
        error.classList.add('hidden');

        try {
            const response = await fetch('/api/daftar', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token || ''
                },
                body: JSON.stringify({
                    nama: form.nama.value,
                    email: form.email.value,
                    no_whatsapp: form.no_whatsapp.value,
                    kata_sandi: form.kata_sandi.value,
                    kata_sandi_confirmation: form.kata_sandi_confirmation.value
                })
            });
            const result = await response.json();

            if (!response.ok) {
                error.textContent = result.errors ? Object.values(result.errors).flat().join(' ') : (result.message || 'Pendaftaran gagal.');
                error.classList.remove('hidden');
                button.disabled = false;
                return;
            }

            window.location.href = @json(route('pemesanan'));
        } catch (errorResponse) {
            error.textContent = 'Pendaftaran gagal. Periksa koneksi Anda.';
            error.classList.remove('hidden');
            button.disabled = false;
        }
    });
    </script>
</body>
</html>
