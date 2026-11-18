@extends('layouts.app')

@section('title', 'Masuk | Rahmat Tailor')
@section('main_class', 'w-full pt-20 min-h-screen bg-[#F8F6F2]')

@section('content')
<section class="max-w-md mx-auto px-6 py-12">
    <div class="bg-white border border-[#E5DFD5] rounded-xl shadow-[0_4px_24px_rgba(20,23,26,0.06)] p-6 md:p-8">
        <h1 class="font-serif text-2xl font-bold text-[#14171A]">Masuk ke akun</h1>
        <p class="mt-2 text-sm text-neutral-600">Masuk sebelum membuat pemesanan online.</p>

        <form id="login-form" class="mt-6 space-y-4">
            <div class="space-y-1.5">
                <label for="login-email" class="block text-xs font-bold uppercase tracking-wider text-[#14171A]">Email</label>
                <input id="login-email" name="email" type="email" autocomplete="email" required
                    class="w-full px-3 py-2.5 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm">
            </div>
            <div class="space-y-1.5">
                <label for="login-password" class="block text-xs font-bold uppercase tracking-wider text-[#14171A]">Kata sandi</label>
                <input id="login-password" name="kata_sandi" type="password" autocomplete="current-password" required
                    class="w-full px-3 py-2.5 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm">
            </div>
            <div id="login-error" role="alert" class="hidden p-3 bg-red-50 border border-red-300 rounded text-sm text-red-700"></div>
            <button id="login-submit" type="submit"
                class="w-full min-h-11 px-4 py-3 bg-[#BA8B4E] hover:bg-[#a67a3f] text-white rounded text-sm font-bold">
                Masuk
            </button>
        </form>

        <p class="mt-5 text-sm text-neutral-600">
            Belum punya akun?
            <a class="font-bold text-[#94682a] hover:underline" href="{{ route('daftar') }}">Daftar pelanggan</a>
        </p>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.getElementById('login-form')?.addEventListener('submit', async (event) => {
    event.preventDefault();
    const form = event.currentTarget;
    const button = document.getElementById('login-submit');
    const error = document.getElementById('login-error');
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    button.disabled = true;
    error.classList.add('hidden');

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
});
</script>
@endpush
