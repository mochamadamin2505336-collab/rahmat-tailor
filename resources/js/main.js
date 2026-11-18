document.addEventListener('DOMContentLoaded', () => {
  // 1. Dynamic Interactive Underline Indicator for Navbar
  const mainNav = document.getElementById('main-nav');
  const navItems = document.querySelectorAll('.nav-item');
  const indicator = document.getElementById('nav-indicator');

  if (mainNav && indicator && navItems.length > 0) {
    let activeItem = document.querySelector('.nav-item[aria-current="page"]') || navItems[0];

    const updateIndicator = (target) => {
      if (!target) return;
      const navRect = mainNav.getBoundingClientRect();
      const targetRect = target.getBoundingClientRect();
      const left = targetRect.left - navRect.left;
      const width = targetRect.width;

      indicator.style.left = `${left}px`;
      indicator.style.width = `${width}px`;
      indicator.style.opacity = '1';
    };

    const setActive = (target) => {
      navItems.forEach(item => {
        item.removeAttribute('aria-current');
        item.classList.remove('text-primary', 'font-semibold');
        item.classList.add('text-gray-300', 'font-medium');
      });
      target.setAttribute('aria-current', 'page');
      target.classList.add('text-primary', 'font-semibold');
      target.classList.remove('text-gray-300', 'font-medium');
      activeItem = target;
      updateIndicator(target);
    };

    // Dipanggil dari menu mobile agar status aktif desktop ikut sinkron
    mainNav.addEventListener('nav:activate', (e) => {
      if (e.detail) setActive(e.detail);
    });

    // Set initial position
    updateIndicator(activeItem);

    navItems.forEach(item => {
      item.addEventListener('click', (e) => {
        // If clicking an internal hash link on the same page
        const href = item.getAttribute('href');
        if (href && href.startsWith('#')) {
          setActive(item);
        }
      });

      item.addEventListener('mouseenter', () => {
        updateIndicator(item);
      });
    });

    mainNav.addEventListener('mouseleave', () => {
      updateIndicator(activeItem);
    });

    window.addEventListener('resize', () => {
      updateIndicator(activeItem);
    });

    // ScrollSpy on homepage sections to auto-update navbar indicator
    const homeSections = document.querySelectorAll('section[id]');
    if (homeSections.length > 0) {
      window.addEventListener('scroll', () => {
        const scrollPosition = window.scrollY + 120;
        let currentSectionId = '';

        homeSections.forEach(section => {
          const top = section.offsetTop;
          const height = section.offsetHeight;
          if (scrollPosition >= top && scrollPosition < top + height) {
            currentSectionId = section.getAttribute('id');
          }
        });

        if (window.scrollY < 200) {
          const berandaItem = document.querySelector('.nav-item[data-path="beranda"]');
          if (berandaItem && activeItem !== berandaItem) {
            setActive(berandaItem);
          }
        } else if (currentSectionId) {
          const matchingItem = document.querySelector(`.nav-item[data-path="${currentSectionId}"], .nav-item[href="#${currentSectionId}"]`);
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
    rootMargin: '0px',
    threshold: 0.12
  };

  const revealObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  document.querySelectorAll('.reveal-element').forEach(el => {
    revealObserver.observe(el);
  });

  // 3. Interactive Portfolio Filtering Tabs
  const filterTabs = document.querySelectorAll('.gallery-tab');
  const galleryCards = document.querySelectorAll('.gallery-card');

  filterTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const filter = tab.getAttribute('data-filter');

      // Toggle active states on tabs
      filterTabs.forEach(t => {
        t.classList.remove('bg-white', 'text-charcoal', 'shadow-sm', 'font-semibold', 'border-b-2', 'border-primary');
        t.classList.add('text-on-surface-variant');
      });
      tab.classList.add('bg-white', 'text-charcoal', 'shadow-sm', 'font-semibold', 'border-b-2', 'border-primary');
      tab.classList.remove('text-on-surface-variant');

      // Filter and animate cards
      galleryCards.forEach(card => {
        const category = card.getAttribute('data-category');
        if (filter === 'all' || category === filter) {
          card.classList.remove('filter-hidden');
          setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0) scale(1)';
          }, 20);
        } else {
          card.style.opacity = '0';
          card.style.transform = 'scale(0.95)';
          setTimeout(() => {
            card.classList.add('filter-hidden');
          }, 300);
        }
      });
    });
  });

  // 4. Quick Order Tracker Micro-Interaction
  const trackerForm = document.getElementById('tracker-form');
  const trackerInput = document.getElementById('tracker-input');
  const trackerResult = document.getElementById('tracker-result');
  const trackerSpinner = document.getElementById('tracker-spinner');
  const trackerBtnText = document.getElementById('tracker-btn-text');
  const trackerCodeBadge = document.getElementById('tracker-code-badge');
  const trackerCard = document.getElementById('tracker-result-card');

  if (trackerForm) {
    trackerForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const digit = document.getElementById('tracker-digit');
      const resultBox = document.getElementById('tracking-sample-box');
      const token = document.querySelector('meta[name="csrf-token"]')?.content;

      try {
        const response = await fetch('/api/pelacakan', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token || ''
          },
          body: JSON.stringify({
            kode: trackerInput.value.trim(),
            empat_digit: digit?.value.trim()
          })
        });
        const result = await response.json();

        if (!response.ok) {
          resultBox.classList.remove('hidden');
          resultBox.innerHTML = `<p class="text-sm text-red-700">${result.errors ? Object.values(result.errors).flat().join(' ') : (result.pesan || 'Kode pesanan tidak cocok.')}</p>`;
          return;
        }

        resultBox.classList.remove('hidden');
        resultBox.innerHTML = `
          <div class="space-y-3">
            <span class="font-mono text-sm font-bold text-charcoal bg-white px-2.5 py-1 rounded border border-primary/40">${result.kode}</span>
            <h4 class="font-serif text-lg font-bold text-charcoal">${result.layanan}</h4>
            <p class="text-xs text-gray-600">Pemesan: <strong>${result.pemesan}</strong></p>
            <p class="text-sm font-bold text-[#94682a]">Status: ${result.status_label}</p>
          </div>
        `;
      } catch (error) {
        if (resultBox) {
          resultBox.classList.remove('hidden');
          resultBox.innerHTML = '<p class="text-sm text-red-700">Pelacakan belum dapat dijalankan. Periksa koneksi internet.</p>';
        }
      }
    });
  }

  // 5. Booking Form Submission Feedback
  const bookingForm = document.getElementById('booking-form');
  const bookingSubmitBtn = document.getElementById('booking-submit-btn');
  const bookingSpinner = document.getElementById('booking-spinner');
  const bookingBtnText = document.getElementById('booking-btn-text');
  const bookingToast = document.getElementById('booking-toast');

  if (bookingForm) {
    bookingForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      bookingSpinner?.classList.remove('hidden');
      if (bookingBtnText) bookingBtnText.textContent = 'Memproses Jadwal...';
      bookingSubmitBtn.disabled = true;
      const token = document.querySelector('meta[name="csrf-token"]')?.content;

      try {
        const response = await fetch('/api/jadwal', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token || ''
          },
          body: JSON.stringify({
            nama: document.getElementById('booking-name')?.value,
            no_whatsapp: document.getElementById('booking-whatsapp')?.value,
            jenis: 'ukur',
            jenis_jahitan: document.getElementById('booking-service')?.value,
            bahan: document.getElementById('booking-material')?.value,
            tanggal: document.getElementById('booking-date')?.value,
            jam: '09:00'
          })
        });
        const result = await response.json();

        if (bookingSpinner) bookingSpinner.classList.add('hidden');
        if (!response.ok) {
          bookingToast.textContent = result.errors ? Object.values(result.errors).flat().join(' ') : (result.message || 'Jadwal belum dapat disimpan.');
        } else {
          bookingToast.textContent = result.pesan || 'Jadwal tersimpan.';
          bookingForm.reset();
        }
        bookingToast.classList.remove('hidden');
      } catch (error) {
        if (bookingSpinner) bookingSpinner.classList.add('hidden');
        bookingToast.textContent = 'Jadwal belum dapat disimpan karena koneksi bermasalah.';
        bookingToast.classList.remove('hidden');
      } finally {
        if (bookingBtnText) bookingBtnText.textContent = 'Konfirmasi Booking Jadwal Ukur di Toko';
        bookingSubmitBtn.disabled = false;
      }
    });
  }

  // 6. Header backdrop shadow enhancement on scroll
  const header = document.getElementById('main-header');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
      header.classList.add('shadow-md');
    } else {
      header.classList.remove('shadow-md');
    }
  });

  // 7. Mobile Menu (Hamburger) untuk layar < 1024px
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  const mobileItems = document.querySelectorAll('.mobile-nav-item');

  if (menuToggle && mobileMenu) {
    const setMenu = (open) => {
      mobileMenu.classList.toggle('is-open', open);
      mobileMenu.setAttribute('aria-hidden', String(!open));
      menuToggle.setAttribute('aria-expanded', String(open));
      menuToggle.setAttribute('aria-label', open ? 'Tutup menu navigasi' : 'Buka menu navigasi');
    };

    menuToggle.addEventListener('click', () => {
      setMenu(!mobileMenu.classList.contains('is-open'));
    });

    mobileItems.forEach(item => {
      item.addEventListener('click', () => {
        // Status aktif pada menu mobile
        mobileItems.forEach(i => {
          i.removeAttribute('aria-current');
          i.classList.remove('text-primary', 'font-semibold');
          i.classList.add('text-gray-300', 'font-medium');
        });
        item.setAttribute('aria-current', 'page');
        item.classList.add('text-primary', 'font-semibold');
        item.classList.remove('text-gray-300', 'font-medium');

        // Sinkronkan dengan navbar desktop
        const desktopItem = document.querySelector(`.nav-item[data-path="${item.dataset.path}"]`);
        if (mainNav && desktopItem) {
          mainNav.dispatchEvent(new CustomEvent('nav:activate', { detail: desktopItem }));
        }

        setMenu(false);
      });
    });

    // Tutup saat klik di luar header, tekan Escape, atau layar melebar ke desktop
    document.addEventListener('click', (e) => {
      if (!header.contains(e.target)) setMenu(false);
    });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') setMenu(false);
    });
    window.addEventListener('resize', () => {
      if (window.innerWidth >= 1024) setMenu(false);
    });
  }
});
