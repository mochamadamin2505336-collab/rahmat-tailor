/**
 * Rahmat Tailor — Admin Panel (Vanilla JS)
 * Tab switching, sidebar, modals, search/filter, status progression, print.
 */

document.addEventListener('DOMContentLoaded', () => {
  // ── Sidebar Tab Switching ──────────────────────────────────────────
  const sidebarBtns = document.querySelectorAll('.admin-sidebar-btn');
  const tabPanels   = document.querySelectorAll('.tab-panel');
  const pageTitle   = document.getElementById('page-title');

  const tabTitles = {
    dashboard: 'Dashboard',
    pesanan:   'Pesanan Jahit',
    jadwal:    'Jadwal Ukur',
    ukuran:    'Riwayat Ukuran',
    layanan:   'Layanan & Galeri',
    testimoni: 'Testimoni',
    laporan:   'Laporan Keuangan',
  };

  function switchTab(tabId) {
    tabPanels.forEach(p => p.classList.add('hidden'));
    sidebarBtns.forEach(b => b.classList.remove('active'));

    const target = document.getElementById('tab-' + tabId);
    if (target) target.classList.remove('hidden');

    sidebarBtns.forEach(b => {
      if (b.getAttribute('data-tab') === tabId) b.classList.add('active');
    });

    if (pageTitle) pageTitle.textContent = tabTitles[tabId] || tabId;
    closeSidebar();
  }

  sidebarBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const tab = btn.getAttribute('data-tab');
      if (tab) switchTab(tab);
    });
  });


  // ── Mobile Sidebar Toggle ─────────────────────────────────────────
  const sidebar        = document.getElementById('admin-sidebar');
  const sidebarToggle  = document.getElementById('sidebar-toggle');
  const sidebarOverlay = document.getElementById('sidebar-overlay');

  function openSidebar() {
    sidebar.classList.remove('-translate-x-full');
    sidebarOverlay.classList.remove('hidden');
  }

  function closeSidebar() {
    if (window.innerWidth < 1024) {
      sidebar.classList.add('-translate-x-full');
      sidebarOverlay.classList.add('hidden');
    }
  }

  if (sidebarToggle) sidebarToggle.addEventListener('click', openSidebar);
  if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);


  // ── Modal Management ──────────────────────────────────────────────
  function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }

  function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
  }

  // Close buttons inside modals
  document.querySelectorAll('.modal-close').forEach(btn => {
    btn.addEventListener('click', () => {
      const modal = btn.closest('[id^="modal-"]');
      if (modal) closeModal(modal.id);
    });
  });

  // Close modal on backdrop click
  document.querySelectorAll('[id^="modal-"]').forEach(modal => {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) closeModal(modal.id);
    });
  });

  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      document.querySelectorAll('[id^="modal-"]').forEach(modal => {
        if (!modal.classList.contains('hidden')) closeModal(modal.id);
      });
    }
  });


  // ── Order Detail Modal ────────────────────────────────────────────
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-detail');
    if (!btn) return;

    const code = btn.getAttribute('data-order');
    const detailCode = document.getElementById('detail-code');
    if (detailCode) detailCode.textContent = code;

    // Fill sample data based on the row
    const row = document.querySelector(`tr[data-code="${code}"]`);
    if (row) {
      const cells = row.querySelectorAll('td');
      const customer = document.getElementById('detail-customer');
      const service  = document.getElementById('detail-service');
      if (customer && cells[1]) customer.textContent = cells[1].textContent.trim();
      if (service && cells[3])  service.textContent  = cells[3].textContent.trim();
    }

    openModal('modal-detail');
  });


  // ── Payment Modal ─────────────────────────────────────────────────
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-payment');
    if (!btn) return;

    const code = btn.getAttribute('data-order');
    const paymentCode = document.getElementById('payment-code');
    if (paymentCode) paymentCode.textContent = code;

    openModal('modal-payment');
  });


  // ── Offline Order Modal (PB-18) ───────────────────────────────────
  const btnNewOffline = document.getElementById('btn-new-offline');
  const offlineCode   = document.getElementById('offline-generated-code');
  const offlineForm   = document.getElementById('offline-order-form');
  const offlineGarment = document.getElementById('offline-garment-category');
  const offlineFeedback = document.getElementById('offline-form-feedback');

  function generateOrderCode() {
    const chars  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    const now    = new Date();
    const prefix = 'RT-' + String(now.getFullYear()).slice(-2) + String(now.getMonth() + 1).padStart(2, '0');
    let suffix = '';
    for (let i = 0; i < 2; i++) {
      suffix += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return prefix + suffix;
  }

  function updateOfflineMeasurementFields(category) {
    document.querySelectorAll('.offline-measurement-pane').forEach(pane => {
      const isActive = pane.id === `offline-measurements-${category}`;
      pane.classList.toggle('hidden', !isActive);

      pane.querySelectorAll('.offline-measurement-input').forEach(input => {
        input.disabled = !isActive;
        input.required = isActive;
      });
    });
  }

  if (offlineGarment) {
    offlineGarment.addEventListener('change', () => {
      updateOfflineMeasurementFields(offlineGarment.value);
    });
    updateOfflineMeasurementFields(offlineGarment.value);
  }

  if (btnNewOffline) {
    btnNewOffline.addEventListener('click', () => {
      if (offlineCode) offlineCode.textContent = generateOrderCode();
      if (offlineForm) offlineForm.reset();
      if (offlineFeedback) {
        offlineFeedback.classList.add('hidden');
        offlineFeedback.textContent = '';
      }
      if (offlineGarment) updateOfflineMeasurementFields(offlineGarment.value);
      openModal('modal-offline');
    });
  }

  if (offlineForm) {
    offlineForm.addEventListener('submit', (event) => {
      event.preventDefault();

      if (offlineFeedback) {
        offlineFeedback.textContent = 'Data pesanan offline dan ukuran lengkap, siap diproses.';
        offlineFeedback.classList.remove('hidden');
      }
    });
  }


  // ── Print Invoice Modal ───────────────────────────────────────────
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-print');
    if (!btn) return;

    const code = btn.getAttribute('data-order');
    const invoiceCode     = document.getElementById('invoice-code');
    const invoiceDate     = document.getElementById('invoice-date');
    const invoiceCustomer = document.getElementById('invoice-customer');
    const invoiceService  = document.getElementById('invoice-service');

    if (invoiceCode)     invoiceCode.textContent     = code;
    if (invoiceDate)     invoiceDate.textContent     = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

    const row = document.querySelector(`tr[data-code="${code}"]`);
    if (row) {
      const cells = row.querySelectorAll('td');
      if (invoiceCustomer && cells[1]) invoiceCustomer.textContent = cells[1].textContent.trim();
      if (invoiceService && cells[3])  invoiceService.textContent  = cells[3].textContent.trim();
    }

    openModal('modal-print');
  });

  // Print action button
  const btnPrintAction = document.getElementById('btn-print-action');
  if (btnPrintAction) {
    btnPrintAction.addEventListener('click', () => window.print());
  }


  // ── Status Advancement (1-click, PB-12) ───────────────────────────
  const statusFlow = ['verifikasi', 'diterima', 'dipotong', 'dijahit', 'fitting', 'selesai', 'siap-diambil'];

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-advance-status');
    if (!btn) return;

    const current = btn.getAttribute('data-current');
    const code    = btn.getAttribute('data-order');
    const idx     = statusFlow.indexOf(current);

    if (idx < 0 || idx >= statusFlow.length - 1) return;

    const next     = statusFlow[idx + 1];
    const nextLabel = next.charAt(0).toUpperCase() + next.slice(1).replace('-', ' ');

    if (!confirm(`Naikkan status ${code} dari "${current}" ke "${nextLabel}"?`)) return;

    // Update the row's status badge
    const row = document.querySelector(`tr[data-code="${code}"]`);
    if (row) {
      row.setAttribute('data-status', next);
      const badge = row.querySelector('.status-badge');
      if (badge) {
        badge.className = `status-badge status-badge-${next}`;
        badge.textContent = `● ${nextLabel}`;
      }
    }

    btn.setAttribute('data-current', next);
  });


  // ── Search & Filter Orders ────────────────────────────────────────
  const searchInput   = document.getElementById('order-search');
  const filterStatus  = document.getElementById('filter-status');
  const filterSource  = document.getElementById('filter-source');
  const ordersTable   = document.getElementById('orders-tbody');

  function filterOrders() {
    if (!ordersTable) return;

    const query  = (searchInput?.value || '').toLowerCase();
    const status = filterStatus?.value || '';
    const source = filterSource?.value || '';

    ordersTable.querySelectorAll('.order-row').forEach(row => {
      const rowStatus = row.getAttribute('data-status');
      const rowSource = row.getAttribute('data-source');
      const rowName   = (row.getAttribute('data-name') || '').toLowerCase();
      const rowCode   = (row.getAttribute('data-code') || '').toLowerCase();

      const matchSearch = !query || rowName.includes(query) || rowCode.includes(query);
      const matchStatus = !status || rowStatus === status;
      const matchSource = !source || rowSource === source;

      row.style.display = (matchSearch && matchStatus && matchSource) ? '' : 'none';
    });
  }

  if (searchInput)  searchInput.addEventListener('input', filterOrders);
  if (filterStatus) filterStatus.addEventListener('change', filterOrders);
  if (filterSource) filterSource.addEventListener('change', filterOrders);


  // ── Sidebar Active State Styling (CSS-driven via .active class) ───
  // The CSS for .admin-sidebar-btn.active is handled by admin.css below.
});
