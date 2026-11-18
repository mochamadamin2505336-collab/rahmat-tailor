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

  // ── Riwayat Ukuran dari Database ──────────────────────────────────
  const ukuranList = document.getElementById('ukuran-history-list');
  const ukuranSearch = document.getElementById('ukuran-search');
  let riwayatUkuranLoaded = false;

  const labelUkuran = {
    kategori: 'Kategori',
    lingkar_pinggang_celana: 'Lingkar Pinggang Celana',
    lingkar_panggul_celana: 'Lingkar Panggul Celana',
    lingkar_pesak: 'Lingkar Pesak',
    lingkar_paha: 'Lingkar Paha',
    lingkar_lutut: 'Lingkar Lutut',
    lingkar_celana_bawah: 'Lingkar Celana Bawah',
    panjang_celana: 'Panjang Celana',
    lebar_punggung: 'Lebar Punggung',
    lebar_bahu: 'Lebar Bahu',
    panjang_lengan: 'Panjang Lengan',
    lingkar_lengan_atas: 'Lingkar Lengan Atas',
    lingkar_lengan_bawah: 'Lingkar Lengan Bawah',
    lingkar_dada: 'Lingkar Dada',
    lingkar_pinggang_baju: 'Lingkar Pinggang Baju',
    lingkar_panggul_baju: 'Lingkar Panggul Baju',
    panjang_baju: 'Panjang Baju',
    lingkar_pinggang_rok: 'Lingkar Pinggang Rok',
    lingkar_panggul_rok: 'Lingkar Panggul Rok',
    panjang_rok: 'Panjang Rok'
  };

  function renderUkuranCustomer(container, pelanggan, ukuranRows) {
    ukuranRows.forEach((ukuran) => {
      const card = document.createElement('article');
      card.className = 'p-5 hover:bg-[#221f1d] transition-colors ukuran-customer';
      card.dataset.name = `${pelanggan.nama} ${pelanggan.no_whatsapp}`;

      const header = document.createElement('div');
      header.className = 'flex flex-wrap items-center justify-between gap-3 mb-3';

      const identity = document.createElement('div');
      const name = document.createElement('p');
      name.className = 'text-sm font-semibold text-white';
      name.textContent = pelanggan.nama;
      const date = document.createElement('p');
      date.className = 'text-xs text-[#a8a29e]';
      const updated = ukuran.updated_at ? new Date(ukuran.updated_at).toLocaleDateString('id-ID') : '-';
      date.textContent = `Terakhir diubah: ${updated} | Kategori: ${ukuran.kategori || '-'}`;
      identity.append(name, date);
      header.append(identity);
      card.append(header);

      const grid = document.createElement('div');
      grid.className = 'grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-3';

      Object.entries(labelUkuran).forEach(([key, label]) => {
        if (key === 'kategori' || ukuran[key] === null || ukuran[key] === undefined) return;
        const box = document.createElement('div');
        box.className = 'bg-[#181615] rounded-lg p-2.5 text-center';
        const labelElement = document.createElement('p');
        labelElement.className = 'text-[10px] text-[#78716c] uppercase tracking-wider';
        labelElement.textContent = label;
        const value = document.createElement('p');
        value.className = 'text-sm font-bold text-white mt-0.5';
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
    ukuranList.innerHTML = '<p class="p-5 text-sm text-[#a8a29e]">Memuat riwayat ukuran...</p>';

    try {
      const response = await fetch('/api/admin/pelanggan', { headers: { 'Accept': 'application/json' } });
      if (!response.ok) throw new Error('Gagal memuat pelanggan');
      const daftar = await response.json();

      ukuranList.innerHTML = '';
      const pelangganRows = daftar.data || [];
      if (pelangganRows.length === 0) {
        ukuranList.innerHTML = '<p class="p-5 text-sm text-[#a8a29e]">Belum ada riwayat ukuran pelanggan.</p>';
        return;
      }

      await Promise.all(pelangganRows.map(async (pelangganRingkas) => {
        const detailResponse = await fetch(`/api/admin/pelanggan/${pelangganRingkas.id}`, { headers: { 'Accept': 'application/json' } });
        if (!detailResponse.ok) return;
        const detail = await detailResponse.json();
        if (detail.ukuran?.length) renderUkuranCustomer(ukuranList, detail.pelanggan, detail.ukuran);
      }));

      if (!ukuranList.querySelector('.ukuran-customer')) {
        ukuranList.innerHTML = '<p class="p-5 text-sm text-[#a8a29e]">Belum ada riwayat ukuran pelanggan.</p>';
      }
    } catch (error) {
      ukuranList.innerHTML = '<p class="p-5 text-sm text-red-400">Riwayat ukuran tidak dapat dimuat.</p>';
    }
  }

  sidebarBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      if (btn.getAttribute('data-tab') === 'ukuran') loadRiwayatUkuran();
    });
  });

  ukuranSearch?.addEventListener('input', () => {
    const query = ukuranSearch.value.trim().toLowerCase();
    ukuranList?.querySelectorAll('.ukuran-customer').forEach((card) => {
      card.style.display = !query || card.dataset.name.toLowerCase().includes(query) ? '' : 'none';
    });
  });

  // ── CRUD Layanan & Galeri ─────────────────────────────────────────
  const layananList = document.getElementById('layanan-list');
  const galeriList = document.getElementById('galeri-list');
  const layananForm = document.getElementById('layanan-form');
  const galeriForm = document.getElementById('galeri-form');
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
  let layananData = [];
  let galeriData = [];

  const apiHeaders = (extra = {}) => ({
    'Accept': 'application/json',
    'X-CSRF-TOKEN': csrfToken,
    ...extra
  });

  const rupiah = (value) => new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    maximumFractionDigits: 0
  }).format(Number(value || 0));

  const textValue = (value) => {
    const span = document.createElement('span');
    span.textContent = value || '';
    return span.innerHTML;
  };

  async function loadKatalogAdmin() {
    if (!layananList || !galeriList) return;
    layananList.innerHTML = '<p class="p-5 text-sm text-[#a8a29e]">Memuat layanan...</p>';
    galeriList.innerHTML = '<p class="col-span-full text-sm text-[#a8a29e]">Memuat galeri...</p>';

    try {
      const [layananResponse, galeriResponse] = await Promise.all([
        fetch('/api/admin/layanan', { headers: apiHeaders() }),
        fetch('/api/admin/galeri', { headers: apiHeaders() })
      ]);
      if (!layananResponse.ok || !galeriResponse.ok) throw new Error('Gagal memuat katalog');

      layananData = await layananResponse.json();
      galeriData = await galeriResponse.json();
      renderLayanan();
      renderGaleri();
      updateLayananSelect();
    } catch (error) {
      layananList.innerHTML = '<p class="p-5 text-sm text-red-400">Layanan tidak dapat dimuat.</p>';
      galeriList.innerHTML = '<p class="col-span-full text-sm text-red-400">Galeri tidak dapat dimuat.</p>';
    }
  }

  function renderLayanan() {
    if (layananData.length === 0) {
      layananList.innerHTML = '<p class="p-5 text-sm text-[#a8a29e]">Belum ada layanan.</p>';
      return;
    }

    layananList.innerHTML = layananData.map((item) => `
      <div class="flex items-center justify-between p-4 hover:bg-[#221f1d] transition-colors">
        <div>
          <p class="text-sm font-semibold text-white">${textValue(item.nama)}</p>
          <p class="text-xs text-[#c59b27] font-semibold mt-0.5">${rupiah(item.harga_min)} - ${rupiah(item.harga_max)}</p>
          <p class="text-[11px] text-[#78716c] mt-1">${item.aktif ? 'Aktif' : 'Tidak aktif'} | ${item.estimasi_hari} hari</p>
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
    `).join('');
  }

  function renderGaleri() {
    if (galeriData.length === 0) {
      galeriList.innerHTML = '<p class="col-span-full text-sm text-[#a8a29e]">Belum ada foto galeri.</p>';
      return;
    }

    galeriList.innerHTML = galeriData.map((item) => `
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
    `).join('');
  }

  function updateLayananSelect() {
    const select = document.getElementById('galeri-layanan');
    if (!select) return;
    select.innerHTML = '<option value="">Tidak terkait</option>';
    layananData.forEach((item) => {
      const option = document.createElement('option');
      option.value = String(item.id);
      option.textContent = item.nama;
      select.append(option);
    });
  }

  function resetLayananForm() {
    layananForm?.reset();
    document.getElementById('layanan-id').value = '';
    document.getElementById('layanan-aktif').checked = true;
    document.getElementById('layanan-urutan').value = '0';
    document.getElementById('modal-layanan-title').textContent = 'Tambah Layanan';
  }

  function resetGaleriForm() {
    galeriForm?.reset();
    document.getElementById('galeri-id').value = '';
    document.getElementById('galeri-foto').required = true;
    document.getElementById('modal-galeri-title').textContent = 'Upload Galeri';
  }

  document.getElementById('btn-add-layanan')?.addEventListener('click', () => {
    resetLayananForm();
    openModal('modal-layanan');
  });

  document.getElementById('btn-add-galeri')?.addEventListener('click', () => {
    resetGaleriForm();
    openModal('modal-galeri');
  });

  layananList?.addEventListener('click', (event) => {
    const edit = event.target.closest('.btn-edit-layanan');
    const remove = event.target.closest('.btn-delete-layanan');
    if (edit) {
      const item = layananData.find((row) => row.id === Number(edit.dataset.id));
      if (!item) return;
      document.getElementById('layanan-id').value = item.id;
      document.getElementById('layanan-nama').value = item.nama;
      document.getElementById('layanan-kategori').value = item.kategori;
      document.getElementById('layanan-deskripsi').value = item.deskripsi || '';
      document.getElementById('layanan-harga-min').value = item.harga_min;
      document.getElementById('layanan-harga-max').value = item.harga_max;
      document.getElementById('layanan-estimasi').value = item.estimasi_hari;
      document.getElementById('layanan-urutan').value = item.urutan;
      document.getElementById('layanan-aktif').checked = Boolean(item.aktif);
      document.getElementById('modal-layanan-title').textContent = 'Edit Layanan';
      openModal('modal-layanan');
    }
    if (remove) {
      const item = layananData.find((row) => row.id === Number(remove.dataset.id));
      if (item && confirm(`Hapus layanan "${item.nama}"?`)) deleteLayanan(item.id);
    }
  });

  galeriList?.addEventListener('click', (event) => {
    const edit = event.target.closest('.btn-edit-galeri');
    const remove = event.target.closest('.btn-delete-galeri');
    if (edit) {
      const item = galeriData.find((row) => row.id === Number(edit.dataset.id));
      if (!item) return;
      document.getElementById('galeri-id').value = item.id;
      document.getElementById('galeri-judul').value = item.judul;
      document.getElementById('galeri-kategori').value = item.kategori;
      document.getElementById('galeri-layanan').value = item.layanan_id ? String(item.layanan_id) : '';
      document.getElementById('galeri-foto').required = false;
      document.getElementById('modal-galeri-title').textContent = 'Edit Galeri';
      openModal('modal-galeri');
    }
    if (remove) {
      const item = galeriData.find((row) => row.id === Number(remove.dataset.id));
      if (item && confirm(`Hapus foto "${item.judul}"?`)) deleteGaleri(item.id);
    }
  });

  layananForm?.addEventListener('submit', async (event) => {
    event.preventDefault();
    const id = document.getElementById('layanan-id').value;
    const payload = {
      nama: document.getElementById('layanan-nama').value,
      kategori: document.getElementById('layanan-kategori').value,
      deskripsi: document.getElementById('layanan-deskripsi').value,
      harga_min: Number(document.getElementById('layanan-harga-min').value),
      harga_max: Number(document.getElementById('layanan-harga-max').value),
      estimasi_hari: Number(document.getElementById('layanan-estimasi').value),
      urutan: Number(document.getElementById('layanan-urutan').value),
      aktif: document.getElementById('layanan-aktif').checked
    };

    try {
      const response = await fetch(id ? `/api/admin/layanan/${id}` : '/api/admin/layanan', {
        method: id ? 'PUT' : 'POST',
        headers: apiHeaders({ 'Content-Type': 'application/json' }),
        body: JSON.stringify(payload)
      });
      const result = await response.json();
      if (!response.ok) {
        alert(result.errors ? Object.values(result.errors).flat().join(' ') : (result.pesan || result.message || 'Layanan gagal disimpan.'));
        return;
      }
      closeModal('modal-layanan');
      await loadKatalogAdmin();
    } catch (error) {
      alert('Layanan gagal disimpan. Periksa koneksi.');
    }
  });

  galeriForm?.addEventListener('submit', async (event) => {
    event.preventDefault();
    const id = document.getElementById('galeri-id').value;
    const formData = new FormData();
    formData.append('judul', document.getElementById('galeri-judul').value);
    formData.append('kategori', document.getElementById('galeri-kategori').value);
    const layananId = document.getElementById('galeri-layanan').value;
    if (layananId) formData.append('layanan_id', layananId);
    const file = document.getElementById('galeri-foto').files[0];
    if (file) formData.append('foto', file);

    try {
      const response = await fetch(id ? `/api/admin/galeri/${id}` : '/api/admin/galeri', {
        method: 'POST',
        headers: apiHeaders(),
        body: formData
      });
      const result = await response.json();
      if (!response.ok) {
        alert(result.errors ? Object.values(result.errors).flat().join(' ') : (result.pesan || result.message || 'Galeri gagal disimpan.'));
        return;
      }
      closeModal('modal-galeri');
      await loadKatalogAdmin();
    } catch (error) {
      alert('Galeri gagal disimpan. Periksa koneksi.');
    }
  });

  async function deleteLayanan(id) {
    try {
      const response = await fetch(`/api/admin/layanan/${id}`, { method: 'DELETE', headers: apiHeaders() });
      const result = await response.json();
      if (!response.ok) {
        alert(result.pesan || result.message || 'Layanan gagal dihapus.');
        return;
      }
      await loadKatalogAdmin();
    } catch (error) {
      alert('Layanan gagal dihapus. Periksa koneksi.');
    }
  }

  async function deleteGaleri(id) {
    try {
      const response = await fetch(`/api/admin/galeri/${id}`, { method: 'DELETE', headers: apiHeaders() });
      const result = await response.json();
      if (!response.ok) {
        alert(result.pesan || result.message || 'Galeri gagal dihapus.');
        return;
      }
      await loadKatalogAdmin();
    } catch (error) {
      alert('Galeri gagal dihapus. Periksa koneksi.');
    }
  }

  sidebarBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      if (btn.getAttribute('data-tab') === 'layanan') loadKatalogAdmin();
    });
  });


  // ── Sidebar Active State Styling (CSS-driven via .active class) ───
  // The CSS for .admin-sidebar-btn.active is handled by admin.css below.
});
