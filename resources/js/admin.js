/**
 * Rahmat Tailor — Admin Panel (Vanilla JS)
 * Tab switching, sidebar, modals, search/filter, status progression, print.
 */

document.addEventListener("DOMContentLoaded", () => {
    // ── Sidebar Tab Switching ──────────────────────────────────────────
    const sidebarBtns = document.querySelectorAll(".admin-sidebar-btn");
    const tabPanels = document.querySelectorAll(".tab-panel");
    const pageTitle = document.getElementById("page-title");

    const tabTitles = {
        dashboard: "Dashboard",
        pesanan: "Pesanan Jahit",
        jadwal: "Jadwal Ukur",
        ukuran: "Riwayat Ukuran",
        layanan: "Layanan & Galeri",
        testimoni: "Testimoni",
        laporan: "Laporan Keuangan",
    };

    function switchTab(tabId) {
        tabPanels.forEach((p) => p.classList.add("hidden"));
        sidebarBtns.forEach((b) => b.classList.remove("active"));

        const target = document.getElementById("tab-" + tabId);
        if (target) target.classList.remove("hidden");

        sidebarBtns.forEach((b) => {
            if (b.getAttribute("data-tab") === tabId) b.classList.add("active");
        });

        if (pageTitle) pageTitle.textContent = tabTitles[tabId] || tabId;
        closeSidebar();
    }

    sidebarBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            const tab = btn.getAttribute("data-tab");
            if (tab) switchTab(tab);
        });
    });

    // ── Mobile Sidebar Toggle ─────────────────────────────────────────
    const sidebar = document.getElementById("admin-sidebar");
    const sidebarToggle = document.getElementById("sidebar-toggle");
    const sidebarOverlay = document.getElementById("sidebar-overlay");

    function openSidebar() {
        sidebar.classList.remove("-translate-x-full");
        sidebarOverlay.classList.remove("hidden");
    }

    function closeSidebar() {
        if (window.innerWidth < 1024) {
            sidebar.classList.add("-translate-x-full");
            sidebarOverlay.classList.add("hidden");
        }
    }

    if (sidebarToggle) sidebarToggle.addEventListener("click", openSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener("click", closeSidebar);

    // ── Modal Management ──────────────────────────────────────────────
    function openModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove("hidden");
        modal.classList.add("flex");
        document.body.style.overflow = "hidden";
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add("hidden");
        modal.classList.remove("flex");
        document.body.style.overflow = "";
    }

    // Close buttons inside modals
    document.querySelectorAll(".modal-close").forEach((btn) => {
        btn.addEventListener("click", () => {
            const modal = btn.closest('[id^="modal-"]');
            if (modal) closeModal(modal.id);
        });
    });

    // Close modal on backdrop click
    document.querySelectorAll('[id^="modal-"]').forEach((modal) => {
        modal.addEventListener("click", (e) => {
            if (e.target === modal) closeModal(modal.id);
        });
    });

    // Close on Escape key
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            document.querySelectorAll('[id^="modal-"]').forEach((modal) => {
                if (!modal.classList.contains("hidden")) closeModal(modal.id);
            });
        }
    });

    // ── Order Detail Modal ────────────────────────────────────────────
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-detail");
        if (!btn) return;

        const code = btn.getAttribute("data-order");
        const detailCode = document.getElementById("detail-code");
        if (detailCode) detailCode.textContent = code;
        const row = document.querySelector(`tr[data-code="${code}"]`);
        const id = btn.dataset.id || row?.dataset.id;
        if (!id) {
            openModal("modal-detail");
            return;
        }
        document.getElementById("modal-detail").dataset.orderId = id;
        fetch(`/api/admin/pesanan/${id}`, {
            headers: { Accept: "application/json", "X-CSRF-TOKEN": csrfToken },
        }).then(async (response) => {
            if (!response.ok) throw new Error("Detail gagal dimuat");
            const detail = await response.json();
            document.getElementById("detail-price").value =
                detail.harga ?? "";
            document.getElementById("detail-deadline").value =
                detail.deadline ?? "";
            const verification = document.getElementById("detail-verification");
            verification.classList.toggle("hidden", detail.status !== "verifikasi");
            document.getElementById("detail-customer").textContent =
                detail.pelanggan?.nama || "-";
            document.getElementById("detail-wa").textContent =
                detail.pelanggan?.no_whatsapp || "-";
            document.getElementById("detail-service").textContent =
                detail.layanan || "-";
            document.getElementById("detail-source").textContent =
                detail.sumber === "offline" ? "Offline" : "Online";
            document.getElementById("detail-target-date").textContent =
                detail.target_tanggal
                    ? new Date(`${detail.target_tanggal}T00:00:00`).toLocaleDateString("id-ID", {
                        day: "numeric",
                        month: "long",
                        year: "numeric",
                    })
                    : "-";
            const timeline = document.getElementById("detail-timeline");
            timeline.innerHTML = (detail.langkah || []).map((langkah) =>
                `<div class="flex items-start gap-3"><div class="w-2 h-2 rounded-full ${langkah.tercapai ? "bg-[#c59b27]" : "bg-[#3b3531]"} mt-1.5 shrink-0"></div><div><p class="text-sm ${langkah.tercapai ? "text-white" : "text-[#78716c]"} font-semibold">${langkah.label}</p>${langkah.waktu ? `<p class="text-xs text-[#78716c]">${new Date(langkah.waktu).toLocaleString("id-ID")}</p>` : ""}</div></div>`
            ).join("") || '<p class="text-xs text-[#a8a29e]">Belum ada riwayat status.</p>';
            const measurements = document.getElementById("detail-measurements");
            const labels = {
                lingkar_dada: "Dada", lingkar_pinggang_celana: "Pinggang",
                lingkar_pinggang_baju: "Pinggang", lingkar_pinggang_rok: "Pinggang",
                lebar_bahu: "Bahu", panjang_lengan: "Lengan",
            };
            const rows = Object.entries(detail.ukuran || {}).filter(([key, value]) =>
                key !== "id" && key !== "pesanan_id" && key !== "pelanggan_id" &&
                key !== "kategori" && key !== "created_at" && key !== "updated_at" &&
                value !== null
            );
            measurements.innerHTML = rows.length
                ? rows.map(([key, value]) => `<div class="bg-[#181615] rounded-lg p-2 text-center"><p class="text-[10px] text-[#78716c]">${labels[key] || key.replaceAll("_", " ")}</p><p class="text-sm font-bold text-white">${value} cm</p></div>`).join("")
                : '<p class="col-span-full text-xs text-[#a8a29e]">Ukuran belum tersedia.</p>';

            const modelLoading = document.getElementById("detail-model-loading");
            const modelOpen = document.getElementById("detail-model-open");
            const modelImage = document.getElementById("detail-model-image");
            const modelEmpty = document.getElementById("detail-model-empty");

            modelLoading.classList.remove("hidden");
            modelOpen.classList.add("hidden");
            modelEmpty.classList.add("hidden");

            if (!detail.foto_referensi_url) {
                modelLoading.classList.add("hidden");
                modelEmpty.textContent = "Pelanggan belum mengirim model.";
                modelEmpty.classList.remove("hidden");
            } else {
                modelImage.onload = () => {
                    modelLoading.classList.add("hidden");
                    modelOpen.classList.remove("hidden");
                };
                modelImage.onerror = () => {
                    modelLoading.classList.add("hidden");
                    modelOpen.classList.add("hidden");
                    modelEmpty.textContent = "Gambar referensi gagal dimuat.";
                    modelEmpty.classList.remove("hidden");
                };
                modelImage.src = detail.foto_referensi_url;
            }
        }).catch(() => {
            document.getElementById("detail-customer").textContent = "Data gagal dimuat";
            const modelLoading = document.getElementById("detail-model-loading");
            const modelOpen = document.getElementById("detail-model-open");
            const modelEmpty = document.getElementById("detail-model-empty");
            modelLoading.classList.add("hidden");
            modelOpen.classList.add("hidden");
            modelEmpty.textContent = "Detail pesanan gagal dimuat.";
            modelEmpty.classList.remove("hidden");
        });
        openModal("modal-detail");
    });

    document.addEventListener("click", (e) => {
        if (!e.target.closest("#detail-model-open")) return;

        const source = document.getElementById("detail-model-image")?.src;
        const lightboxImage = document.getElementById("detail-model-lightbox-image");
        if (!source || !lightboxImage) return;

        lightboxImage.src = source;
        openModal("modal-detail-model");
    });

    async function simpanVerifikasiPesanan(konfirmasiStatus) {
        const modal = document.getElementById("modal-detail");
        const id = modal?.dataset.orderId;
        if (!id) return;

        const feedback = document.getElementById("detail-verification-feedback");
        const price = document.getElementById("detail-price").value;
        const deadline = document.getElementById("detail-deadline").value;

        try {
            const updateResponse = await fetch(`/api/admin/pesanan/${id}`, {
                method: "PATCH",
                headers: apiHeaders({ "Content-Type": "application/json" }),
                body: JSON.stringify({
                    harga: price === "" ? null : Number(price),
                    deadline: deadline === "" ? null : deadline,
                }),
            });
            const updateResult = await updateResponse.json();
            if (!updateResponse.ok) {
                throw new Error(updateResult.pesan || "Data verifikasi gagal disimpan");
            }

            if (!konfirmasiStatus) {
                feedback.textContent = "Harga dan deadline tersimpan.";
                feedback.className =
                    "mt-3 rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-3 py-2 text-xs text-emerald-300";
                return;
            }

            const statusResponse = await fetch(`/api/admin/pesanan/${id}/status`, {
                method: "POST",
                headers: apiHeaders({ "Content-Type": "application/json" }),
                body: JSON.stringify({}),
            });
            const statusResult = await statusResponse.json();
            if (!statusResponse.ok) {
                throw new Error(statusResult.pesan || "Pesanan gagal diverifikasi");
            }

            closeModal("modal-detail");
            await loadPesananAdmin();
            await loadDashboardAdmin();
        } catch (error) {
            feedback.textContent = error.message;
            feedback.className =
                "mt-3 rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-2 text-xs text-red-300";
        } finally {
            feedback.classList.remove("hidden");
        }
    }

    document
        .getElementById("detail-save-verification")
        ?.addEventListener("click", () => simpanVerifikasiPesanan(false));
    document
        .getElementById("detail-confirm-verification")
        ?.addEventListener("click", () => simpanVerifikasiPesanan(true));

    // ── Payment Modal ─────────────────────────────────────────────────
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-payment");
        if (!btn) return;

        const code = btn.getAttribute("data-order");
        const id = btn.dataset.id;
        document.getElementById("modal-payment").dataset.orderId = id || "";
        const paymentCode = document.getElementById("payment-code");
        if (paymentCode) paymentCode.textContent = code;

        openModal("modal-payment");
    });

    document.getElementById("payment-submit")?.addEventListener("click", async () => {
        const modal = document.getElementById("modal-payment");
        const id = modal?.dataset.orderId;
        if (!id) return;
        const button = document.getElementById("payment-submit");
        button.disabled = true;
        try {
            const response = await fetch(`/api/admin/pesanan/${id}/pembayaran`, {
                method: "POST",
                headers: apiHeaders({ "Content-Type": "application/json" }),
                body: JSON.stringify({
                    jenis: document.getElementById("payment-type").value,
                    metode: document.getElementById("payment-method").value,
                    jumlah: Number(document.getElementById("payment-amount").value),
                }),
            });
            const result = await response.json();
            if (!response.ok) throw new Error(result.pesan || "Pembayaran gagal disimpan");
            closeModal("modal-payment");
            await loadPesananAdmin();
            await loadDashboardAdmin();
            await loadLaporanAdmin();
        } catch (error) {
            alert(error.message);
        } finally {
            button.disabled = false;
        }
    });

    // ── Offline Order Modal (PB-18) ───────────────────────────────────
    const btnNewOffline = document.getElementById("btn-new-offline");
    const offlineCode = document.getElementById("offline-generated-code");
    const offlineForm = document.getElementById("offline-order-form");
    const offlineGarment = document.getElementById("offline-garment-category");
    const offlineFeedback = document.getElementById("offline-form-feedback");

    function updateOfflineMeasurementFields(category) {
        document
            .querySelectorAll(".offline-measurement-pane")
            .forEach((pane) => {
                const paneCategory =
                    category === "kebaya"
                        ? "baju"
                        : category;
                const isActive =
                    pane.id === `offline-measurements-${paneCategory}`;
                pane.classList.toggle("hidden", !isActive);

                pane.querySelectorAll(".offline-measurement-input").forEach(
                    (input) => {
                        input.disabled = !isActive;
                        input.required = isActive;
                    },
                );
            });
    }

    if (offlineGarment) {
        offlineGarment.addEventListener("change", () => {
            updateOfflineMeasurementFields(offlineGarment.value);
        });
        updateOfflineMeasurementFields(offlineGarment.value);
    }

    if (btnNewOffline) {
        btnNewOffline.addEventListener("click", () => {
            if (offlineCode) offlineCode.textContent = "Dibuat saat disimpan";
            if (offlineForm) offlineForm.reset();
            if (offlineFeedback) {
                offlineFeedback.classList.add("hidden");
                offlineFeedback.textContent = "";
            }
            if (offlineGarment)
                updateOfflineMeasurementFields(offlineGarment.value);
            openModal("modal-offline");
        });
    }

    if (offlineForm) {
        offlineForm.addEventListener("submit", async (event) => {
            event.preventDefault();
            const submitButton = offlineForm.querySelector('button[type="submit"]');
            const formData = new FormData(offlineForm);
            const category = offlineGarment.value;
            const payload = {
                nama: formData.get("customer_name"),
                no_whatsapp: formData.get("customer_phone"),
                bahan: formData.get("bahan"),
                catatan: formData.get("notes") || null,
                deadline: formData.get("deadline") || null,
                kategori_busana: category,
                ukuran: {},
            };

            offlineForm
                .querySelectorAll(".offline-measurement-pane:not(.hidden) .offline-measurement-input")
                .forEach((input) => {
                    if (input.name?.includes("measurements")) {
                        payload.ukuran[input.name.match(/\[(.+)\]/)?.[1]] = input.value;
                    }
                });

            const servicePayload = {
                ...payload,
                ukuran: category === "celana"
                    ? {
                        lingkar_pinggang_celana: payload.ukuran.lingkar_pinggang,
                        lingkar_panggul_celana: payload.ukuran.lingkar_panggul,
                        lingkar_pesak: payload.ukuran.lingkar_pesak,
                        lingkar_paha: payload.ukuran.lingkar_paha,
                        lingkar_lutut: payload.ukuran.lingkar_lutut,
                        lingkar_celana_bawah: payload.ukuran.lingkar_celana_bawah,
                        panjang_celana: payload.ukuran.panjang_celana,
                    }
                    : category === "rok"
                        ? {
                            lingkar_pinggang_rok: payload.ukuran.lingkar_pinggang,
                            lingkar_panggul_rok: payload.ukuran.lingkar_panggul,
                            panjang_rok: payload.ukuran.panjang_rok,
                        }
                        : payload.ukuran,
            };

            submitButton.disabled = true;
            try {
                const response = await fetch("/api/admin/pesanan", {
                    method: "POST",
                    headers: apiHeaders({ "Content-Type": "application/json" }),
                    body: JSON.stringify(servicePayload),
                });
                const result = await response.json();
                if (!response.ok) {
                    throw new Error(
                        result.errors
                            ? Object.values(result.errors).flat().join(" ")
                            : result.pesan || "Pesanan gagal disimpan.",
                    );
                }

                offlineFeedback.textContent =
                    `Pesanan tersimpan dengan kode ${result.pesanan.kode}.`;
                offlineFeedback.classList.remove("hidden");
                await loadPesananAdmin();
                await loadDashboardAdmin();
            } catch (error) {
                offlineFeedback.textContent = error.message;
                offlineFeedback.classList.remove("hidden");
            } finally {
                submitButton.disabled = false;
            }
        });
    }

    // ── Print Invoice Modal ───────────────────────────────────────────
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-print");
        if (!btn) return;

        const code = btn.getAttribute("data-order");
        const id = btn.dataset.id;
        const invoiceCode = document.getElementById("invoice-code");
        const invoiceDate = document.getElementById("invoice-date");
        const invoiceCustomer = document.getElementById("invoice-customer");
        const invoiceService = document.getElementById("invoice-service");

        if (invoiceCode) invoiceCode.textContent = code;
        if (invoiceDate)
            invoiceDate.textContent = new Date().toLocaleDateString("id-ID", {
                day: "numeric",
                month: "long",
                year: "numeric",
            });

        if (id) {
            fetch(`/api/admin/pesanan/${id}/invoice`, { headers: apiHeaders() })
                .then(async (response) => {
                    if (!response.ok) throw new Error("Nota gagal dimuat");
                    const invoice = await response.json();
                    invoiceCode.textContent = invoice.kode;
                    invoiceCustomer.textContent = invoice.pelanggan;
                    invoiceService.textContent = invoice.layanan;
                    document.getElementById("invoice-total").textContent =
                        invoice.harga === null ? "-" : rupiah(invoice.harga);
                    document.getElementById("invoice-balance").textContent =
                        invoice.sisa_tagihan === null ? "-" : rupiah(invoice.sisa_tagihan);
                })
                .catch(() => {
                    document.getElementById("invoice-total").textContent = "-";
                    document.getElementById("invoice-balance").textContent = "-";
                });
        }

        openModal("modal-print");
    });

    // Print action button
    const btnPrintAction = document.getElementById("btn-print-action");
    if (btnPrintAction) {
        btnPrintAction.addEventListener("click", () => window.print());
    }

    // ── Status Advancement (1-click, PB-12) ───────────────────────────
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-advance-status");
        if (!btn) return;

        const code = btn.getAttribute("data-order");
        const id = btn.dataset.id;
        if (!id) return;
        if (!confirm(`Naikkan status pesanan ${code} ke tahap berikutnya?`)) return;

        fetch(`/api/admin/pesanan/${id}/status`, {
            method: "POST",
            headers: apiHeaders({ "Content-Type": "application/json" }),
            body: JSON.stringify({}),
        }).then(async (response) => {
            const result = await response.json();
            if (!response.ok) throw new Error(result.pesan || "Status gagal diubah");
            await loadPesananAdmin();
            await loadDashboardAdmin();
        }).catch((error) => alert(error.message));
    });

    // ── Search & Filter Orders ────────────────────────────────────────
    const searchInput = document.getElementById("order-search");
    const filterStatus = document.getElementById("filter-status");
    const filterSource = document.getElementById("filter-source");
    const ordersTable = document.getElementById("orders-tbody");

    function filterOrders() {
        if (!ordersTable) return;

        const query = (searchInput?.value || "").toLowerCase();
        const status = filterStatus?.value || "";
        const source = filterSource?.value || "";

        ordersTable.querySelectorAll(".order-row").forEach((row) => {
            const rowStatus = row.getAttribute("data-status");
            const rowSource = row.getAttribute("data-source");
            const rowName = (row.getAttribute("data-name") || "").toLowerCase();
            const rowCode = (row.getAttribute("data-code") || "").toLowerCase();

            const matchSearch =
                !query || rowName.includes(query) || rowCode.includes(query);
            const matchStatus = !status || rowStatus === status;
            const matchSource = !source || rowSource === source;

            row.style.display =
                matchSearch && matchStatus && matchSource ? "" : "none";
        });
    }

    if (searchInput) searchInput.addEventListener("input", filterOrders);
    if (filterStatus) filterStatus.addEventListener("change", filterOrders);
    if (filterSource) filterSource.addEventListener("change", filterOrders);

    const statusLabels = {
        verifikasi: "Menunggu verifikasi",
        diterima: "Diterima",
        dipotong: "Dipotong",
        dijahit: "Dijahit",
        fitting: "Fitting",
        selesai: "Selesai",
        "siap-diambil": "Siap diambil",
    };

    async function loadPesananAdmin() {
        if (!ordersTable) return;
        ordersTable.innerHTML =
            '<tr><td colspan="9" class="px-5 py-6 text-sm text-[#a8a29e]">Memuat pesanan...</td></tr>';

        try {
            const params = new URLSearchParams();
            if (searchInput?.value) params.set("q", searchInput.value);
            if (filterStatus?.value) params.set("status", filterStatus.value);
            if (filterSource?.value) params.set("sumber", filterSource.value);

            const response = await fetch(`/api/admin/pesanan?${params}`, {
                headers: apiHeaders(),
            });
            if (!response.ok) throw new Error("Gagal memuat pesanan");
            const result = await response.json();
            const rows = result.data || [];

            if (rows.length === 0) {
                ordersTable.innerHTML =
                    '<tr><td colspan="9" class="px-5 py-6 text-sm text-[#a8a29e]">Belum ada pesanan.</td></tr>';
                document.getElementById("order-count-badge").textContent = "0";
                return;
            }

            document.getElementById("order-count-badge").textContent =
                String(result.total ?? rows.length);
            ordersTable.innerHTML = rows.map((pesanan) => {
                const phone = pesanan.pelanggan?.no_whatsapp || "";
                const payment =
                    pesanan.harga === null
                        ? "Belum ditetapkan"
                        : pesanan.sisa_tagihan === 0
                            ? "Lunas"
                            : `Sisa ${rupiah(pesanan.sisa_tagihan)}`;
                return `
                    <tr class="order-row border-b border-[#2d2825] hover:bg-[#221f1d] transition-colors"
                        data-status="${pesanan.status}" data-source="${pesanan.sumber}"
                        data-name="${textValue(pesanan.pelanggan?.nama || "")}" data-code="${pesanan.kode}">
                        <td class="px-5 py-3 font-mono text-[#c59b27] font-semibold">${pesanan.kode}</td>
                        <td class="px-5 py-3">${textValue(pesanan.pelanggan?.nama || "-")}</td>
                        <td class="px-5 py-3">
                            ${phone ? `<a href="https://wa.me/${phone.replace(/^0/, "62")}" target="_blank" rel="noopener noreferrer" class="text-emerald-400 hover:text-emerald-300 text-xs">${phone}</a>` : "-"}
                        </td>
                        <td class="px-5 py-3 text-[#a8a29e]">${textValue(pesanan.layanan || "-")}</td>
                        <td class="px-5 py-3"><span class="status-badge status-badge-${pesanan.status}">${statusLabels[pesanan.status] || pesanan.status_label}</span></td>
                        <td class="px-5 py-3 ${pesanan.deadline ? "text-amber-400 font-semibold" : "text-[#a8a29e]"}">${pesanan.deadline ? new Date(pesanan.deadline).toLocaleDateString("id-ID") : "-"}</td>
                        <td class="px-5 py-3"><span class="status-badge badge-${pesanan.sumber}">${pesanan.sumber === "offline" ? "Offline" : "Online"}</span></td>
                        <td class="px-5 py-3 text-xs ${pesanan.sisa_tagihan === 0 ? "text-emerald-400" : "text-amber-400"}">${payment}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-center gap-1">
                                <button type="button" class="${pesanan.status === "verifikasi" ? "btn-detail px-2 py-1.5 rounded text-xs font-semibold text-[#181615] bg-[#c59b27] hover:bg-[#d8ac34]" : "btn-detail p-1.5 rounded hover:bg-[#282422] text-[#c59b27]"}" title="${pesanan.status === "verifikasi" ? "Verifikasi Pesanan" : "Detail"}" data-order="${pesanan.kode}" data-id="${pesanan.id}" aria-label="${pesanan.status === "verifikasi" ? "Verifikasi" : "Detail"} pesanan ${pesanan.kode}">${pesanan.status === "verifikasi" ? "Verifikasi" : '<span class="material-symbols-outlined text-[18px]" aria-hidden="true">visibility</span>'}</button>
                                ${pesanan.status !== "siap-diambil" && pesanan.status !== "verifikasi" ? `<button type="button" class="btn-advance-status p-1.5 rounded hover:bg-[#282422] text-sky-400" title="Naikkan Status" data-order="${pesanan.kode}" data-id="${pesanan.id}" data-current="${pesanan.status}" aria-label="Naikkan status pesanan ${pesanan.kode}"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">skip_next</span></button>` : ""}
                                <button type="button" class="btn-payment p-1.5 rounded hover:bg-[#282422] text-emerald-400" title="Catat Pembayaran" data-order="${pesanan.kode}" data-id="${pesanan.id}" aria-label="Catat pembayaran pesanan ${pesanan.kode}"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">payments</span></button>
                                <button type="button" class="btn-print p-1.5 rounded hover:bg-[#282422] text-[#a8a29e]" title="Cetak Nota" data-order="${pesanan.kode}" data-id="${pesanan.id}" aria-label="Cetak nota pesanan ${pesanan.kode}"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">print</span></button>
                            </div>
                        </td>
                    </tr>`;
            }).join("");
        } catch (error) {
            ordersTable.innerHTML =
                '<tr><td colspan="9" class="px-5 py-6 text-sm text-red-400">Pesanan tidak dapat dimuat.</td></tr>';
        }
    }

    async function loadDashboardAdmin() {
        try {
            const [summaryResponse, reportResponse, ordersResponse] = await Promise.all([
                fetch("/api/admin/ringkasan", { headers: apiHeaders() }),
                fetch("/api/admin/laporan", { headers: apiHeaders() }),
                fetch("/api/admin/pesanan", { headers: apiHeaders() }),
            ]);
            if (!summaryResponse.ok || !reportResponse.ok || !ordersResponse.ok)
                throw new Error("Gagal memuat ringkasan");

            const summary = await summaryResponse.json();
            const report = await reportResponse.json();
            const orders = await ordersResponse.json();
            const map = Object.fromEntries(summary.per_status.map((item) => [item.status, item.jumlah]));

            document.getElementById("dashboard-total-orders").textContent = String(summary.total_pesanan);
            document.getElementById("dashboard-active-orders").textContent =
                String(summary.total_pesanan - (map["siap-diambil"] || 0) - (map["selesai"] || 0));
            document.getElementById("dashboard-ready-orders").textContent =
                String(map["siap-diambil"] || 0);
            document.getElementById("dashboard-verification-note").textContent =
                `${map.verifikasi || 0} menunggu verifikasi`;
            document.getElementById("dashboard-month-revenue").textContent =
                rupiah(summary.pendapatan_bulan);

            const urgent = document.getElementById("dashboard-urgent-orders");
            if (summary.pesanan_mendesak.length === 0) {
                urgent.innerHTML =
                    '<p class="text-xs text-[#a8a29e]">Tidak ada pesanan mendesak.</p>';
            } else {
                urgent.innerHTML = summary.pesanan_mendesak.map((pesanan) => `
                    <div class="flex items-center justify-between gap-3 text-sm">
                        <span class="text-[#f5f3ef]"><span class="font-mono text-amber-400">${pesanan.kode}</span> - ${textValue(pesanan.pelanggan?.nama || "-")} - ${textValue(pesanan.layanan || "-")}</span>
                        <span class="text-amber-400 font-semibold text-xs">${pesanan.deadline ? new Date(pesanan.deadline).toLocaleDateString("id-ID") : "-"}</span>
                    </div>`).join("");
            }

            const recent = document.getElementById("dashboard-recent-orders");
            const recentRows = (orders.data || []).slice(0, 5);
            recent.innerHTML = recentRows.length
                ? recentRows.map((pesanan) => `
                    <tr class="border-b border-[#2d2825] hover:bg-[#221f1d] transition-colors">
                        <td class="px-5 py-3 font-mono text-[#c59b27] font-semibold">${pesanan.kode}</td>
                        <td class="px-5 py-3">${textValue(pesanan.pelanggan?.nama || "-")}</td>
                        <td class="px-5 py-3 text-[#a8a29e]">${textValue(pesanan.layanan || "-")}</td>
                        <td class="px-5 py-3"><span class="status-badge status-badge-${pesanan.status}">${statusLabels[pesanan.status] || pesanan.status_label}</span></td>
                        <td class="px-5 py-3 ${pesanan.deadline ? "text-amber-400 font-semibold" : "text-[#a8a29e]"}">${pesanan.deadline ? new Date(pesanan.deadline).toLocaleDateString("id-ID") : "-"}</td>
                        <td class="px-5 py-3"><span class="status-badge badge-${pesanan.sumber}">${pesanan.sumber === "offline" ? "Offline" : "Online"}</span></td>
                        <td class="px-5 py-3 text-center"><button type="button" class="btn-detail text-xs text-[#c59b27]" data-order="${pesanan.kode}" data-id="${pesanan.id}">Detail</button></td>
                    </tr>`).join("")
                : '<tr><td colspan="7" class="px-5 py-6 text-sm text-[#a8a29e]">Belum ada pesanan.</td></tr>';
        } catch (error) {
            document.getElementById("dashboard-total-orders").textContent = "-";
            document.getElementById("dashboard-active-orders").textContent = "-";
            document.getElementById("dashboard-ready-orders").textContent = "-";
        }
    }

    // ── Riwayat Ukuran dari Database ──────────────────────────────────
    const ukuranList = document.getElementById("ukuran-history-list");
    const ukuranSearch = document.getElementById("ukuran-search");
    let riwayatUkuranLoaded = false;

    const labelUkuran = {
        kategori: "Kategori",
        lingkar_pinggang_celana: "Lingkar Pinggang Celana",
        lingkar_panggul_celana: "Lingkar Panggul Celana",
        lingkar_pesak: "Lingkar Pesak",
        lingkar_paha: "Lingkar Paha",
        lingkar_lutut: "Lingkar Lutut",
        lingkar_celana_bawah: "Lingkar Celana Bawah",
        panjang_celana: "Panjang Celana",
        lebar_punggung: "Lebar Punggung",
        lebar_bahu: "Lebar Bahu",
        panjang_lengan: "Panjang Lengan",
        lingkar_lengan_atas: "Lingkar Lengan Atas",
        lingkar_lengan_bawah: "Lingkar Lengan Bawah",
        lingkar_dada: "Lingkar Dada",
        lingkar_pinggang_baju: "Lingkar Pinggang Baju",
        lingkar_panggul_baju: "Lingkar Panggul Baju",
        panjang_baju: "Panjang Baju",
        lingkar_pinggang_rok: "Lingkar Pinggang Rok",
        lingkar_panggul_rok: "Lingkar Panggul Rok",
        panjang_rok: "Panjang Rok",
    };

    function renderUkuranCustomer(container, pelanggan, ukuranRows) {
        ukuranRows.forEach((ukuran) => {
            const card = document.createElement("article");
            card.className =
                "p-5 hover:bg-[#221f1d] transition-colors ukuran-customer";
            card.dataset.name = `${pelanggan.nama} ${pelanggan.no_whatsapp}`;

            const header = document.createElement("div");
            header.className =
                "flex flex-wrap items-center justify-between gap-3 mb-3";

            const identity = document.createElement("div");
            const name = document.createElement("p");
            name.className = "text-sm font-semibold text-white";
            name.textContent = pelanggan.nama;
            const date = document.createElement("p");
            date.className = "text-xs text-[#a8a29e]";
            const updated = ukuran.updated_at
                ? new Date(ukuran.updated_at).toLocaleDateString("id-ID")
                : "-";
            date.textContent = `Terakhir diubah: ${updated} | Kategori: ${ukuran.kategori || "-"}`;
            identity.append(name, date);
            header.append(identity);
            card.append(header);

            const grid = document.createElement("div");
            grid.className =
                "grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-3";

            Object.entries(labelUkuran).forEach(([key, label]) => {
                if (
                    key === "kategori" ||
                    ukuran[key] === null ||
                    ukuran[key] === undefined
                )
                    return;
                const box = document.createElement("div");
                box.className = "bg-[#181615] rounded-lg p-2.5 text-center";
                const labelElement = document.createElement("p");
                labelElement.className =
                    "text-[10px] text-[#78716c] uppercase tracking-wider";
                labelElement.textContent = label;
                const value = document.createElement("p");
                value.className = "text-sm font-bold text-white mt-0.5";
                value.textContent = `${ukuran[key]} cm`;
                box.append(labelElement, value);
                grid.append(box);
            });

            card.append(grid);
            container.append(card);
        });
    }

    async function loadRiwayatUkuran() {
        if (!ukuranList || riwayatUkuranLoaded) return;
        riwayatUkuranLoaded = true;
        ukuranList.innerHTML =
            '<p class="p-5 text-sm text-[#a8a29e]">Memuat riwayat ukuran...</p>';

        try {
            const response = await fetch("/api/admin/pelanggan", {
                headers: { Accept: "application/json" },
            });
            if (!response.ok) throw new Error("Gagal memuat pelanggan");
            const daftar = await response.json();

            ukuranList.innerHTML = "";
            const pelangganRows = daftar.data || [];
            if (pelangganRows.length === 0) {
                ukuranList.innerHTML =
                    '<p class="p-5 text-sm text-[#a8a29e]">Belum ada riwayat ukuran pelanggan.</p>';
                return;
            }

            await Promise.all(
                pelangganRows.map(async (pelangganRingkas) => {
                    const detailResponse = await fetch(
                        `/api/admin/pelanggan/${pelangganRingkas.id}`,
                        { headers: { Accept: "application/json" } },
                    );
                    if (!detailResponse.ok) return;
                    const detail = await detailResponse.json();
                    if (detail.ukuran?.length)
                        renderUkuranCustomer(
                            ukuranList,
                            detail.pelanggan,
                            detail.ukuran,
                        );
                }),
            );

            if (!ukuranList.querySelector(".ukuran-customer")) {
                ukuranList.innerHTML =
                    '<p class="p-5 text-sm text-[#a8a29e]">Belum ada riwayat ukuran pelanggan.</p>';
            }
        } catch (error) {
            ukuranList.innerHTML =
                '<p class="p-5 text-sm text-red-400">Riwayat ukuran tidak dapat dimuat.</p>';
        }
    }

    sidebarBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            if (btn.getAttribute("data-tab") === "ukuran") loadRiwayatUkuran();
        });
    });

    ukuranSearch?.addEventListener("input", () => {
        const query = ukuranSearch.value.trim().toLowerCase();
        ukuranList?.querySelectorAll(".ukuran-customer").forEach((card) => {
            card.style.display =
                !query || card.dataset.name.toLowerCase().includes(query)
                    ? ""
                    : "none";
        });
    });

    async function loadJadwalAdmin() {
        const container = document.getElementById("jadwal-admin-list");
        if (!container) return;
        container.innerHTML =
            '<p class="p-5 text-sm text-[#a8a29e]">Memuat jadwal...</p>';
        try {
            const response = await fetch("/api/admin/jadwal", { headers: apiHeaders() });
            if (!response.ok) throw new Error("Gagal memuat jadwal");
            const rows = await response.json();
            if (rows.length === 0) {
                container.innerHTML =
                    '<p class="p-5 text-sm text-[#a8a29e]">Belum ada jadwal ukur.</p>';
                return;
            }
            container.innerHTML = rows.map((jadwal) => {
                const waktu = new Date(jadwal.waktu);
                return `<div class="flex items-center justify-between gap-3 p-5 hover:bg-[#221f1d] transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg bg-[#c59b27]/10 flex flex-col items-center justify-center text-[#c59b27] shrink-0">
                            <span class="text-sm font-bold leading-none">${waktu.toLocaleDateString("id-ID", { day: "2-digit" })}</span>
                            <span class="text-[10px] uppercase">${waktu.toLocaleDateString("id-ID", { month: "short" })}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">${textValue(jadwal.pelanggan.nama)} - ${textValue(jadwal.jenis_jahitan || jadwal.jenis)}</p>
                            <p class="text-xs text-[#a8a29e] mt-0.5">${waktu.toLocaleTimeString("id-ID", { hour: "2-digit", minute: "2-digit" })} WIB - ${textValue(jadwal.status)}</p>
                        </div>
                    </div>
                    ${jadwal.tautan_whatsapp ? `<a href="${jadwal.tautan_whatsapp}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500/10 text-emerald-400 rounded-lg text-xs font-semibold hover:bg-emerald-500/20"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">chat</span> Kirim Pengingat</a>` : ""}
                </div>`;
            }).join("");
        } catch (error) {
            container.innerHTML =
                '<p class="p-5 text-sm text-red-400">Jadwal tidak dapat dimuat.</p>';
        }
    }

    async function loadTestimoniAdmin() {
        const container = document.getElementById("testimoni-admin-list");
        if (!container) return;
        container.innerHTML =
            '<p class="p-5 text-sm text-[#a8a29e]">Memuat testimoni...</p>';
        try {
            const response = await fetch("/api/admin/testimoni", { headers: apiHeaders() });
            if (!response.ok) throw new Error("Gagal memuat testimoni");
            const rows = await response.json();
            if (rows.length === 0) {
                container.innerHTML =
                    '<p class="p-5 text-sm text-[#a8a29e]">Belum ada testimoni.</p>';
                return;
            }
            container.innerHTML = rows.map((item) => `
                <div class="flex items-start justify-between p-5 hover:bg-[#221f1d] transition-colors">
                    <div class="flex-1 mr-4">
                        <div class="flex items-center gap-2 mb-1">
                            <p class="text-sm font-semibold text-white">${textValue(item.nama)}</p>
                            <div class="flex items-center gap-0.5">${Array.from({ length: 5 }, (_, index) => `<span class="material-symbols-outlined text-[14px] ${index < item.bintang ? "text-[#c59b27]" : "text-[#3b3531]"}" aria-hidden="true">star</span>`).join("")}</div>
                        </div>
                        <p class="text-sm text-[#a8a29e] leading-relaxed">${textValue(item.isi)}</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0 mt-1">
                        <input type="checkbox" class="sr-only peer testimoni-toggle" data-id="${item.id}" ${item.tampil ? "checked" : ""}>
                        <span class="w-9 h-5 bg-[#3b3531] peer-checked:bg-[#c59b27] rounded-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full"></span>
                        <span class="ml-2 text-xs text-[#a8a29e]">${item.tampil ? "Tampil" : "Sembunyi"}</span>
                    </label>
                    <button type="button" class="btn-delete-testimoni ml-2 p-2 rounded text-[#78716c] hover:text-red-400 hover:bg-[#282422]" data-id="${item.id}" aria-label="Hapus testimoni ${textValue(item.nama)}">
                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">delete</span>
                    </button>
                </div>`).join("");
        } catch (error) {
            container.innerHTML =
                '<p class="p-5 text-sm text-red-400">Testimoni tidak dapat dimuat.</p>';
        }
    }

    async function loadLaporanAdmin() {
        const container = document.getElementById("laporan-kategori-list");
        if (!container) return;
        try {
            const response = await fetch("/api/admin/laporan", { headers: apiHeaders() });
            if (!response.ok) throw new Error("Gagal memuat laporan");
            const report = await response.json();
            document.getElementById("laporan-pendapatan").textContent =
                rupiah(report.total_pendapatan);
            document.getElementById("laporan-dp").textContent = rupiah(report.dp);
            document.getElementById("laporan-pelunasan").textContent = rupiah(report.pelunasan);
            document.getElementById("laporan-piutang").textContent = rupiah(report.piutang);
            document.getElementById("laporan-kategori-title").textContent =
                `Pendapatan per Kategori - ${report.tahun}`;
            if (report.per_kategori.length === 0) {
                container.innerHTML =
                    '<tr><td colspan="4" class="px-5 py-6 text-sm text-[#a8a29e]">Belum ada data pendapatan.</td></tr>';
                return;
            }
            container.innerHTML = report.per_kategori.map((item) =>
                `<tr class="border-b border-[#2d2825] hover:bg-[#221f1d] transition-colors">
                    <td class="px-5 py-3 font-semibold text-white">${textValue(item.kategori)}</td>
                    <td class="px-5 py-3 text-[#a8a29e]">${item.jumlah_pesanan}</td>
                    <td class="px-5 py-3 text-[#c59b27] font-semibold">${rupiah(item.pendapatan)}</td>
                    <td class="px-5 py-3"><div class="flex items-center gap-2"><div class="flex-1 h-1.5 bg-[#282422] rounded-full overflow-hidden"><div class="h-full bg-[#c59b27] rounded-full" style="width:${item.proporsi_persen}%"></div></div><span class="text-xs text-[#a8a29e] w-10 text-right">${item.proporsi_persen}%</span></div></td>
                </tr>`
            ).join("");
        } catch (error) {
            container.innerHTML =
                '<tr><td colspan="4" class="px-5 py-6 text-sm text-red-400">Laporan tidak dapat dimuat.</td></tr>';
        }
    }

    // ── CRUD Layanan & Galeri ─────────────────────────────────────────
    const layananList = document.getElementById("layanan-list");
    const galeriList = document.getElementById("galeri-list");
    const layananForm = document.getElementById("layanan-form");
    const galeriForm = document.getElementById("galeri-form");
    const csrfToken =
        document.querySelector('meta[name="csrf-token"]')?.content || "";
    let layananData = [];
    let galeriData = [];

    const apiHeaders = (extra = {}) => ({
        Accept: "application/json",
        "X-CSRF-TOKEN": csrfToken,
        ...extra,
    });

    const rupiah = (value) =>
        new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            maximumFractionDigits: 0,
        }).format(Number(value || 0));

    const textValue = (value) => {
        const span = document.createElement("span");
        span.textContent = value || "";
        return span.innerHTML;
    };

    async function loadKatalogAdmin() {
        if (!layananList || !galeriList) return;
        layananList.innerHTML =
            '<p class="p-5 text-sm text-[#a8a29e]">Memuat layanan...</p>';
        galeriList.innerHTML =
            '<p class="col-span-full text-sm text-[#a8a29e]">Memuat galeri...</p>';

        try {
            const [layananResponse, galeriResponse] = await Promise.all([
                fetch("/api/admin/layanan", { headers: apiHeaders() }),
                fetch("/api/admin/galeri", { headers: apiHeaders() }),
            ]);
            if (!layananResponse.ok || !galeriResponse.ok)
                throw new Error("Gagal memuat katalog");

            layananData = await layananResponse.json();
            galeriData = await galeriResponse.json();
            renderLayanan();
            renderGaleri();
            updateLayananSelect();
        } catch (error) {
            layananList.innerHTML =
                '<p class="p-5 text-sm text-red-400">Layanan tidak dapat dimuat.</p>';
            galeriList.innerHTML =
                '<p class="col-span-full text-sm text-red-400">Galeri tidak dapat dimuat.</p>';
        }
    }

    function renderLayanan() {
        if (layananData.length === 0) {
            layananList.innerHTML =
                '<p class="p-5 text-sm text-[#a8a29e]">Belum ada layanan.</p>';
            return;
        }

        layananList.innerHTML = layananData
            .map(
                (item) => `
      <div class="flex items-center justify-between p-4 hover:bg-[#221f1d] transition-colors">
        <div>
          <p class="text-sm font-semibold text-white">${textValue(item.nama)}</p>
          <p class="text-xs text-[#c59b27] font-semibold mt-0.5">${rupiah(item.harga_min)} - ${rupiah(item.harga_max)}</p>
          <p class="text-[11px] text-[#78716c] mt-1">${item.aktif ? "Aktif" : "Tidak aktif"} | ${item.estimasi_hari} hari</p>
        </div>
        <div class="flex items-center gap-1">
          <button type="button" class="btn-edit-layanan p-2 rounded hover:bg-[#282422] text-[#a8a29e] hover:text-[#c59b27]" data-id="${item.id}" aria-label="Edit ${textValue(item.nama)}">
            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">edit</span>
          </button>
          <button type="button" class="btn-delete-layanan p-2 rounded hover:bg-[#282422] text-[#a8a29e] hover:text-red-400" data-id="${item.id}" aria-label="Hapus ${textValue(item.nama)}">
            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">delete</span>
          </button>
        </div>
      </div>
    `,
            )
            .join("");
    }

    function renderGaleri() {
        if (galeriData.length === 0) {
            galeriList.innerHTML =
                '<p class="col-span-full text-sm text-[#a8a29e]">Belum ada foto galeri.</p>';
            return;
        }

        galeriList.innerHTML = galeriData
            .map(
                (item) => `
      <div class="group relative aspect-square bg-[#282422] rounded-lg overflow-hidden">
        <img src="${textValue(item.url)}" alt="${textValue(item.judul)}" width="300" height="300" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 focus-within:opacity-100 transition-opacity">
          <button type="button" class="btn-edit-galeri p-2 bg-white/20 rounded-lg hover:bg-white/30" data-id="${item.id}" aria-label="Edit ${textValue(item.judul)}">
            <span class="material-symbols-outlined text-white text-[18px]" aria-hidden="true">edit</span>
          </button>
          <button type="button" class="btn-delete-galeri p-2 bg-white/20 rounded-lg hover:bg-red-500/70" data-id="${item.id}" aria-label="Hapus ${textValue(item.judul)}">
            <span class="material-symbols-outlined text-white text-[18px]" aria-hidden="true">delete</span>
          </button>
        </div>
      </div>
    `,
            )
            .join("");
    }

    function updateLayananSelect() {
        const select = document.getElementById("galeri-layanan");
        if (!select) return;
        select.innerHTML = '<option value="">Tidak terkait</option>';
        layananData.forEach((item) => {
            const option = document.createElement("option");
            option.value = String(item.id);
            option.textContent = item.nama;
            select.append(option);
        });
    }

    function resetLayananForm() {
        layananForm?.reset();
        document.getElementById("layanan-id").value = "";
        document.getElementById("layanan-aktif").checked = true;
        document.getElementById("layanan-urutan").value = "0";
        document.getElementById("modal-layanan-title").textContent =
            "Tambah Layanan";
    }

    function resetGaleriForm() {
        galeriForm?.reset();
        document.getElementById("galeri-id").value = "";
        document.getElementById("galeri-foto").required = true;
        document.getElementById("modal-galeri-title").textContent =
            "Upload Galeri";
    }

    document
        .getElementById("btn-add-layanan")
        ?.addEventListener("click", () => {
            resetLayananForm();
            openModal("modal-layanan");
        });

    document.getElementById("btn-add-galeri")?.addEventListener("click", () => {
        resetGaleriForm();
        openModal("modal-galeri");
    });

    layananList?.addEventListener("click", (event) => {
        const edit = event.target.closest(".btn-edit-layanan");
        const remove = event.target.closest(".btn-delete-layanan");
        if (edit) {
            const item = layananData.find(
                (row) => row.id === Number(edit.dataset.id),
            );
            if (!item) return;
            document.getElementById("layanan-id").value = item.id;
            document.getElementById("layanan-nama").value = item.nama;
            document.getElementById("layanan-kategori").value = item.kategori;
            document.getElementById("layanan-deskripsi").value =
                item.deskripsi || "";
            document.getElementById("layanan-harga-min").value = item.harga_min;
            document.getElementById("layanan-harga-max").value = item.harga_max;
            document.getElementById("layanan-estimasi").value =
                item.estimasi_hari;
            document.getElementById("layanan-urutan").value = item.urutan;
            document.getElementById("layanan-aktif").checked = Boolean(
                item.aktif,
            );
            document.getElementById("modal-layanan-title").textContent =
                "Edit Layanan";
            openModal("modal-layanan");
        }
        if (remove) {
            const item = layananData.find(
                (row) => row.id === Number(remove.dataset.id),
            );
            if (item && confirm(`Hapus layanan "${item.nama}"?`))
                deleteLayanan(item.id);
        }
    });

    galeriList?.addEventListener("click", (event) => {
        const edit = event.target.closest(".btn-edit-galeri");
        const remove = event.target.closest(".btn-delete-galeri");
        if (edit) {
            const item = galeriData.find(
                (row) => row.id === Number(edit.dataset.id),
            );
            if (!item) return;
            document.getElementById("galeri-id").value = item.id;
            document.getElementById("galeri-judul").value = item.judul;
            document.getElementById("galeri-kategori").value = item.kategori;
            document.getElementById("galeri-layanan").value = item.layanan_id
                ? String(item.layanan_id)
                : "";
            document.getElementById("galeri-foto").required = false;
            document.getElementById("modal-galeri-title").textContent =
                "Edit Galeri";
            openModal("modal-galeri");
        }
        if (remove) {
            const item = galeriData.find(
                (row) => row.id === Number(remove.dataset.id),
            );
            if (item && confirm(`Hapus foto "${item.judul}"?`))
                deleteGaleri(item.id);
        }
    });

    layananForm?.addEventListener("submit", async (event) => {
        event.preventDefault();
        const id = document.getElementById("layanan-id").value;
        const payload = {
            nama: document.getElementById("layanan-nama").value,
            kategori: document.getElementById("layanan-kategori").value,
            deskripsi: document.getElementById("layanan-deskripsi").value,
            harga_min: Number(
                document.getElementById("layanan-harga-min").value,
            ),
            harga_max: Number(
                document.getElementById("layanan-harga-max").value,
            ),
            estimasi_hari: Number(
                document.getElementById("layanan-estimasi").value,
            ),
            urutan: Number(document.getElementById("layanan-urutan").value),
            aktif: document.getElementById("layanan-aktif").checked,
        };

        try {
            const response = await fetch(
                id ? `/api/admin/layanan/${id}` : "/api/admin/layanan",
                {
                    method: id ? "PUT" : "POST",
                    headers: apiHeaders({ "Content-Type": "application/json" }),
                    body: JSON.stringify(payload),
                },
            );
            const result = await response.json();
            if (!response.ok) {
                alert(
                    result.errors
                        ? Object.values(result.errors).flat().join(" ")
                        : result.pesan ||
                              result.message ||
                              "Layanan gagal disimpan.",
                );
                return;
            }
            closeModal("modal-layanan");
            await loadKatalogAdmin();
        } catch (error) {
            alert("Layanan gagal disimpan. Periksa koneksi.");
        }
    });

    galeriForm?.addEventListener("submit", async (event) => {
        event.preventDefault();
        const id = document.getElementById("galeri-id").value;
        const formData = new FormData();
        formData.append("judul", document.getElementById("galeri-judul").value);
        formData.append(
            "kategori",
            document.getElementById("galeri-kategori").value,
        );
        const layananId = document.getElementById("galeri-layanan").value;
        if (layananId) formData.append("layanan_id", layananId);
        const file = document.getElementById("galeri-foto").files[0];
        if (file) formData.append("foto", file);

        try {
            const response = await fetch(
                id ? `/api/admin/galeri/${id}` : "/api/admin/galeri",
                {
                    method: "POST",
                    headers: apiHeaders(),
                    body: formData,
                },
            );
            const result = await response.json();
            if (!response.ok) {
                alert(
                    result.errors
                        ? Object.values(result.errors).flat().join(" ")
                        : result.pesan ||
                              result.message ||
                              "Galeri gagal disimpan.",
                );
                return;
            }
            closeModal("modal-galeri");
            await loadKatalogAdmin();
        } catch (error) {
            alert("Galeri gagal disimpan. Periksa koneksi.");
        }
    });

    async function deleteLayanan(id) {
        try {
            const response = await fetch(`/api/admin/layanan/${id}`, {
                method: "DELETE",
                headers: apiHeaders(),
            });
            const result = await response.json();
            if (!response.ok) {
                alert(
                    result.pesan || result.message || "Layanan gagal dihapus.",
                );
                return;
            }
            await loadKatalogAdmin();
        } catch (error) {
            alert("Layanan gagal dihapus. Periksa koneksi.");
        }
    }

    async function deleteGaleri(id) {
        try {
            const response = await fetch(`/api/admin/galeri/${id}`, {
                method: "DELETE",
                headers: apiHeaders(),
            });
            const result = await response.json();
            if (!response.ok) {
                alert(
                    result.pesan || result.message || "Galeri gagal dihapus.",
                );
                return;
            }
            await loadKatalogAdmin();
        } catch (error) {
            alert("Galeri gagal dihapus. Periksa koneksi.");
        }
    }

    sidebarBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            if (btn.getAttribute("data-tab") === "layanan") loadKatalogAdmin();
            if (btn.getAttribute("data-tab") === "pesanan") loadPesananAdmin();
            if (btn.getAttribute("data-tab") === "jadwal") loadJadwalAdmin();
            if (btn.getAttribute("data-tab") === "testimoni") loadTestimoniAdmin();
            if (btn.getAttribute("data-tab") === "laporan") loadLaporanAdmin();
        });
    });

    document.addEventListener("change", (event) => {
        const toggle = event.target.closest(".testimoni-toggle");
        if (!toggle) return;
        fetch(`/api/admin/testimoni/${toggle.dataset.id}`, {
            method: "PATCH",
            headers: apiHeaders({ "Content-Type": "application/json" }),
            body: JSON.stringify({ tampil: toggle.checked }),
        }).then(async (response) => {
            const result = await response.json();
            if (!response.ok) throw new Error(result.pesan || "Testimoni gagal diperbarui");
            await loadTestimoniAdmin();
        }).catch((error) => {
            toggle.checked = !toggle.checked;
            alert(error.message);
        });
    });

    document.addEventListener("click", (event) => {
        const button = event.target.closest(".btn-delete-testimoni");
        if (!button) return;
        if (!confirm("Hapus testimoni ini?")) return;

        fetch(`/api/admin/testimoni/${button.dataset.id}`, {
            method: "DELETE",
            headers: apiHeaders(),
        }).then(async (response) => {
            const result = await response.json();
            if (!response.ok) throw new Error(result.pesan || "Testimoni gagal dihapus");
            await loadTestimoniAdmin();
        }).catch((error) => alert(error.message));
    });

    loadDashboardAdmin();
    loadPesananAdmin();

    // ── Sidebar Active State Styling (CSS-driven via .active class) ───
    // The CSS for .admin-sidebar-btn.active is handled by admin.css below.
});
