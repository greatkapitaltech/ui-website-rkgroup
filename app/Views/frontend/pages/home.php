    <!-- Hero -->
    <header class="hero position-relative">
      <div class="hero-overlay"></div>

      <div class="container position-relative z-1 h-100 d-flex align-items-center pb-4">
        <div class="hero-content">
          <!-- Main Heading -->
          <h1 class="hero-title mb-3" data-aos="fade-up" data-aos-delay="100">
            <?= isset($settings['hero_title']) ? esc($settings['hero_title']) : 'Scaling New Heights' ?>
          </h1>

          <!-- Subtitle -->
          <p class="hero-subtitle mb-4" data-aos="fade-up" data-aos-delay="200">
            <?= isset($settings['hero_subtitle']) ? esc($settings['hero_subtitle']) : 'Where Ambition Meets Experience in Every Venture' ?>
          </p>

          <!-- Description -->
          <p class="hero-description mb-4" data-aos="fade-up" data-aos-delay="300">
            <?= isset($settings['hero_description']) ? esc($settings['hero_description']) : 'Leading India\'s e-commerce revolution with innovative solutions across retail, fintech, and technology' ?>
          </p>

          <!-- CTA Buttons -->
          <div class="hero-cta-group" data-aos="fade-up" data-aos-delay="400">
            <a href="<?= base_url('about') ?>" class="btn btn-custom-light btn-lg me-3">
              Know More <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
          </div>

          <!-- Stats Row -->
          <div class="hero-stats mt-5" data-aos="fade-up" data-aos-delay="500">
            <div class="stat-item">
              <div class="stat-number"><?= isset($companies) ? count($companies) : '10' ?>+</div>
              <div class="stat-label">Companies</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
              <div class="stat-number"><?= isset($settings['hero_stat_brands']) ? esc($settings['hero_stat_brands']) : '400' ?>+</div>
              <div class="stat-label">Brands</div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Companies -->
    <section class="py-5 bg-soft position-relative">
      <div class="container">
        <h2 class="section-title text-center mb-4 text-primary"><?= isset($settings['business_title']) ? esc($settings['business_title']) : 'BUSINESS' ?></h2>
        <p class="text-center mb-5 mt-5 fs-5"><?= isset($settings['business_subtitle']) ? esc($settings['business_subtitle']) : 'Our Companies' ?></p>

        <!-- Carousel Container -->
        <div class="position-relative">
          <!-- Previous Button -->
          <button class="carousel-nav carousel-nav-prev" id="companiesPrev">
            <i class="fa-solid fa-chevron-left"></i>
          </button>

          <!-- Next Button -->
          <button class="carousel-nav carousel-nav-next" id="companiesNext">
            <i class="fa-solid fa-chevron-right"></i>
          </button>

          <div class="companies-carousel-wrapper">
            <div class="companies-carousel" id="companiesCarousel">
              <?php if (isset($companies) && !empty($companies)): ?>
                <?php foreach ($companies as $company):
                  // Determine logo URL
                  $logoUrl = '';
                  if (!empty($company['logo'])) {
                    $logoUrl = (strpos($company['logo'], 'http') === 0)
                      ? $company['logo']
                      : base_url('assets/uploads/companies/' . $company['logo']);
                  }
                ?>
                  <div class="company-carousel-item">
                    <div class="company-card h-100 p-4">
                      <?php if (!empty($logoUrl)): ?>
                        <img
                          src="<?= esc($logoUrl) ?>"
                          alt="<?= esc($company['name']) ?>"
                          class="mb-3"
                          height="44"
                        />
                      <?php else: ?>
                        <div class="text-logo mb-3" style="height: 44px; display: flex; align-items: center; justify-content: center;">
                          <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary);"><?= esc($company['name']) ?></span>
                        </div>
                      <?php endif; ?>
                      <p class="small text-secondary mb-0">
                        <?= esc($company['description']) ?>
                      </p>
                      <?php if (!empty($company['website_url'])): ?>
                        <a href="<?= esc($company['website_url']) ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-3">
                          Visit Website <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Partnerships -->
      <div class="container mt-5 pt-5">
        <h2 class="section-title text-center text-primary mb-5"><?= isset($settings['partnerships_title']) ? esc($settings['partnerships_title']) : 'Partnerships' ?></h2>

        <div class="partnerships-grid">
          <?php if (isset($partners) && !empty($partners)): ?>
            <?php foreach ($partners as $partner):
              // Determine logo URL
              $logoUrl = '';
              if (!empty($partner['logo'])) {
                $logoUrl = (strpos($partner['logo'], 'http') === 0)
                  ? $partner['logo']
                  : base_url('assets/uploads/partners/' . $partner['logo']);
              }
            ?>
              <div class="partner-item">
                <div class="partner-card">
                  <?php if (!empty($logoUrl)): ?>
                    <img
                      class="partner-logo"
                      src="<?= esc($logoUrl) ?>"
                      alt="<?= esc($partner['name']) ?>"
                    />
                  <?php else: ?>
                    <span style="font-size: 1.2rem; font-weight: 600; color: var(--primary);"><?= esc($partner['name']) ?></span>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
      </div>
    </section>

    <!-- CSR Philosophy -->
    <section id="csr" class="py-5">
      <div class="container">
        <div class="row g-4 align-items-center">
          <div class="col-lg-6">
            <h2 class="section-title text-primary mb-3"><?= isset($settings['csr_title']) ? esc($settings['csr_title']) : 'RK Trust' ?></h2>
            <p class="text-muted mb-4 fst-italic"><?= isset($settings['csr_subtitle']) ? esc($settings['csr_subtitle']) : 'CSR Philosophy' ?></p>
            <p class="small text-secondary mb-3">
              <?= isset($settings['csr_intro']) ? esc($settings['csr_intro']) : 'RK Trust is the philanthropic arm of RK Group. Founded by Ramesh Kumar Shah, the trust aims to bring about transformation in areas close to his heart.' ?>
            </p>
            <p class="small text-secondary mb-3">
              <?= isset($settings['csr_paragraph_1']) ? esc($settings['csr_paragraph_1']) : 'Running multiple initiatives under 2 primary verticals, the RK Trust connects and anchors all our efforts to the group\'s core philosophies of community centered growth.' ?>
            </p>
            <p class="small text-secondary mb-2"><strong><?= isset($settings['csr_initiatives_title']) ? esc($settings['csr_initiatives_title']) : 'The primary initiatives under RK Trust are:' ?></strong></p>
            <ul class="small text-secondary mb-3">
              <?php if (isset($settings['csr_initiative_1'])): ?>
                <li><?= esc($settings['csr_initiative_1']) ?></li>
              <?php endif; ?>
              <?php if (isset($settings['csr_initiative_2'])): ?>
                <li><?= esc($settings['csr_initiative_2']) ?></li>
              <?php endif; ?>
              <?php if (isset($settings['csr_initiative_3'])): ?>
                <li><?= esc($settings['csr_initiative_3']) ?></li>
              <?php endif; ?>
              <?php if (isset($settings['csr_initiative_4'])): ?>
                <li><?= esc($settings['csr_initiative_4']) ?></li>
              <?php endif; ?>
              <?php if (isset($settings['csr_initiative_5'])): ?>
                <li><?= esc($settings['csr_initiative_5']) ?></li>
              <?php endif; ?>
              <?php if (isset($settings['csr_initiative_6'])): ?>
                <li><?= esc($settings['csr_initiative_6']) ?></li>
              <?php endif; ?>
              <?php if (isset($settings['csr_initiative_7'])): ?>
                <li><?= esc($settings['csr_initiative_7']) ?></li>
              <?php endif; ?>
              <?php if (isset($settings['csr_initiative_8'])): ?>
                <li><?= esc($settings['csr_initiative_8']) ?></li>
              <?php endif; ?>
            </ul>
            <p class="small text-secondary mb-3">
              <?= isset($settings['csr_paragraph_2']) ? esc($settings['csr_paragraph_2']) : 'From environmental rehabilitation at the grassroots level in Kalandri, Rajasthan to facilitating financial assistance for cancer patients, raising awareness about Jain temples in Pakistan, the work aims to build sustainable and robust people systems that are vibrant, resilient and regenerative.' ?>
            </p>
            <p class="small text-secondary mb-4">
              <?= isset($settings['csr_paragraph_3']) ? esc($settings['csr_paragraph_3']) : 'Creating a revolution in our own way, we constantly strive to make a difference, one life at a time.' ?>
            </p>
            <a href="<?= isset($settings['csr_button_url']) ? esc($settings['csr_button_url']) : 'https://www.rktrust.in' ?>" target="_blank" class="btn btn-custom-primary mt-2">
              <?= isset($settings['csr_button_text']) ? esc($settings['csr_button_text']) : 'Know More' ?> &nbsp;<i
                class="fa-solid fa-arrow-right me-2"
                aria-hidden="true"
              ></i>
            </a>
          </div>
          <div class="col-lg-6">
            <img src="<?= base_url(isset($settings['csr_image']) ? $settings['csr_image'] : 'assets/img/csr.png') ?>" width="100%" alt="RK Trust Initiatives" />
          </div>
        </div>
      </div>
    </section>

    <!-- News -->
    <section class="py-5 bg-soft-new">
      <div class="container">
        <h2 class="section-title text-center mb-4 text-primary"><?= isset($settings['news_title']) ? esc($settings['news_title']) : 'News' ?></h2>
        <div class="w-100 d-flex justify-content-center mb-5">
          <p class="mt-2 text-center" style="max-width: 700px">
            <?= isset($settings['news_description']) ? esc($settings['news_description']) : 'News keeps you informed with the latest events and stories from around the world. Stay updated on politics, business, technology, and more.' ?>
          </p>
        </div>
        <div class="row g-4">
          <div class="col-12 col-lg-6">
            <div class="news-card p-4">
              <h5 class="mb-3 fw-bold d-flex align-items-center gap-2">
                <i class="fa-brands fa-linkedin text-primary"></i>
                Latest from RK Group
              </h5>

              <!-- LinkedIn Embedded Post -->
              <div class="linkedin-embed-container mb-3">
                <iframe src="https://www.linkedin.com/embed/feed/update/urn:li:share:7388494921533616128"
                        height="600"
                        width="100%"
                        frameborder="0"
                        allowfullscreen=""
                        title="Embedded post"
                        style="border-radius: 8px;">
                </iframe>
              </div>

              <div class="text-center">
                <a
                  href="https://www.linkedin.com/company/rk-groupp/"
                  target="_blank"
                  class="btn btn-custom-primary"
                >
                  <i class="fa-brands fa-linkedin me-2"></i>
                  Follow us on LinkedIn
                </a>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="news-card p-4">
              <!-- Tabs -->
              <h5 class="mb-3 fw-bold d-flex align-items-center gap-2">
                <i class="fa-brands fa-instagram text-primary"></i>
                CSR Initiatives
              </h5>
              <ul class="nav news-tabs gap-3 mb-3">
                <li class="nav-item">
                  <button
                    class="nav-link active"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-tjf"
                    type="button"
                  >
                    The Jain Foundation
                  </button>
                </li>
                <li class="nav-item">
                  <button
                    class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-ujwala"
                    type="button"
                  >
                    Ujwala Farm
                  </button>
                </li>
                <li class="nav-item">
                  <button
                    class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-school"
                    type="button"
                  >
                    PRSM School
                  </button>
                </li>
              </ul>

              <!-- Content (Instagram embeds) -->
              <div class="tab-content pt-3">
                <!-- TJF Tab -->
                <div class="tab-pane fade show active" id="tab-tjf">
                  <div class="instagram-embed-container">
                    <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/jainfoundation.in/" data-instgrm-version="14"></blockquote>
                  </div>
                  <div class="mt-3 text-center">
                    <a
                      href="https://www.instagram.com/jainfoundation.in/"
                      target="_blank"
                      class="btn btn-custom-primary"
                    >
                      <i class="fa-brands fa-instagram me-2"></i>
                      Follow The Jain Foundation
                    </a>
                  </div>
                </div>

                <!-- Ujwala Farm Tab -->
                <div class="tab-pane fade" id="tab-ujwala">
                  <div class="instagram-embed-container">
                    <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/ujwala_farm_retreat/" data-instgrm-version="14"></blockquote>
                  </div>
                  <div class="mt-3 text-center">
                    <a
                      href="https://www.instagram.com/ujwala_farm_retreat/"
                      target="_blank"
                      class="btn btn-custom-primary"
                    >
                      <i class="fa-brands fa-instagram me-2"></i>
                      Follow Ujwala Farm Retreat
                    </a>
                  </div>
                </div>

                <!-- PRSM School Tab -->
                <div class="tab-pane fade" id="tab-school">
                  <div class="instagram-embed-container">
                    <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/prem_ratan_shah_memorial/" data-instgrm-version="14"></blockquote>
                  </div>
                  <div class="mt-3 text-center">
                    <a
                      href="https://www.instagram.com/prem_ratan_shah_memorial/"
                      target="_blank"
                      class="btn btn-custom-primary"
                    >
                      <i class="fa-brands fa-instagram me-2"></i>
                      Follow PRSM School
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
