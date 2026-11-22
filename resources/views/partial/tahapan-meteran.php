<!-- {{--
    Section "4 Tahapan Jahit" dengan meteran sebagai garis waktu.
    Simpan di: resources/views/partials/tahapan-meteran.blade.php
    Dipanggil dari index.blade.php dengan: @include('partials.tahapan-meteran')
    Animasinya dijalankan oleh resources/js/reveal.js (Motion). File ini hanya tampilan.
--}} -->
<style>
    /* Meteran digambar dengan CSS: pita krem, garis cm, ujung logam emas. */
    .mt-section {
        background: #14171a;
        padding: 80px 0 96px;
        border-top: 1px solid rgba(197, 155, 99, .25);
    }
    .mt-wrap { max-width: 1332px; margin: 0 auto; padding: 0 24px; }
    .mt-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-weight: 700;
        font-size: clamp(1.875rem, 4.2vw, 2.5rem);
        line-height: 1.2;
        color: #fbf9f5;
        text-align: center;
        text-wrap: balance;
        font-variant-numeric: lining-nums;
        margin: 0 0 56px;
    }

    /* Mobile dan tablet: meteran tegak di sisi kiri */
    .mt-list {
        position: relative;
        display: grid;
        grid-template-columns: 1fr;
        gap: 44px;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .mt-tape {
        position: absolute;
        top: 0; bottom: 0; left: 0;
        width: 56px;
        background: #e8d6ae;
        border-top: 12px solid #c59b63;
        border-radius: 2px 2px 0 0;
    }
    .mt-tape::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
            repeating-linear-gradient(180deg, rgba(20, 23, 26, .55) 0 1px, transparent 1px 10px),
            repeating-linear-gradient(180deg, rgba(20, 23, 26, .85) 0 1px, transparent 1px 50px);
        background-size: 9px 100%, 18px 100%;
        background-repeat: no-repeat;
        background-position: right top, right top;
    }
    .mt-item { position: relative; padding: 12px 0 0 80px; }
    .mt-item::before {
        content: "";
        position: absolute;
        left: 0; top: 12px;
        width: 68px; height: 2px;
        background: linear-gradient(90deg, #14171a 0 56px, #c59b63 56px);
        z-index: 1;
    }
    .mt-num {
        position: absolute;
        left: 0; top: 12px;
        width: 56px; height: 48px;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Playfair Display', Georgia, serif;
        font-weight: 700;
        font-size: 1.75rem;
        font-variant-numeric: lining-nums;
        color: #14171a;
        z-index: 1;
    }
    .mt-h {
        font-family: 'Playfair Display', Georgia, serif;
        font-weight: 700;
        font-size: 1.25rem;
        line-height: 1.3;
        color: #fbf9f5;
        margin: 0 0 10px;
        text-wrap: balance;
    }
    .mt-p {
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        font-size: .9375rem;
        line-height: 1.7;
        color: rgba(251, 249, 245, .76);
        margin: 0;
        max-width: 44ch;
    }

    /* Desktop: meteran terbentang mendatar, tiap tahap menempel di satu penanda */
    @media (min-width: 1024px) {
        .mt-list {
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
        }
        .mt-tape {
            top: 0; bottom: auto; left: 0; right: 0;
            width: auto; height: 64px;
            border-top: 0;
            border-left: 12px solid #c59b63;
            border-radius: 2px 0 0 2px;
        }
        .mt-tape::before {
            background-image:
                repeating-linear-gradient(90deg, rgba(20, 23, 26, .55) 0 1px, transparent 1px 10px),
                repeating-linear-gradient(90deg, rgba(20, 23, 26, .85) 0 1px, transparent 1px 50px);
            background-size: 100% 9px, 100% 18px;
            background-position: left bottom, left bottom;
        }
        .mt-item { padding: 92px 28px 0 20px; }
        .mt-item::before {
            left: 0; top: 0;
            width: 2px; height: 78px;
            background: linear-gradient(180deg, #14171a 0 64px, #c59b63 64px);
        }
        .mt-item:first-child::before { display: none; }
        .mt-num {
            left: 20px; top: 0;
            width: auto; height: 64px;
            justify-content: flex-start;
            font-size: 1.875rem;
        }
    }
</style>

<section id="mt-section" class="mt-section" aria-labelledby="mt-title">
    <div class="mt-wrap">
        <h2 id="mt-title" class="mt-title">4 Tahapan Jahit Rahmat Tailor</h2>

        <ol class="mt-list">
            <li class="mt-tape" aria-hidden="true" style="list-style:none"></li>

            <li class="mt-item">
                <span class="mt-num" aria-hidden="true">1</span>
                <h3 class="mt-h">Konsultasi dan ukur badan</h3>
                <p class="mt-p">Pilih kain, rancang model kerah dan lapel, lalu badan Anda diukur dengan teliti.</p>
            </li>

            <li class="mt-item">
                <span class="mt-num" aria-hidden="true">2</span>
                <h3 class="mt-h">Pembuatan pola dan potong kain</h3>
                <p class="mt-p">Pola kertas dibuat khusus untuk Anda, lalu kain dipotong di atas meja potong.</p>
            </li>

            <li class="mt-item">
                <span class="mt-num" aria-hidden="true">3</span>
                <h3 class="mt-h">Basting dan fitting</h3>
                <p class="mt-p">Bahan mentah dicocokkan di tubuh Anda untuk mengecek kelonggaran dada, lekuk punggung, dan jatuhnya lengan.</p>
            </li>

            <li class="mt-item">
                <span class="mt-num" aria-hidden="true">4</span>
                <h3 class="mt-h">Sentuhan akhir</h3>
                <p class="mt-p">Kancing dipasang, jahitan disetrika uap, dan hasilnya dicek sekali lagi sebelum Anda ambil.</p>
            </li>
        </ol>
    </div>
</section>