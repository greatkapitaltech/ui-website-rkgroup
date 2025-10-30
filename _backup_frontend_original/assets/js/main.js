// Companies Carousel
(function() {
  const carousel = document.getElementById('companiesCarousel');
  const prevBtn = document.getElementById('companiesPrev');
  const nextBtn = document.getElementById('companiesNext');
  const items = document.querySelectorAll('.company-carousel-item');

  let currentIndex = 0;
  let itemsPerView = 4;

  // Update items per view based on screen size
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

    // Prevent going beyond bounds
    if (currentIndex > maxIndex) {
      currentIndex = maxIndex;
    }

    // Calculate offset
    const itemWidth = items[0].offsetWidth;
    const gap = 24; // 1.5rem in pixels
    const offset = currentIndex * (itemWidth + gap);

    carousel.style.transform = `translateX(-${offset}px)`;

    // Update button states
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

  // Event listeners
  prevBtn.addEventListener('click', goToPrev);
  nextBtn.addEventListener('click', goToNext);
  window.addEventListener('resize', updateItemsPerView);

  // Initialize
  updateItemsPerView();
})();

// LinkedIn Feed Integration
(function() {
  const feedContainer = document.querySelector('.linkedin-posts-container');

  if (!feedContainer) return;

  // Simulate loading and show fallback content
  setTimeout(function() {
    feedContainer.innerHTML = `
      <div class="text-center py-4">
        <i class="fa-brands fa-linkedin fa-4x mb-3" style="color: var(--primary); opacity: 0.8;"></i>
        <h6 class="fw-bold mb-3">Connect with RK Group on LinkedIn</h6>
        <p class="text-muted mb-0">
          Stay updated with our latest company news, industry insights, and professional updates.
        </p>
        <div class="mt-4">
          <div class="d-flex flex-column gap-3 text-start">
            <div class="linkedin-post-item">
              <div class="d-flex align-items-start gap-3">
                <i class="fa-solid fa-building text-primary mt-1"></i>
                <div>
                  <p class="linkedin-post-content mb-2">
                    <strong>RK Group</strong> is expanding its portfolio across e-commerce, fintech, and retail sectors.
                  </p>
                  <p class="linkedin-post-meta mb-0">
                    <i class="fa-regular fa-clock"></i> Follow us for updates
                  </p>
                </div>
              </div>
            </div>
            <div class="linkedin-post-item">
              <div class="d-flex align-items-start gap-3">
                <i class="fa-solid fa-handshake text-primary mt-1"></i>
                <div>
                  <p class="linkedin-post-content mb-2">
                    <strong>Partnerships</strong> with leading brands like Amazon, Flipkart, Myntra, and more.
                  </p>
                  <p class="linkedin-post-meta mb-0">
                    <i class="fa-regular fa-clock"></i> Explore our network
                  </p>
                </div>
              </div>
            </div>
            <div class="linkedin-post-item">
              <div class="d-flex align-items-start gap-3">
                <i class="fa-solid fa-rocket text-primary mt-1"></i>
                <div>
                  <p class="linkedin-post-content mb-2">
                    <strong>Innovation</strong> at the core - transforming businesses with technology-driven solutions.
                  </p>
                  <p class="linkedin-post-meta mb-0">
                    <i class="fa-regular fa-clock"></i> Join our journey
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
  }, 1000);
})();

// Instagram Embed Integration
(function() {
  // Load Instagram embed script
  const script = document.createElement('script');
  script.src = 'https://www.instagram.com/embed.js';
  script.async = true;
  script.onload = function() {
    // Process Instagram embeds after script loads
    if (window.instgrm) {
      window.instgrm.Embeds.process();
    }
  };
  document.body.appendChild(script);

  // Re-process embeds when tabs are switched
  const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
  tabButtons.forEach(button => {
    button.addEventListener('shown.bs.tab', function() {
      if (window.instgrm) {
        window.instgrm.Embeds.process();
      }
    });
  });
})();

// Coming Soon Modal Handler
(function() {
  function initComingSoonModal() {
    const comingSoonLinks = document.querySelectorAll('[data-coming-soon]');
    const modalElement = document.getElementById('comingSoonModal');

    if (modalElement && comingSoonLinks.length > 0) {
      comingSoonLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const comingSoonModal = new bootstrap.Modal(modalElement);
          comingSoonModal.show();
        });
      });
    }
  }

  // Initialize immediately if DOM is ready, otherwise wait
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initComingSoonModal);
  } else {
    initComingSoonModal();
  }
})();
