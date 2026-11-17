@extends('layouts.app')

@section('title', 'Rahmat Tailor')
@section('meta_description', 'Dedikasi lebih dari tiga dekade dalam seni jahit bespoke, menyatukan presisi anatomi tubuh dengan estetika kain kelas dunia di Menteng, Jakarta Pusat.')
@section('main_class', 'w-full pt-20 bg-surface min-h-[calc(100vh-20rem)]')

@section('content')
<div class="flex flex-col w-full">
    <!-- ==================== 1. HERO SECTION ==================== -->
    <section class="relative w-full overflow-hidden bg-surface py-14 md:py-24 border-b border-[#e9e3d7]">
        <div class="max-w-[1280px] mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                <!-- Text Column -->
                <div class="lg:col-span-7 space-y-6 reveal-element is-visible">
                    <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-charcoal tracking-tight leading-tight font-serif text-3xl sm:text-4xl md:text-5xl font-bold">
                        Dedikasi Jahitan Presisi, Kenyamanan <span class="italic font-normal text-primary inline-block hover:scale-[1.01] transition-transform">Tanpa Kompromi.</span>
                    </h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl leading-relaxed text-sm md:text-base text-gray-600">
                        Menghidupkan seni adibusana klasik dengan potongan anatomi kontemporer. Setiap helai benang diatur cermat oleh tangan Master Tailor berpengalaman lebih dari 28 tahun demi kenyamanan mutlak dan siluet prima.
                    </p>
                    <!-- Dual Call to Action -->
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a class="w-full sm:w-auto justify-center inline-flex items-center gap-2.5 px-8 py-4 bg-primary text-charcoal hover:bg-[#d6a96e] transition-all duration-300 shadow-md hover:shadow-lg font-label-lg text-label-lg font-bold uppercase tracking-wider rounded-DEFAULT hover:-translate-y-0.5 active:translate-y-0 shimmer-badge group text-xs"
                            href="{{ route('pemesanan') }}">
                            <span class="material-symbols-outlined text-[18px] transition-transform group-hover:rotate-6">straighten</span>
                            <span>Pesan &amp; Formulir Ukuran Online</span>
                        </a>
                        <a class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-7 py-4 bg-charcoal text-white hover:bg-charcoal-light transition-all duration-300 font-label-lg text-label-lg uppercase tracking-wider rounded-DEFAULT shadow-sm hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 border border-charcoal text-xs font-semibold"
                            href="#booking">
                            <span class="material-symbols-outlined text-[18px] text-primary">calendar_month</span>
                            <span>Booking Jadwal Ukur</span>
                        </a>
                    </div>
                    <!-- Trust Badges Bar -->
                    <div class="pt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="flex items-center gap-3 p-3.5 bg-white rounded-xl shadow-sm border border-[#e8e2d5] hover:-translate-y-1 hover:shadow-md transition-all duration-300 cursor-default group">
                            <div class="w-10 h-10 rounded-full bg-camel-light flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-charcoal transition-colors">
                                <span class="material-symbols-outlined text-[20px]">straighten</span>
                            </div>
                            <div class="flex flex-col text-xs">
                                <span class="font-label-lg text-charcoal font-semibold">100% Pas di Badan</span>
                                <span class="text-on-surface-variant text-gray-500">Gratis revisi kalau ukuran kurang pas</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3.5 bg-white rounded-xl shadow-sm border border-[#e8e2d5] hover:-translate-y-1 hover:shadow-md transition-all duration-300 cursor-default group">
                            <div class="w-10 h-10 rounded-full bg-camel-light flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-charcoal transition-colors">
                                <span class="material-symbols-outlined text-[20px]">texture</span>
                            </div>
                            <div class="flex flex-col text-xs">
                                <span class="font-label-lg text-charcoal font-semibold">Bawa / Pilih Bahan</span>
                                <span class="text-on-surface-variant text-gray-500">Tersedia koleksi kain berkualitas</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3.5 bg-white rounded-xl shadow-sm border border-[#e8e2d5] hover:-translate-y-1 hover:shadow-md transition-all duration-300 cursor-default group">
                            <div class="w-10 h-10 rounded-full bg-camel-light flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-charcoal transition-colors">
                                <span class="material-symbols-outlined text-[20px]">history_edu</span>
                            </div>
                            <div class="flex flex-col text-xs">
                                <span class="font-label-lg text-charcoal font-semibold">Track Real-Time</span>
                                <span class="text-on-surface-variant text-gray-500">Cek status pesanan langsung lewat web & WhatsApp    </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visual / Master Tailor Spotlight Column -->
                <div class="lg:col-span-5 relative reveal-element is-visible">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        <!-- Background Accent Card -->
                        <div class="absolute -inset-4 bg-primary/20 rounded-2xl transform rotate-2 transition-transform duration-500 hover:rotate-3 border border-primary/30"></div>
                        <!-- Main Imagery Frame -->
                        <div class="relative bg-white rounded-xl shadow-xl overflow-hidden p-3 transition-transform duration-500 hover:scale-[1.01] border border-[#e8e2d5]">
                            <div class="w-full h-[420px] sm:h-[470px] overflow-hidden rounded-lg relative group">
                                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                    alt="Master Tailor di Atelier"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuB9UJPHOiCyCE6e-ELcDgtKuO6U2PNF_RlV2cWpFzRBUSLtrR9PlDrFV7uNjYM3EPUbrlW4_XivrUnklz23LkYPkNzQe4Id1CENwfYPOtwZKxfPNolxFIETp5litHR4JTQCsF_BtxF9CBwpvFuizsk_IaVPqvLSneFU9-YfXNflrGaJ3mzz5ghZ3C90nIo8-ERjRz3-IeFrEBmOCrWzQC6kO5GnHg_uKXflgHQZ_c2N" />
                                <div class="absolute inset-0 bg-gradient-to-t from-charcoal/85 via-transparent to-transparent"></div>
                                <!-- Floating Master Tailor Badge -->
                                <div class="absolute bottom-3 left-3 right-3 sm:bottom-4 sm:left-4 sm:right-4 p-3 sm:p-4 bg-[#14171a]/90 backdrop-blur-md rounded-lg shadow-lg border border-primary/30 hover:bg-[#14171a]/95 transition-all text-white">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-charcoal font-headline-sm font-bold shadow-inner font-serif text-lg">
                                                PR
                                            </div>
                                            <div>
                                                <h4 class="font-headline-sm text-headline-sm text-white leading-tight font-serif font-bold text-base">
                                                    Pak Rahmat Hidayat
                                                </h4>
                                                <p class="font-label-md text-label-md uppercase tracking-wider text-primary text-[10px]">
                                                    Master Cutter &amp; Tailor (28 Th Pengalaman)
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right hidden sm:block text-xs">
                                            <span class="text-gray-300 block uppercase text-[10px]">Kepuasan Klien</span>
                                            <span class="text-primary font-bold">4.9 / 5.0 ★</span>
                                        </div>
                                    </div>
                                    <p class="mt-2.5 font-body-sm text-body-sm text-gray-300 italic text-xs">
                                        “Jahitan yang baik bukan sekadar pas ukuran, namun mengalir menyatu dengan gerak napas dan wibawa pemakainya.”
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Sartorial Seal Tag Overlap -->
                        <div class="absolute -top-6 -right-6 hidden sm:flex flex-col items-center justify-center w-24 h-24 rounded-full bg-primary text-charcoal shadow-xl p-2 text-center animated-seal shimmer-badge cursor-pointer hover:scale-105 transition-transform border-2 border-white">
                            <span class="material-symbols-outlined text-[24px]">workspace_premium</span>
                            <span class="font-label-md text-[9px] leading-tight uppercase font-bold mt-1">100% Fit Guarantee</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== 2. LAYANAN SECTION ==================== -->
    <section class="w-full py-16 md:py-24 bg-surface-container-low" id="layanan">
        <div class="max-w-[1280px] mx-auto px-6 lg:px-12 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <h2 class="font-serif text-3xl md:text-4xl text-charcoal font-bold">Pilihan Layanan Jahit & Perkiraan Harga</h2>
                <p class="text-sm text-gray-600">Jahit pakaian khusus sesuai keinginan Anda dengan bahan berkualitas, jahitan kuat, dan pola yang pas di bentuk tubuh.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Service 1 -->
                <div class="p-6 bg-white rounded-xl border border-[#e8e2d5] shadow-sm hover:shadow-md transition-all duration-300 space-y-4">
                    <div class="flex justify-between items-start">
                        <span class="px-2.5 py-1 bg-camel-light text-[#94682a] text-[10px] font-bold uppercase tracking-wider rounded">Jas Formal</span>
                        <span class="text-xs font-mono text-gray-500">Estimasi 14 Hari</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-charcoal">Jas Formal</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Jahit jas formal pria dengan ukuran presisi, jahitan rapi, dan desain sesuai keinginan. Bahan berkualitas, nyaman dipakai untuk acara penting.
                    </p>
                    <div class="pt-3 border-t border-[#f0eae1] flex items-center justify-between text-xs">
                        <span class="text-gray-500">Rentang Harga:</span>
                        <span class="font-mono font-bold text-charcoal">Rp 3.500.000 - Rp 7.500.000</span>
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="p-6 bg-white rounded-xl border border-[#e8e2d5] shadow-sm hover:shadow-md transition-all duration-300 space-y-4">
                    <div class="flex justify-between items-start">
                        <span class="px-2.5 py-1 bg-camel-light text-[#94682a] text-[10px] font-bold uppercase tracking-wider rounded">Batik Tulis</span>
                        <span class="text-xs font-mono text-gray-500">Estimasi 7 Hari</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-charcoal">Kemeja Batik</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Penyesuaian motif presisi simetris tanpa terpotong di dada dan saku, dilapisi furing sutra katun bernapas sejuk, kancing sembunyi rapi.
                    </p>
                    <div class="pt-3 border-t border-[#f0eae1] flex items-center justify-between text-xs">
                        <span class="text-gray-500">Rentang Harga:</span>
                        <span class="font-mono font-bold text-charcoal">Rp 750.000 - Rp 1.400.000</span>
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="p-6 bg-white rounded-xl border border-[#e8e2d5] shadow-sm hover:shadow-md transition-all duration-300 space-y-4">
                    <div class="flex justify-between items-start">
                        <span class="px-2.5 py-1 bg-camel-light text-[#94682a] text-[10px] font-bold uppercase tracking-wider rounded">Kebaya Modern</span>
                        <span class="text-xs font-mono text-gray-500">Estimasi 12 Hari</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-charcoal">Kebaya Modern &amp; Brokat</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Potongan pas di badan dengan payet jahit tangan yang rapi. Nyaman dipakai untuk acara wisuda, kondangan, maupun acara resmi lainnya
                    </p>
                    <div class="pt-3 border-t border-[#f0eae1] flex items-center justify-between text-xs">
                        <span class="text-gray-500">Rentang Harga:</span>
                        <span class="font-mono font-bold text-charcoal">Rp 1.500.000 - Rp 3.800.000</span>
                    </div>
                </div>

                <!-- Service 4 -->
                <div class="p-6 bg-white rounded-xl border border-[#e8e2d5] shadow-sm hover:shadow-md transition-all duration-300 space-y-4">
                    <div class="flex justify-between items-start">
                        <span class="px-2.5 py-1 bg-camel-light text-[#94682a] text-[10px] font-bold uppercase tracking-wider rounded">Celana Formal</span>
                        <span class="text-xs font-mono text-gray-500">Estimasi 5 Hari</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-charcoal">Celana Formal</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Potongan klasik atau modern slim, dilengkapi sabuk internal, side adjusters logam, furing lutut halus, dan lipatan setrika tahan lama.
                    </p>
                    <div class="pt-3 border-t border-[#f0eae1] flex items-center justify-between text-xs">
                        <span class="text-gray-500">Rentang Harga:</span>
                        <span class="font-mono font-bold text-charcoal">Rp 600.000 - Rp 1.200.000</span>
                    </div>
                </div>

                <!-- Service 5 -->
                <div class="p-6 bg-white rounded-xl border border-[#e8e2d5] shadow-sm hover:shadow-md transition-all duration-300 space-y-4">
                    <div class="flex justify-between items-start">
                        <span class="px-2.5 py-1 bg-camel-light text-[#94682a] text-[10px] font-bold uppercase tracking-wider rounded">Seragam</span>
                        <span class="text-xs font-mono text-gray-500">Estimasi 8 Hari</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-charcoal">Setelan Seragam PDH</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Bahan drill premium berstruktur kokoh, saku berpenutup berkancing rapi, standar pakaian dinas kementerian dan instansi negara.
                    </p>
                    <div class="pt-3 border-t border-[#f0eae1] flex items-center justify-between text-xs">
                        <span class="text-gray-500">Rentang Harga:</span>
                        <span class="font-mono font-bold text-charcoal">Rp 1.200.000 - Rp 2.200.000</span>
                    </div>
                </div>

                <!-- Service 6: CTA Card -->
                <div class="p-6 bg-gradient-to-br from-[#1c1917] to-[#2c2825] rounded-xl text-white flex flex-col justify-between shadow-md space-y-4">
                    <div class="space-y-2">
                        <span class="text-[10px] uppercase tracking-widest text-primary font-bold">Layanan Jarak Jauh</span>
                        <h3 class="font-serif text-xl font-bold text-white">Pesan &amp; Ukur Mandiri Online</h3>
                        <p class="text-xs text-stone-300 leading-relaxed">
                            Tidak sempat datang ke toko? Gunakan formulir pemesanan online dengan panduan diagram cara ukur badan langkah demi langkah.
                        </p>
                    </div>
                    <a href="{{ route('pemesanan') }}"
                        class="inline-flex items-center justify-center gap-2 py-3 px-4 bg-primary text-charcoal font-bold uppercase tracking-wider text-xs rounded hover:bg-[#d6a96e] transition-colors">
                        <span class="material-symbols-outlined text-[16px]">straighten</span>
                        <span>Buka Form Pemesanan</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== 3. GALERI PORTOFOLIO ==================== -->
    <section class="w-full py-16 md:py-24 bg-surface" id="galeri">
        <div class="max-w-[1280px] mx-auto px-6 lg:px-12 space-y-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-4 border-b border-[#e8e2d5]">
                <div class="space-y-2">
                    <h2 class="font-serif text-3xl md:text-4xl text-charcoal font-bold">Galeri Karya Pilihan</h2>
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Item 1 -->
                <div class="group bg-white rounded-xl overflow-hidden border border-[#e8e2d5] shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="relative h-64 overflow-hidden bg-stone-900">
                        <img src="https://images.unsplash.com/photo-1594938298603-c8148c4dae35?auto=format&fit=crop&w=800&q=80"
                            alt="Tuxedo Black-Tie Wool Super 150s"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <span class="absolute top-3 left-3 text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-sm text-primary border border-primary/40 uppercase">Bespoke Jas</span>
                    </div>
                    <div class="p-5 space-y-1">
                        <h3 class="font-serif text-base font-bold text-charcoal">Tuxedo Black-Tie Wool Super 150s</h3>
                        <p class="text-xs text-gray-500">Shawl Lapel Sutra Satin • Full Canvas</p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="group bg-white rounded-xl overflow-hidden border border-[#e8e2d5] shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="relative h-64 overflow-hidden bg-stone-900">
                        <img src="https://images.unsplash.com/photo-1607344645866-009c320c5ab8?auto=format&fit=crop&w=800&q=80"
                            alt="Batik Tulis Sutra Solo Parang Kusumo"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <span class="absolute top-3 left-3 text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-sm text-primary border border-primary/40 uppercase">Batik Tulis</span>
                    </div>
                    <div class="p-5 space-y-1">
                        <h3 class="font-serif text-base font-bold text-charcoal">Batik Tulis Sutra Solo Parang Kusumo</h3>
                        <p class="text-xs text-gray-500">Motif Simetris Menyambung Presisi • Furing Sutra</p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="group bg-white rounded-xl overflow-hidden border border-[#e8e2d5] shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="relative h-64 overflow-hidden bg-stone-900">
                        <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80"
                            alt="Kebaya Kartini Brokat Chantilly Modern"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <span class="absolute top-3 left-3 text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-sm text-primary border border-primary/40 uppercase">Kebaya Bespoke</span>
                    </div>
                    <div class="p-5 space-y-1">
                        <h3 class="font-serif text-base font-bold text-charcoal">Kebaya Kartini Brokat Chantilly Modern</h3>
                        <p class="text-xs text-gray-500">Aplikasi Payet Swarovski • Siluet Ramping</p>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="group bg-white rounded-xl overflow-hidden border border-[#e8e2d5] shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="relative h-64 overflow-hidden bg-stone-900">
                        <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=800&q=80"
                            alt="Double-Breasted Pinstripe Suit"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <span class="absolute top-3 left-3 text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-sm text-primary border border-primary/40 uppercase">Bespoke Jas</span>
                    </div>
                    <div class="p-5 space-y-1">
                        <h3 class="font-serif text-base font-bold text-charcoal">Double-Breasted Pinstripe Suit</h3>
                        <p class="text-xs text-gray-500">Peak Lapel Lebar • Savile Row Sartorial Style</p>
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="group bg-white rounded-xl overflow-hidden border border-[#e8e2d5] shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="relative h-64 overflow-hidden bg-stone-900">
                        <img src="https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?auto=format&fit=crop&w=800&q=80"
                            alt="Celana Gurkha Pleated Wool Charcoal"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <span class="absolute top-3 left-3 text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-sm text-primary border border-primary/40 uppercase">Celana Formal</span>
                    </div>
                    <div class="p-5 space-y-1">
                        <h3 class="font-serif text-base font-bold text-charcoal">Celana Gurkha Pleated Wool Charcoal</h3>
                        <p class="text-xs text-gray-500">Side Adjusters Kuningan • Cuff 4 cm</p>
                    </div>
                </div>

                <!-- Item 6 -->
                <div class="group bg-white rounded-xl border border-[#e8e2d5] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="relative h-64 overflow-hidden bg-stone-900">
                        <img src="https://images.unsplash.com/photo-1589456355423-474c57cad55c?auto=format&fit=crop&w=800&q=80"
                            alt="Kemeja Batik Sutra Motif Sekar Jagad"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <span class="absolute top-3 left-3 text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-sm text-primary border border-primary/40 uppercase">Batik Tulis</span>
                    </div>
                    <div class="p-5 space-y-1">
                        <h3 class="font-serif text-base font-bold text-charcoal">Kemeja Batik Sutra Motif Sekar Jagad</h3>
                        <p class="text-xs text-gray-500">Saku Bobok Tersembunyi • Manset Kancing Tanduk</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== 4. CARA KERJA ==================== -->
    <section class="w-full py-16 md:py-24 bg-surface-container-low border-y border-[#e9e3d7]">
        <div class="max-w-[1280px] mx-auto px-6 lg:px-12 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <h2 class="font-serif text-3xl md:text-4xl text-charcoal font-bold">4 Tahapan Jahit Rahmat Tailor</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 bg-white rounded-xl border border-[#e8e2d5] space-y-3 shadow-xs">
                    <span class="w-8 h-8 rounded-full bg-primary text-charcoal font-bold text-xs flex items-center justify-center font-serif">1</span>
                    <h3 class="font-serif text-base font-bold text-charcoal">Konsultasi &amp; Ukur Anatomi</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">Pemilihan kain, rancang model lapel/kerah, dan pengukuran 24 titik anatomi tubuh secara teliti.</p>
                </div>
                <div class="p-6 bg-white rounded-xl border border-[#e8e2d5] space-y-3 shadow-xs">
                    <span class="w-8 h-8 rounded-full bg-primary text-charcoal font-bold text-xs flex items-center justify-center font-serif">2</span>
                    <h3 class="font-serif text-base font-bold text-charcoal">Pembuatan Pola &amp; Potong Kain</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">Pola kertas individual dibuat khusus untuk Anda, lalu dipotong secara presisi di atas meja potong.</p>
                </div>
                <div class="p-6 bg-white rounded-xl border border-[#e8e2d5] space-y-3 shadow-xs">
                    <span class="w-8 h-8 rounded-full bg-primary text-charcoal font-bold text-xs flex items-center justify-center font-serif">3</span>
                    <h3 class="font-serif text-base font-bold text-charcoal">Sesi Basting &amp; Fitting</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">Pencocokan bahan mentah berkanvas di tubuh Anda untuk mengecek kelonggaran dada, lekuk punggung, dan jatuhnya lengan.</p>
                </div>
                <div class="p-6 bg-white rounded-xl border border-[#e8e2d5] space-y-3 shadow-xs">
                    <span class="w-8 h-8 rounded-full bg-primary text-charcoal font-bold text-xs flex items-center justify-center font-serif">4</span>
                    <h3 class="font-serif text-base font-bold text-charcoal">Sentuhan Akhir &amp; Garansi Fit</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">Pemasangan kancing tanduk, setrika uap suhu tinggi, serta garansi pas sempurna 100% pasca pengambilan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== 5. LACAK PESANAN REALTIME ==================== -->
    <section class="w-full py-16 md:py-20 bg-surface border-b border-[#e9e3d7]" id="lacak">
        <div class="max-w-[960px] mx-auto px-6 lg:px-12 space-y-8">
            <div class="text-center space-y-2">
                <h2 class="font-serif text-3xl text-charcoal font-bold">Lacak Progres Jahitan Pesanan Anda</h2>
                <p class="text-xs text-gray-600 max-w-lg mx-auto">
                    Masukkan 8 karakter kode pesanan dari nota fisik atau notifikasi WhatsApp Anda untuk memantau tahapan jahit secara langsung.
                </p>
            </div>

            <form class="p-6 bg-white rounded-xl border border-[#e8e2d5] shadow-sm space-y-4" onsubmit="event.preventDefault(); document.getElementById('tracking-sample-box').classList.remove('hidden');">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block text-charcoal font-bold mb-1">Kode Pesanan (8 Karakter) *</label>
                        <input type="text" required placeholder="Misal: RT-8X39K1"
                            class="w-full px-3.5 py-2.5 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal font-mono uppercase focus:border-primary focus:outline-none" />
                    </div>
                    <div>
                        <label class="block text-charcoal font-bold mb-1">4 Digit Terakhir No. WhatsApp *</label>
                        <input type="text" maxlength="4" placeholder="Misal: 7890"
                            class="w-full px-3.5 py-2.5 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal font-mono focus:border-primary focus:outline-none" />
                    </div>
                </div>

                <div class="flex justify-center pt-2">
                    <button type="submit"
                        class="px-8 py-3 bg-[#14171a] text-white hover:bg-stone-800 text-xs font-bold uppercase tracking-widest rounded-lg transition-colors shadow flex items-center gap-2 cursor-pointer">
                        <span class="material-symbols-outlined text-[18px] text-primary">search</span>
                        <span>Cek Progres Jahitan Sekarang</span>
                    </button>
                </div>
            </form>

            <!-- Tracking Result Box -->
            <div class="hidden p-6 bg-[#FAF4EB] border-2 border-primary rounded-xl space-y-5" id="tracking-sample-box">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-[#e2d5c3]">
                    <div>
                        <span class="font-mono text-sm font-bold text-charcoal bg-white px-2.5 py-1 rounded border border-primary/40">
                            RT-8X39K1
                        </span>
                        <h4 class="font-serif text-lg font-bold text-charcoal mt-2">Jas Bespoke 2-Piece Wool Scabal</h4>
                        <p class="text-xs text-gray-600">Pemesan: <strong>Bapak Hendra Wijaya</strong></p>
                    </div>
                    <div class="text-right text-xs">
                        <span class="text-gray-500 block">Estimasi Selesai:</span>
                        <strong class="text-charcoal font-mono text-sm">20 Nov 2026</strong>
                    </div>
                </div>

                <div class="grid grid-cols-5 gap-2 text-center text-xs">
                    <div class="space-y-1">
                        <div class="h-2 rounded-full bg-primary"></div>
                        <span class="text-[10px] text-charcoal font-bold block">Diterima</span>
                    </div>
                    <div class="space-y-1">
                        <div class="h-2 rounded-full bg-primary"></div>
                        <span class="text-[10px] text-charcoal font-bold block">Dipotong</span>
                    </div>
                    <div class="space-y-1">
                        <div class="h-2 rounded-full bg-primary animate-pulse"></div>
                        <span class="text-[10px] text-charcoal font-bold block">Dijahit</span>
                    </div>
                    <div class="space-y-1">
                        <div class="h-2 rounded-full bg-stone-300"></div>
                        <span class="text-[10px] text-gray-400 block">Fitting</span>
                    </div>
                    <div class="space-y-1">
                        <div class="h-2 rounded-full bg-stone-300"></div>
                        <span class="text-[10px] text-gray-400 block">Siap Diambil</span>
                    </div>
                </div>

                <p class="text-xs text-gray-700 bg-white/70 p-3 rounded border border-primary/20 text-center">
                    Status saat ini: <strong class="text-[#94682a]">Sedang Dijahit (Tahap Kanvas)</strong>. Tim penjahit kami sedang merakit konstruksi kanvas dan furing dalam jas Anda.
                </p>
            </div>
        </div>
    </section>

    <!-- ==================== 6. TESTIMONI ==================== -->
    <section class="w-full py-16 md:py-24 bg-surface">
        <div class="max-w-[1280px] mx-auto px-6 lg:px-12 space-y-10">
            <div class="text-center max-w-xl mx-auto space-y-2">
                <h2 class="font-serif text-3xl font-bold text-charcoal">Kata Mereka Tentang Rahmat Tailor</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white rounded-xl border border-[#e8e2d5] shadow-xs space-y-4">
                    <div class="text-amber-400 text-sm">★★★★★</div>
                    <p class="text-xs text-gray-600 leading-relaxed italic">
                        “Jahitan sangat presisi dan nyaman dipakai seharian untuk resepsi adik saya. Bahu pas sekali dan lekuk pinggang sangat proporsional tanpa terasa sesak.”
                    </p>
                    <div class="pt-3 border-t border-[#f0eae1]">
                        <strong class="text-xs text-charcoal block">Bapak Hendra Wijaya</strong>
                        <span class="text-[11px] text-gray-500">Jas Bespoke 2-Piece Wool</span>
                    </div>
                </div>

                <div class="p-6 bg-white rounded-xl border border-[#e8e2d5] shadow-xs space-y-4">
                    <div class="text-amber-400 text-sm">★★★★★</div>
                    <p class="text-xs text-gray-600 leading-relaxed italic">
                        “Detail shawl lapel sutra satinnya luar biasa halus. Fitting dilakukan teliti hingga tidak ada kerutan di punggung saat berdiri maupun duduk.”
                    </p>
                    <div class="pt-3 border-t border-[#f0eae1]">
                        <strong class="text-xs text-charcoal block">dr. Dimas Aditya, Sp.A</strong>
                        <span class="text-[11px] text-gray-500">Jas Tuxedo Black Tie</span>
                    </div>
                </div>

                <div class="p-6 bg-white rounded-xl border border-[#e8e2d5] shadow-xs space-y-4">
                    <div class="text-amber-400 text-sm">★★★★★</div>
                    <p class="text-xs text-gray-600 leading-relaxed italic">
                        “Pola batik di saku dan sambungan kancing menyambung tanpa terputus. Pak Rahmat sangat paham memotong kain batik tulis bernilai tinggi.”
                    </p>
                    <div class="pt-3 border-t border-[#f0eae1]">
                        <strong class="text-xs text-charcoal block">Bapak Ir. Bambang Sutrisno</strong>
                        <span class="text-[11px] text-gray-500">Kemeja Batik Tulis Sutra Solo</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== 7. BOOKING JADWAL UKUR ==================== -->
    <section class="w-full py-16 md:py-24 bg-surface-container-low border-t border-[#e9e3d7]" id="booking">
        <div class="max-w-[1280px] mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-7 bg-white p-8 rounded-xl shadow-md border border-[#e8e2d5] space-y-6">
                    <div>
                        <h2 class="font-serif text-2xl md:text-3xl font-bold text-charcoal mt-1">Reservasi Jadwal Ukur &amp; Fitting di Atelier</h2>
                        <p class="text-xs text-gray-600 mt-1">Silakan tentukan waktu kunjungan Anda. Master Tailor kami meluangkan waktu eksklusif 45-60 menit per pelanggan.</p>
                    </div>

                    <form class="space-y-4 text-xs" onsubmit="event.preventDefault(); alert('Reservasi berhasil dikirim! Concierge Rahmat Tailor akan mengonfirmasi sesi Anda melalui WhatsApp.');">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-charcoal font-bold mb-1">Nama Lengkap Pemesan *</label>
                                <input type="text" required placeholder="Contoh: Bpk. H. Hendrawan"
                                    class="w-full px-3.5 py-2.5 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal focus:border-primary focus:outline-none" />
                            </div>
                            <div>
                                <label class="block text-charcoal font-bold mb-1">Nomor WhatsApp Aktif *</label>
                                <input type="tel" required placeholder="+62 812-3456-7890"
                                    class="w-full px-3.5 py-2.5 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal font-mono focus:border-primary focus:outline-none" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-charcoal font-bold mb-1">Rencana Busana *</label>
                                <select class="w-full px-3.5 py-2.5 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal focus:border-primary focus:outline-none">
                                    <option>Jas Bespoke Formal</option>
                                    <option>Kemeja Batik Tulis Sutra</option>
                                    <option>Kebaya &amp; Gaun Pengantin</option>
                                    <option>Celana Formal Wool</option>
                                    <option>Setelan Safari / Seragam</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-charcoal font-bold mb-1">Pilihan Bahan Kain *</label>
                                <select class="w-full px-3.5 py-2.5 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal focus:border-primary focus:outline-none">
                                    <option>Membawa Bahan Kain Sendiri</option>
                                    <option>Memilih Bahan Koleksi Atelier</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-charcoal font-bold mb-1">Tanggal Kunjungan *</label>
                            <input type="date" required value="2026-11-18"
                                class="w-full px-3.5 py-2.5 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal" />
                        </div>

                        <button type="submit"
                            class="w-full py-4 bg-primary text-charcoal hover:bg-[#d6a96e] rounded-lg text-xs font-bold uppercase tracking-widest transition-all shadow-md mt-2 cursor-pointer">
                            Konfirmasi Booking Jadwal Ukur di Toko
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-[#e8e2d5] shadow-xs space-y-4">
                        <span class="text-xs uppercase tracking-widest text-[#BA8B4E] font-bold">Lokasi Atelier Toko</span>
                        <div class="aspect-video w-full rounded-lg overflow-hidden border border-[#e8e2d5] bg-stone-100">
                            <img src="https://images.unsplash.com/photo-1594938298603-c8148c4dae35?auto=format&fit=crop&w=700&q=80"
                                alt="Workshop Atelier Rahmat Tailor" class="w-full h-full object-cover" />
                        </div>
                        <div class="text-xs text-gray-600 space-y-1">
                            <strong class="text-charcoal block">Rahmat Tailor Bespoke Menteng</strong>
                            <p>Jl. Kebon Sirih No. 42, Menteng, Jakarta Pusat (Dekat Stasiun Gondangdia)</p>
                            <p class="text-primary font-semibold">WhatsApp Concierge: +62 812-8899-0211</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
