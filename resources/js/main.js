import "@google/model-viewer";
import "./reveal";
document.addEventListener("DOMContentLoaded", () => {
    // 1. Dynamic Interactive Underline Indicator for Navbar
    const mainNav = document.getElementById("main-nav");
    const navItems = document.querySelectorAll(".nav-item");
    const indicator = document.getElementById("nav-indicator");

    if (mainNav && indicator && navItems.length > 0) {
        let activeItem =
            document.querySelector('.nav-item[aria-current="page"]') ||
            navItems[0];

        const updateIndicator = (target) => {
            if (!target) return;
            const navRect = mainNav.getBoundingClientRect();
            const targetRect = target.getBoundingClientRect();
            const left = targetRect.left - navRect.left;
            const width = targetRect.width;

            indicator.style.left = `${left}px`;
            indicator.style.width = `${width}px`;
            indicator.style.opacity = "1";
        };

        const setActive = (target) => {
            navItems.forEach((item) => {
                item.removeAttribute("aria-current");
                item.classList.remove("text-primary", "font-semibold");
                item.classList.add("text-gray-300", "font-medium");
            });
            target.setAttribute("aria-current", "page");
            target.classList.add("text-primary", "font-semibold");
            target.classList.remove("text-gray-300", "font-medium");
            activeItem = target;
            updateIndicator(target);
        };

        // Dipanggil dari menu mobile agar status aktif desktop ikut sinkron
        mainNav.addEventListener("nav:activate", (e) => {
            if (e.detail) setActive(e.detail);
        });

        // Set initial position
        updateIndicator(activeItem);

        navItems.forEach((item) => {
            item.addEventListener("click", (e) => {
                // If clicking an internal hash link on the same page
                const href = item.getAttribute("href");
                if (href && href.startsWith("#")) {
                    setActive(item);
                }
            });

            item.addEventListener("mouseenter", () => {
                updateIndicator(item);
            });
        });

        mainNav.addEventListener("mouseleave", () => {
            updateIndicator(activeItem);
        });

        window.addEventListener("resize", () => {
            updateIndicator(activeItem);
        });

        // ScrollSpy on homepage sections to auto-update navbar indicator
        const homeSections = document.querySelectorAll("section[id]");
        if (homeSections.length > 0) {
            window.addEventListener("scroll", () => {
                const scrollPosition = window.scrollY + 120;
                let currentSectionId = "";

                homeSections.forEach((section) => {
                    const top = section.offsetTop;
                    const height = section.offsetHeight;
                    if (
                        scrollPosition >= top &&
                        scrollPosition < top + height
                    ) {
                        currentSectionId = section.getAttribute("id");
                    }
                });

                if (window.scrollY < 200) {
                    const berandaItem = document.querySelector(
                        '.nav-item[data-path="beranda"]',
                    );
                    if (berandaItem && activeItem !== berandaItem) {
                        setActive(berandaItem);
                    }
                } else if (currentSectionId) {
                    const matchingItem = document.querySelector(
                        `.nav-item[data-path="${currentSectionId}"], .nav-item[href="#${currentSectionId}"]`,
                    );
                    if (matchingItem && activeItem !== matchingItem) {
                        setActive(matchingItem);
                    }
                }
            });
        }
    }

    // 2. Intersection Observer for Scroll Reveals
    const observerOptions = {
        root: null,
        rootMargin: "0px",
        threshold: 0.12,
    };

    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("is-visible");
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll(".reveal-element").forEach((el) => {
        revealObserver.observe(el);
    });

    // 3. Interactive Portfolio Filtering Tabs
    const filterTabs = document.querySelectorAll(".gallery-tab");
    const galleryCards = document.querySelectorAll(".gallery-card");

    filterTabs.forEach((tab) => {
        tab.addEventListener("click", () => {
            const filter = tab.getAttribute("data-filter");

            // Toggle active states on tabs
            filterTabs.forEach((t) => {
                t.classList.remove(
                    "bg-white",
                    "text-charcoal",
                    "shadow-sm",
                    "font-semibold",
                    "border-b-2",
                    "border-primary",
                );
                t.classList.add("text-on-surface-variant");
            });
            tab.classList.add(
                "bg-white",
                "text-charcoal",
                "shadow-sm",
                "font-semibold",
                "border-b-2",
                "border-primary",
            );
            tab.classList.remove("text-on-surface-variant");

            // Filter and animate cards
            galleryCards.forEach((card) => {
                const category = card.getAttribute("data-category");
                if (filter === "all" || category === filter) {
                    card.classList.remove("filter-hidden");
                    setTimeout(() => {
                        card.style.opacity = "1";
                        card.style.transform = "translateY(0) scale(1)";
                    }, 20);
                } else {
                    card.style.opacity = "0";
                    card.style.transform = "scale(0.95)";
                    setTimeout(() => {
                        card.classList.add("filter-hidden");
                    }, 300);
                }
            });
        });
    });

    // 4. Quick Order Tracker Micro-Interaction
    const trackerForm = document.getElementById("tracker-form");
    const trackerInput = document.getElementById("tracker-input");
    const trackerResult = document.getElementById("tracker-result");
    const trackerSpinner = document.getElementById("tracker-spinner");
    const trackerBtnText = document.getElementById("tracker-btn-text");
    const trackerCodeBadge = document.getElementById("tracker-code-badge");
    const trackerCard = document.getElementById("tracker-result-card");

    if (trackerForm) {
        trackerForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const digit = document.getElementById("tracker-digit");
            const resultBox = document.getElementById("tracking-sample-box");
            const token = document.querySelector(
                'meta[name="csrf-token"]',
            )?.content;

            try {
                const response = await fetch("/api/pelacakan", {
                    method: "POST",
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token || "",
                    },
                    body: JSON.stringify({
                        kode: trackerInput.value.trim(),
                        empat_digit: digit?.value.trim(),
                    }),
                });
                const result = await response.json();

                if (!response.ok) {
                    resultBox.classList.remove("hidden");
                    const message = result.errors
                        ? Object.values(result.errors).flat().join(" ")
                        : result.pesan || "Kode pesanan tidak cocok.";
                    resultBox.replaceChildren();
                    const errorText = document.createElement("p");
                    errorText.className = "text-sm text-red-700";
                    errorText.textContent = message;
                    resultBox.append(errorText);
                    return;
                }

                resultBox.classList.remove("hidden");
                resultBox.replaceChildren();
                const wrapper = document.createElement("div");
                wrapper.className = "space-y-3";
                const code = document.createElement("span");
                code.className = "font-mono text-sm font-bold text-charcoal bg-white px-2.5 py-1 rounded border border-primary/40";
                code.textContent = result.kode;
                const service = document.createElement("h4");
                service.className = "font-serif text-lg font-bold text-charcoal";
                service.textContent = result.layanan;
                const customer = document.createElement("p");
                customer.className = "text-xs text-gray-600";
                customer.textContent = `Pemesan: ${result.pemesan}`;
                const status = document.createElement("p");
                status.className = "text-sm font-bold text-[#94682a]";
                status.textContent = `Status: ${result.status_label}`;
                wrapper.append(code, service, customer, status);
                resultBox.append(wrapper);
            } catch (error) {
                if (resultBox) {
                    resultBox.classList.remove("hidden");
                    resultBox.replaceChildren();
                    const errorText = document.createElement("p");
                    errorText.className = "text-sm text-red-700";
                    errorText.textContent =
                        "Pelacakan belum dapat dijalankan. Periksa koneksi internet.";
                    resultBox.append(errorText);
                }
            }
        });
    }

    // 5. Testimonial Submission
    const testimonialForm = document.getElementById("testimonial-form");
    if (testimonialForm) {
        testimonialForm.addEventListener("submit", async (event) => {
            event.preventDefault();
            const submitButton = document.getElementById("testimonial-submit");
            const feedback = document.getElementById("testimonial-feedback");
            const formData = new FormData(testimonialForm);
            submitButton.disabled = true;
            submitButton.textContent = "Mengirim...";

            try {
                const token = document.querySelector(
                    'meta[name="csrf-token"]',
                )?.content;
                const response = await fetch("/api/testimoni", {
                    method: "POST",
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token || "",
                    },
                    body: JSON.stringify({
                        bintang: Number(formData.get("bintang")),
                        isi: String(formData.get("isi") || "").trim(),
                    }),
                });
                const result = await response.json();

                feedback.classList.remove("hidden");
                if (!response.ok) {
                    feedback.textContent =
                        result.errors
                            ? Object.values(result.errors).flat().join(" ")
                            : result.pesan || "Testimoni gagal dikirim.";
                    feedback.className =
                        "text-sm rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-red-700";
                    return;
                }

                feedback.textContent =
                    result.pesan ||
                    "Terima kasih. Testimoni akan ditinjau admin.";
                feedback.className =
                    "text-sm rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-emerald-700";
                testimonialForm.reset();
                const fiveStar = document.getElementById("rating-5");
                if (fiveStar) fiveStar.checked = true;
            } catch (error) {
                feedback.classList.remove("hidden");
                feedback.textContent =
                    "Testimoni belum dapat dikirim. Periksa koneksi internet.";
                feedback.className =
                    "text-sm rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-red-700";
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = "Kirim Testimoni";
            }
        });
    }

    // 6. Booking Form Submission Feedback
    const bookingForm = document.getElementById("booking-form");
    // Ubah "2026-11-23" menjadi "Senin, 23 November 2026"
    const formatTanggal = (isoDate) => {
        const [tahun, bulan, hari] = isoDate.split("-").map(Number);
        if (!tahun || !bulan || !hari) return isoDate;
        // Dibuat dari angka (bukan string) agar tidak bergeser sehari karena zona waktu
        const tanggal = new Date(tahun, bulan - 1, hari);
        return tanggal.toLocaleDateString("id-ID", {
            weekday: "long",
            day: "numeric",
            month: "long",
            year: "numeric",
        });
    };
    if (bookingForm) {
        bookingForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const name = document.getElementById("booking-name")?.value.trim();
            const phone = document.getElementById("booking-whatsapp")?.value.trim();
            const service = document.getElementById("booking-service")?.value;
            const material = document.getElementById("booking-material")?.value;
            const date = document.getElementById("booking-date")?.value;

            if (!name || !phone || !service || !material || !date) return;

            const materialText =
                material === "sendiri"
                    ? "Membawa bahan sendiri"
                    : "Memilih bahan koleksi atelier";
            const message =
                `Halo Rahmat Tailor, saya ingin booking jadwal ukur.\n\n` +
                `Nama: ${name}\n` +
                `WhatsApp: ${phone}\n` +
                `Rencana busana: ${service}\n` +
                `Bahan: ${materialText}\n` +
                `Tanggal kunjungan: ${formatTanggal(date)}`;

            window.open(
                `https://wa.me/6282154244646?text=${encodeURIComponent(message)}`,
                "_blank",
                "noopener,noreferrer",
            );
        });
    }

    // 6. Header backdrop shadow enhancement on scroll
    const header = document.getElementById("main-header");
    window.addEventListener("scroll", () => {
        if (window.scrollY > 20) {
            header.classList.add("shadow-md");
        } else {
            header.classList.remove("shadow-md");
        }
    });

    // 7. Mobile Menu (Hamburger) untuk layar < 1024px
    const menuToggle = document.getElementById("menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");
    const mobileItems = document.querySelectorAll(".mobile-nav-item");

    // Profil pengguna
    const profileButton = document.getElementById("profile-menu-button");
    const profileMenu = document.getElementById("profile-menu");
    const profileWrapper = document.getElementById("profile-menu-wrapper");
    const profileHistory = document.getElementById("profile-order-history");
    let profileHistoryLoaded = false;

    const setProfileMenu = (open) => {
        if (!profileButton || !profileMenu) return;
        profileMenu.classList.toggle("hidden", !open);
        profileButton.setAttribute("aria-expanded", String(open));
    };

    if (profileButton && profileMenu) {
        profileButton.addEventListener("click", async (event) => {
            event.stopPropagation();
            const open = profileMenu.classList.contains("hidden");
            setProfileMenu(open);

            if (open && profileHistory && !profileHistoryLoaded) {
                profileHistoryLoaded = true;
                try {
                    const response = await fetch("/api/pesanan", {
                        headers: { Accept: "application/json" },
                    });
                    if (!response.ok) throw new Error("Gagal memuat riwayat");
                    const pesanan = await response.json();

                    if (!Array.isArray(pesanan) || pesanan.length === 0) {
                        profileHistory.innerHTML =
                            '<p class="text-xs text-[#a8a29e]">Belum ada riwayat pemesanan.</p>';
                        return;
                    }

                    profileHistory.innerHTML = pesanan
                        .slice(0, 8)
                        .map(
                            (item) => `
            <div class="p-3 rounded-lg bg-[#221f1d] border border-[#2d2825]">
              <div class="flex items-start justify-between gap-3">
                <p class="text-xs font-mono font-bold text-[#c59b27]">${String(item.kode || "-")}</p>
                <p class="text-[11px] text-[#a8a29e] text-right">${String(item.status_label || item.status || "-")}</p>
              </div>
              <p class="mt-1 text-xs text-white truncate">${String(item.layanan || "Layanan tidak tercatat")}</p>
            </div>
          `,
                        )
                        .join("");
                } catch (error) {
                    profileHistory.innerHTML =
                        '<p class="text-xs text-red-400">Riwayat pemesanan tidak dapat dimuat.</p>';
                }
            }
        });

        document.addEventListener("click", (event) => {
            if (profileWrapper && !profileWrapper.contains(event.target))
                setProfileMenu(false);
        });
    }

    document.querySelectorAll(".profile-logout").forEach((button) => {
        button.addEventListener("click", async () => {
            const token = document.querySelector(
                'meta[name="csrf-token"]',
            )?.content;
            try {
                await fetch("/api/keluar", {
                    method: "POST",
                    headers: {
                        Accept: "application/json",
                        "X-CSRF-TOKEN": token || "",
                    },
                });
            } finally {
                window.location.href = "/";
            }
        });
    });

    const mobileHistoryButton = document.getElementById("mobile-history-button");
    const mobileHistory = document.getElementById("mobile-order-history");
    let mobileHistoryLoaded = false;

    if (mobileHistoryButton && mobileHistory) {
        mobileHistoryButton.addEventListener("click", async () => {
            const open = mobileHistory.classList.contains("hidden");
            mobileHistory.classList.toggle("hidden", !open);
            mobileHistoryButton.setAttribute("aria-expanded", String(open));

            if (!open || mobileHistoryLoaded) return;
            mobileHistoryLoaded = true;

            try {
                const response = await fetch("/api/pesanan", {
                    headers: { Accept: "application/json" },
                });
                if (!response.ok) throw new Error("Gagal memuat riwayat");
                const pesanan = await response.json();

                if (!Array.isArray(pesanan) || pesanan.length === 0) {
                    mobileHistory.innerHTML =
                        '<p class="text-xs text-[#a8a29e] px-1">Belum ada riwayat pemesanan.</p>';
                    return;
                }

                mobileHistory.innerHTML = pesanan
                    .slice(0, 8)
                    .map(
                        (item) => `
                            <div class="p-3 rounded-lg bg-[#1f2225] border border-[#2d2825]">
                                <div class="flex items-start justify-between gap-3">
                                    <p class="text-xs font-mono font-bold text-[#c59b27]">${String(item.kode || "-")}</p>
                                    <p class="text-[11px] text-[#a8a29e] text-right">${String(item.status_label || item.status || "-")}</p>
                                </div>
                                <p class="mt-1 text-xs text-white">${String(item.layanan || "Layanan tidak tercatat")}</p>
                            </div>
                        `,
                    )
                    .join("");
            } catch (error) {
                mobileHistory.innerHTML =
                    '<p class="text-xs text-red-400 px-1">Riwayat pemesanan tidak dapat dimuat.</p>';
            }
        });
    }

    if (menuToggle && mobileMenu) {
        const setMenu = (open) => {
            mobileMenu.classList.toggle("is-open", open);
            mobileMenu.setAttribute("aria-hidden", String(!open));
            menuToggle.setAttribute("aria-expanded", String(open));
            menuToggle.setAttribute(
                "aria-label",
                open ? "Tutup menu navigasi" : "Buka menu navigasi",
            );
        };

        menuToggle.addEventListener("click", () => {
            setMenu(!mobileMenu.classList.contains("is-open"));
        });

        mobileItems.forEach((item) => {
            item.addEventListener("click", () => {
                // Status aktif pada menu mobile
                mobileItems.forEach((i) => {
                    i.removeAttribute("aria-current");
                    i.classList.remove("text-primary", "font-semibold");
                    i.classList.add("text-gray-300", "font-medium");
                });
                item.setAttribute("aria-current", "page");
                item.classList.add("text-primary", "font-semibold");
                item.classList.remove("text-gray-300", "font-medium");

                // Sinkronkan dengan navbar desktop
                const desktopItem = document.querySelector(
                    `.nav-item[data-path="${item.dataset.path}"]`,
                );
                if (mainNav && desktopItem) {
                    mainNav.dispatchEvent(
                        new CustomEvent("nav:activate", {
                            detail: desktopItem,
                        }),
                    );
                }

                setMenu(false);
            });
        });

        // Tutup saat klik di luar header, tekan Escape, atau layar melebar ke desktop
        document.addEventListener("click", (e) => {
            if (!header.contains(e.target)) setMenu(false);
        });
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") setMenu(false);
            if (e.key === "Escape") setProfileMenu(false);
        });
        window.addEventListener("resize", () => {
            if (window.innerWidth >= 1024) setMenu(false);
        });
    }
});
