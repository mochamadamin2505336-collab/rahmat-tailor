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
    trackerForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const code = trackerInput.value.trim() || 'RT-2024-089';

      // Trigger loading state
      trackerSpinner.classList.remove('hidden');
      trackerBtnText.textContent = 'Mencari...';
      trackerResult.style.opacity = '0.5';

      setTimeout(() => {
        trackerSpinner.classList.add('hidden');
        trackerBtnText.textContent = 'Cari Status';
        trackerResult.style.opacity = '1';
        trackerCodeBadge.textContent = `Pesanan Terkonfirmasi • #${code.toUpperCase()}`;

        // Animate highlight
        trackerCard.classList.add('ring-2', 'ring-primary');
        setTimeout(() => {
          trackerCard.classList.remove('ring-2', 'ring-primary');
        }, 1000);
      }, 600);
    });
  }

  // 5. Booking Form Submission Feedback
  const bookingForm = document.getElementById('booking-form');
  const bookingSubmitBtn = document.getElementById('booking-submit-btn');
  const bookingSpinner = document.getElementById('booking-spinner');
  const bookingBtnText = document.getElementById('booking-btn-text');
  const bookingToast = document.getElementById('booking-toast');

  if (bookingForm) {
    bookingForm.addEventListener('submit', (e) => {
      e.preventDefault();
      bookingSpinner.classList.remove('hidden');
      bookingBtnText.textContent = 'Memproses Jadwal...';
      bookingSubmitBtn.disabled = true;

      setTimeout(() => {
        bookingSpinner.classList.add('hidden');
        bookingBtnText.textContent = 'Jadwal Terkonfirmasi ✓';
        bookingToast.classList.remove('hidden');

        // Reset button text after delay
        setTimeout(() => {
          bookingBtnText.textContent = 'Konfirmasi Jadwal Ukur Sekarang';
          bookingSubmitBtn.disabled = false;
        }, 5000);
      }, 900);
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
