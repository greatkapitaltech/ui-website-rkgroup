<!-- Careers Hero Section -->
<section class="vision-hero position-relative" style="min-height: 350px;">
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
    <div class="d-flex justify-content-center">
      <iframe
        src="<?= isset($settings['careers_openings_iframe_url']) ? esc($settings['careers_openings_iframe_url']) : 'https://hr.gkdev.in/public/jobs' ?>"
        width="100%"
        height="800"
        frameborder="0"
        style="border: none; max-width: 1200px; margin: 0 auto; display: block; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
      </iframe>
    </div>
  </div>
</section>
