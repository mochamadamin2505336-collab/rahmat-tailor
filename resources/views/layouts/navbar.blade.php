<header class="fixed top-0 w-full z-50 bg-[#14171a]/95 text-white backdrop-blur-xl border-b border-[#282d33] shadow-[0_4px_20px_rgba(0,0,0,0.15)] transition-all duration-300" id="main-header">
    <div class="h-20 max-w-[1280px] mx-auto px-6 lg:px-12 flex items-center justify-between gap-4">
        
        <!-- Brand Logo -->
        <a href="{{ route('beranda') }}" class="flex items-center gap-3 group cursor-pointer" aria-label="Kembali ke Beranda Rahmat Tailor">
            <div class="flex flex-col">
                <span class="font-headline-sm text-headline-sm text-white tracking-wide transition-colors group-hover:text-primary">
                    Rahmat Tailor<span class="text-primary text-xl">.</span>
                </span>
            </div>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="hidden lg:flex items-center gap-7 relative py-2" id="main-nav" aria-label="Navigasi Utama Desktop">
            @php
                $isHome = request()->routeIs('beranda') || request()->is('/');
                $isPemesanan = request()->routeIs('pemesanan') || request()->is('pemesanan*');
            @endphp

            <!-- Layanan -->
            <a class="nav-item whitespace-nowrap font-label-lg text-label-lg uppercase tracking-wider py-1 font-medium transition-all duration-200 hover:-translate-y-0.5 text-gray-300 hover:text-primary"
               data-path="layanan"
               href="{{ $isHome ? '#layanan' : url('/#layanan') }}">
                Layanan
            </a>

            <!-- Galeri -->
            <a class="nav-item whitespace-nowrap font-label-lg text-label-lg uppercase tracking-wider py-1 font-medium transition-all duration-200 hover:-translate-y-0.5 text-gray-300 hover:text-primary"
               data-path="galeri"
               href="{{ $isHome ? '#galeri' : url('/#galeri') }}">
                Galeri
            </a>

            <!-- Booking Jadwal Ukur -->
            <a class="nav-item whitespace-nowrap font-label-lg text-label-lg uppercase tracking-wider py-1 font-medium transition-all duration-200 hover:-translate-y-0.5 text-gray-300 hover:text-primary"
               data-path="booking"
               href="{{ $isHome ? '#booking' : url('/#booking') }}">
                Reservasi
            </a>

             <!-- Lacak Pesanan -->
            <a class="nav-item whitespace-nowrap font-label-lg text-label-lg uppercase tracking-wider py-1 font-medium transition-all duration-200 hover:-translate-y-0.5 text-gray-300 hover:text-primary"
               data-path="lacak-pesanan"
               href="{{ $isHome ? '#lacak' : url('/#lacak') }}">
                Lacak Pesanan
            </a>

            <a class="nav-item whitespace-nowrap font-label-lg text-label-lg uppercase tracking-wider py-1 font-medium transition-all duration-200 hover:-translate-y-0.5 text-gray-300 hover:text-primary"
               data-path="pesan online"
               href="{{ route('pemesanan') }}">
                Pesan Online
            </a>

            <!-- Dynamic Gold Indicator Bar -->
            <div class="absolute bottom-0 h-[2.5px] bg-[#ba8b4e] rounded-full pointer-events-none shadow-[0_0_8px_rgba(186,139,78,0.7)] transition-all duration-300"
                 id="nav-indicator"></div>
        </nav>

        <!-- Right Action Button & Mobile Hamburger -->
        <div class="flex items-center gap-3">
            <a class="hidden sm:inline-flex whitespace-nowrap items-center gap-2 px-4 py-2.5 bg-primary text-charcoal hover:bg-[#d6a96e] font-semibold transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] rounded font-label-lg text-label-lg uppercase tracking-wider shadow-sm shimmer-badge"
               href="https://wa.me/6281288990211?text=Halo%20Pak%20Rahmat,%20saya%20ingin%20konsultasi%20pemesanan%20jahit"
               rel="noopener noreferrer" target="_blank">
                <span class="material-symbols-outlined text-[18px]">chat</span>
                <span>Konsultasi Gratis</span>
            </a>

            @auth
                <div class="relative hidden lg:block" id="profile-menu-wrapper">
                    <button id="profile-menu-button" type="button"
                            class="inline-flex items-center gap-2 min-h-11 px-3 py-2 border border-[#282d33] hover:border-primary hover:text-primary rounded-lg text-sm font-semibold text-white transition-colors"
                            aria-haspopup="true" aria-expanded="false" aria-controls="profile-menu">
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">person</span>
                        <span class="max-w-32 truncate">{{ auth()->user()->name }}</span>
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">expand_more</span>
                    </button>

                    <div id="profile-menu"
                         class="absolute right-0 top-full mt-2 w-80 bg-[#1a1816] border border-[#2d2825] rounded-xl shadow-xl overflow-hidden hidden"
                         role="menu">
                        @if(!auth()->user()->isAdmin())
                            <div class="px-4 py-3 border-b border-[#2d2825]">
                                <p class="text-xs uppercase tracking-wider text-[#78716c] font-semibold">Riwayat Pemesanan</p>
                                <div id="profile-order-history" class="mt-2 max-h-64 overflow-y-auto space-y-2" aria-live="polite">
                                    <p class="text-xs text-[#a8a29e]">Memuat riwayat pemesanan...</p>
                                </div>
                            </div>
                        @endif
                        <button type="button" class="profile-logout w-full min-h-11 flex items-center gap-2 px-4 py-3 text-left text-sm text-[#a8a29e] hover:text-white hover:bg-[#282422] transition-colors" role="menuitem">
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">logout</span>
                            Logout
                        </button>
                    </div>
                </div>
            @else
                <a class="hidden sm:inline-flex items-center gap-2 min-h-11 px-4 py-2 border border-primary/60 text-primary hover:bg-primary hover:text-charcoal rounded-lg font-semibold text-sm transition-colors"
                   href="{{ route('login') }}">
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">login</span>
                    Masuk
                </a>
            @endauth

            <!-- Mobile Menu Toggle Button -->
            <button aria-controls="mobile-menu" aria-expanded="false" aria-label="Buka menu navigasi"
                    class="menu-toggle lg:hidden inline-flex items-center justify-center w-11 h-11 text-white border border-[#282d33] hover:border-primary hover:text-primary transition-colors rounded"
                    id="menu-toggle" type="button">
                <span class="burger" aria-hidden="true"><span></span><span></span><span></span></span>
            </button>
        </div>
    </div>

    <!-- Mobile Drawer Navigation -->
    <div aria-hidden="true"
         class="mobile-menu lg:hidden absolute top-full left-0 w-full bg-[#14171a] border-b border-[#282d33] shadow-[0_20px_30px_-10px_rgba(0,0,0,0.45)]"
         id="mobile-menu">
        <nav aria-label="Menu navigasi mobile" class="max-w-[1280px] mx-auto px-6 py-3 flex flex-col" id="mobile-nav">
            <a class="mobile-nav-item flex items-center justify-between py-3.5 border-b border-[#282d33] font-label-lg text-label-lg uppercase tracking-wider font-medium transition-colors {{ $isHome ? 'text-primary font-semibold' : 'text-gray-300 hover:text-primary' }}"
               data-path="beranda"
               @if($isHome) aria-current="page" @endif
               href="{{ $isHome ? '#' : route('beranda') }}">
                Beranda <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </a>

            <a class="mobile-nav-item flex items-center justify-between py-3.5 border-b border-[#282d33] font-label-lg text-label-lg uppercase tracking-wider text-gray-300 font-medium hover:text-primary transition-colors"
               data-path="layanan"
               href="{{ $isHome ? '#layanan' : url('/#layanan') }}">
                Layanan <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </a>

            <a class="mobile-nav-item flex items-center justify-between py-3.5 border-b border-[#282d33] font-label-lg text-label-lg uppercase tracking-wider text-gray-300 font-medium hover:text-primary transition-colors"
               data-path="galeri"
               href="{{ $isHome ? '#galeri' : url('/#galeri') }}">
                Galeri Karya <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </a>

            <a class="mobile-nav-item flex items-center justify-between py-3.5 border-b border-[#282d33] font-label-lg text-label-lg uppercase tracking-wider text-gray-300 font-medium hover:text-primary transition-colors"
               data-path="lacak-pesanan"
               href="{{ $isHome ? '#lacak' : url('/#lacak') }}">
                Lacak Pesanan <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </a>

            <a class="mobile-nav-item flex items-center justify-between py-3.5 border-b border-[#282d33] font-label-lg text-label-lg uppercase tracking-wider text-gray-300 font-medium hover:text-primary transition-colors"
               data-path="booking"
               href="{{ $isHome ? '#booking' : url('/#booking') }}">
                Booking Jadwal <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </a>

            <a class="mobile-nav-item flex items-center justify-between py-3.5 border-b border-[#282d33] font-label-lg text-label-lg uppercase tracking-wider font-semibold transition-colors {{ $isPemesanan ? 'text-primary' : 'text-gray-300 hover:text-primary' }}"
               data-path="pemesanan"
               @if($isPemesanan) aria-current="page" @endif
               href="{{ route('pemesanan') }}">
                <span class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-primary">straighten</span>
                    Pesan &amp; Formulir Ukuran Online
                </span>
                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </a>

            <a class="sm:hidden flex items-center justify-center gap-2 mt-3 mb-3 px-5 py-3.5 bg-primary text-charcoal font-semibold rounded font-label-lg text-label-lg uppercase tracking-wider shadow-sm"
               href="https://wa.me/6289694756666" rel="noopener noreferrer" target="_blank">
                <span class="material-symbols-outlined text-[18px]">chat</span>
                <span>Konsultasi WhatsApp</span>
            </a>

            @auth
                @if(!auth()->user()->isAdmin())
                    <button id="mobile-history-button" type="button"
                       class="flex items-center justify-between w-full min-h-11 py-3.5 border-b border-[#282d33] text-gray-300 hover:text-primary transition-colors"
                       aria-expanded="false" aria-controls="mobile-order-history">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">receipt_long</span>
                            Riwayat Pemesanan
                        </span>
                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">chevron_right</span>
                    </button>
                    <div id="mobile-order-history"
                         class="hidden max-h-64 overflow-y-auto space-y-2 py-3 border-b border-[#282d33]"
                         aria-live="polite">
                        <p class="text-xs text-[#a8a29e]">Memuat riwayat pemesanan...</p>
                    </div>
                @endif
                <button type="button" class="profile-logout flex items-center gap-2 min-h-11 py-3.5 text-gray-300 hover:text-primary text-left transition-colors">
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">logout</span>
                    Logout
                </button>
            @else
                <a class="flex items-center justify-center gap-2 min-h-11 mt-3 px-5 py-3.5 border border-primary/60 text-primary rounded font-semibold"
                   href="{{ route('login') }}">
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">login</span>
                    Masuk
                </a>
            @endauth
        </nav>
    </div>
</header>

