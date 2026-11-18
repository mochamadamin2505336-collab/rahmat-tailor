import { animate } from "motion";

function initAnatomy3D() {
    const wrapper = document.getElementById("anatomy-3d-wrapper");
    const stage = document.getElementById("anatomy-3d-stage");
    const svg3d = document.getElementById("anatomy-svg-3d");
    const modalTag = document.getElementById("modal-tag");
    const resetBtn = document.getElementById("reset-3d-angle");

    const refLine = document.getElementById("svg-tape-line");
    const frontArc = document.getElementById("tape-3d-front");
    const backArc = document.getElementById("tape-3d-back");
    const c1 = document.getElementById("tape-3d-c1");
    const c2 = document.getElementById("tape-3d-c2");
    const frontGroup = document.getElementById("tape-3d-front-group");

    if (!wrapper || !stage || !svg3d || !refLine) return;
    if (wrapper.dataset.ready3d === "true") return;
    wrapper.dataset.ready3d = "true";

    // Ambil elemen siluet tubuh & kepala di dalam SVG untuk proyeksi 3D
    const headEl = svg3d.querySelector("circle");
    const bodyEl = svg3d.querySelector("path[fill^='url(#body3dGrad)']");
    const hintBadge = wrapper.querySelector("span");

    // State sudut rotasi 360 derajat
    let angleY = 0;
    let angleX = 0;
    let isDragging = false;
    let lastX = 0;
    let lastY = 0;

    // Koordinat dasar dari measureGuides
    let coords = { x1: 58, y1: 114, x2: 142, y2: 114 };

    // 1. Animasi melayang lembut pada wadah panggung
    animate(
        stage,
        { y: [-3, 3, -3] },
        { duration: 3.6, repeat: Infinity, ease: "easeInOut" },
    );

    // 2. Fungsi Render Proyeksi 3D Penuh 360°
    function render3D() {
        const rad = (angleY * Math.PI) / 180;
        const cosY = Math.cos(rad); // 1 = depan, 0 = samping (90°/270°), -1 = belakang (180°)
        const sinY = Math.sin(rad);

        // Skala lebar tubuh saat berputar ke samping (tidak pernah gepeng 0px)
        const bodyScaleX = 0.52 + 0.48 * Math.abs(cosY);

        // Terapkan perspektif 3D pada SVG
        const tiltY = sinY * 26;
        svg3d.style.transform = `translateZ(16px) rotateX(${angleX.toFixed(1)}deg) rotateY(${tiltY.toFixed(1)}deg)`;

        // Proyeksikan lebar siluet tubuh & kepala secara volumetrik
        if (bodyEl) {
            bodyEl.setAttribute(
                "transform",
                `translate(100, 0) scale(${bodyScaleX.toFixed(3)}, 1) translate(-100, 0)`,
            );
        }
        if (headEl) {
            headEl.setAttribute("cx", (100 + sinY * 3).toFixed(1));
            headEl.setAttribute(
                "rx",
                (16 * (0.85 + 0.15 * Math.abs(cosY))).toFixed(1),
            );
        }

        // Update indikator derajat putaran
        const normalizedDeg = ((Math.round(angleY) % 360) + 360) % 360;
        if (hintBadge) {
            const sisi =
                normalizedDeg >= 315 || normalizedDeg < 45
                    ? "Depan"
                    : normalizedDeg < 135
                      ? "Samping Kanan"
                      : normalizedDeg < 225
                        ? "Belakang"
                        : "Samping Kiri";
            hintBadge.textContent = `Geser 360° • ${sisi} (${normalizedDeg}°)`;
        }

        // Hitung proyeksi pita meteran emas
        const { x1, y1, x2, y2 } = coords;
        const isHorizontalWrap = Math.abs(y2 - y1) < 8;

        if (isHorizontalWrap) {
            const cx = (x1 + x2) / 2;
            const cy = (y1 + y2) / 2;
            const halfW = (Math.abs(x2 - x1) / 2) * bodyScaleX;
            const curveDepth = Math.max(8, halfW * 0.34);

            const leftX = cx - halfW;
            const rightX = cx + halfW;

            // Pita depan (garis penuh) & pita belakang (putus-putus)
            frontArc?.setAttribute(
                "d",
                `M ${leftX.toFixed(1)} ${cy} Q ${cx} ${(cy + curveDepth).toFixed(1)} ${rightX.toFixed(1)} ${cy}`,
            );
            frontArc?.setAttribute("stroke-opacity", "1");
            frontArc?.removeAttribute("stroke-dasharray");
            frontArc?.setAttribute("stroke-width", "4");

            if (backArc) {
                backArc.style.opacity = "1";
                backArc.setAttribute(
                    "d",
                    `M ${leftX.toFixed(1)} ${cy} Q ${cx} ${(cy - curveDepth).toFixed(1)} ${rightX.toFixed(1)} ${cy}`,
                );
            }

            // Kedua titik ujung pita ikut mengorbit 360° mengelilingi tubuh
            const dot1X = cx + Math.cos(rad) * halfW;
            const dot1Y = cy + Math.sin(rad) * curveDepth;
            const dot2X = cx + Math.cos(rad + Math.PI) * halfW;
            const dot2Y = cy + Math.sin(rad + Math.PI) * curveDepth;

            if (c1) {
                c1.setAttribute("cx", dot1X.toFixed(1));
                c1.setAttribute("cy", dot1Y.toFixed(1));
                c1.setAttribute(
                    "opacity",
                    Math.sin(rad) >= -0.15 ? "1" : "0.4",
                );
            }
            if (c2) {
                c2.setAttribute("cx", dot2X.toFixed(1));
                c2.setAttribute("cy", dot2Y.toFixed(1));
                c2.setAttribute(
                    "opacity",
                    Math.sin(rad + Math.PI) >= -0.15 ? "1" : "0.4",
                );
            }
        } else {
            // Garis ukur vertikal / diagonal (Panjang Baju, Celana, Lengan, Pesak, Rok)
            const px1 = 100 + (x1 - 100) * bodyScaleX + sinY * 10;
            const px2 = 100 + (x2 - 100) * bodyScaleX + sinY * 10;
            const midX = (px1 + px2) / 2;
            const midY = (y1 + y2) / 2;
            const bendX = midX < 100 ? -6 : 6;

            frontArc?.setAttribute(
                "d",
                `M ${px1.toFixed(1)} ${y1} Q ${(midX + bendX).toFixed(1)} ${midY} ${px2.toFixed(1)} ${y2}`,
            );
            frontArc?.setAttribute("stroke-opacity", "1");
            frontArc?.removeAttribute("stroke-dasharray");
            frontArc?.setAttribute("stroke-width", "4");

            if (backArc) backArc.style.opacity = "0";

            if (c1) {
                c1.setAttribute("cx", px1.toFixed(1));
                c1.setAttribute("cy", y1);
                c1.setAttribute("opacity", "1");
            }
            if (c2) {
                c2.setAttribute("cx", px2.toFixed(1));
                c2.setAttribute("cy", y2);
                c2.setAttribute("opacity", "1");
            }
        }
    }

    // 3. Event Mouse & Touch Langsung ke Window (Bebas PointerCancel)
    wrapper.addEventListener("mousedown", (e) => {
        if (e.target.closest("#reset-3d-angle")) return;
        isDragging = true;
        lastX = e.clientX;
        lastY = e.clientY;
        e.preventDefault();
    });

    window.addEventListener("mousemove", (e) => {
        if (!isDragging) return;
        const dx = e.clientX - lastX;
        const dy = e.clientY - lastY;

        angleY += dx * 0.85;
        angleX = Math.max(-22, Math.min(22, angleX - dy * 0.4));

        lastX = e.clientX;
        lastY = e.clientY;
        render3D();
    });

    window.addEventListener("mouseup", () => {
        if (!isDragging) return;
        isDragging = false;
        animate(angleX, 0, {
            type: "spring",
            stiffness: 220,
            damping: 20,
            onUpdate: (v) => {
                angleX = v;
                render3D();
            },
        });
    });

    // Dukungan layar sentuh HP/tablet
    wrapper.addEventListener(
        "touchstart",
        (e) => {
            if (e.target.closest("#reset-3d-angle") || !e.touches[0]) return;
            isDragging = true;
            lastX = e.touches[0].clientX;
            lastY = e.touches[0].clientY;
        },
        { passive: true },
    );

    window.addEventListener(
        "touchmove",
        (e) => {
            if (!isDragging || !e.touches[0]) return;
            const dx = e.touches[0].clientX - lastX;
            const dy = e.touches[0].clientY - lastY;

            angleY += dx * 0.95;
            angleX = Math.max(-22, Math.min(22, angleX - dy * 0.4));

            lastX = e.touches[0].clientX;
            lastY = e.touches[0].clientY;
            render3D();
        },
        { passive: true },
    );

    window.addEventListener("touchend", () => {
        if (!isDragging) return;
        isDragging = false;
        animate(angleX, 0, {
            type: "spring",
            stiffness: 220,
            damping: 20,
            onUpdate: (v) => {
                angleX = v;
                render3D();
            },
        });
    });

    // Tombol Reset Posisi dengan animasi spring
    if (resetBtn) {
        resetBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            const targetNearestZero = Math.round(angleY / 360) * 360;
            animate(angleY, targetNearestZero, {
                type: "spring",
                stiffness: 170,
                damping: 20,
                onUpdate: (v) => {
                    angleY = v;
                    render3D();
                },
                onComplete: () => {
                    angleY = 0;
                    render3D();
                },
            });
            animate(angleX, 0, {
                type: "spring",
                stiffness: 170,
                damping: 20,
                onUpdate: (v) => {
                    angleX = v;
                    render3D();
                },
            });
        });
    }

    // 4. Sinkronisasi Otomatis saat Titik Ukur Berganti
    function syncFromRefLine() {
        coords = {
            x1: parseFloat(refLine.getAttribute("x1") || 58),
            y1: parseFloat(refLine.getAttribute("y1") || 114),
            x2: parseFloat(refLine.getAttribute("x2") || 142),
            y2: parseFloat(refLine.getAttribute("y2") || 114),
        };

        render3D();

        if (frontGroup) {
            animate(
                frontGroup,
                { opacity: [0.4, 1] },
                { duration: 0.35, ease: "easeOut" },
            );
        }

        if (modalTag) {
            animate(
                modalTag,
                { scale: [0.94, 1], y: [4, 0] },
                { type: "spring", stiffness: 300, damping: 20 },
            );
        }
    }

    const observer = new MutationObserver(syncFromRefLine);
    observer.observe(refLine, {
        attributes: true,
        attributeFilter: ["x1", "y1", "x2", "y2"],
    });

    syncFromRefLine();
}

// Jalankan langsung jika DOM sudah siap, atau tunggu DOMContentLoaded
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initAnatomy3D);
} else {
    initAnatomy3D();
}
