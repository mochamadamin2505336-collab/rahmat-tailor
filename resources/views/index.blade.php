@extends('layouts.app')

@section('title', 'Rahmat Tailor')
@section('meta_description',
    'Dedikasi lebih dari tiga dekade dalam seni jahit bespoke, menyatukan presisi anatomi tubuh
    dengan estetika kain kelas dunia di Menteng, Jakarta Pusat.')
@section('main_class', 'w-full pt-20 bg-surface min-h-[calc(100vh-20rem)]')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet" />
@endpush

@section('content')
    <div class="flex flex-col w-full">
        <!-- ==================== 1. HERO SECTION ==================== -->
        <section class="hero-gelap relative w-full overflow-hidden text-white border-b border-white/10"
            aria-labelledby="hero-judul">
            <div class="hero-glow pointer-events-none absolute inset-0" aria-hidden="true"></div>

            <div
                class="relative max-w-[1280px] mx-auto px-6 lg:px-12 pt-10 pb-12 lg:pt-12 lg:pb-16 flex flex-col gap-8 lg:gap-0 lg:block lg:min-h-[720px]">

                <!-- Teks merek raksasa di belakang foto (dekoratif) -->
                <p class="hero-ghost order-1 text-center select-none lg:absolute lg:inset-x-12 lg:top-6" aria-hidden="true">
                    RAHMAT TAILOR</p>

                <!-- Judul: kata beraksen mengapit foto pakaian -->
                <h1 id="hero-judul" class="order-2 text-center lg:text-left">
                    <span
                        class="hero-script block text-primary text-5xl sm:text-7xl lg:absolute lg:z-10 lg:left-0 lg:top-[40%] lg:text-[clamp(5rem,8.4vw,8rem)] ">Elegance</span>
                    <span
                        class="hero-script block text-primary text-5xl sm:text-7xl lg:absolute lg:z-10 lg:right-0 lg:top-[40%] lg:text-[clamp(5rem,8.4vw,8rem)]">Tailoring</span>
                    <span
                        class="hero-script block text-white text-3xl sm:text-4xl lg:absolute lg:z-10 lg:left-0 lg:top-[61%] lg:text-[clamp(2rem,3.4vw,3.2rem)] ">Dijahit
                        untuk Anda.</span>
                    <span
                        class="hero-script block text-white text-3xl sm:text-4xl lg:absolute lg:z-10 lg:right-0 lg:top-[61%] lg:text-[clamp(2rem,3.4vw,3.2rem)] ">Penjahit
                        Berpengalaman.</span>
                    <span class="sr-only">Rahmat Tailor, jahit bespoke dengan ukuran pribadi</span>
                </h1>

                <!-- Foto pakaian di tengah -->
                <div
                    class="hero-3d-floating order-3 relative z-10 h-[320px] w-full flex items-center justify-center sm:h-[390px] md:h-[430px] lg:absolute lg:inset-0 lg:h-auto lg:pointer-events-none">
                    <model-viewer id="hero-tailor-3d" src="{{ asset('models/manekin.glb') }}"
                        alt="Manekin Bespoke 3D Rahmat Tailor" camera-controls disable-pan disable-zoom auto-rotate
                        auto-rotate-delay="0" rotation-per-second="16deg" interaction-prompt="none" touch-action="pan-y"
                        environment-image="neutral" tone-mapping="aces" exposure="1.25" shadow-intensity="1.4"
                        shadow-softness="0.9" camera-orbit="0deg 78deg 128%" min-camera-orbit="auto 78deg 128%"
                        max-camera-orbit="auto 78deg 128%" camera-target="auto auto auto" field-of-view="30deg"
                        class="pointer-events-auto w-full max-w-[440px] h-[360px] sm:h-[420px] lg:h-[520px] bg-transparent cursor-grab active:cursor-grabbing">
                    </model-viewer>
                </div>

                <!-- Blok teks kiri -->
                <div
                    class="order-4 space-y-3 text-center lg:text-left lg:absolute lg:z-30 lg:left-0 lg:bottom-10 lg:max-w-[280px]">
                    <p class="hero-serif text-lg font-bold uppercase tracking-wide">Pesan Online</p>
                    <p class="text-sm text-stone-300 leading-relaxed">Pesan dengan pengukuran mandiri</p>
                    <a href="{{ route('pemesanan') }}"
                        class="inline-flex items-center gap-2 rounded-lg border border-primary/70 bg-primary/5 px-4 py-2 text-sm font-semibold text-primary no-underline transition-colors hover:bg-primary hover:text-[#14171A] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary">
                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">straighten</span>
                        <span>Pesan &amp; Formulir Ukuran Online</span>
                    </a>
                </div>

                <!-- Kartu kanan: booking jadwal ukur -->
                <div
                    class="order-5 space-y-3 text-center lg:text-left lg:absolute lg:z-30 lg:right-0 lg:bottom-10 lg:max-w-[280px]">
                    <p class="hero-serif text-lg font-bold uppercase tracking-wide">Reservasi Jadwal Ukur</p>
                    <p class="text-xs text-stone-300 leading-relaxed">Pengukuran langsung di kios.</p>
                    <a href="#booking"
                        class="inline-flex items-center gap-2 rounded-lg border border-primary/70 bg-primary/5 px-4 py-2 text-sm font-semibold text-primary no-underline transition-colors hover:bg-primary hover:text-[#14171A] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">calendar_month</span>
                        <span>Pesan jadwal ukur</span>
                        
                    </a>
                </div>
            </div>
        </section>

        <!-- ==================== 2. LAYANAN SECTION ==================== -->
        <section class="w-full py-16 md:py-24 bg-surface-container-low" id="layanan">
            <div class="max-w-[1280px] mx-auto px-6 lg:px-12 space-y-12">
                <div class="text-center max-w-2xl mx-auto space-y-3">
                    <h2 class="font-serif text-3xl md:text-4xl text-charcoal font-bold text-balance">Pilihan Layanan Jahit & Perkiraan
                        Harga</h2>
                    <p class="text-sm text-gray-600">Jahit pakaian khusus sesuai keinginan Anda dengan bahan berkualitas,
                        jahitan kuat, dan pola yang pas di bentuk tubuh.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($layanan as $item)
                        <div
                            class="p-6 bg-white rounded-xl border border-[#e8e2d5] shadow-sm hover:shadow-md transition-all duration-300 space-y-4">
                            <div class="flex justify-between items-start gap-3">
                                <span
                                    class="px-2.5 py-1 bg-camel-light text-[#94682a] text-[10px] font-bold uppercase tracking-wider rounded">{{ $item->kategori }}</span>
                                <span class="text-xs font-mono text-gray-500">Estimasi {{ $item->estimasi_hari }}
                                    Hari</span>
                            </div>
                            <h3 class="font-serif text-xl font-bold text-charcoal">{{ $item->nama }}</h3>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                {{ $item->deskripsi ?: 'Layanan jahit sesuai ukuran dan kebutuhan pelanggan.' }}</p>
                            <div class="pt-3 border-t border-[#f0eae1] flex items-center justify-between gap-3 text-xs">
                                <span class="text-gray-500">Rentang Harga:</span>
                                <span class="font-mono font-bold text-charcoal">Rp
                                    {{ number_format($item->harga_min, 0, ',', '.') }} - Rp
                                    {{ number_format($item->harga_max, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @empty
                        <p
                            class="md:col-span-2 lg:col-span-3 text-sm text-center text-gray-500 bg-white border border-[#e8e2d5] rounded-xl p-6">
                            Belum ada layanan yang aktif.</p>
                    @endforelse

                    <!-- Service 6: CTA Card -->
                    <div
                        class="p-6 bg-gradient-to-br from-[#1c1917] to-[#2c2825] rounded-xl text-white flex flex-col justify-between shadow-md space-y-4">
                        <div class="space-y-2">
                            <span class="text-[10px] uppercase tracking-widest text-primary font-bold">Layanan Jarak
                                Jauh</span>
                            <h3 class="font-serif text-xl font-bold text-white">Pesan &amp; Ukur Mandiri Online</h3>
                            <p class="text-xs text-stone-300 leading-relaxed">
                                Tidak sempat datang ke toko? Gunakan formulir pemesanan online dengan panduan diagram cara
                                ukur badan langkah demi langkah.
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
                    <div class="text-center max-w-2xl mx-auto space-y-3">
                        <h2 class="font-serif text-3xl md:text-4xl text-charcoal font-bold">Galeri Karya Pilihan</h2>
                    </div>
                </div>

                <!-- Gallery Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($galeri as $foto)
                        <article
                            class="group bg-white rounded-xl overflow-hidden border border-[#e8e2d5] shadow-sm hover:shadow-xl transition-all duration-500">
                            <div class="relative h-64 overflow-hidden bg-stone-900">
                                <img src="{{ $foto->url }}" alt="{{ $foto->judul }}" width="800" height="256"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition-opacity">
                                </div>
                                <span
                                    class="absolute top-3 left-3 text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-sm text-primary border border-primary/40 uppercase">{{ $foto->kategori }}</span>
                            </div>
                            <div class="p-5 space-y-1">
                                <h3 class="font-serif text-base font-bold text-charcoal">{{ $foto->judul }}</h3>
                            </div>
                        </article>
                    @empty
                        <p
                            class="sm:col-span-2 lg:col-span-3 text-sm text-center text-gray-500 bg-white border border-[#e8e2d5] rounded-xl p-6">
                            Belum ada foto galeri.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- ==================== 4. CARA KERJA ==================== -->
        @include('partial.tahapan-meteran')

        <!-- ==================== 6. TESTIMONI ==================== -->
        <section class="w-full py-16 md:py-24 bg-surface">
            <div class="max-w-[1280px] mx-auto px-6 lg:px-12 space-y-10">
                <div class="text-center max-w-xl mx-auto space-y-2">
                    <h2 class="font-serif text-3xl font-bold text-charcoal">Kata Mereka Tentang Rahmat Tailor</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse ($testimoni as $item)
                        <article class="p-6 bg-white rounded-xl border border-[#e8e2d5] shadow-xs space-y-4">
                            <div class="text-amber-400 text-sm" aria-label="{{ $item->bintang }} dari 5 bintang">
                                {{ str_repeat('★', $item->bintang) }}{{ str_repeat('☆', 5 - $item->bintang) }}
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed italic">“{{ $item->isi }}”</p>
                            <div class="pt-3 border-t border-[#f0eae1]">
                                <strong class="text-xs text-charcoal block">{{ $item->pelanggan->nama }}</strong>
                            </div>
                        </article>
                    @empty
                        <p
                            class="md:col-span-3 text-sm text-center text-gray-500 bg-white border border-[#e8e2d5] rounded-xl p-6">
                            Belum ada testimoni yang ditampilkan.</p>
                    @endforelse
                </div>

                <div class="max-w-2xl mx-auto bg-white rounded-xl border border-[#e8e2d5] p-6 md:p-8 shadow-xs">
                    <div class="mb-5">
                        <h3 class="font-serif text-xl font-bold text-charcoal">Bagikan Pengalaman Anda</h3>
                        <p class="mt-1 text-xs text-gray-600">Testimoni akan ditinjau admin sebelum ditampilkan di halaman
                            ini.</p>
                    </div>

                    @auth
                        @if (auth()->user()->isAdmin())
                            <p class="text-sm text-gray-600">Gunakan akun pelanggan untuk mengirim testimoni.</p>
                        @else
                            <form id="testimonial-form" class="space-y-4">
                                <fieldset>
                                    <legend class="block text-charcoal font-bold mb-2 text-xs">Penilaian *</legend>
                                    <div class="flex flex-row-reverse justify-end gap-1" aria-label="Pilih penilaian">
                                        @for ($bintang = 5; $bintang >= 1; $bintang--)
                                            <input class="peer sr-only" id="rating-{{ $bintang }}" type="radio"
                                                name="bintang" value="{{ $bintang }}"
                                                {{ $bintang === 5 ? 'checked' : '' }}>
                                            <label for="rating-{{ $bintang }}"
                                                class="cursor-pointer text-2xl text-stone-300 peer-checked:text-amber-400 hover:text-amber-400"
                                                aria-label="{{ $bintang }} bintang">★</label>
                                        @endfor
                                    </div>
                                </fieldset>
                                <div>
                                    <label for="testimonial-text" class="block text-charcoal font-bold mb-1 text-xs">Isi
                                        Testimoni *</label>
                                    <textarea id="testimonial-text" name="isi" rows="4" minlength="10" maxlength="500" required
                                        placeholder="Ceritakan pengalaman jahit atau pelayanan Anda"
                                        class="w-full px-3.5 py-3 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal text-sm resize-none focus:border-primary focus:outline-none"></textarea>
                                </div>
                                <p id="testimonial-feedback" class="hidden text-sm" role="status" aria-live="polite"></p>
                                <button id="testimonial-submit" type="submit"
                                    class="w-full md:w-auto min-h-11 px-6 py-3 bg-primary text-charcoal hover:bg-[#d6a96e] rounded-lg text-xs font-bold uppercase tracking-widest transition-colors">
                                    Kirim Testimoni
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <p class="text-sm text-gray-600">Masuk dengan akun pelanggan untuk mengirim testimoni.</p>
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center min-h-11 px-5 py-2.5 bg-primary text-charcoal rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-[#d6a96e]">
                                Masuk
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </section>

           <!-- ==================== 7. BOOKING JADWAL UKUR ==================== -->
        @php
            // Slot kunjungan per 30 menit. Ubah $jamMulai dan $jamAkhir sesuai jam buka asli toko.
            $jamMulai = 9 * 60;
            $jamAkhir = 19 * 60;
            $slotJam = [];
            for ($m = $jamMulai; $m <= $jamAkhir; $m += 30) {
                $slotJam[] = sprintf('%02d:%02d', intdiv($m, 60), $m % 60);
            }
        @endphp
        <section class="w-full py-16 md:py-24 bg-surface-container-low border-t border-[#e9e3d7]" id="booking">
            <div class="max-w-[1280px] mx-auto px-6 lg:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <div class="lg:col-span-7 bg-white p-8 rounded-xl shadow-md border border-[#e8e2d5] space-y-6">
                        <div>
                            <h2 class="font-serif text-2xl md:text-3xl font-bold text-charcoal mt-1">Reservasi Jadwal Ukur di kios</h2>
                            <p class="text-xs text-gray-600 mt-1">Silakan tentukan waktu kunjungan Anda.</p>
                        </div>

                        <form id="booking-form" class="space-y-4 text-xs">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="booking-name" class="block text-charcoal font-bold mb-1">Nama Lengkap
                                        Pemesan *</label>
                                    <input id="booking-name" type="text" required maxlength="100"
                                    
                                        class="w-full px-3.5 py-2.5 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal focus:border-primary focus:outline-none" />
                                </div>
                                <div>
                                    <label for="booking-whatsapp" class="block text-charcoal font-bold mb-1">Nomor
                                        WhatsApp Aktif *</label>
                                    <input id="booking-whatsapp" type="tel" required placeholder="08xxxxxxxx"
                                        class="w-full px-3.5 py-2.5 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal font-mono focus:border-primary focus:outline-none" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="booking-service" class="block text-charcoal font-bold mb-1">Rencana Busana
                                        *</label>
                                    <select id="booking-service"
                                        class="w-full px-3.5 py-2.5 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal focus:border-primary focus:outline-none">
                                        <option>Jas Formal</option>
                                        <option>Kemeja</option>
                                        <option>Kebaya &amp; Gaun Pengantin</option>
                                        <option>Celana</option>
                                        <option>Seragam</option>
                                        <option>Vermak</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="booking-material" class="block text-charcoal font-bold mb-1">Pilihan Bahan
                                        Kain *</label>
                                    <select id="booking-material"
                                        class="w-full px-3.5 py-2.5 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal focus:border-primary focus:outline-none">
                                        <option value="sendiri">Membawa Bahan Kain Sendiri</option>
                                        <option value="toko">Memilih Kain dari Toko</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="booking-date" class="block text-charcoal font-bold mb-1">Tanggal Kunjungan
                                        *</label>
                                    <input id="booking-date" type="date" required min="{{ now()->toDateString() }}"
                                        class="w-full px-3.5 py-2.5 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal focus:border-primary focus:outline-none" />
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full py-4 bg-primary text-charcoal hover:bg-[#d6a96e] rounded-lg text-xs font-bold uppercase tracking-widest transition-all shadow-md mt-2 cursor-pointer">
                                Konfirmasi Booking Jadwal Ukur di Toko
                            </button>
                        </form>
                    </div>
                    <div
                        class="w-full lg:w-[440px] lg:shrink-0 min-w-0 rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-bold tracking-wide text-[#8a5f2b]">Lokasi Toko</p>

                        <div class="relative mt-4 w-full overflow-hidden rounded-lg border border-stone-200"
                            style="aspect-ratio: 4 / 3; min-height: 240px;">
                            <iframe title="Peta lokasi Rahmat Tailor di Jl. Anila 2 No. 9A/47, Sekarpuro, Pakis, Malang"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4208.578551967924!2d112.66760580000003!3d-7.964758499999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd628f8ba4ad09f%3A0x76663445968791c5!2sJl.%20Anila%20II%2C%20Sawojajar%20A%2C%20Sekarpuro%2C%20Kec.%20Pakis%2C%20Kabupaten%20Malang%2C%20Jawa%20Timur%2065154!5e1!3m2!1sen!2sid!4v1795256785187!5m2!1sen!2sid"
                                class="absolute inset-0 h-full w-full border-0" loading="lazy" allowfullscreen
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <p class="mt-4 font-semibold">Rahmat Tailor</p>
                        <p class="text-sm text-stone-600">Jl. Anila 2 No. 9A/47, Sekarpuro, Pakis, Malang</p>
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
                        Masukkan 8 karakter kode pesanan dari nota fisik atau notifikasi WhatsApp Anda untuk memantau
                        tahapan jahit secara langsung.
                    </p>
                </div>

                <form id="tracker-form" class="p-6 bg-white rounded-xl border border-[#e8e2d5] shadow-sm space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label for="tracker-input" class="block text-charcoal font-bold mb-1">Kode Pesanan (8
                                Karakter) *</label>
                            <input id="tracker-input" name="kode" type="text" required maxlength="8"
                                placeholder="Misal: RT8X39K1"
                                class="w-full px-3.5 py-2.5 bg-[#FAF8F5] border border-[#e8e2d5] rounded-lg text-charcoal font-mono focus:border-primary focus:outline-none" />
                        </div>
                        <div>
                            <label for="tracker-digit" class="block text-charcoal font-bold mb-1">4 Digit Terakhir No.
                                WhatsApp *</label>
                            <input id="tracker-digit" name="empat_digit" type="text" required pattern="[0-9]{4}"
                                maxlength="4" placeholder="Misal: 7890"
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
                <div class="hidden p-6 bg-[#FAF4EB] border-2 border-primary rounded-xl space-y-5"
                    id="tracking-sample-box">
                    <p class="text-sm text-gray-600">Memuat status pesanan...</p>
                </div>
            </div>
        </section>
    </div>
@endsection
