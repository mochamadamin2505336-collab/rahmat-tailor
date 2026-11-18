@extends('layouts.app')

@section('title', 'Daftar Pelanggan | Rahmat Tailor')
@section('main_class', 'w-full pt-20 min-h-screen bg-[#F8F6F2]')

@section('content')
<section class="max-w-md mx-auto px-6 py-12">
    <div class="bg-white border border-[#E5DFD5] rounded-xl shadow-[0_4px_24px_rgba(20,23,26,0.06)] p-6 md:p-8">
        <h1 class="font-serif text-2xl font-bold text-[#14171A]">Daftar pelanggan</h1>
        <p class="mt-2 text-sm text-neutral-600">Buat akun untuk membuat pemesanan online.</p>

        <form id="register-form" class="mt-6 space-y-4">
            <div class="space-y-1.5">
                <label for="register-name" class="block text-xs font-bold uppercase tracking-wider text-[#14171A]">Nama lengkap</label>
                <input id="register-name" name="nama" type="text" autocomplete="name" required class="w-full px-3 py-2.5 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm">
            </div>
            <div class="space-y-1.5">
                <label for="register-email" class="block text-xs font-bold uppercase tracking-wider text-[#14171A]">Email</label>
                <input id="register-email" name="email" type="email" autocomplete="email" required class="w-full px-3 py-2.5 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm">
            </div>
            <div class="space-y-1.5">
                <label for="register-whatsapp" class="block text-xs font-bold uppercase tracking-wider text-[#14171A]">Nomor WhatsApp</label>
                <input id="register-whatsapp" name="no_whatsapp" type="tel" autocomplete="tel" required placeholder="812-xxxx-xxxx" class="w-full px-3 py-2.5 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm">
            </div>
            <div class="space-y-1.5">
                <label for="register-password" class="block text-xs font-bold uppercase tracking-wider text-[#14171A]">Kata sandi</label>
                <input id="register-password" name="kata_sandi" type="password" autocomplete="new-password" minlength="8" required class="w-full px-3 py-2.5 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm">
            </div>
            <div class="space-y-1.5">
                <label for="register-password-confirm" class="block text-xs font-bold uppercase tracking-wider text-[#14171A]">Ulangi kata sandi</label>
                <input id="register-password-confirm" name="kata_sandi_confirmation" type="password" autocomplete="new-password" minlength="8" required class="w-full px-3 py-2.5 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm">
            </div>
            <div id="register-error" role="alert" class="hidden p-3 bg-red-50 border border-red-300 rounded text-sm text-red-700"></div>
            <button id="register-submit" type="submit" class="w-full min-h-11 px-4 py-3 bg-[#BA8B4E] hover:bg-[#a67a3f] text-white rounded text-sm font-bold">
                Daftar dan masuk
            </button>
        </form>

        <p class="mt-5 text-sm text-neutral-600">
            Sudah punya akun?
            <a class="font-bold text-[#94682a] hover:underline" href="{{ route('login') }}">Masuk</a>
        </p>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.getElementById('register-form')?.addEventListener('submit', async (event) => {
    event.preventDefault();
    const form = event.currentTarget;
    const button = document.getElementById('register-submit');
    const error = document.getElementById('register-error');
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    button.disabled = true;
    error.classList.add('hidden');

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
});
</script>
@endpush
