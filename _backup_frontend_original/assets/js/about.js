// Timeline Carousel
(function() {
  const timelineTrack = document.getElementById('timelineTrack');
  const prevBtn = document.getElementById('timelinePrev');
  const nextBtn = document.getElementById('timelineNext');
  const items = document.querySelectorAll('.timeline-item');

  if (!timelineTrack || !prevBtn || !nextBtn || items.length === 0) return;

  let currentIndex = 0;
  let itemsPerView = 3;

  function updateItemsPerView() {
    if (window.innerWidth < 576) {
      itemsPerView = 1;
    } else if (window.innerWidth < 992) {
      itemsPerView = 2;
    } else {
      itemsPerView = 3;
    }
    updateTimeline();
  }

  function updateTimeline() {
    const totalItems = items.length;
    const maxIndex = Math.max(0, totalItems - itemsPerView);

    if (currentIndex > maxIndex) {
      currentIndex = maxIndex;
    }

    const itemWidth = items[0].offsetWidth;
    const gap = 32; // 2rem in pixels
    const offset = currentIndex * (itemWidth + gap);

    timelineTrack.style.transform = `translateX(-${offset}px)`;

    prevBtn.disabled = currentIndex === 0;
    nextBtn.disabled = currentIndex >= maxIndex;
  }

  function goToPrev() {
    if (currentIndex > 0) {
      currentIndex--;
      updateTimeline();
    }
  }

  function goToNext() {
    const maxIndex = Math.max(0, items.length - itemsPerView);
    if (currentIndex < maxIndex) {
      currentIndex++;
      updateTimeline();
    }
  }

  prevBtn.addEventListener('click', goToPrev);
  nextBtn.addEventListener('click', goToNext);
  window.addEventListener('resize', updateItemsPerView);

  updateItemsPerView();
})();

// Board Members Carousel
(function() {
  const carousel = document.getElementById('boardCarousel');
  const prevBtn = document.getElementById('boardPrev');
  const nextBtn = document.getElementById('boardNext');
  const items = document.querySelectorAll('.team-member-item');

  if (!carousel || !prevBtn || !nextBtn || items.length === 0) return;

  let currentIndex = 0;
  let itemsPerView = 4;

  function updateItemsPerView() {
    if (window.innerWidth < 576) {
      itemsPerView = 1;
    } else if (window.innerWidth < 992) {
      itemsPerView = 2;
    } else {
      itemsPerView = 4;
    }
    updateCarousel();
  }

  function updateCarousel() {
    const totalItems = items.length;
    const maxIndex = Math.max(0, totalItems - itemsPerView);

    if (currentIndex > maxIndex) {
      currentIndex = maxIndex;
    }

    const itemWidth = items[0].offsetWidth;
    const gap = 24; // 1.5rem in pixels
    const offset = currentIndex * (itemWidth + gap);

    carousel.style.transform = `translateX(-${offset}px)`;

    prevBtn.disabled = currentIndex === 0;
    nextBtn.disabled = currentIndex >= maxIndex;
  }

  function goToPrev() {
    if (currentIndex > 0) {
      currentIndex--;
      updateCarousel();
    }
  }

  function goToNext() {
    const maxIndex = Math.max(0, items.length - itemsPerView);
    if (currentIndex < maxIndex) {
      currentIndex++;
      updateCarousel();
    }
  }

  prevBtn.addEventListener('click', goToPrev);
  nextBtn.addEventListener('click', goToNext);
  window.addEventListener('resize', updateItemsPerView);

  updateItemsPerView();
})();

// Vertical Timeline Navigation and Scroll Animation
(function() {
  const yearItems = document.querySelectorAll('.timeline-year-item');
  const contentItems = document.querySelectorAll('.timeline-fullwidth-item');

  // Click handler for year navigation
  yearItems.forEach(item => {
    item.addEventListener('click', function() {
      const year = this.getAttribute('data-year');
      const targetSection = document.getElementById('timeline-' + year);

      if (targetSection) {
        // Remove active class from all year items
        yearItems.forEach(y => y.classList.remove('active'));
        // Add active class to clicked item
        this.classList.add('active');

        // Scroll to target section
        targetSection.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  // Intersection Observer for scroll animations
  const observerOptions = {
    root: null,
    rootMargin: '-20% 0px -20% 0px',
    threshold: 0.5
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');

        // Update active year based on visible section
        const sectionId = entry.target.getAttribute('id');
        if (sectionId) {
          const year = sectionId.replace('timeline-', '');
          yearItems.forEach(item => {
            if (item.getAttribute('data-year') === year) {
              yearItems.forEach(y => y.classList.remove('active'));
              item.classList.add('active');
            }
          });
        }
      }
    });
  }, observerOptions);

  // Observe all timeline content items
  contentItems.forEach(item => {
    observer.observe(item);
  });
})();

// Smooth scroll for any internal links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    // Skip links with data-coming-soon attribute
    if (this.hasAttribute('data-coming-soon')) {
      return;
    }

    const href = this.getAttribute('href');
    if (href !== '#') {
      e.preventDefault();
      const target = document.querySelector(href);
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    }
  });
});

// Show/hide timeline navigation based on timeline section visibility
(function() {
  const timelineNav = document.querySelector('.timeline-years-nav-floating');
  const timelineSection = document.querySelector('.vertical-timeline-section');

  if (!timelineNav || !timelineSection) return;

  function checkTimelineVisibility() {
    const rect = timelineSection.getBoundingClientRect();
    const windowHeight = window.innerHeight || document.documentElement.clientHeight;

    // Show when timeline section is in viewport
    // Hide when we've scrolled completely past it
    const sectionTop = rect.top;
    const sectionBottom = rect.bottom;

    // Show if: section has entered view AND we haven't scrolled completely past it
    const isVisible = sectionTop < windowHeight && sectionBottom > 100;

    if (isVisible) {
      timelineNav.classList.add('visible');
    } else {
      timelineNav.classList.remove('visible');
    }
  }

  // Check on scroll
  window.addEventListener('scroll', checkTimelineVisibility);

  // Check on load
  checkTimelineVisibility();
})();
