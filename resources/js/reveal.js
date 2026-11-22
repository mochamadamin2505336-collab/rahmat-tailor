import { animate, inView } from "motion";

// Animasi muncul saat section masuk layar, dan diputar ulang setiap kali kembali.
// Saat section keluar sepenuhnya dari layar, isinya direset.
// Tanpa JS, atau dengan reduced motion, semua konten tetap tampil normal.
(function () {
    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

    const EASE = [0.22, 0.7, 0.2, 1];

    // Catatan penting: inView berhenti memantau elemen jika callback masuk
    // tidak mengembalikan fungsi. Karena itu callback masuk selalu me-return fungsi kosong.
    const noop = () => {};

    // ---------- Section biasa: item muncul berurutan ----------
    function setupGeneric(section) {
        let items = Array.from(section.querySelectorAll("[data-reveal-item]"));
        if (!items.length && section.firstElementChild) {
            items = Array.from(section.firstElementChild.children);
        }
        // Lewati elemen yang sudah ditangani .reveal-element di main.js
        items = items.filter((el) => !el.classList.contains("reveal-element"));
        if (!items.length) return;

        let state = "hidden";
        let controls = null;
        let run = 0; // penanda putaran, mencegah animasi lama mengganggu yang baru

        const hide = () => {
            run++;
            if (controls) controls.stop();
            items.forEach((el) => {
                el.style.transition = "none";
                el.style.opacity = "0";
                el.style.removeProperty("transform");
            });
            state = "hidden";
        };

        const play = () => {
            if (state === "shown") return;
            state = "shown";
            const id = ++run;

            controls = animate(
                items,
                { opacity: [0, 1], y: [16, 0] },
                {
                    duration: 0.6,
                    ease: EASE,
                    delay: (i) => Math.min(i, 5) * 0.1,
                },
            );

            // Setelah selesai, kembalikan kendali ke CSS (hover kartu tetap jalan).
            controls.finished.then(() => {
                if (id !== run || state !== "shown") return;
                items.forEach((el) => {
                    el.style.removeProperty("opacity");
                    el.style.removeProperty("transform");
                    el.style.removeProperty("transition");
                });
            });
        };

        hide();

        // Masuk: putar saat 10% section terlihat.
        inView(
            section,
            () => {
                play();
                return noop;
            },
            { amount: 0.1, margin: "0px 0px -6% 0px" },
        );

        // Keluar: reset hanya setelah section benar-benar tidak terlihat.
        inView(section, () => () => hide());
    }

    // ---------- Section meteran (4 tahapan): pita terbentang, lalu tahap muncul ----------
    function setupMeteran(section) {
        const title = section.querySelector(".mt-title");
        const tape = section.querySelector(".mt-tape");
        const steps = Array.from(section.querySelectorAll(".mt-item"));
        if (!tape || !steps.length) return;

        const desktop = window.matchMedia("(min-width: 1024px)");
        // Desktop: pita terbentang ke kanan. Mobile: pita terbentang ke bawah.
        const hiddenClip = () =>
            desktop.matches ? "inset(0 100% 0 0)" : "inset(0 0 100% 0)";

        let state = "hidden";
        let running = [];
        let run = 0;

        const hide = () => {
            run++;
            running.forEach((c) => c.stop());
            running = [];
            if (title) {
                title.style.opacity = "0";
                title.style.removeProperty("transform");
            }
            tape.style.clipPath = hiddenClip();
            steps.forEach((el) => {
                el.style.opacity = "0";
                el.style.removeProperty("transform");
            });
            state = "hidden";
        };

        const play = () => {
            if (state === "shown") return;
            state = "shown";
            const id = ++run;

            if (title) {
                running.push(
                    animate(
                        title,
                        { opacity: [0, 1], y: [16, 0] },
                        { duration: 0.6, ease: EASE },
                    ),
                );
            }
            running.push(
                animate(
                    tape,
                    { clipPath: [hiddenClip(), "inset(0 0 0 0)"] },
                    { duration: 1.3, ease: EASE, delay: 0.15 },
                ),
            );
            running.push(
                animate(
                    steps,
                    { opacity: [0, 1], y: [8, 0] },
                    { duration: 0.5, ease: EASE, delay: (i) => 0.35 + i * 0.3 },
                ),
            );

            Promise.all(running.map((c) => c.finished)).then(() => {
                if (id !== run || state !== "shown") return;
                [title, tape, ...steps].forEach((el) => {
                    if (!el) return;
                    el.style.removeProperty("opacity");
                    el.style.removeProperty("transform");
                    el.style.removeProperty("clip-path");
                });
            });
        };

        hide();

        inView(
            section,
            () => {
                play();
                return noop;
            },
            { amount: 0.15, margin: "0px 0px -6% 0px" },
        );
        inView(section, () => () => hide());
    }

    // ---------- Pasang ke semua section ----------
    document.querySelectorAll("section").forEach((section) => {
        if (section.classList.contains("hero-gelap")) return; // hero punya animasi sendiri
        if (section.classList.contains("mt-section")) {
            setupMeteran(section);
        } else {
            setupGeneric(section);
        }
    });
})();
