import "./anatomi3d.js";
import { animate, stagger, inView } from "motion";
import "./reveal.js"

export const measureGuides = {
    // CELANA
    lingkar_pinggang: {
        title: "Panduan Mengukur Lingkar Pinggang",
        tag: "Garis Ukur: Posisi Ban Sabuk / Lekuk Pinggang",
        instruction:
            "Lilitkan pita meteran melingkari badan tepat pada posisi pinggang tempat ban sabuk atau celana biasa Anda kenakan. Berdirilah santai dan bernapas biasa.",
        tips: "Beri ruang kelonggaran sekitar 1 jari tangan di sela meteran. Jangan menarik napas terlalu dalam atau menahan perut ke dalam.",
        line: { x1: 58, y1: 114, x2: 142, y2: 114 },
    },
    lingkar_panggul: {
        title: "Panduan Mengukur Lingkar Panggul",
        tag: "Garis Ukur: Bagian Pantat/Panggul Paling Berisi",
        instruction:
            "Lilitkan pita meteran melintang secara horizontal melingkari pinggul dan pantat pada bagian yang paling menonjol.",
        tips: "Rapatkan kedua tumit dan kaki saat pengukuran dilakukan agar draperi celana/rok tidak terasa sempit saat melangkah.",
        line: { x1: 56, y1: 138, x2: 144, y2: 138 },
    },
    lingkar_pesak: {
        title: "Panduan Mengukur Lingkar Pesak (Selangkang)",
        tag: "Garis Ukur: Ban Depan Lewat Selangkang ke Belakang",
        instruction:
            "Tarik pita meteran mulai dari batas atas ban pinggang celana bagian depan, lewat bawah selangkangan kaki secara leluasa, hingga bertemu di batas atas ban pinggang belakang.",
        tips: "Pegang meteran dalam posisi agak santai (beri kelonggaran 2-3 cm) agar celana tidak menjepit atau terasa begah saat berjongkok dan mengemudi.",
        line: { x1: 96, y1: 114, x2: 104, y2: 162 },
    },
    lingkar_paha: {
        title: "Panduan Mengukur Lingkar Paha",
        tag: "Garis Ukur: Keliling Pangkal Paha Tertinggi",
        instruction:
            "Lilitkan pita meteran pada pangkal paha tertinggi (tepat di bawah garis selangkangan) yang merupakan bagian paha paling besar.",
        tips: "Selipkan 1-2 jari tangan di dalam meteran agar potongan celana tailored jatuh rapi tanpa menjiplak paha secara berlebihan.",
        line: { x1: 65, y1: 158, x2: 95, y2: 158 },
    },
    lingkar_lutut: {
        title: "Panduan Mengukur Lingkar Lutut",
        tag: "Garis Ukur: Melingkari Tempurung Lutut",
        instruction:
            "Lilitkan pita meteran melingkari tepat pada tempurung lutut dalam posisi kaki berdiri santai atau sedikit ditekuk.",
        tips: "Ukuran ini krusial untuk memastikan kenyamanan celana berpotongan slim-fit saat Anda menekuk lutut duduk.",
        line: { x1: 68, y1: 190, x2: 92, y2: 190 },
    },
    lingkar_celana_bawah: {
        title: "Panduan Mengukur Lingkar Celana Bawah",
        tag: "Garis Ukur: Bukaan Ujung Kaki (Leg Opening)",
        instruction:
            "Tentukan keliling bukaan lubang kaki celana bawah yang Anda inginkan (misal model slim 34-36 cm, atau model classic fit 38-42 cm).",
        tips: "Bisa diukur dari celana favorit Anda yang sudah jadi dengan mengukur lebar ujung kaki lalu dikalikan dua.",
        line: { x1: 60, y1: 228, x2: 95, y2: 228 },
    },
    panjang_celana: {
        title: "Panduan Mengukur Panjang Celana",
        tag: "Garis Ukur: Ban Pinggang Luar ke Batas Sepatu",
        instruction:
            "Tarik pita meteran dari sisi pinggang (posisi sabuk) lurus ke bawah di sepanjang sisi luar paha dan kaki sampai batas tumit atau sol atas sepatu.",
        tips: "Sebaiknya kenakan sepatu formal yang biasa Anda pakai agar jatuhnya break celana (no-break, slight break) presisi.",
        line: { x1: 58, y1: 114, x2: 58, y2: 232 },
    },

    // BAJU
    lebar_punggung: {
        title: "Panduan Mengukur Lebar Punggung",
        tag: "Garis Ukur: Lipatan Ketiak Kiri ke Kanan Belakang",
        instruction:
            "Ukur secara horizontal pada bagian punggung belakang, tepat di antara batas lipatan ketiak kiri dan ketiak kanan (sekitar 8-10 cm di bawah kerah leher).",
        tips: "Paling baik diukur dengan bantuan orang lain selagi kedua tangan Anda menggantung santai di samping tubuh.",
        line: { x1: 54, y1: 76, x2: 146, y2: 76 },
    },
    lebar_bahu: {
        title: "Panduan Mengukur Lebar Bahu",
        tag: "Garis Ukur: Ujung Tulang Bahu Kiri ke Kanan",
        instruction:
            "Ukur dari ujung tulang bahu paling luar sebelah kiri melintasi pangkal leher belakang hingga ke ujung tulang bahu sebelah kanan.",
        tips: "Berdirilah dalam posisi rileks alami. Jangan mengangkat bahu atau membungkuk agar panjang garis bahu tidak menyempit.",
        line: { x1: 44, y1: 58, x2: 156, y2: 58 },
    },
    panjang_lengan: {
        title: "Panduan Mengukur Panjang Lengan",
        tag: "Garis Ukur: Puncak Bahu ke Ujung Pergelangan",
        instruction:
            "Mulai dari puncak tulang bahu, tarik pita meteran melewati siku yang sedikit ditekuk hingga mencapai tonjolan tulang pergelangan tangan (atau batas manset).",
        tips: "Sedikit tekuk siku tangan sekitar 15 derajat agar kemeja atau jas tidak menggantung naik saat Anda menekuk tangan.",
        line: { x1: 156, y1: 58, x2: 166, y2: 165 },
    },
    lingkar_lengan_atas: {
        title: "Panduan Mengukur Lingkar Lengan Atas",
        tag: "Garis Ukur: Keliling Otot Bisep Terbesar",
        instruction:
            "Lilitkan pita meteran melingkar pada otot lengan atas (bisep) yang paling berisi saat posisi tangan lurus rileks.",
        tips: "Jangan mengepalkan atau menegangkan otot lengan. Tambahkan kelonggaran 2 cm untuk kenyamanan gerak.",
        line: { x1: 145, y1: 96, x2: 163, y2: 96 },
    },
    lingkar_lengan_bawah: {
        title: "Panduan Mengukur Lingkar Lengan Bawah",
        tag: "Garis Ukur: Ujung Manset / Pergelangan Tangan",
        instruction:
            "Lilitkan meteran melingkari pergelangan tangan pas di atas tulang pergelangan sesuai bukaan manset kancing yang biasa Anda kenakan.",
        tips: "Jika sering memakai jam tangan formal tebal, berikan kelonggaran ekstra 1 cm pada pergelangan tangan kiri.",
        line: { x1: 154, y1: 156, x2: 168, y2: 156 },
    },
    lingkar_dada: {
        title: "Panduan Mengukur Lingkar Dada",
        tag: "Garis Ukur: Puncak Dada Terbesar (Bust Point)",
        instruction:
            "Lilitkan pita meteran melingkari badan melewati puncak dada tertinggi secara horizontal. Pastikan meteran di punggung sejajar dan tidak melorot.",
        tips: "Beri ruang kelonggaran 1-2 jari tangan di dalam pita meteran. Jangan membusungkan dada atau menahan napas saat membaca angka.",
        line: { x1: 52, y1: 88, x2: 148, y2: 88 },
    },
    panjang_baju: {
        title: "Panduan Mengukur Panjang Baju",
        tag: "Garis Ukur: Bahu hingga Betis",
        instruction:
            "Tarik meteran tegak lurus dari pangkal bahu dekat leher melewati badan hingga ke batas betis tempat baju atau gamis berakhir.",
        tips: "Berdirilah tegak dengan kaki rapat dan minta bantuan orang lain agar meteran tetap lurus dari bahu sampai betis.",
        line: { x1: 78, y1: 48, x2: 78, y2: 190 },
    },

    // ROK
    panjang_rok: {
        title: "Panduan Mengukur Panjang Rok",
        tag: "Garis Ukur: Ban Pinggang ke Batas Keliman Rok",
        instruction:
            "Ukur dari garis ban pinggang tempat rok dipakai, lurus ke bawah di samping badan sampai ke batas lutut, betis, atau mata kaki sesuai siluet rok yang diinginkan.",
        tips: "Pastikan pandangan tetap lurus ke depan saat diukur oleh pendamping, karena membungkuk dapat memendekkan hasil ukuran hingga 3 cm.",
        line: { x1: 142, y1: 114, x2: 142, y2: 215 },
    },
};

export function openMeasureModal(key) {
    const data = measureGuides[key];
    if (!data) return;

    if (typeof window.updateMeasurement3D === "function") {
        const map = {
            lingkar_dada: "dada",
            lingkar_pinggang: "pinggang",
            lingkar_panggul: "pinggul",
        };
        window.updateMeasurement3D(map[key] || "pinggang");
    }

    const titleEl = document.getElementById("modal-title");
    const tagEl = document.getElementById("modal-tag");
    const instEl = document.getElementById("modal-instruction");
    const tipsEl = document.getElementById("modal-tips");

    if (titleEl) titleEl.textContent = data.title;
    if (tagEl) tagEl.textContent = data.tag;
    if (instEl) instEl.textContent = data.instruction;
    if (tipsEl) tipsEl.textContent = data.tips;

    const line = document.getElementById("svg-tape-line");
    const c1 = document.getElementById("svg-tape-c1");
    const c2 = document.getElementById("svg-tape-c2");

    if (line && c1 && c2 && data.line) {
        line.setAttribute("x1", data.line.x1);
        line.setAttribute("y1", data.line.y1);
        line.setAttribute("x2", data.line.x2);
        line.setAttribute("y2", data.line.y2);

        c1.setAttribute("cx", data.line.x1);
        c1.setAttribute("cy", data.line.y1);

        c2.setAttribute("cx", data.line.x2);
        c2.setAttribute("cy", data.line.y2);
    }

    const modal = document.getElementById("measure-modal");
    const card = document.getElementById("measure-modal-card");
    if (modal && card) {
        modal.classList.remove("opacity-0", "pointer-events-none");
        modal.setAttribute("aria-hidden", "false");
        card.classList.remove("scale-95");
        card.classList.add("scale-100");
        document.body.style.overflow = "hidden";
    }
}

export function closeMeasureModal() {
    const modal = document.getElementById("measure-modal");
    const card = document.getElementById("measure-modal-card");
    if (modal && card) {
        card.classList.remove("scale-100");
        card.classList.add("scale-95");
        modal.classList.add("opacity-0", "pointer-events-none");
        modal.setAttribute("aria-hidden", "true");
        document.body.style.overflow = "";
    }
}

export function switchMainTab(tab) {
    const paneBooking = document.getElementById("pane-booking");
    const paneOnline = document.getElementById("pane-online");
    const btnBooking = document.getElementById("tab-booking-btn");
    const btnOnline = document.getElementById("tab-online-btn");

    if (!paneBooking || !paneOnline || !btnBooking || !btnOnline) return;

    if (tab === "booking") {
        paneBooking.classList.remove("hidden");
        paneOnline.classList.add("hidden");
        btnBooking.className =
            "flex-1 sm:flex-initial flex items-center justify-center gap-2 px-5 py-3 rounded-md text-xs sm:text-sm font-semibold uppercase tracking-wider transition-all duration-300 bg-[#BA8B4E] text-white shadow-md";
        btnOnline.className =
            "flex-1 sm:flex-initial flex items-center justify-center gap-2 px-5 py-3 rounded-md text-xs sm:text-sm font-semibold uppercase tracking-wider transition-all duration-300 text-neutral-600 hover:text-[#14171A]";
    } else {
        paneBooking.classList.add("hidden");
        paneOnline.classList.remove("hidden");
        btnOnline.className =
            "flex-1 sm:flex-initial flex items-center justify-center gap-2 px-5 py-3 rounded-md text-xs sm:text-sm font-semibold uppercase tracking-wider transition-all duration-300 bg-[#BA8B4E] text-white shadow-md";
        btnBooking.className =
            "flex-1 sm:flex-initial flex items-center justify-center gap-2 px-5 py-3 rounded-md text-xs sm:text-sm font-semibold uppercase tracking-wider transition-all duration-300 text-neutral-600 hover:text-[#14171A]";
    }
}

export function selectGarmentCategory(cat) {
    const curGarment = document.getElementById("current-garment");
    if (curGarment) curGarment.value = cat;

    // Toggle tombol active state
    document.querySelectorAll(".garment-btn").forEach((btn) => {
        const isTarget = btn.dataset.target === cat;
        if (isTarget) {
            btn.className =
                "garment-btn p-3 rounded-lg border-2 border-[#BA8B4E] bg-[#FAF4EB] text-center transition-all flex flex-col items-center justify-center gap-1 shadow-xs cursor-pointer";
            const icon = btn.querySelector(".material-symbols-outlined");
            if (icon)
                icon.className =
                    "material-symbols-outlined text-[#BA8B4E] text-[24px]";
            const text = btn.querySelector("span:last-child");
            if (text) text.className = "text-xs font-bold text-[#14171A]";
        } else {
            btn.className =
                "garment-btn p-3 rounded-lg border border-[#E5DFD5] bg-[#FAF8F5] hover:bg-[#F3EFE7] text-center transition-all flex flex-col items-center justify-center gap-1 cursor-pointer";
            const icon = btn.querySelector(".material-symbols-outlined");
            if (icon)
                icon.className =
                    "material-symbols-outlined text-neutral-500 text-[24px]";
            const text = btn.querySelector("span:last-child");
            if (text) text.className = "text-xs font-semibold text-[#14171A]";
        }
    });

    // Toggle fields container
    const paneCategory = cat === "kebaya" ? "baju" : cat;

    ["celana", "baju", "rok", "seragam"].forEach((c) => {
        const pane = document.getElementById("pane-fields-" + c);
        if (pane) {
            const active = c === paneCategory;
            pane.classList.toggle("hidden", !active);
            pane.querySelectorAll("input, select, textarea").forEach(
                (field) => {
                    field.disabled = !active;
                    if (field.type === "number") {
                        field.required = active;
                    }
                },
            );
        }
    });
}

// Expose functions globally for inline HTML event handlers (e.g. onclick="...")
if (typeof window !== "undefined") {
    window.openMeasureModal = openMeasureModal;
    window.closeMeasureModal = closeMeasureModal;
    window.switchMainTab = switchMainTab;
    window.selectGarmentCategory = selectGarmentCategory;
}

// Event-driven initializations
document.addEventListener("DOMContentLoaded", () => {
    // Delegasi event agar kategori dan panduan tetap berfungsi meskipun atribut inline
    // tidak dieksekusi oleh browser.
    document.addEventListener("click", (event) => {
        const garmentButton = event.target.closest(".garment-btn");
        if (garmentButton) {
            event.preventDefault();
            selectGarmentCategory(garmentButton.dataset.target);
            return;
        }

        const guideButton = event.target.closest(
            'button[onclick^="openMeasureModal"]',
        );
        if (guideButton) {
            event.preventDefault();
            const match = guideButton
                .getAttribute("onclick")
                ?.match(/openMeasureModal\('([^']+)'\)/);
            if (match) openMeasureModal(match[1]);
            return;
        }

        const closeGuideButton = event.target.closest(
            'button[onclick^="closeMeasureModal"]',
        );
        if (closeGuideButton) {
            event.preventDefault();
            closeMeasureModal();
        }
    });

    const currentCategory =
        document.getElementById("current-garment")?.value || "celana";
    selectGarmentCategory(currentCategory);

    const modal = document.getElementById("measure-modal");
    if (modal) {
        modal.addEventListener("click", function (e) {
            if (e.target === this) closeMeasureModal();
        });
    }

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") closeMeasureModal();
    });

    const orderForm = document.getElementById("online-order-form");
    if (orderForm) {
        orderForm.addEventListener("submit", async (event) => {
            event.preventDefault();

            const submitButton = orderForm.querySelector(
                'button[type="submit"]',
            );
            const successBox = document.getElementById(
                "online-order-success-box",
            );
            const errorBox = document.getElementById("online-order-error-box");
            const codeBox = document.getElementById("kode-nota-pesanan");

            if (errorBox) {
                errorBox.classList.add("hidden");
                errorBox.textContent = "";
            }
            if (submitButton) submitButton.disabled = true;

            const category =
                document.getElementById("current-garment")?.value || "celana";
            const paneCategory = category === "kebaya" ? "baju" : category;
            const inputs = Array.from(
                document.querySelectorAll(
                    `#pane-fields-${paneCategory} input[type="number"]`,
                ),
            );

            const fieldsByCategory = {
                celana: [
                    "lingkar_pinggang_celana",
                    "lingkar_panggul_celana",
                    "lingkar_pesak",
                    "lingkar_paha",
                    "lingkar_lutut",
                    "lingkar_celana_bawah",
                    "panjang_celana",
                ],
                baju: [
                    "lebar_punggung",
                    "lebar_bahu",
                    "panjang_lengan",
                    "lingkar_lengan_atas",
                    "lingkar_lengan_bawah",
                    "lingkar_dada",
                    "lingkar_pinggang_baju",
                    "lingkar_panggul_baju",
                    "panjang_baju",
                ],
                rok: [
                    "lingkar_pinggang_rok",
                    "lingkar_panggul_rok",
                    "panjang_rok",
                ],
            };

            const seragamFields = [
                "lingkar_pinggang_celana",
                "lingkar_panggul_celana",
                "lingkar_pesak",
                "lingkar_paha",
                "lingkar_lutut",
                "lingkar_celana_bawah",
                "panjang_celana",
                "lebar_punggung",
                "lebar_bahu",
                "panjang_lengan",
                "lingkar_lengan_atas",
                "lingkar_lengan_bawah",
                "lingkar_dada",
                "lingkar_pinggang_baju",
                "lingkar_panggul_baju",
                "panjang_baju",
            ];

            const fields =
                category === "seragam"
                    ? seragamFields
                    : fieldsByCategory[paneCategory] || [];

            const formData = new FormData();
            formData.append(
                "layanan_id",
                document.getElementById("layanan-id")?.value || "",
            );
            formData.append("kategori_busana", category);
            formData.append(
                "bahan",
                orderForm.querySelector('input[name="fab_source"]:checked')
                    ?.value || "sendiri",
            );
            formData.append("ukuran_di_toko", "0");
            formData.append(
                "target_tanggal",
                document.getElementById("target-tanggal")?.value || "",
            );
            formData.append(
                "catatan",
                document.getElementById("catatan-pesanan")?.value || "",
            );

            fields.forEach((field, index) => {
                const value =
                    category === "seragam"
                        ? document.querySelectorAll(
                              '#pane-fields-seragam input[type="number"]',
                          )[index]?.value
                        : inputs[index]?.value;
                if (value) formData.append(`ukuran[${field}]`, value);
            });

            const fileInput = document.getElementById("file-upload-input");
            if (fileInput?.files?.length)
                formData.append("foto_referensi", fileInput.files[0]);

            const token = document.querySelector(
                'meta[name="csrf-token"]',
            )?.content;
            try {
                const response = await fetch("/api/pesanan", {
                    method: "POST",
                    headers: {
                        Accept: "application/json",
                        "X-CSRF-TOKEN": token || "",
                    },
                    body: formData,
                });
                const result = await response.json();

                if (!response.ok) {
                    const messages = result.errors
                        ? Object.values(result.errors).flat()
                        : [result.message || "Pesanan belum dapat dikirim."];
                    if (errorBox) {
                        errorBox.textContent = messages.join(" ");
                        errorBox.classList.remove("hidden");
                    }
                    return;
                }

                if (codeBox) codeBox.textContent = `KODE NOTA: #${result.kode}`;
                if (successBox) successBox.classList.remove("hidden");
                successBox?.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
                orderForm.reset();
            } catch (error) {
                if (errorBox) {
                    errorBox.textContent =
                        "Pesanan belum dapat dikirim karena koneksi bermasalah.";
                    errorBox.classList.remove("hidden");
                }
            } finally {
                if (submitButton) submitButton.disabled = false;
            }
        });
    }
});
