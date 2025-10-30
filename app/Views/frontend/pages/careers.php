<!-- Careers Hero Section -->
<section class="vision-hero position-relative">
  <div class="vision-hero-bg"></div>
  <div class="vision-overlay"></div>
  <div class="container position-relative z-1 h-100 d-flex align-items-center">
    <div class="text-white">
      <h1 class="display-3 fw-bold mb-3"><?= isset($settings['careers_hero_title']) ? esc($settings['careers_hero_title']) : 'JOIN OUR TEAM' ?></h1>
      <p class="h5 fw-normal"><?= isset($settings['careers_hero_subtitle']) ? esc($settings['careers_hero_subtitle']) : 'Explore Exciting Career Opportunities At RK Group' ?></p>
    </div>
  </div>
</section>

<!-- Careers Intro Section -->
<section class="py-5" style="background: #f8f9fa;">
  <div class="container text-center">
    <h2 class="section-title text-primary mb-3"><?= isset($settings['careers_intro_title']) ? esc($settings['careers_intro_title']) : 'BUILD YOUR FUTURE WITH US' ?></h2>
    <p class="fs-5 text-secondary mb-3"><?= isset($settings['careers_intro_tagline']) ? esc($settings['careers_intro_tagline']) : '- Where Talent Meets Opportunity -' ?></p>
    <p class="text-secondary mb-0" style="max-width: 800px; margin: 0 auto;">
      <?= isset($settings['careers_intro_description']) ? esc($settings['careers_intro_description']) : 'At RK Group, we believe in nurturing talent and fostering growth.' ?>
    </p>
  </div>
</section>

<!-- Current Openings Section -->
<section class="py-5 bg-white">
  <div class="container">
    <h2 class="section-title text-center mb-5 text-primary"><?= isset($settings['careers_openings_title']) ? esc($settings['careers_openings_title']) : 'CURRENT OPENINGS' ?></h2>
    <div class="careers-iframe-container">
      <iframe
        id="careersIframe"
        src="<?= isset($settings['careers_openings_iframe_url']) ? esc($settings['careers_openings_iframe_url']) : 'https://hr.gkdev.in/public/jobs' ?>"
        frameborder="0">
      </iframe>
    </div>
  </div>
</section>

<script>
// Make iframe responsive and adjust height based on content
(function() {
  const iframe = document.getElementById('careersIframe');

  // Set minimum height
  iframe.style.height = '600px';

  // Try to adjust height based on content (if same origin allows)
  iframe.addEventListener('load', function() {
    try {
      const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
      const height = iframeDoc.body.scrollHeight;
      if (height > 600) {
        iframe.style.height = height + 'px';
      }
    } catch(e) {
      // Cross-origin restriction - use IntersectionObserver to adjust on scroll
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            // Estimate height based on viewport
            const viewportHeight = window.innerHeight;
            iframe.style.height = Math.max(800, viewportHeight * 1.2) + 'px';
          }
        });
      });
      observer.observe(iframe);
    }
  });

  // Handle window resize
  window.addEventListener('resize', function() {
    const viewportHeight = window.innerHeight;
    const currentHeight = parseInt(iframe.style.height);
    if (currentHeight < 600) {
      iframe.style.height = '600px';
    }
  });
})();
</script>
