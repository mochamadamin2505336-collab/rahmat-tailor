<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Panel Admin — Rahmat Tailor Bespoke Atelier</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />

    <!-- Tailwind CDN + Vite CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>

<body
    class="h-full bg-[#181615] text-[#f5f3ef] font-sans antialiased overflow-x-hidden selection:bg-[#c59b27]/30 selection:text-[#fbf9f5]">

    {{-- ================================================================
         LAYOUT: Sidebar + Main Content
         ================================================================ --}}
    <div class="flex h-full">

        {{-- ============================================================
             SIDEBAR (Desktop fixed / Mobile drawer)
             ============================================================ --}}
        <aside id="admin-sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-[#1a1816] border-r border-[#2d2825] flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0">
            {{-- Brand --}}
            <div class="h-16 flex items-center gap-3 px-5 border-b border-[#2d2825] shrink-0">
                <span class="font-serif text-lg text-white tracking-wide">Rahmat Tailor<span
                        class="text-[#c59b27] text-xl">.</span></span>
                <span
                    class="ml-auto text-[10px] uppercase tracking-widest text-[#78716c] font-semibold px-2 py-0.5 rounded bg-[#282422] border border-[#3b3531]">Admin</span>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1" id="sidebar-nav">
                <button data-tab="dashboard"
                    class="admin-sidebar-btn active w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">dashboard</span>
                    Dashboard
                </button>
                <button data-tab="pesanan"
                    class="admin-sidebar-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                    Pesanan Jahit
                    <span class="ml-auto text-[11px] bg-[#c59b27]/20 text-[#c59b27] px-2 py-0.5 rounded-full font-bold"
                        id="order-count-badge">12</span>
                </button>
                <button data-tab="jadwal"
                    class="admin-sidebar-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                    Jadwal Ukur
                </button>
                <button data-tab="ukuran"
                    class="admin-sidebar-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">straighten</span>
                    Riwayat Ukuran
                </button>

                <div class="pt-3 pb-1 px-3">
                    <span class="text-[10px] uppercase tracking-widest text-[#78716c] font-semibold">Konten</span>
                </div>
                <button data-tab="layanan"
                    class="admin-sidebar-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">design_services</span>
                    Layanan & Galeri
                </button>
                <button data-tab="testimoni"
                    class="admin-sidebar-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">reviews</span>
                    Testimoni
                </button>

                <div class="pt-3 pb-1 px-3">
                    <span class="text-[10px] uppercase tracking-widest text-[#78716c] font-semibold">Keuangan</span>
                </div>
                <button data-tab="laporan"
                    class="admin-sidebar-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">monitoring</span>
                    Laporan Keuangan
                </button>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="p-4 border-t border-[#2d2825] shrink-0">
                <a href="{{ route('beranda') }}"
                    class="flex items-center gap-2 text-sm text-[#a8a29e] hover:text-[#c59b27] transition-colors">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali ke Website
                </a>
            </div>
        </aside>

        {{-- Sidebar overlay for mobile --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-30 bg-black/60 backdrop-blur-sm hidden lg:hidden"
            aria-hidden="true"></div>

        {{-- ============================================================
             MAIN CONTENT AREA
             ============================================================ --}}
        <div class="flex-1 min-w-0 flex flex-col lg:ml-64 min-h-screen">

            {{-- Top Header Bar --}}
            <header
                class="sticky top-0 z-20 h-16 bg-[#1a1816]/95 backdrop-blur-lg border-b border-[#2d2825] flex items-center justify-between px-4 lg:px-6 shrink-0">
                {{-- Mobile hamburger --}}
                <button id="sidebar-toggle"
                    class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg text-[#a8a29e] hover:text-white hover:bg-[#282422] transition-colors"
                    aria-label="Buka menu">
                    <span class="material-symbols-outlined text-[24px]">menu</span>
                </button>

                <h2 class="text-sm font-semibold text-[#a8a29e] uppercase tracking-wider hidden lg:block"
                    id="page-title">Dashboard</h2>

                <div class="flex items-center gap-3">
                    {{-- Quick Action: + Pesanan Offline (PB-18) --}}
                    <button id="btn-new-offline"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-[#c59b27] text-[#181615] text-sm font-bold rounded-lg hover:bg-[#d8ac34] transition-all active:scale-95 shadow-lg shadow-[#c59b27]/20">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        <span class="hidden sm:inline">Pesanan Offline</span>
                    </button>
                </div>
            </header>

            {{-- ============================================================
                 TAB CONTENT PANELS
                 ============================================================ --}}
            <main class="flex-1 min-w-0 overflow-y-auto p-4 lg:p-6 space-y-6">

                {{-- ======================== DASHBOARD (PB-07, PB-16) ======================== --}}
                <section id="tab-dashboard" class="tab-panel">
                    {{-- KPI Cards Row --}}
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="admin-card p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Total
                                    Pesanan</span>
                                <span class="material-symbols-outlined text-[20px] text-[#c59b27]">receipt_long</span>
                            </div>
                            <p id="dashboard-total-orders" class="text-2xl font-bold text-white">0</p>
                            <p id="dashboard-total-orders-note" class="text-xs text-emerald-400 mt-1">Memuat data</p>
                        </div>
                        <div class="admin-card p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Proses
                                    Aktif</span>
                                <span class="material-symbols-outlined text-[20px] text-sky-400">manufacturing</span>
                            </div>
                            <p id="dashboard-active-orders" class="text-2xl font-bold text-white">0</p>
                            <p id="dashboard-verification-note" class="text-xs text-[#a8a29e] mt-1">Memuat data</p>
                        </div>
                        <div class="admin-card p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Siap
                                    Diambil</span>
                                <span class="material-symbols-outlined text-[20px] text-amber-400">check_circle</span>
                            </div>
                            <p id="dashboard-ready-orders" class="text-2xl font-bold text-white">0</p>
                            <p class="text-xs text-amber-400 mt-1">Perlu dihubungi</p>
                        </div>
                        <div class="admin-card p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Pendapatan
                                    Bulan</span>
                                <span class="material-symbols-outlined text-[20px] text-emerald-400">payments</span>
                            </div>
                            <p id="dashboard-month-revenue" class="text-2xl font-bold text-white">Rp 0</p>
                            <p class="text-xs text-emerald-400 mt-1">Bulan berjalan</p>
                        </div>
                    </div>

                    {{-- Urgent Deadline Alert (PB-07) --}}
                    <div class="admin-card border-amber-500/40 p-4 mb-6 urgent-pulse">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-amber-400 text-[22px] mt-0.5">warning</span>
                            <div>
                                <h3 class="text-sm font-bold text-amber-300">Deadline Mendekat (< 3 Hari)</h3>
                                        <div id="dashboard-urgent-orders" class="mt-2 space-y-2">
                                            <p class="text-xs text-[#a8a29e]">Memuat pesanan mendesak...</p>
                                        </div>
                            </div>
                        </div>
                    </div>

                    {{-- Recent Orders Quick Table --}}
                    <div class="admin-card overflow-hidden">
                        <div class="px-5 py-4 border-b border-[#2d2825] flex items-center justify-between">
                            <h3 class="text-sm font-bold text-white">Pesanan Terbaru</h3>
                            <button data-tab="pesanan"
                                class="admin-sidebar-btn text-xs text-[#c59b27] hover:underline font-semibold">Lihat
                                Semua →</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr
                                        class="border-b border-[#2d2825] text-[#78716c] text-xs uppercase tracking-wider">
                                        <th class="px-5 py-3 text-left font-semibold">Kode</th>
                                        <th class="px-5 py-3 text-left font-semibold">Pelanggan</th>
                                        <th class="px-5 py-3 text-left font-semibold">Layanan</th>
                                        <th class="px-5 py-3 text-left font-semibold">Status</th>
                                        <th class="px-5 py-3 text-left font-semibold">Deadline</th>
                                        <th class="px-5 py-3 text-left font-semibold">Sumber</th>
                                        <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="dashboard-recent-orders">
                                    <tr><td colspan="7" class="px-5 py-6 text-sm text-[#a8a29e]">Memuat pesanan terbaru...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>


                {{-- ======================== PESANAN JAHIT (PB-07, PB-08, PB-12, PB-13, PB-20) ======================== --}}
                <section id="tab-pesanan" class="tab-panel hidden">
                    {{-- Search & Filter Bar --}}
                    <div class="flex flex-col sm:flex-row gap-3 mb-5">
                        <div class="relative flex-1">
                            <span
                                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-[#78716c]">search</span>
                            <input id="order-search" type="text"
                                placeholder="Cari kode pesanan, nama pelanggan..."
                                class="w-full pl-10 pr-4 py-2.5 bg-[#221f1d] border border-[#3b3531] rounded-lg text-sm text-white placeholder-[#78716c] focus:border-[#c59b27] focus:ring-1 focus:ring-[#c59b27] transition-colors" />
                        </div>
                        <select id="filter-status"
                            class="px-4 py-2.5 bg-[#221f1d] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]">
                            <option value="">Semua Status</option>
                            <option value="verifikasi">Verifikasi</option>
                            <option value="diterima">Diterima</option>
                            <option value="dipotong">Dipotong</option>
                            <option value="dijahit">Dijahit</option>
                            <option value="fitting">Fitting</option>
                            <option value="selesai">Selesai</option>
                            <option value="siap-diambil">Siap Diambil</option>
                        </select>
                        <select id="filter-source"
                            class="px-4 py-2.5 bg-[#221f1d] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]">
                            <option value="">Semua Sumber</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>

                    {{-- Orders Table --}}
                    <div class="admin-card overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm" id="orders-table">
                                <thead>
                                    <tr
                                        class="border-b border-[#2d2825] text-[#78716c] text-xs uppercase tracking-wider">
                                        <th class="px-5 py-3 text-left font-semibold">Kode</th>
                                        <th class="px-5 py-3 text-left font-semibold">Pelanggan</th>
                                        <th class="px-5 py-3 text-left font-semibold">WhatsApp</th>
                                        <th class="px-5 py-3 text-left font-semibold">Layanan</th>
                                        <th class="px-5 py-3 text-left font-semibold">Status</th>
                                        <th class="px-5 py-3 text-left font-semibold">Deadline</th>
                                        <th class="px-5 py-3 text-left font-semibold">Sumber</th>
                                        <th class="px-5 py-3 text-left font-semibold">Pembayaran</th>
                                        <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="orders-tbody">
                                    <tr><td colspan="9" class="px-5 py-6 text-sm text-[#a8a29e]">Memuat pesanan...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>


                {{-- ======================== JADWAL UKUR (PB-11) ======================== --}}
                <section id="tab-jadwal" class="tab-panel hidden">
                    <div class="admin-card overflow-hidden">
                        <div class="px-5 py-4 border-b border-[#2d2825]">
                            <h3 class="text-sm font-bold text-white">Jadwal Pengukuran & Fitting di Toko</h3>
                        </div>
                        <div id="jadwal-admin-list" class="divide-y divide-[#2d2825]">
                            <p class="p-5 text-sm text-[#a8a29e]">Memuat jadwal...</p>
                        </div>
                    </div>
                </section>


                {{-- ======================== RIWAYAT UKURAN (PB-14) ======================== --}}
                <section id="tab-ukuran" class="tab-panel hidden">
                    <div class="admin-card overflow-hidden">
                        <div class="px-5 py-4 border-b border-[#2d2825] flex items-center justify-between">
                            <h3 class="text-sm font-bold text-white">Profil Ukuran Pelanggan</h3>
                            <div class="relative w-64">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[16px] text-[#78716c]">search</span>
                                <input id="ukuran-search" type="search" placeholder="Cari pelanggan..."
                                    class="w-full pl-9 pr-4 py-2 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                            </div>
                        </div>
                        <div id="ukuran-history-list" class="divide-y divide-[#2d2825]">
                            <p class="p-5 text-sm text-[#a8a29e]" id="ukuran-history-loading">Memuat riwayat ukuran...
                            </p>
                        </div>
                    </div>
                </section>


                {{-- ======================== LAYANAN & GALERI (PB-10) ======================== --}}
                <section id="tab-layanan" class="tab-panel hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {{-- Layanan Management --}}
                        <div class="admin-card overflow-hidden">
                            <div class="px-5 py-4 border-b border-[#2d2825] flex items-center justify-between">
                                <h3 class="text-sm font-bold text-white">Daftar Layanan</h3>
                                <button id="btn-add-layanan" type="button"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#c59b27] text-[#181615] rounded-lg text-xs font-bold hover:bg-[#d8ac34] transition-colors">
                                    <span class="material-symbols-outlined text-[14px]">add</span> Tambah
                                </button>
                            </div>
                            <div id="layanan-list" class="divide-y divide-[#2d2825]">
                                <p class="p-5 text-sm text-[#a8a29e]">Memuat layanan...</p>
                            </div>
                        </div>

                        {{-- Galeri Management --}}
                        <div class="admin-card overflow-hidden">
                            <div class="px-5 py-4 border-b border-[#2d2825] flex items-center justify-between">
                                <h3 class="text-sm font-bold text-white">Galeri Portofolio</h3>
                                <button id="btn-add-galeri" type="button"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#c59b27] text-[#181615] rounded-lg text-xs font-bold hover:bg-[#d8ac34] transition-colors">
                                    <span class="material-symbols-outlined text-[14px]">upload</span> Upload
                                </button>
                            </div>
                            <div id="galeri-list" class="p-5 grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <p class="col-span-full text-sm text-[#a8a29e]">Memuat galeri...</p>
                            </div>
                        </div>
                    </div>
                </section>


                {{-- ======================== TESTIMONI (PB-15) ======================== --}}
                <section id="tab-testimoni" class="tab-panel hidden">
                    <div class="admin-card overflow-hidden">
                        <div class="px-5 py-4 border-b border-[#2d2825]">
                            <h3 class="text-sm font-bold text-white">Testimoni Pelanggan</h3>
                        </div>
                        <div id="testimoni-admin-list" class="divide-y divide-[#2d2825]">
                            <p class="p-5 text-sm text-[#a8a29e]">Memuat testimoni...</p>
                        </div>
                    </div>
                </section>


                {{-- ======================== LAPORAN KEUANGAN (PB-16) ======================== --}}
                <section id="tab-laporan" class="tab-panel hidden">
                    {{-- Revenue Summary Cards --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="admin-card p-4">
                            <p class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Pendapatan Bulan
                                Ini</p>
                            <p id="laporan-pendapatan" class="text-xl font-bold text-white mt-1">Rp 0</p>
                        </div>
                        <div class="admin-card p-4">
                            <p class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">DP Terkumpul</p>
                            <p id="laporan-dp" class="text-xl font-bold text-emerald-400 mt-1">Rp 0</p>
                        </div>
                        <div class="admin-card p-4">
                            <p class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Pelunasan Diterima
                            </p>
                            <p id="laporan-pelunasan" class="text-xl font-bold text-sky-400 mt-1">Rp 0</p>
                        </div>
                        <div class="admin-card p-4">
                            <p class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Piutang</p>
                            <p id="laporan-piutang" class="text-xl font-bold text-amber-400 mt-1">Rp 0</p>
                        </div>
                    </div>

                    {{-- Category Breakdown --}}
                    <div class="admin-card overflow-hidden">
                        <div class="px-5 py-4 border-b border-[#2d2825]">
                            <h3 id="laporan-kategori-title" class="text-sm font-bold text-white">Pendapatan per Kategori</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr
                                        class="border-b border-[#2d2825] text-[#78716c] text-xs uppercase tracking-wider">
                                        <th class="px-5 py-3 text-left font-semibold">Kategori</th>
                                        <th class="px-5 py-3 text-left font-semibold">Jumlah Pesanan</th>
                                        <th class="px-5 py-3 text-left font-semibold">Pendapatan</th>
                                        <th class="px-5 py-3 text-left font-semibold">Proporsi</th>
                                    </tr>
                                </thead>
                                <tbody id="laporan-kategori-list">
                                    <tr><td colspan="4" class="px-5 py-6 text-sm text-[#a8a29e]">Memuat laporan...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

            </main>
        </div>
    </div>


    {{-- ================================================================
         MODALS
         ================================================================ --}}

    <div id="modal-layanan"
        class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/70 backdrop-blur-sm" role="dialog"
        aria-modal="true" aria-labelledby="modal-layanan-title">
        <div class="admin-card w-full max-w-xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#2d2825]">
                <h3 id="modal-layanan-title" class="text-base font-bold text-white">Tambah Layanan</h3>
                <button type="button"
                    class="modal-close p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] hover:text-white"
                    aria-label="Tutup">
                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">close</span>
                </button>
            </div>
            <form id="layanan-form" class="p-6 space-y-4">
                <input id="layanan-id" type="hidden">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="layanan-nama" class="block text-xs text-[#a8a29e] mb-1">Nama layanan</label>
                        <input id="layanan-nama" type="text" maxlength="100" required
                            class="w-full px-3 py-2 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white">
                    </div>
                    <div>
                        <label for="layanan-kategori" class="block text-xs text-[#a8a29e] mb-1">Kategori</label>
                        <input id="layanan-kategori" type="text" maxlength="60" required
                            class="w-full px-3 py-2 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white">
                    </div>
                    <div>
                        <label for="layanan-harga-min" class="block text-xs text-[#a8a29e] mb-1">Harga minimum</label>
                        <input id="layanan-harga-min" type="number" min="0" required
                            class="w-full px-3 py-2 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white">
                    </div>
                    <div>
                        <label for="layanan-harga-max" class="block text-xs text-[#a8a29e] mb-1">Harga
                            maksimum</label>
                        <input id="layanan-harga-max" type="number" min="0" required
                            class="w-full px-3 py-2 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white">
                    </div>
                    <div>
                        <label for="layanan-estimasi" class="block text-xs text-[#a8a29e] mb-1">Estimasi hari</label>
                        <input id="layanan-estimasi" type="number" min="1" max="365" required
                            class="w-full px-3 py-2 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white">
                    </div>
                    <div>
                        <label for="layanan-urutan" class="block text-xs text-[#a8a29e] mb-1">Urutan</label>
                        <input id="layanan-urutan" type="number" min="0" value="0"
                            class="w-full px-3 py-2 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white">
                    </div>
                </div>
                <div>
                    <label for="layanan-deskripsi" class="block text-xs text-[#a8a29e] mb-1">Deskripsi</label>
                    <textarea id="layanan-deskripsi" maxlength="1000" rows="4"
                        class="w-full px-3 py-2 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white resize-none"></textarea>
                </div>
                <label class="inline-flex items-center gap-2 text-sm text-[#a8a29e]">
                    <input id="layanan-aktif" type="checkbox" checked class="accent-[#c59b27]">
                    Layanan aktif
                </label>
                <p id="layanan-feedback" class="hidden text-sm" role="alert"></p>
                <button type="submit"
                    class="w-full py-3 bg-[#c59b27] text-[#181615] rounded-lg text-sm font-bold hover:bg-[#d8ac34]">Simpan
                    Layanan</button>
            </form>
        </div>
    </div>

    <div id="modal-galeri"
        class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/70 backdrop-blur-sm" role="dialog"
        aria-modal="true" aria-labelledby="modal-galeri-title">
        <div class="admin-card w-full max-w-lg">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#2d2825]">
                <h3 id="modal-galeri-title" class="text-base font-bold text-white">Upload Galeri</h3>
                <button type="button"
                    class="modal-close p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] hover:text-white"
                    aria-label="Tutup">
                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">close</span>
                </button>
            </div>
            <form id="galeri-form" class="p-6 space-y-4" enctype="multipart/form-data">
                <input id="galeri-id" type="hidden">
                <div>
                    <label for="galeri-judul" class="block text-xs text-[#a8a29e] mb-1">Judul</label>
                    <input id="galeri-judul" type="text" maxlength="150" required
                        class="w-full px-3 py-2 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white">
                </div>
                <div>
                    <label for="galeri-kategori" class="block text-xs text-[#a8a29e] mb-1">Kategori</label>
                    <input id="galeri-kategori" type="text" maxlength="60" required
                        class="w-full px-3 py-2 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white">
                </div>
                <div>
                    <label for="galeri-layanan" class="block text-xs text-[#a8a29e] mb-1">Layanan terkait</label>
                    <select id="galeri-layanan"
                        class="w-full px-3 py-2 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white">
                        <option value="">Tidak terkait</option>
                    </select>
                </div>
                <div>
                    <label for="galeri-foto" class="block text-xs text-[#a8a29e] mb-1">Foto JPG atau PNG, maksimal 5
                        MB</label>
                    <input id="galeri-foto" type="file" accept="image/jpeg,image/png"
                        class="w-full text-sm text-[#a8a29e] file:mr-3 file:px-3 file:py-2 file:rounded-lg file:border-0 file:bg-[#282422] file:text-white">
                </div>
                <p id="galeri-feedback" class="hidden text-sm" role="alert"></p>
                <button type="submit"
                    class="w-full py-3 bg-[#c59b27] text-[#181615] rounded-lg text-sm font-bold hover:bg-[#d8ac34]">Simpan
                    Galeri</button>
            </form>
        </div>
    </div>

    {{-- === ORDER DETAIL MODAL (PB-20) === --}}
    <div id="modal-detail"
        class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/70 backdrop-blur-sm" role="dialog"
        aria-modal="true">
        <div class="admin-card w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#2d2825]">
                <h3 class="text-base font-bold text-white">Detail Pesanan <span id="detail-code"
                        class="text-[#c59b27]">RT-XXXXXXXX</span></h3>
                <button
                    type="button" aria-label="Tutup detail pesanan"
                    class="modal-close p-2 rounded-lg hover:bg-[#282422] text-[#a8a29e] hover:text-white transition-colors cursor-pointer"><span
                        class="material-symbols-outlined text-[20px]" aria-hidden="true">close</span></button>
            </div>
            <div class="p-6 space-y-5">
                {{-- Customer Info --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-[#78716c] uppercase tracking-wider font-semibold mb-1">Pelanggan</p>
                        <p class="text-sm text-white font-semibold" id="detail-customer">—</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#78716c] uppercase tracking-wider font-semibold mb-1">WhatsApp</p>
                        <p class="text-sm text-emerald-400" id="detail-wa">—</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#78716c] uppercase tracking-wider font-semibold mb-1">Layanan</p>
                        <p class="text-sm text-white" id="detail-service">—</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#78716c] uppercase tracking-wider font-semibold mb-1">Sumber</p>
                        <p class="text-sm" id="detail-source">—</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#78716c] uppercase tracking-wider font-semibold mb-1">Tanggal Dipakai</p>
                        <p class="text-sm text-[#c59b27] font-semibold" id="detail-target-date">—</p>
                    </div>
                </div>

                {{-- Status Timeline (PB-08) --}}
                <div>
                    <p class="text-xs text-[#78716c] uppercase tracking-wider font-semibold mb-3">Riwayat Status</p>
                    <div class="space-y-3" id="detail-timeline">
                        <p class="text-xs text-[#a8a29e]">Memuat riwayat status...</p>
                    </div>
                </div>

                {{-- Measurements Summary --}}
                <div>
                    <p class="text-xs text-[#78716c] uppercase tracking-wider font-semibold mb-3">Ukuran Pelanggan</p>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-2" id="detail-measurements">
                        <p class="col-span-full text-xs text-[#a8a29e]">Memuat ukuran...</p>
                    </div>
                </div>

                {{-- Model Reference --}}
                <div>
                    <p class="text-xs text-[#78716c] uppercase tracking-wider font-semibold mb-3">Model dari Pelanggan</p>
                    <div id="detail-model-loading" class="h-48 rounded-xl border border-[#3b3531] bg-[#181615] flex items-center justify-center text-xs text-[#a8a29e]">
                        Memuat model...
                    </div>
                    <button id="detail-model-open" type="button"
                        class="hidden w-full cursor-pointer overflow-hidden rounded-xl border border-[#3b3531] bg-[#181615] text-left focus:outline-none focus:ring-2 focus:ring-[#c59b27]"
                        aria-label="Perbesar gambar model pelanggan">
                        <img id="detail-model-image" src="" alt="Model atau gambar referensi pesanan pelanggan"
                            width="640" height="360" class="h-48 sm:h-64 w-full object-contain">
                    </button>
                    <p id="detail-model-empty" class="hidden rounded-xl border border-[#3b3531] bg-[#181615] px-4 py-8 text-center text-xs text-[#a8a29e]">
                        Pelanggan belum mengirim model.
                    </p>
                </div>

                <div id="detail-verification" class="border-t border-[#2d2825] pt-5">
                    <p class="text-xs text-[#78716c] uppercase tracking-wider font-semibold mb-3">Verifikasi Pesanan</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="detail-price" class="block text-xs text-[#a8a29e] mb-1">Harga (Rp)</label>
                            <input id="detail-price" type="number" min="0"
                                class="w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white">
                        </div>
                        <div>
                            <label for="detail-deadline" class="block text-xs text-[#a8a29e] mb-1">Deadline</label>
                            <input id="detail-deadline" type="date"
                                class="w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white">
                        </div>
                    </div>

                    {{-- Model preview lightbox --}}
                    <div id="modal-detail-model"
                        class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-black/90"
                        role="dialog" aria-modal="true" aria-labelledby="detail-model-title">
                        <div class="relative w-full max-w-5xl">
                            <h3 id="detail-model-title" class="sr-only">Pratinjau model pesanan pelanggan</h3>
                            <button type="button" aria-label="Tutup pratinjau model"
                                class="modal-close absolute right-2 top-2 z-10 p-2 rounded-lg bg-black/70 text-white hover:bg-black cursor-pointer">
                                <span class="material-symbols-outlined text-[20px]" aria-hidden="true">close</span>
                            </button>
                            <img id="detail-model-lightbox-image" src="" alt="Gambar model pesanan pelanggan diperbesar"
                                width="1280" height="720" class="max-h-[88vh] w-full rounded-xl object-contain">
                        </div>
                    </div>
                    <p id="detail-verification-feedback" class="hidden mt-3 rounded-lg border border-[#3b3531] px-3 py-2 text-xs" role="status" aria-live="polite"></p>
                    <div class="flex flex-col sm:flex-row gap-2 mt-3">
                        <button id="detail-save-verification" type="button"
                            class="px-4 py-2.5 rounded-lg border border-[#3b3531] text-sm text-[#a8a29e] hover:text-white hover:bg-[#282422]">Simpan Harga & Deadline</button>
                        <button id="detail-confirm-verification" type="button"
                            class="px-4 py-2.5 rounded-lg bg-[#c59b27] text-[#181615] text-sm font-bold hover:bg-[#d8ac34]">Verifikasi dan Terima Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- === PAYMENT MODAL (PB-13) === --}}
    <div id="modal-payment"
        class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/70 backdrop-blur-sm" role="dialog"
        aria-modal="true">
        <div class="admin-card w-full max-w-md">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#2d2825]">
                <h3 class="text-base font-bold text-white">Catat Pembayaran</h3>
                <button
                    class="modal-close p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] hover:text-white transition-colors"><span
                        class="material-symbols-outlined text-[20px]">close</span></button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-xs text-[#78716c] mb-1">Pesanan</p>
                    <p class="text-sm font-mono text-[#c59b27] font-bold" id="payment-code">—</p>
                </div>
                <div>
                    <label class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Jenis
                        Pembayaran</label>
                    <select id="payment-type"
                        class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]">
                        <option value="dp">DP (Uang Muka 50%)</option>
                        <option value="pelunasan">Pelunasan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Jumlah
                        (Rp)</label>
                    <input id="payment-amount" type="number" placeholder="Contoh: 1250000"
                        class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                </div>
                <div>
                    <label
                        class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Metode</label>
                    <select id="payment-method"
                        class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]">
                        <option value="transfer">Transfer Bank</option>
                        <option value="cash">Tunai</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>
                <button id="payment-submit" type="button"
                    class="w-full py-2.5 bg-[#c59b27] text-[#181615] font-bold rounded-lg hover:bg-[#d8ac34] transition-colors text-sm active:scale-[0.98]">Simpan
                    Pembayaran</button>
            </div>
        </div>
    </div>


    {{-- === OFFLINE ORDER MODAL (PB-18) === --}}
    <div id="modal-offline"
        class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/70 backdrop-blur-sm" role="dialog"
        aria-modal="true">
        <div class="admin-card w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#2d2825]">
                <h3 class="text-base font-bold text-white">Buat Pesanan Offline</h3>
                <button
                    class="modal-close p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] hover:text-white transition-colors"><span
                        class="material-symbols-outlined text-[20px]">close</span></button>
            </div>
            <form id="offline-order-form" class="p-6 space-y-4">
                <div>
                    <p class="text-xs text-[#78716c] mb-1">Kode Pesanan</p>
                    <p class="text-lg font-mono text-[#c59b27] font-bold" id="offline-generated-code">Dibuat saat disimpan</p>
                </div>
                <div>
                    <label for="offline-customer-name"
                        class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Nama
                        Pelanggan</label>
                    <input id="offline-customer-name" name="customer_name" type="text" placeholder="Nama lengkap"
                        required
                        class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                </div>
                <div>
                    <label for="offline-customer-phone"
                        class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">No.
                        WhatsApp</label>
                    <input id="offline-customer-phone" name="customer_phone" type="tel"
                        placeholder="08xxxxxxxxxx" required
                        class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white placeholder-[#78716c]" />
                </div>
                <div>
                    <label for="offline-bahan"
                        class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Sumber Bahan</label>
                    <select id="offline-bahan" name="bahan" required
                        class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]">
                        <option value="sendiri">Bahan dari pelanggan</option>
                        <option value="toko">Bahan dari toko</option>
                    </select>
                </div>
                <div>
                    <label for="offline-garment-category"
                        class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Kategori
                        Busana</label>
                    <select id="offline-garment-category" name="garment_category" required
                        class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]">
                        <option value="celana">Celana</option>
                        <option value="baju">Baju / Jas</option>
                        <option value="rok">Rok</option>
                        <option value="kebaya">Kebaya / Gamis</option>
                        <option value="seragam">Seragam</option>
                    </select>
                </div>
                <div class="border-t border-[#2d2825] pt-4">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs text-[#a8a29e] font-semibold uppercase tracking-wider">Ukuran Pelanggan (cm)
                        </p>
                        <span class="text-[11px] text-[#78716c]">Sesuaikan dengan kategori busana</span>
                    </div>
                    <div id="offline-measurements-celana" class="offline-measurement-pane grid grid-cols-2 gap-3">
                        <div>
                            <label for="offline-waist" class="block text-xs text-[#a8a29e] mb-1">Lingkar
                                Pinggang</label>
                            <input id="offline-waist" name="measurements[lingkar_pinggang]" type="number"
                                min="50" max="160" placeholder="84" required
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-hip" class="block text-xs text-[#a8a29e] mb-1">Lingkar Panggul</label>
                            <input id="offline-hip" name="measurements[lingkar_panggul]" type="number"
                                min="60" max="170" placeholder="98" required
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-rise" class="block text-xs text-[#a8a29e] mb-1">Lingkar Pesak</label>
                            <input id="offline-rise" name="measurements[lingkar_pesak]" type="number"
                                min="40" max="90" placeholder="68" required
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-thigh" class="block text-xs text-[#a8a29e] mb-1">Lingkar Paha</label>
                            <input id="offline-thigh" name="measurements[lingkar_paha]" type="number"
                                min="30" max="90" placeholder="58" required
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-knee" class="block text-xs text-[#a8a29e] mb-1">Lingkar Lutut</label>
                            <input id="offline-knee" name="measurements[lingkar_lutut]" type="number"
                                min="25" max="70" placeholder="42" required
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-pants-opening" class="block text-xs text-[#a8a29e] mb-1">Lingkar
                                Celana Bawah</label>
                            <input id="offline-pants-opening" name="measurements[lingkar_celana_bawah]"
                                type="number" min="20" max="60" placeholder="36" required
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div class="col-span-2">
                            <label for="offline-pants-length" class="block text-xs text-[#a8a29e] mb-1">Panjang
                                Celana</label>
                            <input id="offline-pants-length" name="measurements[panjang_celana]" type="number"
                                min="60" max="140" placeholder="98" required
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                    </div>
                    <div id="offline-measurements-baju"
                        class="offline-measurement-pane hidden grid grid-cols-2 gap-3">
                        <div>
                            <label for="offline-back-width" class="block text-xs text-[#a8a29e] mb-1">Lebar
                                Punggung</label>
                            <input id="offline-back-width" name="measurements[lebar_punggung]" type="number"
                                placeholder="44" disabled
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-shoulder-width" class="block text-xs text-[#a8a29e] mb-1">Lebar
                                Bahu</label>
                            <input id="offline-shoulder-width" name="measurements[lebar_bahu]" type="number"
                                placeholder="46" disabled
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-sleeve-length" class="block text-xs text-[#a8a29e] mb-1">Panjang
                                Lengan</label>
                            <input id="offline-sleeve-length" name="measurements[panjang_lengan]" type="number"
                                placeholder="61" disabled
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-sleeve-upper" class="block text-xs text-[#a8a29e] mb-1">Lingkar Lengan Atas</label>
                            <input id="offline-sleeve-upper" name="measurements[lingkar_lengan_atas]" type="number" min="15" max="70" placeholder="36" disabled
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-chest" class="block text-xs text-[#a8a29e] mb-1">Lingkar Dada</label>
                            <input id="offline-chest" name="measurements[lingkar_dada]" type="number"
                                placeholder="102" disabled
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-sleeve-lower" class="block text-xs text-[#a8a29e] mb-1">Lingkar Lengan Bawah</label>
                            <input id="offline-sleeve-lower" name="measurements[lingkar_lengan_bawah]" type="number" min="10" max="40" placeholder="24" disabled
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-baju-waist" class="block text-xs text-[#a8a29e] mb-1">Lingkar Pinggang Baju</label>
                            <input id="offline-baju-waist" name="measurements[lingkar_pinggang_baju]" type="number" min="50" max="170" placeholder="90" disabled
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-baju-hip" class="block text-xs text-[#a8a29e] mb-1">Lingkar Panggul Baju</label>
                            <input id="offline-baju-hip" name="measurements[lingkar_panggul_baju]" type="number" min="60" max="180" placeholder="102" disabled
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div class="col-span-2">
                            <label for="offline-shirt-length" class="block text-xs text-[#a8a29e] mb-1">Panjang Baju /
                                Jas</label>
                            <input id="offline-shirt-length" name="measurements[panjang_baju]" type="number"
                                placeholder="74" disabled
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                    </div>
                    <div id="offline-measurements-rok" class="offline-measurement-pane hidden grid grid-cols-2 gap-3">
                        <div>
                            <label for="offline-skirt-waist" class="block text-xs text-[#a8a29e] mb-1">Lingkar
                                Pinggang</label>
                            <input id="offline-skirt-waist" name="measurements[lingkar_pinggang]" type="number"
                                placeholder="72" disabled
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-skirt-hip" class="block text-xs text-[#a8a29e] mb-1">Lingkar
                                Panggul</label>
                            <input id="offline-skirt-hip" name="measurements[lingkar_panggul]" type="number"
                                placeholder="96" disabled
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c]" />
                        </div>
                        <div class="col-span-2">
                            <label for="offline-skirt-length" class="block text-xs text-[#a8a29e] mb-1">Panjang
                                Rok</label>
                            <input id="offline-skirt-length" name="measurements[panjang_rok]" type="number"
                                placeholder="92" disabled
                                class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c]" />
                        </div>
                    </div>
                    <div id="offline-measurements-seragam"
                        class="offline-measurement-pane hidden grid grid-cols-2 gap-3">
                        <div><label for="seragam-pinggang-celana" class="block text-xs text-[#a8a29e] mb-1">Lingkar Pinggang Celana</label><input id="seragam-pinggang-celana" name="measurements[lingkar_pinggang_celana]" type="number" min="50" max="160" placeholder="84" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-panggul-celana" class="block text-xs text-[#a8a29e] mb-1">Lingkar Panggul Celana</label><input id="seragam-panggul-celana" name="measurements[lingkar_panggul_celana]" type="number" min="60" max="170" placeholder="98" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-pesak" class="block text-xs text-[#a8a29e] mb-1">Lingkar Pesak</label><input id="seragam-pesak" name="measurements[lingkar_pesak]" type="number" min="40" max="90" placeholder="68" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-paha" class="block text-xs text-[#a8a29e] mb-1">Lingkar Paha</label><input id="seragam-paha" name="measurements[lingkar_paha]" type="number" min="30" max="90" placeholder="58" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-lutut" class="block text-xs text-[#a8a29e] mb-1">Lingkar Lutut</label><input id="seragam-lutut" name="measurements[lingkar_lutut]" type="number" min="25" max="70" placeholder="42" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-celana-bawah" class="block text-xs text-[#a8a29e] mb-1">Lingkar Celana Bawah</label><input id="seragam-celana-bawah" name="measurements[lingkar_celana_bawah]" type="number" min="20" max="60" placeholder="36" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-panjang-celana" class="block text-xs text-[#a8a29e] mb-1">Panjang Celana</label><input id="seragam-panjang-celana" name="measurements[panjang_celana]" type="number" min="60" max="140" placeholder="98" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-lebar-punggung" class="block text-xs text-[#a8a29e] mb-1">Lebar Punggung</label><input id="seragam-lebar-punggung" name="measurements[lebar_punggung]" type="number" min="20" max="80" placeholder="44" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-lebar-bahu" class="block text-xs text-[#a8a29e] mb-1">Lebar Bahu</label><input id="seragam-lebar-bahu" name="measurements[lebar_bahu]" type="number" min="25" max="80" placeholder="46" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-panjang-lengan" class="block text-xs text-[#a8a29e] mb-1">Panjang Lengan</label><input id="seragam-panjang-lengan" name="measurements[panjang_lengan]" type="number" min="30" max="100" placeholder="61" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-lengan-atas" class="block text-xs text-[#a8a29e] mb-1">Lingkar Lengan Atas</label><input id="seragam-lengan-atas" name="measurements[lingkar_lengan_atas]" type="number" min="15" max="70" placeholder="36" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-lengan-bawah" class="block text-xs text-[#a8a29e] mb-1">Lingkar Lengan Bawah</label><input id="seragam-lengan-bawah" name="measurements[lingkar_lengan_bawah]" type="number" min="10" max="40" placeholder="24" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-dada" class="block text-xs text-[#a8a29e] mb-1">Lingkar Dada</label><input id="seragam-dada" name="measurements[lingkar_dada]" type="number" min="60" max="180" placeholder="104" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-pinggang-baju" class="block text-xs text-[#a8a29e] mb-1">Lingkar Pinggang Baju</label><input id="seragam-pinggang-baju" name="measurements[lingkar_pinggang_baju]" type="number" min="50" max="170" placeholder="90" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div><label for="seragam-panggul-baju" class="block text-xs text-[#a8a29e] mb-1">Lingkar Panggul Baju</label><input id="seragam-panggul-baju" name="measurements[lingkar_panggul_baju]" type="number" min="60" max="180" placeholder="102" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                        <div class="col-span-2"><label for="seragam-panjang-baju" class="block text-xs text-[#a8a29e] mb-1">Panjang Baju</label><input id="seragam-panjang-baju" name="measurements[panjang_baju]" type="number" min="40" max="180" placeholder="74" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white"></div>
                    </div>
                </div>
                <div>
                    <label for="offline-deadline"
                        class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Deadline</label>
                    <input id="offline-deadline" name="deadline" type="date" required
                        class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]" />
                </div>
                <div>
                    <label for="offline-notes"
                        class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Catatan
                        Tambahan</label>
                    <textarea id="offline-notes" name="notes" rows="2" placeholder="Catatan khusus..."
                        class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white placeholder-[#78716c] focus:border-[#c59b27] resize-none"></textarea>
                </div>
                <p id="offline-form-feedback"
                    class="hidden rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-3 py-2 text-xs text-emerald-300"
                    role="status" aria-live="polite"></p>
                <button type="submit"
                    class="w-full py-2.5 bg-[#c59b27] text-[#181615] font-bold rounded-lg hover:bg-[#d8ac34] transition-colors text-sm active:scale-[0.98]">Simpan
                    Pesanan Offline</button>
            </form>
        </div>
    </div>


    {{-- === PRINT INVOICE MODAL (PB-13 & PB-18) === --}}
    <div id="modal-print"
        class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/70 backdrop-blur-sm" role="dialog"
        aria-modal="true">
        <div class="bg-white w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-xl">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 no-print">
                <h3 class="text-base font-bold text-gray-900">Nota Pesanan</h3>
                <div class="flex items-center gap-2">
                    <button id="btn-print-action"
                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#c59b27] text-white rounded-lg text-xs font-bold hover:bg-[#b08a22] transition-colors">
                        <span class="material-symbols-outlined text-[14px]">print</span> Cetak
                    </button>
                    <button class="modal-close p-1.5 rounded hover:bg-gray-100 text-gray-500 transition-colors"><span
                            class="material-symbols-outlined text-[20px]">close</span></button>
                </div>
            </div>
            <div id="printable-invoice" class="p-6 text-gray-900">
                <div class="text-center mb-6">
                    <h2 class="text-xl font-bold font-serif">Rahmat Tailor</h2>
                    <p class="text-xs text-gray-500">Bespoke Atelier — Jl. Anila 2 No.9A/47, Malang</p>
                    <p class="text-xs text-gray-500">WhatsApp: +62 812-8899-0211</p>
                </div>
                <hr class="border-gray-300 mb-4" />
                <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                    <div>
                        <p class="text-xs text-gray-500">No. Nota</p>
                        <p class="font-bold font-mono" id="invoice-code">—</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Tanggal</p>
                        <p class="font-semibold" id="invoice-date">—</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Pelanggan</p>
                        <p class="font-semibold" id="invoice-customer">—</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Layanan</p>
                        <p class="font-semibold" id="invoice-service">—</p>
                    </div>
                </div>
                <hr class="border-gray-300 mb-4" />
                <table class="w-full text-sm mb-4">
                    <thead>
                        <tr class="border-b border-gray-300 text-xs text-gray-500">
                            <th class="py-2 text-left">Deskripsi</th>
                            <th class="py-2 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody id="invoice-items">
                        <tr>
                            <td class="py-1.5">Total Biaya Jahit</td>
                            <td class="py-1.5 text-right font-semibold" id="invoice-total">-</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gray-900 font-bold">
                            <td class="py-2">Sisa Pembayaran</td>
                            <td class="py-2 text-right" id="invoice-balance">-</td>
                        </tr>
                    </tfoot>
                </table>
                <p class="text-xs text-gray-400 text-center mt-6">Terima kasih telah mempercayakan busana Anda kepada
                    Rahmat Tailor.</p>
            </div>
        </div>
    </div>

</body>

</html>
