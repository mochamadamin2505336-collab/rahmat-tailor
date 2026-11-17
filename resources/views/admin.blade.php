<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Panel Admin — Rahmat Tailor Bespoke Atelier</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <!-- Tailwind CDN + Vite CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="h-full bg-[#181615] text-[#f5f3ef] font-sans antialiased overflow-x-hidden selection:bg-[#c59b27]/30 selection:text-[#fbf9f5]">

    {{-- ================================================================
         LAYOUT: Sidebar + Main Content
         ================================================================ --}}
    <div class="flex h-full">

        {{-- ============================================================
             SIDEBAR (Desktop fixed / Mobile drawer)
             ============================================================ --}}
        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-[#1a1816] border-r border-[#2d2825] flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0">
            {{-- Brand --}}
            <div class="h-16 flex items-center gap-3 px-5 border-b border-[#2d2825] shrink-0">
                <span class="font-serif text-lg text-white tracking-wide">Rahmat Tailor<span class="text-[#c59b27] text-xl">.</span></span>
                <span class="ml-auto text-[10px] uppercase tracking-widest text-[#78716c] font-semibold px-2 py-0.5 rounded bg-[#282422] border border-[#3b3531]">Admin</span>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1" id="sidebar-nav">
                <button data-tab="dashboard" class="admin-sidebar-btn active w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">dashboard</span>
                    Dashboard
                </button>
                <button data-tab="pesanan" class="admin-sidebar-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                    Pesanan Jahit
                    <span class="ml-auto text-[11px] bg-[#c59b27]/20 text-[#c59b27] px-2 py-0.5 rounded-full font-bold" id="order-count-badge">12</span>
                </button>
                <button data-tab="jadwal" class="admin-sidebar-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                    Jadwal Ukur
                </button>
                <button data-tab="ukuran" class="admin-sidebar-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">straighten</span>
                    Riwayat Ukuran
                </button>

                <div class="pt-3 pb-1 px-3">
                    <span class="text-[10px] uppercase tracking-widest text-[#78716c] font-semibold">Konten</span>
                </div>
                <button data-tab="layanan" class="admin-sidebar-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">design_services</span>
                    Layanan & Galeri
                </button>
                <button data-tab="testimoni" class="admin-sidebar-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">reviews</span>
                    Testimoni
                </button>

                <div class="pt-3 pb-1 px-3">
                    <span class="text-[10px] uppercase tracking-widest text-[#78716c] font-semibold">Keuangan</span>
                </div>
                <button data-tab="laporan" class="admin-sidebar-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[20px]">monitoring</span>
                    Laporan Keuangan
                </button>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="p-4 border-t border-[#2d2825] shrink-0">
                <a href="{{ route('beranda') }}" class="flex items-center gap-2 text-sm text-[#a8a29e] hover:text-[#c59b27] transition-colors">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali ke Website
                </a>
            </div>
        </aside>

        {{-- Sidebar overlay for mobile --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-30 bg-black/60 backdrop-blur-sm hidden lg:hidden" aria-hidden="true"></div>

        {{-- ============================================================
             MAIN CONTENT AREA
             ============================================================ --}}
        <div class="flex-1 min-w-0 flex flex-col lg:ml-64 min-h-screen">

            {{-- Top Header Bar --}}
            <header class="sticky top-0 z-20 h-16 bg-[#1a1816]/95 backdrop-blur-lg border-b border-[#2d2825] flex items-center justify-between px-4 lg:px-6 shrink-0">
                {{-- Mobile hamburger --}}
                <button id="sidebar-toggle" class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg text-[#a8a29e] hover:text-white hover:bg-[#282422] transition-colors" aria-label="Buka menu">
                    <span class="material-symbols-outlined text-[24px]">menu</span>
                </button>

                <h2 class="text-sm font-semibold text-[#a8a29e] uppercase tracking-wider hidden lg:block" id="page-title">Dashboard</h2>

                <div class="flex items-center gap-3">
                    {{-- Quick Action: + Pesanan Offline (PB-18) --}}
                    <button id="btn-new-offline" class="inline-flex items-center gap-2 px-4 py-2 bg-[#c59b27] text-[#181615] text-sm font-bold rounded-lg hover:bg-[#d8ac34] transition-all active:scale-95 shadow-lg shadow-[#c59b27]/20">
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
                                <span class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Total Pesanan</span>
                                <span class="material-symbols-outlined text-[20px] text-[#c59b27]">receipt_long</span>
                            </div>
                            <p class="text-2xl font-bold text-white">48</p>
                            <p class="text-xs text-emerald-400 mt-1">+5 minggu ini</p>
                        </div>
                        <div class="admin-card p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Proses Aktif</span>
                                <span class="material-symbols-outlined text-[20px] text-sky-400">manufacturing</span>
                            </div>
                            <p class="text-2xl font-bold text-white">12</p>
                            <p class="text-xs text-[#a8a29e] mt-1">3 menunggu verifikasi</p>
                        </div>
                        <div class="admin-card p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Siap Diambil</span>
                                <span class="material-symbols-outlined text-[20px] text-amber-400">check_circle</span>
                            </div>
                            <p class="text-2xl font-bold text-white">4</p>
                            <p class="text-xs text-amber-400 mt-1">Perlu dihubungi</p>
                        </div>
                        <div class="admin-card p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Pendapatan Bulan</span>
                                <span class="material-symbols-outlined text-[20px] text-emerald-400">payments</span>
                            </div>
                            <p class="text-2xl font-bold text-white">Rp 18,5jt</p>
                            <p class="text-xs text-emerald-400 mt-1">+12% dari bulan lalu</p>
                        </div>
                    </div>

                    {{-- Urgent Deadline Alert (PB-07) --}}
                    <div class="admin-card border-amber-500/40 p-4 mb-6 urgent-pulse">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-amber-400 text-[22px] mt-0.5">warning</span>
                            <div>
                                <h3 class="text-sm font-bold text-amber-300">Deadline Mendekat (< 3 Hari)</h3>
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-[#f5f3ef]"><span class="font-mono text-amber-400">RT-2411A3</span> — Jas 2 Piece Bp. Hendra</span>
                                        <span class="text-amber-400 font-semibold text-xs">Besok</span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-[#f5f3ef]"><span class="font-mono text-amber-400">RT-2411B1</span> — Kebaya Ibu Sari</span>
                                        <span class="text-amber-400 font-semibold text-xs">2 hari lagi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Recent Orders Quick Table --}}
                    <div class="admin-card overflow-hidden">
                        <div class="px-5 py-4 border-b border-[#2d2825] flex items-center justify-between">
                            <h3 class="text-sm font-bold text-white">Pesanan Terbaru</h3>
                            <button data-tab="pesanan" class="admin-sidebar-btn text-xs text-[#c59b27] hover:underline font-semibold">Lihat Semua →</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-[#2d2825] text-[#78716c] text-xs uppercase tracking-wider">
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
                                    <tr class="border-b border-[#2d2825] hover:bg-[#221f1d] transition-colors">
                                        <td class="px-5 py-3 font-mono text-[#c59b27] font-semibold">RT-2411A3</td>
                                        <td class="px-5 py-3">Bp. Hendra Wijaya</td>
                                        <td class="px-5 py-3 text-[#a8a29e]">Jas 2 Piece</td>
                                        <td class="px-5 py-3"><span class="status-badge status-badge-dijahit">● Dijahit</span></td>
                                        <td class="px-5 py-3 text-amber-400 font-semibold">16 Nov 2026</td>
                                        <td class="px-5 py-3"><span class="status-badge badge-online">Online</span></td>
                                        <td class="px-5 py-3 text-center">
                                            <button class="btn-detail inline-flex items-center gap-1 text-[#c59b27] hover:text-[#d8ac34] text-xs font-semibold" data-order="RT-2411A3">
                                                <span class="material-symbols-outlined text-[16px]">visibility</span> Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-[#2d2825] hover:bg-[#221f1d] transition-colors">
                                        <td class="px-5 py-3 font-mono text-[#c59b27] font-semibold">RT-2411B1</td>
                                        <td class="px-5 py-3">Ibu Sari Dewi</td>
                                        <td class="px-5 py-3 text-[#a8a29e]">Kebaya Modern</td>
                                        <td class="px-5 py-3"><span class="status-badge status-badge-fitting">● Fitting</span></td>
                                        <td class="px-5 py-3 text-amber-400 font-semibold">17 Nov 2026</td>
                                        <td class="px-5 py-3"><span class="status-badge badge-offline">Offline</span></td>
                                        <td class="px-5 py-3 text-center">
                                            <button class="btn-detail inline-flex items-center gap-1 text-[#c59b27] hover:text-[#d8ac34] text-xs font-semibold" data-order="RT-2411B1">
                                                <span class="material-symbols-outlined text-[16px]">visibility</span> Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-[#2d2825] hover:bg-[#221f1d] transition-colors">
                                        <td class="px-5 py-3 font-mono text-[#c59b27] font-semibold">RT-2411C5</td>
                                        <td class="px-5 py-3">Bp. Ahmad Fauzi</td>
                                        <td class="px-5 py-3 text-[#a8a29e]">Batik Tulis Shirt</td>
                                        <td class="px-5 py-3"><span class="status-badge status-badge-verifikasi">● Verifikasi</span></td>
                                        <td class="px-5 py-3 text-[#a8a29e]">25 Nov 2026</td>
                                        <td class="px-5 py-3"><span class="status-badge badge-online">Online</span></td>
                                        <td class="px-5 py-3 text-center">
                                            <button class="btn-detail inline-flex items-center gap-1 text-[#c59b27] hover:text-[#d8ac34] text-xs font-semibold" data-order="RT-2411C5">
                                                <span class="material-symbols-outlined text-[16px]">visibility</span> Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-[#221f1d] transition-colors">
                                        <td class="px-5 py-3 font-mono text-[#c59b27] font-semibold">RT-2411D2</td>
                                        <td class="px-5 py-3">Ibu Rina Marlina</td>
                                        <td class="px-5 py-3 text-[#a8a29e]">Gamis Premium</td>
                                        <td class="px-5 py-3"><span class="status-badge status-badge-diterima">● Diterima</span></td>
                                        <td class="px-5 py-3 text-[#a8a29e]">30 Nov 2026</td>
                                        <td class="px-5 py-3"><span class="status-badge badge-online">Online</span></td>
                                        <td class="px-5 py-3 text-center">
                                            <button class="btn-detail inline-flex items-center gap-1 text-[#c59b27] hover:text-[#d8ac34] text-xs font-semibold" data-order="RT-2411D2">
                                                <span class="material-symbols-outlined text-[16px]">visibility</span> Detail
                                            </button>
                                        </td>
                                    </tr>
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
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-[#78716c]">search</span>
                            <input id="order-search" type="text" placeholder="Cari kode pesanan, nama pelanggan..." class="w-full pl-10 pr-4 py-2.5 bg-[#221f1d] border border-[#3b3531] rounded-lg text-sm text-white placeholder-[#78716c] focus:border-[#c59b27] focus:ring-1 focus:ring-[#c59b27] transition-colors" />
                        </div>
                        <select id="filter-status" class="px-4 py-2.5 bg-[#221f1d] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]">
                            <option value="">Semua Status</option>
                            <option value="verifikasi">Verifikasi</option>
                            <option value="diterima">Diterima</option>
                            <option value="dipotong">Dipotong</option>
                            <option value="dijahit">Dijahit</option>
                            <option value="fitting">Fitting</option>
                            <option value="selesai">Selesai</option>
                            <option value="siap-diambil">Siap Diambil</option>
                        </select>
                        <select id="filter-source" class="px-4 py-2.5 bg-[#221f1d] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]">
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
                                    <tr class="border-b border-[#2d2825] text-[#78716c] text-xs uppercase tracking-wider">
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
                                    {{-- Row 1 --}}
                                    <tr class="order-row border-b border-[#2d2825] hover:bg-[#221f1d] transition-colors" data-status="dijahit" data-source="online" data-name="Hendra Wijaya" data-code="RT-2411A3">
                                        <td class="px-5 py-3 font-mono text-[#c59b27] font-semibold">RT-2411A3</td>
                                        <td class="px-5 py-3">Bp. Hendra Wijaya</td>
                                        <td class="px-5 py-3">
                                            <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-emerald-400 hover:text-emerald-300 text-xs">
                                                <span class="material-symbols-outlined text-[14px]">chat</span> 0812...
                                            </a>
                                        </td>
                                        <td class="px-5 py-3 text-[#a8a29e]">Jas 2 Piece</td>
                                        <td class="px-5 py-3"><span class="status-badge status-badge-dijahit">● Dijahit</span></td>
                                        <td class="px-5 py-3 text-amber-400 font-semibold">16 Nov</td>
                                        <td class="px-5 py-3"><span class="status-badge badge-online">Online</span></td>
                                        <td class="px-5 py-3"><span class="text-emerald-400 text-xs font-semibold">DP 50%</span></td>
                                        <td class="px-5 py-3">
                                            <div class="flex items-center justify-center gap-1">
                                                <button class="btn-detail p-1.5 rounded hover:bg-[#282422] text-[#c59b27] transition-colors" title="Detail" data-order="RT-2411A3"><span class="material-symbols-outlined text-[18px]">visibility</span></button>
                                                <button class="btn-advance-status p-1.5 rounded hover:bg-[#282422] text-sky-400 transition-colors" title="Naikkan Status" data-order="RT-2411A3" data-current="dijahit"><span class="material-symbols-outlined text-[18px]">skip_next</span></button>
                                                <button class="btn-payment p-1.5 rounded hover:bg-[#282422] text-emerald-400 transition-colors" title="Catat Pembayaran" data-order="RT-2411A3"><span class="material-symbols-outlined text-[18px]">payments</span></button>
                                                <button class="btn-print p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] transition-colors" title="Cetak Nota" data-order="RT-2411A3"><span class="material-symbols-outlined text-[18px]">print</span></button>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Row 2 --}}
                                    <tr class="order-row border-b border-[#2d2825] hover:bg-[#221f1d] transition-colors" data-status="fitting" data-source="offline" data-name="Sari Dewi" data-code="RT-2411B1">
                                        <td class="px-5 py-3 font-mono text-[#c59b27] font-semibold">RT-2411B1</td>
                                        <td class="px-5 py-3">Ibu Sari Dewi</td>
                                        <td class="px-5 py-3">
                                            <a href="https://wa.me/6289876543210" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-emerald-400 hover:text-emerald-300 text-xs">
                                                <span class="material-symbols-outlined text-[14px]">chat</span> 0898...
                                            </a>
                                        </td>
                                        <td class="px-5 py-3 text-[#a8a29e]">Kebaya Modern</td>
                                        <td class="px-5 py-3"><span class="status-badge status-badge-fitting">● Fitting</span></td>
                                        <td class="px-5 py-3 text-amber-400 font-semibold">17 Nov</td>
                                        <td class="px-5 py-3"><span class="status-badge badge-offline">Offline</span></td>
                                        <td class="px-5 py-3"><span class="text-emerald-400 text-xs font-semibold">DP 50%</span></td>
                                        <td class="px-5 py-3">
                                            <div class="flex items-center justify-center gap-1">
                                                <button class="btn-detail p-1.5 rounded hover:bg-[#282422] text-[#c59b27] transition-colors" title="Detail" data-order="RT-2411B1"><span class="material-symbols-outlined text-[18px]">visibility</span></button>
                                                <button class="btn-advance-status p-1.5 rounded hover:bg-[#282422] text-sky-400 transition-colors" title="Naikkan Status" data-order="RT-2411B1" data-current="fitting"><span class="material-symbols-outlined text-[18px]">skip_next</span></button>
                                                <button class="btn-payment p-1.5 rounded hover:bg-[#282422] text-emerald-400 transition-colors" title="Catat Pembayaran" data-order="RT-2411B1"><span class="material-symbols-outlined text-[18px]">payments</span></button>
                                                <button class="btn-print p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] transition-colors" title="Cetak Nota" data-order="RT-2411B1"><span class="material-symbols-outlined text-[18px]">print</span></button>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Row 3 --}}
                                    <tr class="order-row border-b border-[#2d2825] hover:bg-[#221f1d] transition-colors" data-status="verifikasi" data-source="online" data-name="Ahmad Fauzi" data-code="RT-2411C5">
                                        <td class="px-5 py-3 font-mono text-[#c59b27] font-semibold">RT-2411C5</td>
                                        <td class="px-5 py-3">Bp. Ahmad Fauzi</td>
                                        <td class="px-5 py-3">
                                            <a href="https://wa.me/6281555666777" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-emerald-400 hover:text-emerald-300 text-xs">
                                                <span class="material-symbols-outlined text-[14px]">chat</span> 0815...
                                            </a>
                                        </td>
                                        <td class="px-5 py-3 text-[#a8a29e]">Batik Tulis Shirt</td>
                                        <td class="px-5 py-3"><span class="status-badge status-badge-verifikasi">● Verifikasi</span></td>
                                        <td class="px-5 py-3 text-[#a8a29e]">25 Nov</td>
                                        <td class="px-5 py-3"><span class="status-badge badge-online">Online</span></td>
                                        <td class="px-5 py-3"><span class="text-amber-400 text-xs font-semibold">Belum DP</span></td>
                                        <td class="px-5 py-3">
                                            <div class="flex items-center justify-center gap-1">
                                                <button class="btn-detail p-1.5 rounded hover:bg-[#282422] text-[#c59b27] transition-colors" title="Detail" data-order="RT-2411C5"><span class="material-symbols-outlined text-[18px]">visibility</span></button>
                                                <button class="btn-advance-status p-1.5 rounded hover:bg-[#282422] text-sky-400 transition-colors" title="Naikkan Status" data-order="RT-2411C5" data-current="verifikasi"><span class="material-symbols-outlined text-[18px]">skip_next</span></button>
                                                <button class="btn-payment p-1.5 rounded hover:bg-[#282422] text-emerald-400 transition-colors" title="Catat Pembayaran" data-order="RT-2411C5"><span class="material-symbols-outlined text-[18px]">payments</span></button>
                                                <button class="btn-print p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] transition-colors" title="Cetak Nota" data-order="RT-2411C5"><span class="material-symbols-outlined text-[18px]">print</span></button>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Row 4 --}}
                                    <tr class="order-row border-b border-[#2d2825] hover:bg-[#221f1d] transition-colors" data-status="diterima" data-source="online" data-name="Rina Marlina" data-code="RT-2411D2">
                                        <td class="px-5 py-3 font-mono text-[#c59b27] font-semibold">RT-2411D2</td>
                                        <td class="px-5 py-3">Ibu Rina Marlina</td>
                                        <td class="px-5 py-3">
                                            <a href="https://wa.me/6287811223344" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-emerald-400 hover:text-emerald-300 text-xs">
                                                <span class="material-symbols-outlined text-[14px]">chat</span> 0878...
                                            </a>
                                        </td>
                                        <td class="px-5 py-3 text-[#a8a29e]">Gamis Premium</td>
                                        <td class="px-5 py-3"><span class="status-badge status-badge-diterima">● Diterima</span></td>
                                        <td class="px-5 py-3 text-[#a8a29e]">30 Nov</td>
                                        <td class="px-5 py-3"><span class="status-badge badge-online">Online</span></td>
                                        <td class="px-5 py-3"><span class="text-emerald-400 text-xs font-semibold">DP 50%</span></td>
                                        <td class="px-5 py-3">
                                            <div class="flex items-center justify-center gap-1">
                                                <button class="btn-detail p-1.5 rounded hover:bg-[#282422] text-[#c59b27] transition-colors" title="Detail" data-order="RT-2411D2"><span class="material-symbols-outlined text-[18px]">visibility</span></button>
                                                <button class="btn-advance-status p-1.5 rounded hover:bg-[#282422] text-sky-400 transition-colors" title="Naikkan Status" data-order="RT-2411D2" data-current="diterima"><span class="material-symbols-outlined text-[18px]">skip_next</span></button>
                                                <button class="btn-payment p-1.5 rounded hover:bg-[#282422] text-emerald-400 transition-colors" title="Catat Pembayaran" data-order="RT-2411D2"><span class="material-symbols-outlined text-[18px]">payments</span></button>
                                                <button class="btn-print p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] transition-colors" title="Cetak Nota" data-order="RT-2411D2"><span class="material-symbols-outlined text-[18px]">print</span></button>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Row 5 --}}
                                    <tr class="order-row hover:bg-[#221f1d] transition-colors" data-status="siap-diambil" data-source="offline" data-name="Budi Santoso" data-code="RT-2410E8">
                                        <td class="px-5 py-3 font-mono text-[#c59b27] font-semibold">RT-2410E8</td>
                                        <td class="px-5 py-3">Bp. Budi Santoso</td>
                                        <td class="px-5 py-3">
                                            <a href="https://wa.me/6281999888777" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-emerald-400 hover:text-emerald-300 text-xs">
                                                <span class="material-symbols-outlined text-[14px]">chat</span> 0819...
                                            </a>
                                        </td>
                                        <td class="px-5 py-3 text-[#a8a29e]">Safari Suit</td>
                                        <td class="px-5 py-3"><span class="status-badge status-badge-siap-diambil">● Siap Diambil</span></td>
                                        <td class="px-5 py-3 text-[#a8a29e]">10 Nov</td>
                                        <td class="px-5 py-3"><span class="status-badge badge-offline">Offline</span></td>
                                        <td class="px-5 py-3"><span class="text-emerald-400 text-xs font-semibold">Lunas</span></td>
                                        <td class="px-5 py-3">
                                            <div class="flex items-center justify-center gap-1">
                                                <button class="btn-detail p-1.5 rounded hover:bg-[#282422] text-[#c59b27] transition-colors" title="Detail" data-order="RT-2410E8"><span class="material-symbols-outlined text-[18px]">visibility</span></button>
                                                <button class="btn-print p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] transition-colors" title="Cetak Nota" data-order="RT-2410E8"><span class="material-symbols-outlined text-[18px]">print</span></button>
                                            </div>
                                        </td>
                                    </tr>
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
                        <div class="divide-y divide-[#2d2825]">
                            <div class="flex items-center justify-between p-5 hover:bg-[#221f1d] transition-colors">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-[#c59b27]/10 flex flex-col items-center justify-center text-[#c59b27] shrink-0">
                                        <span class="text-sm font-bold leading-none">16</span>
                                        <span class="text-[10px] uppercase">Nov</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Bp. Hendra Wijaya — Fitting Jas 2 Piece</p>
                                        <p class="text-xs text-[#a8a29e] mt-0.5">10:00 WIB · Pengukuran + Fitting pertama</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="https://wa.me/6281234567890?text=Halo%20Pak%20Hendra,%20mengingatkan%20jadwal%20fitting%20besok%20pukul%2010:00%20WIB%20di%20Atelier%20Rahmat%20Tailor." target="_blank" rel="noopener" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500/10 text-emerald-400 rounded-lg text-xs font-semibold hover:bg-emerald-500/20 transition-colors">
                                        <span class="material-symbols-outlined text-[14px]">chat</span> Kirim Pengingat
                                    </a>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-5 hover:bg-[#221f1d] transition-colors">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-[#c59b27]/10 flex flex-col items-center justify-center text-[#c59b27] shrink-0">
                                        <span class="text-sm font-bold leading-none">18</span>
                                        <span class="text-[10px] uppercase">Nov</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Ibu Rina Marlina — Pengukuran Gamis Premium</p>
                                        <p class="text-xs text-[#a8a29e] mt-0.5">14:00 WIB · Pengukuran pertama kali</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="https://wa.me/6287811223344?text=Halo%20Ibu%20Rina,%20mengingatkan%20jadwal%20pengukuran%20Senin%2018%20Nov%20pukul%2014:00%20WIB." target="_blank" rel="noopener" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500/10 text-emerald-400 rounded-lg text-xs font-semibold hover:bg-emerald-500/20 transition-colors">
                                        <span class="material-symbols-outlined text-[14px]">chat</span> Kirim Pengingat
                                    </a>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-5 hover:bg-[#221f1d] transition-colors">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-[#c59b27]/10 flex flex-col items-center justify-center text-[#c59b27] shrink-0">
                                        <span class="text-sm font-bold leading-none">20</span>
                                        <span class="text-[10px] uppercase">Nov</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Bp. Ahmad Fauzi — Pengukuran Batik Tulis Shirt</p>
                                        <p class="text-xs text-[#a8a29e] mt-0.5">09:30 WIB · Pengukuran + konsultasi bahan</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="https://wa.me/6281555666777?text=Halo%20Pak%20Ahmad,%20mengingatkan%20jadwal%20pengukuran%20Rabu%2020%20Nov%20pukul%2009:30%20WIB." target="_blank" rel="noopener" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500/10 text-emerald-400 rounded-lg text-xs font-semibold hover:bg-emerald-500/20 transition-colors">
                                        <span class="material-symbols-outlined text-[14px]">chat</span> Kirim Pengingat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                {{-- ======================== RIWAYAT UKURAN (PB-14) ======================== --}}
                <section id="tab-ukuran" class="tab-panel hidden">
                    <div class="admin-card overflow-hidden">
                        <div class="px-5 py-4 border-b border-[#2d2825] flex items-center justify-between">
                            <h3 class="text-sm font-bold text-white">Profil Ukuran Pelanggan</h3>
                            <div class="relative w-64">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[16px] text-[#78716c]">search</span>
                                <input type="text" placeholder="Cari pelanggan..." class="w-full pl-9 pr-4 py-2 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                            </div>
                        </div>
                        <div class="divide-y divide-[#2d2825]">
                            {{-- Customer 1 --}}
                            <div class="p-5 hover:bg-[#221f1d] transition-colors">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <p class="text-sm font-semibold text-white">Bp. Hendra Wijaya</p>
                                        <p class="text-xs text-[#a8a29e]">Terakhir diukur: 5 Nov 2026</p>
                                    </div>
                                    <button class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#c59b27]/10 text-[#c59b27] rounded-lg text-xs font-semibold hover:bg-[#c59b27]/20 transition-colors">
                                        <span class="material-symbols-outlined text-[14px]">content_copy</span> Gunakan untuk Pesanan Baru
                                    </button>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-3">
                                    <div class="bg-[#181615] rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-[#78716c] uppercase tracking-wider">Lingkar Dada</p>
                                        <p class="text-sm font-bold text-white mt-0.5">102 cm</p>
                                    </div>
                                    <div class="bg-[#181615] rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-[#78716c] uppercase tracking-wider">Lingkar Pinggang</p>
                                        <p class="text-sm font-bold text-white mt-0.5">88 cm</p>
                                    </div>
                                    <div class="bg-[#181615] rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-[#78716c] uppercase tracking-wider">Panjang Baju</p>
                                        <p class="text-sm font-bold text-white mt-0.5">72 cm</p>
                                    </div>
                                    <div class="bg-[#181615] rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-[#78716c] uppercase tracking-wider">Lebar Bahu</p>
                                        <p class="text-sm font-bold text-white mt-0.5">46 cm</p>
                                    </div>
                                    <div class="bg-[#181615] rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-[#78716c] uppercase tracking-wider">Pjg Lengan</p>
                                        <p class="text-sm font-bold text-white mt-0.5">62 cm</p>
                                    </div>
                                    <div class="bg-[#181615] rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-[#78716c] uppercase tracking-wider">Lingkar Leher</p>
                                        <p class="text-sm font-bold text-white mt-0.5">40 cm</p>
                                    </div>
                                </div>
                            </div>
                            {{-- Customer 2 --}}
                            <div class="p-5 hover:bg-[#221f1d] transition-colors">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <p class="text-sm font-semibold text-white">Ibu Sari Dewi</p>
                                        <p class="text-xs text-[#a8a29e]">Terakhir diukur: 8 Nov 2026</p>
                                    </div>
                                    <button class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#c59b27]/10 text-[#c59b27] rounded-lg text-xs font-semibold hover:bg-[#c59b27]/20 transition-colors">
                                        <span class="material-symbols-outlined text-[14px]">content_copy</span> Gunakan untuk Pesanan Baru
                                    </button>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-3">
                                    <div class="bg-[#181615] rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-[#78716c] uppercase tracking-wider">Lingkar Dada</p>
                                        <p class="text-sm font-bold text-white mt-0.5">90 cm</p>
                                    </div>
                                    <div class="bg-[#181615] rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-[#78716c] uppercase tracking-wider">Lingkar Pinggang</p>
                                        <p class="text-sm font-bold text-white mt-0.5">72 cm</p>
                                    </div>
                                    <div class="bg-[#181615] rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-[#78716c] uppercase tracking-wider">Panjang Kebaya</p>
                                        <p class="text-sm font-bold text-white mt-0.5">65 cm</p>
                                    </div>
                                    <div class="bg-[#181615] rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-[#78716c] uppercase tracking-wider">Lebar Bahu</p>
                                        <p class="text-sm font-bold text-white mt-0.5">38 cm</p>
                                    </div>
                                    <div class="bg-[#181615] rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-[#78716c] uppercase tracking-wider">Lingkar Pinggul</p>
                                        <p class="text-sm font-bold text-white mt-0.5">96 cm</p>
                                    </div>
                                    <div class="bg-[#181615] rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-[#78716c] uppercase tracking-wider">Pjg Lengan</p>
                                        <p class="text-sm font-bold text-white mt-0.5">55 cm</p>
                                    </div>
                                </div>
                            </div>
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
                                <button class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#c59b27] text-[#181615] rounded-lg text-xs font-bold hover:bg-[#d8ac34] transition-colors">
                                    <span class="material-symbols-outlined text-[14px]">add</span> Tambah
                                </button>
                            </div>
                            <div class="divide-y divide-[#2d2825]">
                                @foreach (['Jas 2 Piece' => 'Rp 2.500.000', 'Jas 3 Piece' => 'Rp 3.200.000', 'Kebaya Modern' => 'Rp 1.800.000', 'Batik Tulis Shirt' => 'Rp 950.000', 'Gamis Premium' => 'Rp 1.200.000', 'Safari Suit' => 'Rp 2.000.000'] as $service => $price)
                                <div class="flex items-center justify-between p-4 hover:bg-[#221f1d] transition-colors">
                                    <div>
                                        <p class="text-sm font-semibold text-white">{{ $service }}</p>
                                        <p class="text-xs text-[#c59b27] font-semibold mt-0.5">{{ $price }}</p>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <button class="p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] hover:text-[#c59b27] transition-colors" title="Edit"><span class="material-symbols-outlined text-[18px]">edit</span></button>
                                        <button class="p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] hover:text-red-400 transition-colors" title="Hapus"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Galeri Management --}}
                        <div class="admin-card overflow-hidden">
                            <div class="px-5 py-4 border-b border-[#2d2825] flex items-center justify-between">
                                <h3 class="text-sm font-bold text-white">Galeri Portofolio</h3>
                                <button class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#c59b27] text-[#181615] rounded-lg text-xs font-bold hover:bg-[#d8ac34] transition-colors">
                                    <span class="material-symbols-outlined text-[14px]">upload</span> Upload
                                </button>
                            </div>
                            <div class="p-5 grid grid-cols-3 gap-3">
                                @for ($i = 1; $i <= 6; $i++)
                                <div class="group relative aspect-square bg-[#282422] rounded-lg overflow-hidden cursor-pointer">
                                    <div class="w-full h-full flex items-center justify-center text-[#78716c]">
                                        <span class="material-symbols-outlined text-[32px]">image</span>
                                    </div>
                                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button class="p-1.5 bg-white/20 rounded-lg hover:bg-white/30 transition-colors"><span class="material-symbols-outlined text-white text-[18px]">edit</span></button>
                                        <button class="p-1.5 bg-white/20 rounded-lg hover:bg-white/30 transition-colors"><span class="material-symbols-outlined text-white text-[18px]">delete</span></button>
                                    </div>
                                </div>
                                @endfor
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
                        <div class="divide-y divide-[#2d2825]">
                            @php
                                $testimonials = [
                                    ['name' => 'Bp. Hendra Wijaya', 'text' => 'Jasnya pas sekali di badan, jahitannya sangat rapi. Sudah 3x pesan di sini dan selalu puas.', 'rating' => 5, 'visible' => true],
                                    ['name' => 'Ibu Sari Dewi', 'text' => 'Kebaya untuk acara pernikahan anak, hasilnya indah sekali. Banyak yang memuji!', 'rating' => 5, 'visible' => true],
                                    ['name' => 'Bp. Ahmad Fauzi', 'text' => 'Pelayanan ramah, pengerjaan tepat waktu. Batik shirtnya nyaman dipakai.', 'rating' => 4, 'visible' => false],
                                ];
                            @endphp
                            @foreach ($testimonials as $t)
                            <div class="flex items-start justify-between p-5 hover:bg-[#221f1d] transition-colors">
                                <div class="flex-1 mr-4">
                                    <div class="flex items-center gap-2 mb-1">
                                        <p class="text-sm font-semibold text-white">{{ $t['name'] }}</p>
                                        <div class="flex items-center gap-0.5">
                                            @for ($s = 1; $s <= 5; $s++)
                                            <span class="material-symbols-outlined text-[14px] {{ $s <= $t['rating'] ? 'text-[#c59b27]' : 'text-[#3b3531]' }}">star</span>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-sm text-[#a8a29e] leading-relaxed">"{{ $t['text'] }}"</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer shrink-0 mt-1">
                                    <input type="checkbox" class="sr-only peer" {{ $t['visible'] ? 'checked' : '' }} />
                                    <div class="w-9 h-5 bg-[#3b3531] peer-focus:outline-none rounded-full peer peer-checked:bg-[#c59b27] transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full"></div>
                                    <span class="ml-2 text-xs text-[#a8a29e]">{{ $t['visible'] ? 'Tampil' : 'Sembunyi' }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>


                {{-- ======================== LAPORAN KEUANGAN (PB-16) ======================== --}}
                <section id="tab-laporan" class="tab-panel hidden">
                    {{-- Revenue Summary Cards --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="admin-card p-4">
                            <p class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Pendapatan Bulan Ini</p>
                            <p class="text-xl font-bold text-white mt-1">Rp 18.500.000</p>
                        </div>
                        <div class="admin-card p-4">
                            <p class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">DP Terkumpul</p>
                            <p class="text-xl font-bold text-emerald-400 mt-1">Rp 12.750.000</p>
                        </div>
                        <div class="admin-card p-4">
                            <p class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Pelunasan Diterima</p>
                            <p class="text-xl font-bold text-sky-400 mt-1">Rp 5.750.000</p>
                        </div>
                        <div class="admin-card p-4">
                            <p class="text-xs text-[#a8a29e] uppercase tracking-wider font-semibold">Piutang</p>
                            <p class="text-xl font-bold text-amber-400 mt-1">Rp 8.200.000</p>
                        </div>
                    </div>

                    {{-- Category Breakdown --}}
                    <div class="admin-card overflow-hidden">
                        <div class="px-5 py-4 border-b border-[#2d2825]">
                            <h3 class="text-sm font-bold text-white">Pendapatan per Kategori — November 2026</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-[#2d2825] text-[#78716c] text-xs uppercase tracking-wider">
                                        <th class="px-5 py-3 text-left font-semibold">Kategori</th>
                                        <th class="px-5 py-3 text-left font-semibold">Jumlah Pesanan</th>
                                        <th class="px-5 py-3 text-left font-semibold">Pendapatan</th>
                                        <th class="px-5 py-3 text-left font-semibold">Proporsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $categories = [
                                            ['cat' => 'Jas (2 & 3 Piece)', 'orders' => 8, 'revenue' => 'Rp 22.400.000', 'pct' => '42%'],
                                            ['cat' => 'Kebaya & Gaun', 'orders' => 5, 'revenue' => 'Rp 9.000.000', 'pct' => '17%'],
                                            ['cat' => 'Batik & Kemeja', 'orders' => 12, 'revenue' => 'Rp 11.400.000', 'pct' => '21%'],
                                            ['cat' => 'Gamis & Busana Muslim', 'orders' => 6, 'revenue' => 'Rp 7.200.000', 'pct' => '13%'],
                                            ['cat' => 'Safari & Lainnya', 'orders' => 4, 'revenue' => 'Rp 3.500.000', 'pct' => '7%'],
                                        ];
                                    @endphp
                                    @foreach ($categories as $c)
                                    <tr class="border-b border-[#2d2825] hover:bg-[#221f1d] transition-colors">
                                        <td class="px-5 py-3 font-semibold text-white">{{ $c['cat'] }}</td>
                                        <td class="px-5 py-3 text-[#a8a29e]">{{ $c['orders'] }}</td>
                                        <td class="px-5 py-3 text-[#c59b27] font-semibold">{{ $c['revenue'] }}</td>
                                        <td class="px-5 py-3">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 h-1.5 bg-[#282422] rounded-full overflow-hidden">
                                                    <div class="h-full bg-[#c59b27] rounded-full" style="width: {{ $c['pct'] }}"></div>
                                                </div>
                                                <span class="text-xs text-[#a8a29e] w-8 text-right">{{ $c['pct'] }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
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

    {{-- === ORDER DETAIL MODAL (PB-20) === --}}
    <div id="modal-detail" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/70 backdrop-blur-sm" role="dialog" aria-modal="true">
        <div class="admin-card w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#2d2825]">
                <h3 class="text-base font-bold text-white">Detail Pesanan <span id="detail-code" class="text-[#c59b27]">RT-XXXXXXXX</span></h3>
                <button class="modal-close p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] hover:text-white transition-colors"><span class="material-symbols-outlined text-[20px]">close</span></button>
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
                </div>

                {{-- Status Timeline (PB-08) --}}
                <div>
                    <p class="text-xs text-[#78716c] uppercase tracking-wider font-semibold mb-3">Riwayat Status</p>
                    <div class="space-y-3" id="detail-timeline">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-[#c59b27] mt-1.5 shrink-0"></div>
                            <div>
                                <p class="text-sm text-white font-semibold">Pesanan Diterima</p>
                                <p class="text-xs text-[#78716c]">10 Nov 2026 · 14:30 WIB</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-[#c59b27] mt-1.5 shrink-0"></div>
                            <div>
                                <p class="text-sm text-white font-semibold">Kain Dipotong</p>
                                <p class="text-xs text-[#78716c]">12 Nov 2026 · 09:15 WIB</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-[#c59b27] mt-1.5 shrink-0"></div>
                            <div>
                                <p class="text-sm text-white font-semibold">Proses Jahit</p>
                                <p class="text-xs text-[#78716c]">13 Nov 2026 · 10:00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Measurements Summary --}}
                <div>
                    <p class="text-xs text-[#78716c] uppercase tracking-wider font-semibold mb-3">Ukuran Pelanggan</p>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-2" id="detail-measurements">
                        <div class="bg-[#181615] rounded-lg p-2 text-center">
                            <p class="text-[10px] text-[#78716c]">Dada</p>
                            <p class="text-sm font-bold text-white">102 cm</p>
                        </div>
                        <div class="bg-[#181615] rounded-lg p-2 text-center">
                            <p class="text-[10px] text-[#78716c]">Pinggang</p>
                            <p class="text-sm font-bold text-white">88 cm</p>
                        </div>
                        <div class="bg-[#181615] rounded-lg p-2 text-center">
                            <p class="text-[10px] text-[#78716c]">Bahu</p>
                            <p class="text-sm font-bold text-white">46 cm</p>
                        </div>
                        <div class="bg-[#181615] rounded-lg p-2 text-center">
                            <p class="text-[10px] text-[#78716c]">Lengan</p>
                            <p class="text-sm font-bold text-white">62 cm</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- === PAYMENT MODAL (PB-13) === --}}
    <div id="modal-payment" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/70 backdrop-blur-sm" role="dialog" aria-modal="true">
        <div class="admin-card w-full max-w-md">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#2d2825]">
                <h3 class="text-base font-bold text-white">Catat Pembayaran</h3>
                <button class="modal-close p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] hover:text-white transition-colors"><span class="material-symbols-outlined text-[20px]">close</span></button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-xs text-[#78716c] mb-1">Pesanan</p>
                    <p class="text-sm font-mono text-[#c59b27] font-bold" id="payment-code">—</p>
                </div>
                <div>
                    <label class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Jenis Pembayaran</label>
                    <select class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]">
                        <option value="dp">DP (Uang Muka 50%)</option>
                        <option value="pelunasan">Pelunasan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Jumlah (Rp)</label>
                    <input type="number" placeholder="Contoh: 1250000" class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                </div>
                <div>
                    <label class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Metode</label>
                    <select class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]">
                        <option value="transfer">Transfer Bank</option>
                        <option value="cash">Tunai</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>
                <button class="w-full py-2.5 bg-[#c59b27] text-[#181615] font-bold rounded-lg hover:bg-[#d8ac34] transition-colors text-sm active:scale-[0.98]">Simpan Pembayaran</button>
            </div>
        </div>
    </div>


    {{-- === OFFLINE ORDER MODAL (PB-18) === --}}
    <div id="modal-offline" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/70 backdrop-blur-sm" role="dialog" aria-modal="true">
        <div class="admin-card w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#2d2825]">
                <h3 class="text-base font-bold text-white">Buat Pesanan Offline</h3>
                <button class="modal-close p-1.5 rounded hover:bg-[#282422] text-[#a8a29e] hover:text-white transition-colors"><span class="material-symbols-outlined text-[20px]">close</span></button>
            </div>
            <form id="offline-order-form" class="p-6 space-y-4">
                <div>
                    <p class="text-xs text-[#78716c] mb-1">Kode Pesanan (Auto)</p>
                    <p class="text-lg font-mono text-[#c59b27] font-bold" id="offline-generated-code">RT-XXXXXXXX</p>
                </div>
                <div>
                    <label for="offline-customer-name" class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Nama Pelanggan</label>
                    <input id="offline-customer-name" name="customer_name" type="text" placeholder="Nama lengkap" required class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                </div>
                <div>
                    <label for="offline-customer-phone" class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">No. WhatsApp</label>
                    <input id="offline-customer-phone" name="customer_phone" type="tel" placeholder="08xxxxxxxxxx" required class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white placeholder-[#78716c]" />
                </div>
                <div>
                    <label for="offline-service" class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Jenis Layanan</label>
                    <select id="offline-service" name="service" required class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]">
                        <option>Jas 2 Piece</option>
                        <option>Jas 3 Piece</option>
                        <option>Kebaya Modern</option>
                        <option>Batik Tulis Shirt</option>
                        <option>Gamis Premium</option>
                        <option>Safari Suit</option>
                    </select>
                </div>
                <div>
                    <label for="offline-garment-category" class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Kategori Busana</label>
                    <select id="offline-garment-category" name="garment_category" required class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]">
                        <option value="celana">Celana</option>
                        <option value="baju">Baju / Jas</option>
                        <option value="rok">Rok</option>
                    </select>
                </div>
                <div class="border-t border-[#2d2825] pt-4">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs text-[#a8a29e] font-semibold uppercase tracking-wider">Ukuran Pelanggan (cm)</p>
                        <span class="text-[11px] text-[#78716c]">Sesuaikan dengan kategori busana</span>
                    </div>
                    <div id="offline-measurements-celana" class="offline-measurement-pane grid grid-cols-2 gap-3">
                        <div>
                            <label for="offline-waist" class="block text-xs text-[#a8a29e] mb-1">Lingkar Pinggang</label>
                            <input id="offline-waist" name="measurements[lingkar_pinggang]" type="number" min="50" max="160" placeholder="84" required class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-hip" class="block text-xs text-[#a8a29e] mb-1">Lingkar Panggul</label>
                            <input id="offline-hip" name="measurements[lingkar_panggul]" type="number" min="60" max="170" placeholder="98" required class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-rise" class="block text-xs text-[#a8a29e] mb-1">Lingkar Pesak</label>
                            <input id="offline-rise" name="measurements[lingkar_pesak]" type="number" min="40" max="90" placeholder="68" required class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-thigh" class="block text-xs text-[#a8a29e] mb-1">Lingkar Paha</label>
                            <input id="offline-thigh" name="measurements[lingkar_paha]" type="number" min="30" max="90" placeholder="58" required class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-knee" class="block text-xs text-[#a8a29e] mb-1">Lingkar Lutut</label>
                            <input id="offline-knee" name="measurements[lingkar_lutut]" type="number" min="25" max="70" placeholder="42" required class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-pants-opening" class="block text-xs text-[#a8a29e] mb-1">Lingkar Celana Bawah</label>
                            <input id="offline-pants-opening" name="measurements[lingkar_celana_bawah]" type="number" min="20" max="60" placeholder="36" required class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div class="col-span-2">
                            <label for="offline-pants-length" class="block text-xs text-[#a8a29e] mb-1">Panjang Celana</label>
                            <input id="offline-pants-length" name="measurements[panjang_celana]" type="number" min="60" max="140" placeholder="98" required class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                    </div>
                    <div id="offline-measurements-baju" class="offline-measurement-pane hidden grid grid-cols-2 gap-3">
                        <div>
                            <label for="offline-back-width" class="block text-xs text-[#a8a29e] mb-1">Lebar Punggung</label>
                            <input id="offline-back-width" name="measurements[lebar_punggung]" type="number" placeholder="44" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-shoulder-width" class="block text-xs text-[#a8a29e] mb-1">Lebar Bahu</label>
                            <input id="offline-shoulder-width" name="measurements[lebar_bahu]" type="number" placeholder="46" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-sleeve-length" class="block text-xs text-[#a8a29e] mb-1">Panjang Lengan</label>
                            <input id="offline-sleeve-length" name="measurements[panjang_lengan]" type="number" placeholder="61" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-chest" class="block text-xs text-[#a8a29e] mb-1">Lingkar Dada</label>
                            <input id="offline-chest" name="measurements[lingkar_dada]" type="number" placeholder="102" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div class="col-span-2">
                            <label for="offline-shirt-length" class="block text-xs text-[#a8a29e] mb-1">Panjang Baju / Jas</label>
                            <input id="offline-shirt-length" name="measurements[panjang_baju]" type="number" placeholder="74" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                    </div>
                    <div id="offline-measurements-rok" class="offline-measurement-pane hidden grid grid-cols-2 gap-3">
                        <div>
                            <label for="offline-skirt-waist" class="block text-xs text-[#a8a29e] mb-1">Lingkar Pinggang</label>
                            <input id="offline-skirt-waist" name="measurements[lingkar_pinggang]" type="number" placeholder="72" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c] focus:border-[#c59b27]" />
                        </div>
                        <div>
                            <label for="offline-skirt-hip" class="block text-xs text-[#a8a29e] mb-1">Lingkar Panggul</label>
                            <input id="offline-skirt-hip" name="measurements[lingkar_panggul]" type="number" placeholder="96" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c]" />
                        </div>
                        <div class="col-span-2">
                            <label for="offline-skirt-length" class="block text-xs text-[#a8a29e] mb-1">Panjang Rok</label>
                            <input id="offline-skirt-length" name="measurements[panjang_rok]" type="number" placeholder="92" disabled class="offline-measurement-input w-full px-3 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm font-mono text-white placeholder-[#78716c]" />
                        </div>
                    </div>
                </div>
                <div>
                    <label for="offline-deadline" class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Deadline</label>
                    <input id="offline-deadline" name="deadline" type="date" required class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white focus:border-[#c59b27]" />
                </div>
                <div>
                    <label for="offline-notes" class="block text-xs text-[#a8a29e] mb-1.5 font-semibold uppercase tracking-wider">Catatan Tambahan</label>
                    <textarea id="offline-notes" name="notes" rows="2" placeholder="Catatan khusus..." class="w-full px-4 py-2.5 bg-[#181615] border border-[#3b3531] rounded-lg text-sm text-white placeholder-[#78716c] focus:border-[#c59b27] resize-none"></textarea>
                </div>
                <p id="offline-form-feedback" class="hidden rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-3 py-2 text-xs text-emerald-300" role="status" aria-live="polite"></p>
                <button type="submit" class="w-full py-2.5 bg-[#c59b27] text-[#181615] font-bold rounded-lg hover:bg-[#d8ac34] transition-colors text-sm active:scale-[0.98]">Simpan Pesanan Offline</button>
            </form>
        </div>
    </div>


    {{-- === PRINT INVOICE MODAL (PB-13 & PB-18) === --}}
    <div id="modal-print" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/70 backdrop-blur-sm" role="dialog" aria-modal="true">
        <div class="bg-white w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-xl">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 no-print">
                <h3 class="text-base font-bold text-gray-900">Nota Pesanan</h3>
                <div class="flex items-center gap-2">
                    <button id="btn-print-action" class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#c59b27] text-white rounded-lg text-xs font-bold hover:bg-[#b08a22] transition-colors">
                        <span class="material-symbols-outlined text-[14px]">print</span> Cetak
                    </button>
                    <button class="modal-close p-1.5 rounded hover:bg-gray-100 text-gray-500 transition-colors"><span class="material-symbols-outlined text-[20px]">close</span></button>
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
                        <tr><td class="py-1.5">Total Biaya Jahit</td><td class="py-1.5 text-right font-semibold">Rp 2.500.000</td></tr>
                        <tr><td class="py-1.5 text-emerald-600">DP (50%)</td><td class="py-1.5 text-right font-semibold text-emerald-600">- Rp 1.250.000</td></tr>
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gray-900 font-bold">
                            <td class="py-2">Sisa Pembayaran</td>
                            <td class="py-2 text-right">Rp 1.250.000</td>
                        </tr>
                    </tfoot>
                </table>
                <p class="text-xs text-gray-400 text-center mt-6">Terima kasih telah mempercayakan busana Anda kepada Rahmat Tailor.</p>
            </div>
        </div>
    </div>

</body>
</html>
