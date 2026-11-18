<footer class="w-full bg-[#14171a] text-gray-300 mt-auto pt-16 pb-12 border-t border-[#23282e]">
    <div class="max-w-[1280px] mx-auto px-6 lg:px-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
        <!-- Col 1: About Atelier -->
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <span class="font-headline-sm text-headline-sm text-white">Rahmat Tailor<span class="text-primary text-xl">.</span></span>
            </div>
            <p class="font-body-sm text-body-sm text-gray-400 leading-relaxed">
                Dedikasi lebih dari tiga dekade dalam seni jahit bespoke, menyatukan presisi anatomi tubuh dengan estetika kain kelas dunia untuk busana yang personal, nyaman, dan berwibawa.
            </p>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#1e2226] rounded-DEFAULT border border-primary/30 shimmer-badge">
                <span class="material-symbols-outlined text-primary text-[16px]">verified</span>
                <span class="font-label-md text-label-md text-primary uppercase font-bold">Garansi Pas Sempurna (100% Fit Guarantee)</span>
            </div>
        </div>

        <!-- Col 2: Jam Operasional -->
        <div class="space-y-3">
            <h4 class="font-title-md text-title-md text-white">Jam Operasional</h4>
            <ul class="space-y-2 font-body-sm text-body-sm text-gray-400">
                <li><span class="font-semibold text-white">Senin – Sabtu:</span> 08.30 – 20.00 WIB</li>
                <li><span class="font-semibold text-white">Minggu &amp; Libur Nasional:</span> Hanya dengan Janji Temu</li>
                <li><span class="font-semibold text-white">Sesi Fitting Privat:</span> Reservasi H-1</li>
                <li><span class="font-semibold text-white">Layanan Online:</span> Setiap Hari via WhatsApp</li>
            </ul>
        </div>

        <!-- Col 3: Lokasi & Kontak -->
        <div class="space-y-3">
            <h4 class="font-title-md text-title-md text-white">Atelier &amp; Kontak</h4>
            <p class="font-body-sm text-body-sm text-gray-400 leading-relaxed">
                Jl. Anila 2 No.9A/47 RT.03/RW.04, Kel. Sekarpuro, Kec. Pakis, Kab. Malang, Jawa Timur 65154
            </p>
            <p class="font-body-sm text-body-sm text-gray-400">
                WhatsApp: +62 812-8899-0211<br />
                Telepon: (021) 392-8812<br />
                Email: [EMAIL_ADDRESS]
            </p>
        </div>

        <!-- Col 4: Akses Cepat -->
        <div class="space-y-3">
            <h4 class="font-title-md text-title-md text-white">Akses Cepat</h4>
            <nav class="flex flex-col space-y-2">
                <a class="font-body-sm text-body-sm text-gray-400 hover:text-primary transition-colors inline-block hover:translate-x-1"
                   href="{{ route('pemesanan') }}">
                    &rarr; Formulir Pemesanan &amp; Ukuran Online
                </a>
                <a class="font-body-sm text-body-sm text-gray-400 hover:text-primary transition-colors inline-block hover:translate-x-1"
                   href="{{ url('/#layanan') }}">
                    &rarr; Daftar Layanan &amp; Biaya Jahit
                </a>
                <a class="font-body-sm text-body-sm text-gray-400 hover:text-primary transition-colors inline-block hover:translate-x-1"
                   href="{{ url('/#galeri') }}">
                    &rarr; Galeri Portofolio &amp; Busana
                </a>
                <a class="font-body-sm text-body-sm text-gray-400 hover:text-primary transition-colors inline-block hover:translate-x-1"
                   href="{{ url('/#lacak') }}">
                    &rarr; Lacak Progres Jahitan Garment
                </a>
                <a class="font-body-sm text-body-sm text-gray-400 hover:text-primary transition-colors inline-block hover:translate-x-1"
                   href="{{ url('/#booking') }}">
                    &rarr; Reservasi Jadwal Fitting di Toko
                </a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a class="font-body-sm text-body-sm text-gray-500 hover:text-primary transition-colors inline-block hover:translate-x-1 pt-1"
                           href="{{ route('admin') }}">
                            &rarr; Panel Manajemen Admin
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </div>

    <!-- Bottom Copyright -->
    <div class="max-w-[1280px] mx-auto px-6 lg:px-12 mt-12 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 font-body-sm text-body-sm text-gray-400 border-t border-[#23282e]">
        <p class="text-center sm:text-left">
            &copy; 2026 Rahmat Tailor Menteng. Hak Cipta Dilindungi Undang-Undang. Seni Jahit Tradisi &amp; Presisi Modern.
        </p>
    </div>
</footer>

