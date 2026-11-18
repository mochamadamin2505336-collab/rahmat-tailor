@extends('layouts.app')

@section('title', 'Booking Jadwal Ukur & Pemesanan Online | Rahmat Tailor Menteng')
@section('meta_description', 'Reservasi sesi privat pengukuran anatomi tubuh bersama Master Tailor di atelier, atau lakukan pemesanan online langsung dengan input ukuran tubuh mandiri.')
@section('main_class', 'w-full pt-20 bg-[#F8F6F2] min-h-screen pb-16')

@push('styles')
    @vite(['resources/css/pemesanan.css'])
@endpush

@section('content')
<div class="flex flex-col w-full">
<!-- Editorial Header -->
<section class="max-w-[1280px] w-full mx-auto px-6 lg:px-12 pt-8 pb-4">
  <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-6 border-b border-[#E5DFD5]">
    <div class="space-y-2">
      <div class="flex items-center gap-2">
      </div>
      <h1 class="font-serif text-3xl md:text-4xl text-[#14171A] font-medium tracking-tight">Booking Jadwal Ukur & Pemesanan Online</h1>
      <p class="text-sm text-neutral-600 max-w-2xl">
        Reservasi sesi privat pengukuran anatomi tubuh bersama Master Tailor di atelier, atau lakukan pemesanan online langsung dengan input ukuran tubuh mandiri dan unggah model impian Anda.
      </p>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
      <div class="flex items-center gap-2 bg-[#FAF6F0] border border-[#BA8B4E]/30 px-3.5 py-1.5 rounded shadow-xs">
        <span class="w-2.5 h-2.5 rounded-full bg-[#BA8B4E] animate-pulse"></span>
        <span class="text-xs text-[#14171A] uppercase font-bold">Slot Hari Ini: Tersedia 4 Sesi</span>
      </div>
      <div class="hidden sm:flex items-center gap-2 bg-[#FAF6F0] border border-[#BA8B4E]/30 px-3.5 py-1.5 rounded text-neutral-700 shadow-xs">
        <span class="material-symbols-outlined text-[18px] text-[#BA8B4E]">verified_user</span>
        <span class="text-xs uppercase font-bold text-[#14171A]">Verifikasi Master Tailor (PB-20)</span>
      </div>
    </div>
  </div>

<!-- TAB 2: PEMESANAN ONLINE & UKURAN MANDIRI -->
<section class="max-w-[1280px] w-full mx-auto px-6 lg:px-12 py-6" id="pane-online">
  <div class="pemesanan-layout grid grid-cols-1 gap-8 items-start">
    
    <!-- Formulir Kiri (7 Cols) -->
    <div class="pemesanan-form w-full min-w-0 bg-white p-5 sm:p-8 md:p-10 rounded-xl shadow-[0_4px_24px_rgba(20,23,26,0.06)] border border-[#E5DFD5] space-y-8">
      <div>
        <div class="flex items-center gap-2 text-[#BA8B4E] mb-1">
          <span class="material-symbols-outlined text-[18px]">tune</span>
          <span class="text-xs uppercase tracking-wider font-bold">Pemesanan Jarak Jauh (Online Bespoke)</span>
        </div>
        <h2 class="font-serif text-2xl md:text-3xl text-[#14171A] font-medium">Formulir Pemesanan & Ukuran Mandiri</h2>
        <p class="text-xs sm:text-sm text-neutral-600 mt-1">
          Pesan pakaian tanpa perlu ke atelier. Masukkan ukuran tubuh mandiri menggunakan pita meteran, klik tombol <strong>(?)</strong> di samping setiap ukuran untuk panduan visual, lalu unggah model impian Anda.
        </p>
      </div>

      <form class="space-y-8" id="online-order-form" enctype="multipart/form-data">
        @if($layanan->isNotEmpty())
          <input id="layanan-id" type="hidden" value="{{ $layanan->first()->id }}">
        @endif
        
        <!-- A. INFORMASI PELANGGAN -->
        <div class="space-y-4">
          <div class="flex items-center gap-2 pb-2 border-b border-[#E5DFD5]">
            <span class="w-6 h-6 rounded-full bg-[#14171A] text-white text-xs font-bold flex items-center justify-center">A</span>
            <h3 class="text-sm font-bold uppercase tracking-wider text-[#14171A]">Informasi Pelanggan</h3>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1.5">
              <label class="block text-xs uppercase tracking-wider font-bold text-[#14171A]">Nama Lengkap *</label>
              <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-neutral-400 text-[18px]">person</span>
                <input class="w-full pl-10 pr-4 py-2.5 bg-[#FAF8F5] border border-[#E5DFD5] text-sm text-[#14171A] rounded focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Misal: Ibu Dewi Lestari / Bpk Dimas" required type="text" value="{{ auth()->user()->name }}">
              </div>
            </div>
            <div class="space-y-1.5">
              <label class="block text-xs uppercase tracking-wider font-bold text-[#14171A]">Nomor WhatsApp Aktif *</label>
              <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-[#BA8B4E]">+62</span>
                <input class="w-full pl-12 pr-4 py-2.5 bg-[#FAF8F5] border border-[#E5DFD5] text-sm text-[#14171A] rounded focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="812-9876-5432" required type="tel" value="{{ auth()->user()->pelanggan?->no_whatsapp }}">
              </div>
              <p class="text-[11px] text-neutral-500">Kode nota tiket acak 8 karakter akan dikirimkan ke nomor ini.</p>
            </div>
          </div>
        </div>

        <!-- B. PILIH KATEGORI BUSANA (Celana, Baju, Rok) -->
        <div class="space-y-4">
          <div class="flex items-center justify-between pb-2 border-b border-[#E5DFD5]">
            <div class="flex items-center gap-2">
              <span class="w-6 h-6 rounded-full bg-[#14171A] text-white text-xs font-bold flex items-center justify-center">B</span>
              <h3 class="text-sm font-bold uppercase tracking-wider text-[#14171A]">Pilih Kategori Busana</h3>
            </div>
            <span class="text-xs text-[#BA8B4E] font-semibold">Form ukuran menyesuaikan otomatis</span>
          </div>
          <div class="grid grid-cols-3 gap-3">
            <button class="garment-btn p-3 rounded-lg border-2 border-[#BA8B4E] bg-[#FAF4EB] text-center transition-all flex flex-col items-center justify-center gap-1 shadow-xs cursor-pointer" data-target="celana" onclick="selectGarmentCategory('celana')" type="button">
              <span class="material-symbols-outlined text-[#BA8B4E] text-[24px]">checkroom</span>
              <span class="text-xs font-bold text-[#14171A]">Celana</span>
            </button>
            <button class="garment-btn p-3 rounded-lg border border-[#E5DFD5] bg-[#FAF8F5] hover:bg-[#F3EFE7] text-center transition-all flex flex-col items-center justify-center gap-1 cursor-pointer" data-target="baju" onclick="selectGarmentCategory('baju')" type="button">
              <span class="material-symbols-outlined text-neutral-500 text-[24px]">dry_cleaning</span>
              <span class="text-xs font-semibold text-[#14171A]">Baju / Jas</span>
            </button>
            <button class="garment-btn p-3 rounded-lg border border-[#E5DFD5] bg-[#FAF8F5] hover:bg-[#F3EFE7] text-center transition-all flex flex-col items-center justify-center gap-1 cursor-pointer" data-target="rok" onclick="selectGarmentCategory('rok')" type="button">
              <span class="material-symbols-outlined text-neutral-500 text-[24px]">styler</span>
              <span class="text-xs font-semibold text-[#14171A]">Rok</span>
            </button> 
            <button class="garment-btn p-3 rounded-lg border border-[#E5DFD5] bg-[#FAF8F5] hover:bg-[#F3EFE7] text-center transition-all flex flex-col items-center justify-center gap-1 cursor-pointer" data-target="kebaya" onclick="selectGarmentCategory('kebaya')" type="button">
              <span class="material-symbols-outlined text-neutral-500 text-[24px]">styler</span>
              <span class="text-xs font-semibold text-[#14171A]">Kebaya / Gamis</span>
            </button>
            <button class="garment-btn p-3 rounded-lg border border-[#E5DFD5] bg-[#FAF8F5] hover:bg-[#F3EFE7] text-center transition-all flex flex-col items-center justify-center gap-1 cursor-pointer" data-target="seragam" onclick="selectGarmentCategory('seragam')" type="button">
              <span class="material-symbols-outlined text-neutral-500 text-[24px]">styler</span>
              <span class="text-xs font-semibold text-[#14171A]">Seragam</span>
            </button>
          </div>
          <input id="current-garment" type="hidden" value="celana">
        </div>

        <!-- C. FORM UKURAN TUBUH MANDIRI DENGAN TOMBOL (?) POPUP PANDUAN -->
        <div class="space-y-4">
          <div class="flex items-center justify-between pb-2 border-b border-[#E5DFD5]">
            <div class="flex items-center gap-2">
              <span class="w-6 h-6 rounded-full bg-[#14171A] text-white text-xs font-bold flex items-center justify-center">C</span>
              <h3 class="text-sm font-bold uppercase tracking-wider text-[#14171A]">Form Ukuran Tubuh (cm)</h3>
            </div>
            <div class="flex items-center gap-1.5 text-xs text-[#BA8B4E] font-medium">
              <span>Klik ikon</span>
              <span class="w-4 h-4 rounded-full bg-[#BA8B4E]/20 text-[#BA8B4E] font-bold text-[10px] inline-flex items-center justify-center">?</span>
              <span>untuk membuka panduan pengukuran</span>
            </div>
          </div>

          <!-- KATEGORI: CELANA (7 Titik Ukur) -->
          <div class="garment-pane grid grid-cols-2 md:grid-cols-3 gap-4" id="pane-fields-celana">
            <!-- Lingkar Pinggang -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lingkar Pinggang *</label>
                <button aria-label="Panduan Lingkar Pinggang" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lingkar_pinggang')" title="Panduan Lingkar Pinggang" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="160" min="50" placeholder="Contoh: 84" required type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Lingkar Panggul -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lingkar Panggul *</label>
                <button aria-label="Panduan Lingkar Panggul" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lingkar_panggul')" title="Panduan Lingkar Panggul" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="170" min="60" placeholder="Contoh: 98" required type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Lingkar Pesak -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lingkar Pesak *</label>
                <button aria-label="Panduan Lingkar Pesak" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lingkar_pesak')" title="Panduan Lingkar Pesak" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="90" min="40" placeholder="Contoh: 68" required type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Lingkar Paha -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lingkar Paha *</label>
                <button aria-label="Panduan Lingkar Paha" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lingkar_paha')" title="Panduan Lingkar Paha" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="90" min="30" placeholder="Contoh: 58" required type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Lingkar Lutut -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lingkar Lutut *</label>
                <button aria-label="Panduan Lingkar Lutut" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lingkar_lutut')" title="Panduan Lingkar Lutut" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="70" min="25" placeholder="Contoh: 42" required type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Lingkar Celana Bawah -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lingkar Celana Bawah *</label>
                <button aria-label="Panduan Lingkar Celana Bawah" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lingkar_celana_bawah')" title="Panduan Lingkar Celana Bawah" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="60" min="20" placeholder="Contoh: 36" required type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Panjang Celana -->
            <div class="space-y-1 md:col-span-3">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Panjang Celana *</label>
                <button aria-label="Panduan Panjang Celana" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('panjang_celana')" title="Panduan Panjang Celana" type="button">?</button>
              </div>
              <div class="relative max-w-xs">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="140" min="60" placeholder="Contoh: 98" required type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>
          </div>

          <!-- KATEGORI: BAJU (9 Titik Ukur) -->
          <div class="garment-pane grid grid-cols-2 md:grid-cols-3 gap-4 hidden" id="pane-fields-baju">
            <!-- Lebar Punggung -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lebar Punggung *</label>
                <button aria-label="Panduan Lebar Punggung" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lebar_punggung')" title="Panduan Lebar Punggung" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 44" type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Lebar Bahu -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lebar Bahu *</label>
                <button aria-label="Panduan Lebar Bahu" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lebar_bahu')" title="Panduan Lebar Bahu" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 46" type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Panjang Lengan -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Panjang Lengan *</label>
                <button aria-label="Panduan Panjang Lengan" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('panjang_lengan')" title="Panduan Panjang Lengan" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 61" type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Lingkar Lengan Atas -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lingkar Lengan Atas *</label>
                <button aria-label="Panduan Lingkar Lengan Atas" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lingkar_lengan_atas')" title="Panduan Lingkar Lengan Atas" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 36" type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Lingkar Lengan Bawah -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lingkar Lengan Bawah *</label>
                <button aria-label="Panduan Lingkar Lengan Bawah" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lingkar_lengan_bawah')" title="Panduan Lingkar Lengan Bawah" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 24" type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Lingkar Dada -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lingkar Dada *</label>
                <button aria-label="Panduan Lingkar Dada" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lingkar_dada')" title="Panduan Lingkar Dada" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 104" type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Lingkar Pinggang Baju -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lingkar Pinggang *</label>
                <button aria-label="Panduan Lingkar Pinggang" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lingkar_pinggang')" title="Panduan Lingkar Pinggang" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 90" type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Lingkar Panggul Baju -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lingkar Panggul *</label>
                <button aria-label="Panduan Lingkar Panggul" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lingkar_panggul')" title="Panduan Lingkar Panggul" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 102" type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Panjang Baju -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Panjang Baju *</label>
                <button aria-label="Panduan Panjang Baju" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('panjang_baju')" title="Panduan Panjang Baju" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 74" type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>
          </div>

          <!-- KATEGORI: ROK (3 Titik Ukur) -->
          <div class="garment-pane grid grid-cols-1 md:grid-cols-3 gap-4 hidden" id="pane-fields-rok">
            <!-- Lingkar Pinggang Rok -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lingkar Pinggang *</label>
                <button aria-label="Panduan Lingkar Pinggang" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lingkar_pinggang')" title="Panduan Lingkar Pinggang" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 72" type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Lingkar Panggul Rok -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Lingkar Panggul *</label>
                <button aria-label="Panduan Lingkar Panggul" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('lingkar_panggul')" title="Panduan Lingkar Panggul" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 96" type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

            <!-- Panjang Rok -->
            <div class="space-y-1">
              <div class="flex items-center justify-between gap-1">
                <label class="block text-xs font-bold text-[#14171A]">Panjang Rok *</label>
                <button aria-label="Panduan Panjang Rok" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 shadow-xs cursor-pointer" onclick="openMeasureModal('panjang_rok')" title="Panduan Panjang Rok" type="button">?</button>
              </div>
              <div class="relative">
                <input class="w-full pr-10 pl-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 92" type="number">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-neutral-400">cm</span>
              </div>
            </div>

          </div>

            <!-- KATEGORI: SERAGAM (UKURAN CELANA DAN BAJU) -->
            <div class="garment-pane hidden space-y-6" id="pane-fields-seragam">
              <div class="space-y-3">
                <h4 class="text-xs uppercase tracking-wider font-bold text-[#14171A] border-b border-[#E5DFD5] pb-2">Ukuran Celana Seragam</h4>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-lingkar-pinggang-celana" class="block text-xs font-bold text-[#14171A]">Lingkar Pinggang *</label>
                      <button aria-label="Panduan Lingkar Pinggang Celana Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('lingkar_pinggang')" title="Panduan Lingkar Pinggang Celana Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-lingkar-pinggang-celana" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="160" min="50" placeholder="Contoh: 84" required type="number">
                  </div>
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-lingkar-panggul-celana" class="block text-xs font-bold text-[#14171A]">Lingkar Panggul *</label>
                      <button aria-label="Panduan Lingkar Panggul Celana Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('lingkar_panggul')" title="Panduan Lingkar Panggul Celana Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-lingkar-panggul-celana" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="170" min="60" placeholder="Contoh: 98" required type="number">
                  </div>
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-lingkar-pesak" class="block text-xs font-bold text-[#14171A]">Lingkar Pesak *</label>
                      <button aria-label="Panduan Lingkar Pesak Celana Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('lingkar_pesak')" title="Panduan Lingkar Pesak Celana Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-lingkar-pesak" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="90" min="40" placeholder="Contoh: 68" required type="number">
                  </div>
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-lingkar-paha" class="block text-xs font-bold text-[#14171A]">Lingkar Paha *</label>
                      <button aria-label="Panduan Lingkar Paha Celana Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('lingkar_paha')" title="Panduan Lingkar Paha Celana Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-lingkar-paha" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="90" min="30" placeholder="Contoh: 58" required type="number">
                  </div>
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-lingkar-lutut" class="block text-xs font-bold text-[#14171A]">Lingkar Lutut *</label>
                      <button aria-label="Panduan Lingkar Lutut Celana Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('lingkar_lutut')" title="Panduan Lingkar Lutut Celana Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-lingkar-lutut" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="70" min="25" placeholder="Contoh: 42" required type="number">
                  </div>
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-lingkar-celana-bawah" class="block text-xs font-bold text-[#14171A]">Lingkar Celana Bawah *</label>
                      <button aria-label="Panduan Lingkar Celana Bawah Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('lingkar_celana_bawah')" title="Panduan Lingkar Celana Bawah Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-lingkar-celana-bawah" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="60" min="20" placeholder="Contoh: 36" required type="number">
                  </div>
                  <div class="space-y-1 md:col-span-3">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-panjang-celana" class="block text-xs font-bold text-[#14171A]">Panjang Celana *</label>
                      <button aria-label="Panduan Panjang Celana Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('panjang_celana')" title="Panduan Panjang Celana Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-panjang-celana" class="w-full max-w-xs px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" max="140" min="60" placeholder="Contoh: 98" required type="number">
                  </div>
                </div>
              </div>

              <div class="space-y-3">
                <h4 class="text-xs uppercase tracking-wider font-bold text-[#14171A] border-b border-[#E5DFD5] pb-2">Ukuran Baju Seragam</h4>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-lebar-punggung" class="block text-xs font-bold text-[#14171A]">Lebar Punggung *</label>
                      <button aria-label="Panduan Lebar Punggung Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('lebar_punggung')" title="Panduan Lebar Punggung Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-lebar-punggung" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 44" required type="number">
                  </div>
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-lebar-bahu" class="block text-xs font-bold text-[#14171A]">Lebar Bahu *</label>
                      <button aria-label="Panduan Lebar Bahu Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('lebar_bahu')" title="Panduan Lebar Bahu Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-lebar-bahu" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 46" required type="number">
                  </div>
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-panjang-lengan" class="block text-xs font-bold text-[#14171A]">Panjang Lengan *</label>
                      <button aria-label="Panduan Panjang Lengan Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('panjang_lengan')" title="Panduan Panjang Lengan Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-panjang-lengan" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 61" required type="number">
                  </div>
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-lingkar-lengan-atas" class="block text-xs font-bold text-[#14171A]">Lingkar Lengan Atas *</label>
                      <button aria-label="Panduan Lingkar Lengan Atas Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('lingkar_lengan_atas')" title="Panduan Lingkar Lengan Atas Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-lingkar-lengan-atas" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 36" required type="number">
                  </div>
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-lingkar-lengan-bawah" class="block text-xs font-bold text-[#14171A]">Lingkar Lengan Bawah *</label>
                      <button aria-label="Panduan Lingkar Lengan Bawah Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('lingkar_lengan_bawah')" title="Panduan Lingkar Lengan Bawah Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-lingkar-lengan-bawah" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 24" required type="number">
                  </div>
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-lingkar-dada" class="block text-xs font-bold text-[#14171A]">Lingkar Dada *</label>
                      <button aria-label="Panduan Lingkar Dada Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('lingkar_dada')" title="Panduan Lingkar Dada Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-lingkar-dada" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 104" required type="number">
                  </div>
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-lingkar-pinggang-baju" class="block text-xs font-bold text-[#14171A]">Lingkar Pinggang *</label>
                      <button aria-label="Panduan Lingkar Pinggang Baju Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('lingkar_pinggang')" title="Panduan Lingkar Pinggang Baju Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-lingkar-pinggang-baju" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 90" required type="number">
                  </div>
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-lingkar-panggul-baju" class="block text-xs font-bold text-[#14171A]">Lingkar Panggul *</label>
                      <button aria-label="Panduan Lingkar Panggul Baju Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('lingkar_panggul')" title="Panduan Lingkar Panggul Baju Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-lingkar-panggul-baju" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 102" required type="number">
                  </div>
                  <div class="space-y-1">
                    <div class="flex items-center justify-between gap-1">
                      <label for="seragam-panjang-baju" class="block text-xs font-bold text-[#14171A]">Panjang Baju *</label>
                      <button aria-label="Panduan Panjang Baju Seragam" class="w-5 h-5 rounded-full border border-[#BA8B4E] bg-[#FAF4EB] text-[#BA8B4E] hover:bg-[#BA8B4E] hover:text-white transition-all flex items-center justify-center text-[11px] font-bold shrink-0 cursor-pointer" onclick="openMeasureModal('panjang_baju')" title="Panduan Panjang Baju Seragam" type="button">?</button>
                    </div>
                    <input id="seragam-panjang-baju" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] rounded text-sm font-mono text-[#14171A] focus:outline-none focus:ring-2 focus:ring-[#BA8B4E]" placeholder="Contoh: 74" required type="number">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- D. UNGGAH GAMBAR MODEL / DESAIN (PB-04) -->
        <div class="space-y-4">
          <div class="flex items-center justify-between pb-2 border-b border-[#E5DFD5]">
            <div class="flex items-center gap-2">
              <span class="w-6 h-6 rounded-full bg-[#14171A] text-white text-xs font-bold flex items-center justify-center">D</span>
              <h3 class="text-sm font-bold uppercase tracking-wider text-[#14171A]">Unggah Gambar Model / Desain</h3>
            </div>
            <span class="text-xs text-neutral-500">JPG, PNG, WEBP (Maks 10MB)</span>
          </div>
          <div class="p-6 bg-[#FAF8F5] border-2 border-dashed border-[#E5DFD5] hover:border-[#BA8B4E] rounded-xl text-center cursor-pointer transition-all" onclick="document.getElementById('file-upload-input').click()">
            <input accept="image/*" class="hidden" id="file-upload-input" name="foto_referensi" onchange="if(this.files[0]) document.getElementById('upload-preview-tag').textContent = 'File terpilih: ' + this.files[0].name" type="file">
            <div class="flex flex-col items-center justify-center space-y-2 pointer-events-none">
              <div class="w-12 h-12 rounded-full bg-[#FAF4EB] border border-[#BA8B4E]/30 flex items-center justify-center text-[#BA8B4E]">
                <span class="material-symbols-outlined text-[26px]">add_photo_alternate</span>
              </div>
              <p class="text-sm font-bold text-[#14171A]">Seret foto desain/siluet ke sini atau <span class="text-[#BA8B4E] underline">klik telusuri file</span></p>
              <p class="text-xs text-neutral-500 max-w-md">Bisa berupa screenshot Instagram/Pinterest, pola saku/kerah, sketsa rancangan, atau foto busana idaman Anda.</p>
              <span class="mt-2 text-xs font-mono font-semibold text-[#BA8B4E] bg-[#FAF4EB] px-3 py-1 rounded border border-[#BA8B4E]/40" id="upload-preview-tag">Model terpilih: Gurkha Bespoke Pleated Cut</span>
            </div>
          </div>
        </div>

        <!-- E. KETERSEDIAAN KAIN & CATATAN KHUSUS -->
        <div class="space-y-4">
          <div class="flex items-center gap-2 pb-2 border-b border-[#E5DFD5]">
            <span class="w-6 h-6 rounded-full bg-[#14171A] text-white text-xs font-bold flex items-center justify-center">E</span>
            <h3 class="text-sm font-bold uppercase tracking-wider text-[#14171A]">Penyediaan Bahan & Catatan Khusus</h3>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1.5">
              <label class="block text-xs uppercase tracking-wider font-bold text-[#14171A]">Ketersediaan Kain *</label>
              <div class="grid grid-cols-2 gap-2">
                <label class="flex items-center justify-center gap-2 p-2.5 rounded bg-[#FAF4EB] border border-[#BA8B4E] cursor-pointer text-xs font-bold text-[#14171A]"><input checked class="sr-only" name="fab_source" type="radio" value="sendiri"> Kirim Kain Sendiri</label>
                <label class="flex items-center justify-center gap-2 p-2.5 rounded bg-[#FAF8F5] border border-[#E5DFD5] cursor-pointer text-xs font-semibold text-neutral-700"><input class="sr-only" name="fab_source" type="radio" value="toko"> Rekomendasi Atelier</label>
              </div>
            </div>
            <div class="space-y-1.5">
              <label class="block text-xs uppercase tracking-wider font-bold text-[#14171A]">Target Tanggal Digunakan (Opsional)</label>
              <input id="target-tanggal" class="w-full px-3 py-2 bg-[#FAF8F5] border border-[#E5DFD5] text-xs text-[#14171A] rounded" type="date">
            </div>
          </div>
          <div class="space-y-1.5">
            <label class="block text-xs uppercase tracking-wider font-bold text-[#14171A]">Catatan Khusus Desain / Siluet / Fitting</label>
            <textarea id="catatan-pesanan" class="w-full px-4 py-2.5 bg-[#FAF8F5] border border-[#E5DFD5] text-sm text-[#14171A] rounded focus:outline-none focus:ring-2 focus:ring-[#BA8B4E] resize-none" placeholder="Contoh: Saku samping miring, tanpa lipatan bawah (plain hem), kancing tanduk horn gelap, dan beri ruang leluasa di selangkang." rows="3"></textarea>
          </div>
        </div>

        <!-- Tombol Aksi Submit (PB-20) -->
        <div class="pt-4 border-t border-[#E5DFD5] space-y-3">
          <button class="w-full py-4 bg-[#BA8B4E] text-white hover:bg-[#a67a3f] rounded text-xs font-bold uppercase tracking-widest transition-all duration-200 flex items-center justify-center gap-3 shadow-md cursor-pointer" type="submit">
            <span class="material-symbols-outlined text-[20px]">send_and_archive</span>
            <span>Kirim Pesanan Online & Dapatkan Kode Nota</span>
          </button>
          <div class="flex items-center justify-center gap-2 text-center">
            <span class="w-2 h-2 rounded-full bg-[#BA8B4E]"></span>
            <p class="text-xs text-neutral-600">
              Status awal pesanan: <strong class="text-[#14171A]">Menunggu Verifikasi Ukuran oleh Master Tailor</strong> (Aturan Bisnis PB-20).
            </p>
          </div>
        </div>
      </form>

      <!-- Alert Sukses Pemesanan (Hidden) -->
      <div class="hidden p-4 bg-red-50 border border-red-300 rounded-lg text-sm text-red-700" id="online-order-error-box" role="alert"></div>
      <div class="hidden p-6 bg-[#FAF4EB] border-2 border-[#BA8B4E] rounded-xl space-y-3" id="online-order-success-box">
        <div class="flex items-start gap-3">
          <span class="material-symbols-outlined text-[#BA8B4E] text-3xl">task_alt</span>
          <div class="space-y-1">
            <div class="flex items-center gap-2">
              <span id="kode-nota-pesanan" class="px-2 py-0.5 bg-[#14171A] text-white font-mono text-xs font-bold rounded">KODE NOTA:</span>
              <span class="px-2 py-0.5 bg-[#BA8B4E]/20 text-[#BA8B4E] text-[10px] font-bold uppercase rounded">Terkirim</span>
            </div>
            <h4 class="font-serif text-lg font-bold text-[#14171A]">Pesanan & Data Ukuran Berhasil Terkirim!</h4>
            <p class="text-xs text-neutral-700 leading-relaxed">
              Terima kasih. Master Tailor Pak Rahmat akan memeriksa apakah rasio lingkar dada, lingkar perut, dan panjang celana/baju Anda ergonomis secara proporsi anatomi. Konfirmasi & salinan nota dikirim via WhatsApp.
            </p>
          </div>
        </div>
      </div>
    </div>

    
    </div>
  </div>
</section>


<!-- MODAL / POPUP INTERAKTIF GAMBAR PANDUAN CARA MENGUKUR -->
<div aria-hidden="true" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs transition-opacity duration-200 opacity-0 pointer-events-none" id="measure-modal" role="dialog">
  <div class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-[#E5DFD5] transform transition-transform duration-200 scale-95" id="measure-modal-card">
    
    <!-- Modal Header -->
    <div class="sticky top-0 bg-[#FBF9F5] px-6 py-4 border-b border-[#E5DFD5] flex items-center justify-between z-10">
      <div class="flex items-center gap-3">
        <span class="w-8 h-8 rounded-full bg-[#FAF4EB] text-[#BA8B4E] flex items-center justify-center border border-[#BA8B4E]/30">
          <span class="material-symbols-outlined text-[18px]">straighten</span>
        </span>
        <div>
          <span class="text-[10px] uppercase tracking-wider text-[#BA8B4E] font-bold block">Panduan Titik Ukur Anatomi</span>
          <h3 class="font-serif text-lg font-bold text-[#14171A]" id="modal-title">Panduan Ukuran Tubuh</h3>
        </div>
      </div>
      <button aria-label="Tutup panduan" class="w-8 h-8 rounded-full hover:bg-neutral-200/60 text-neutral-500 hover:text-[#14171A] transition-colors flex items-center justify-center cursor-pointer" onclick="closeMeasureModal()" type="button">
        <span class="material-symbols-outlined text-[20px]">close</span>
      </button>
    </div>

    <!-- Modal Body -->
    <div class="p-6 space-y-5">
      
      <!-- Visual Gambar / Diagram Anatomi dengan Garis Pita Meteran Emas -->
      <div class="w-full bg-[#FAF8F5] rounded-xl p-5 border border-[#E5DFD5] flex flex-col items-center justify-center relative overflow-hidden">
        <svg class="w-44 h-52 text-[#14171A]" fill="none" viewBox="0 0 200 240" xmlns="http://www.w3.org/2000/svg">
          <!-- Siluet Anatomi Tubuh Manusia -->
          <circle cx="100" cy="30" fill="#EADECF" opacity="0.8" r="16"></circle>
          <path d="M88 45 C78 50, 48 58, 44 95 C41 120, 36 150, 34 165 C32 172, 38 174, 42 168 C48 152, 54 125, 56 112 C57 142, 60 170, 58 230 C58 234, 94 234, 95 230 C97 185, 98 160, 100 145 C102 160, 103 185, 105 230 C106 234, 142 234, 142 230 C140 170, 143 142, 144 112 C146 125, 152 152, 158 168 C162 174, 168 172, 166 165 C164 150, 159 120, 156 95 C152 58, 122 50, 112 45 Z" fill="#F4F0E8" stroke="#D3C4B5" stroke-width="1.5"></path>
          
          <!-- Garis Dinamis Meteran Pita Emas (posisi diupdate via script) -->
          <g id="modal-tape-group">
            <line id="svg-tape-line" stroke="#BA8B4E" stroke-dasharray="4 3" stroke-width="3.5" x1="58" x2="142" y1="114" y2="114"></line>
            <circle cx="58" cy="114" fill="#BA8B4E" id="svg-tape-c1" r="4.5"></circle>
            <circle cx="142" cy="114" fill="#BA8B4E" id="svg-tape-c2" r="4.5"></circle>
          </g>
        </svg>
        <span class="mt-2 font-mono text-[11px] text-[#BA8B4E] uppercase tracking-wider font-semibold bg-[#FAF4EB] px-3 py-1 rounded-full border border-[#BA8B4E]/30" id="modal-tag">Garis Ukur: Lingkar Pinggang</span>
      </div>

      <!-- Langkah Cara Mengukur -->
      <div class="space-y-1.5">
        <h4 class="text-xs uppercase tracking-wider font-bold text-[#14171A] flex items-center gap-1.5">
          <span class="material-symbols-outlined text-[#BA8B4E] text-[18px]">format_list_numbered</span>
          <span>Langkah Cara Mengukur</span>
        </h4>
        <p class="text-xs text-neutral-700 leading-relaxed bg-[#FAF8F5] p-3 rounded-lg border border-[#E5DFD5]" id="modal-instruction">
          Lilitkan pita meteran melingkari badan pada posisi garis pinggang atau ban sabuk celana yang biasa Anda kenakan.
        </p>
      </div>

      <!-- Tips Master Tailor -->
      <div class="p-4 bg-[#FAF4EB] border border-[#BA8B4E]/40 rounded-xl space-y-1.5">
        <div class="flex items-center gap-2 text-[#BA8B4E]">
          <span class="material-symbols-outlined text-[18px]">lightbulb</span>
          <span class="text-xs uppercase font-bold tracking-wider">Tips Master Tailor</span>
        </div>
        <p class="text-xs text-neutral-700 leading-normal" id="modal-tips">
          Bernapaslah secara biasa dan rileks. Jangan mengempiskan perut berlebih agar pakaian tetap nyaman saat duduk sehabis makan.
        </p>
      </div>

    </div>

    <!-- Modal Footer -->
    <div class="bg-[#F8F6F2] px-6 py-3.5 border-t border-[#E5DFD5] flex items-center justify-end">
      <button class="w-full sm:w-auto px-6 py-2.5 bg-[#BA8B4E] hover:bg-[#a67a3f] text-white rounded text-xs font-bold uppercase tracking-wider transition-colors shadow-sm flex items-center justify-center gap-2 cursor-pointer" onclick="closeMeasureModal()" type="button">
        <span class="material-symbols-outlined text-[18px]">check</span>
        <span>Paham, Tutup Panduan</span>
      </button>
    </div>

  </div>
</div>

@endsection

@push('scripts')
    @vite(['resources/js/pemesanan.js'])
@endpush