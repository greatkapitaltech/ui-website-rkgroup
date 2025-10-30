<!-- Our Vision Hero -->
<section class="vision-hero position-relative">
  <div class="vision-hero-bg"></div>
  <div class="vision-overlay"></div>
  <div class="container position-relative z-1 h-100 d-flex align-items-center">
    <div class="text-white">
      <h1 class="display-3 fw-bold mb-3"><?= isset($settings['about_vision_title']) ? esc($settings['about_vision_title']) : 'OUR VISION' ?></h1>
      <p class="h5 fw-normal"><?= isset($settings['about_vision_subtitle']) ? esc($settings['about_vision_subtitle']) : 'The Guiding Vision At RK Group Is To Bring Out The Best In Everyone.' ?></p>
    </div>
  </div>
</section>

<!-- RK Group Intro -->
<section class="py-5" style="background: #f8f9fa;">
  <div class="container text-center">
    <h2 class="section-title text-primary mb-3"><?= isset($settings['about_intro_title']) ? esc($settings['about_intro_title']) : 'RK GROUP' ?></h2>
    <p class="fs-5 text-secondary mb-3"><?= isset($settings['about_intro_tagline']) ? esc($settings['about_intro_tagline']) : '- Excellence Is Our Passion, Enriching Lives Is Our Goal -' ?></p>
    <p class="text-secondary mb-0" style="max-width: 800px; margin: 0 auto;">
      <?= isset($settings['about_intro_description']) ? esc($settings['about_intro_description']) : 'We are constantly pushing boundaries in everything we do. We are earnest about creating a better life not only for our partners and employees but also for the people around us.' ?>
    </p>
  </div>
</section>

<?php if (isset($timeline) && !empty($timeline)): ?>
<!-- Journey of RK Group - Vertical Timeline -->
<section class="vertical-timeline-section">
  <div class="timeline-header text-center py-5 bg-white">
    <div class="container">
      <h2 class="section-title mb-3 text-primary"><?= isset($settings['about_journey_title']) ? esc($settings['about_journey_title']) : 'JOURNEY OF RK GROUP' ?></h2>
      <p class="text-secondary mb-0"><?= isset($settings['about_journey_subtitle']) ? esc($settings['about_journey_subtitle']) : 'Decades of Excellence and Growth' ?></p>
    </div>
  </div>

  <div class="position-relative">
    <!-- Timeline Navigation - Floating -->
    <div class="timeline-years-nav-floating">
      <?php
      $index = 0;
      foreach ($timeline as $event):
      ?>
        <div class="timeline-year-item <?= $index === 0 ? 'active' : '' ?>" data-year="<?= esc($event['year']) ?>"><?= esc($event['year']) ?></div>
      <?php
        $index++;
      endforeach;
      ?>
    </div>

    <!-- Timeline Content -->
    <div class="timeline-fullwidth-wrapper">
      <?php foreach ($timeline as $event):
        // Determine image URL
        $imageUrl = '';
        if (!empty($event['image_url'])) {
          $imageUrl = (strpos($event['image_url'], 'http') === 0)
            ? $event['image_url']
            : base_url('assets/uploads/timeline/' . $event['image_url']);
        }

        // Determine content alignment
        $contentClass = ($event['alignment'] == 'right') ? 'content-right' : '';
        $colClass = ($event['alignment'] == 'right') ? 'justify-content-end' : '';
      ?>
        <div class="timeline-fullwidth-item" id="timeline-<?= esc($event['year']) ?>">
          <div class="timeline-image-wrapper">
            <?php if (!empty($imageUrl)): ?>
              <img src="<?= esc($imageUrl) ?>" alt="<?= esc($event['year']) ?> - <?= esc($event['title']) ?>" class="timeline-fullwidth-image">
            <?php else: ?>
              <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1600&h=900&fit=crop" alt="<?= esc($event['title']) ?>" class="timeline-fullwidth-image">
            <?php endif; ?>
            <div class="timeline-overlay"></div>
          </div>
          <div class="timeline-content-overlay <?= $contentClass ?>">
            <div class="container">
              <div class="row <?= $colClass ?>">
                <div class="col-lg-6">
                  <span class="timeline-year-display"><?= esc($event['year']) ?></span>
                  <h3 class="timeline-title"><?= esc($event['title']) ?></h3>
                  <p class="timeline-description">
                    <?= esc($event['description']) ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($board_members) && !empty($board_members)): ?>
<!-- Board Members -->
<section class="py-5 bg-soft">
  <div class="container">
    <h2 class="section-title text-center mb-3 text-primary"><?= isset($settings['about_people_title']) ? esc($settings['about_people_title']) : 'PEOPLE' ?></h2>
    <p class="text-center text-secondary mb-5">
      <?= isset($settings['about_people_description']) ? esc($settings['about_people_description']) : 'A Passion For Excellence, Entrepreneurial Spirit, And High Ethical Standards Define Our Team Of Board Members.' ?>
    </p>

    <div class="position-relative">
      <button class="carousel-nav carousel-nav-prev" id="boardPrev">
        <i class="fa-solid fa-chevron-left"></i>
      </button>
      <button class="carousel-nav carousel-nav-next" id="boardNext">
        <i class="fa-solid fa-chevron-right"></i>
      </button>

      <div class="team-carousel-wrapper">
        <div class="team-carousel" id="boardCarousel">
          <?php foreach ($board_members as $member):
            // Determine photo URL
            $photoUrl = '';
            if (!empty($member['photo'])) {
              $photoUrl = (strpos($member['photo'], 'http') === 0)
                ? $member['photo']
                : base_url('assets/uploads/board_members/' . $member['photo']);
            }
          ?>
            <div class="team-member-item">
              <div class="team-card text-center">
                <div class="team-image-wrapper">
                  <?php if (!empty($photoUrl)): ?>
                    <img src="<?= esc($photoUrl) ?>" alt="<?= esc($member['name']) ?>" class="team-image">
                  <?php else: ?>
                    <div style="width: 100%; height: 100%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                      <i class="fa fa-user" style="font-size: 60px; color: #ccc;"></i>
                    </div>
                  <?php endif; ?>
                </div>
                <h6 class="fw-bold mt-3 mb-1"><?= esc($member['name']) ?></h6>
                <p class="small text-muted mb-2"><?= esc($member['position']) ?></p>
                <?php if (!empty($member['bio']) || !empty($member['education'])): ?>
                  <p class="small text-secondary">
                    <?php if (!empty($member['bio'])): ?>
                      <?= esc($member['bio']) ?>
                      <?php if (!empty($member['education'])): ?> | <?php endif; ?>
                    <?php endif; ?>
                    <?php if (!empty($member['education'])): ?>
                      <?= esc($member['education']) ?>
                    <?php endif; ?>
                  </p>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($advisory_members) && !empty($advisory_members)): ?>
<!-- Advisory Board -->
<section class="py-5 bg-white">
  <div class="container">
    <h2 class="section-title text-center mb-5 text-primary"><?= isset($settings['about_advisory_title']) ? esc($settings['about_advisory_title']) : 'ADVISORY BOARD' ?></h2>

    <div class="row g-4 justify-content-center">
      <?php foreach ($advisory_members as $member):
        // Determine photo URL
        $photoUrl = '';
        if (!empty($member['photo'])) {
          $photoUrl = (strpos($member['photo'], 'http') === 0)
            ? $member['photo']
            : base_url('assets/uploads/board_members/' . $member['photo']);
        }
      ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="team-card text-center">
            <div class="team-image-wrapper">
              <?php if (!empty($photoUrl)): ?>
                <img src="<?= esc($photoUrl) ?>" alt="<?= esc($member['name']) ?>" class="team-image">
              <?php else: ?>
                <div style="width: 100%; height: 100%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                  <i class="fa fa-user" style="font-size: 60px; color: #ccc;"></i>
                </div>
              <?php endif; ?>
            </div>
            <h6 class="fw-bold mt-3 mb-1"><?= esc($member['name']) ?></h6>
            <p class="small text-muted mb-2"><?= esc($member['position']) ?></p>
            <?php if (!empty($member['bio']) || !empty($member['education'])): ?>
              <p class="small text-secondary">
                <?php if (!empty($member['bio'])): ?>
                  <?= esc($member['bio']) ?>
                  <?php if (!empty($member['education'])): ?> | <?php endif; ?>
                <?php endif; ?>
                <?php if (!empty($member['education'])): ?>
                  <?= esc($member['education']) ?>
                <?php endif; ?>
              </p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($companies) && !empty($companies)): ?>
<!-- Our Companies Section -->
<section class="py-5 bg-soft">
  <div class="container">
    <h2 class="section-title text-center mb-3 text-primary"><?= isset($settings['about_companies_title']) ? esc($settings['about_companies_title']) : 'OUR COMPANIES' ?></h2>
    <p class="text-center text-secondary mb-5"><?= isset($settings['about_companies_subtitle']) ? esc($settings['about_companies_subtitle']) : 'Powering innovation across diverse industries' ?></p>

    <!-- Scrolling Banner -->
    <div class="companies-scroll-container">
      <div class="companies-scroll-track">
        <?php foreach ($companies as $company):
          $logoUrl = '';
          if (!empty($company['logo'])) {
            $logoUrl = (strpos($company['logo'], 'http') === 0)
              ? $company['logo']
              : base_url('assets/uploads/companies/' . $company['logo']);
          }
        ?>
          <div class="company-logo-item">
            <?php if (!empty($logoUrl)): ?>
              <img src="<?= esc($logoUrl) ?>" alt="<?= esc($company['name']) ?>">
            <?php else: ?>
              <div class="text-logo" style="display: flex; align-items: center; justify-content: center; height: 44px;">
                <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary);"><?= esc($company['name']) ?></span>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
        <!-- Duplicate for seamless scrolling -->
        <?php foreach ($companies as $company):
          $logoUrl = '';
          if (!empty($company['logo'])) {
            $logoUrl = (strpos($company['logo'], 'http') === 0)
              ? $company['logo']
              : base_url('assets/uploads/companies/' . $company['logo']);
          }
        ?>
          <div class="company-logo-item">
            <?php if (!empty($logoUrl)): ?>
              <img src="<?= esc($logoUrl) ?>" alt="<?= esc($company['name']) ?>">
            <?php else: ?>
              <div class="text-logo" style="display: flex; align-items: center; justify-content: center; height: 44px;">
                <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary);"><?= esc($company['name']) ?></span>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (isset($partners) && !empty($partners)): ?>
<!-- Partnerships and Brands -->
<section class="py-5 bg-white">
  <div class="container">
    <h2 class="section-title text-center mb-5 text-primary"><?= isset($settings['about_partnerships_title']) ? esc($settings['about_partnerships_title']) : 'PARTNERSHIPS AND BRANDS' ?></h2>

    <div class="row g-4 justify-content-center">
      <?php foreach ($partners as $partner):
        $logoUrl = '';
        if (!empty($partner['logo'])) {
          $logoUrl = (strpos($partner['logo'], 'http') === 0)
            ? $partner['logo']
            : base_url('assets/uploads/partners/' . $partner['logo']);
        }
      ?>
        <div class="col-6 col-md-4 col-lg-3 text-center">
          <?php if (!empty($logoUrl)): ?>
            <img src="<?= esc($logoUrl) ?>" alt="<?= esc($partner['name']) ?>" class="img-fluid" style="max-height: 80px; width: auto;">
          <?php else: ?>
            <span style="font-size: 1.2rem; font-weight: 600; color: var(--primary);"><?= esc($partner['name']) ?></span>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Careers Section -->
<section class="py-5" style="background: linear-gradient(135deg, #E6F4F9 0%, #D1E9F6 100%);">
  <div class="container text-center">
    <h2 class="section-title mb-3 text-primary"><?= isset($settings['about_careers_title']) ? esc($settings['about_careers_title']) : 'JOIN OUR TEAM' ?></h2>
    <p class="text-secondary mb-4" style="max-width: 700px; margin: 0 auto;">
      <?= isset($settings['about_careers_description']) ? esc($settings['about_careers_description']) : 'Explore exciting career opportunities and join our team—explore a career path for your future with open positions and growth opportunities on our Careers portal.' ?>
    </p>
    <a href="<?= base_url('careers') ?>" class="btn btn-custom-primary btn-lg">
      <?= isset($settings['about_careers_button']) ? esc($settings['about_careers_button']) : 'Join Us!' ?> &nbsp;<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
    </a>
  </div>
</section>
