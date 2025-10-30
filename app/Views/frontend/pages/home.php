    <!-- Hero -->
    <header class="hero position-relative">
      <div class="hero-overlay"></div>

      <div class="container position-relative z-1 h-100 d-flex align-items-center pb-4">
        <div class="hero-content">
          <!-- Main Heading -->
          <h1 class="hero-title mb-3" data-aos="fade-up" data-aos-delay="100">
            Scaling New Heights
          </h1>

          <!-- Subtitle -->
          <p class="hero-subtitle mb-4" data-aos="fade-up" data-aos-delay="200">
            Where Ambition Meets Experience in Every Venture
          </p>

          <!-- Description -->
          <p class="hero-description mb-4" data-aos="fade-up" data-aos-delay="300">
            Leading India's e-commerce revolution with innovative solutions across retail, fintech, and technology
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
              <div class="stat-number">10+</div>
              <div class="stat-label">Companies</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
              <div class="stat-number">400+</div>
              <div class="stat-label">Brands</div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Companies -->
    <section class="py-5 bg-soft position-relative">
      <div class="container">
        <h2 class="section-title text-center mb-4 text-primary">BUSINESS</h2>
        <p class="text-center mb-5 mt-5 fs-5">Our Companies</p>

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
              <!-- Card 1: RK World Infocom -->
              <div class="company-carousel-item">
                <div class="company-card h-100 p-4">
              <img
                src="<?= base_url('assets/img/logo-rkwi.png') ?>"
                alt="RK World Infocom"
                class="mb-3"
                height="44"
              />
              <p class="small text-secondary mb-0">
                Leading FMCG distribution platform, delivering products across 95% of India's pin codes. RKWI connects brands with customers with supply chain expertise and trusted partnerships with leading global brands.
              </p>
                </div>
              </div>
              <!-- Card 2: Great Kapital Ventura -->
              <div class="company-carousel-item">
                <div class="company-card h-100 p-4">
              <img
                src="<?= base_url('assets/img/logo-gk.png') ?>"
                alt="Great Kapital Ventura"
                class="mb-3"
                height="44"
              />
              <p class="small text-secondary mb-0">
                A fintech platform dedicated to redefining working capital management. Great Kapital provides innovative supply chain finance solutions that enable corporations to optimize cash flow while ensuring timely payments for suppliers.
              </p>
                </div>
              </div>
              <!-- Card 3: Valuekart -->
              <div class="company-carousel-item">
                <div class="company-card h-100 p-4">
              <img
                src="<?= base_url('assets/img/logo-valuekart.png') ?>"
                alt="Valuekart"
                class="mb-3"
                height="44"
              />
              <p class="small text-secondary mb-0">
                A cross-border e-commerce enabler, providing end-to-end market access solutions for international aspiring to target the Indian markets. ValueKart provides market entry strategy, supply chain and logistics management, order fulfillment, platform integration, and category management.
              </p>
                </div>
              </div>
              <!-- Card 4: RK Fabrics -->
              <div class="company-carousel-item">
                <div class="company-card h-100 p-4">
              <img
                src="<?= base_url('assets/img/logo-rkfabrics.png') ?>"
                alt="RK Fabrics"
                class="mb-3"
                height="44"
              />
              <p class="small text-secondary mb-0">
                Pioneers of textile trading in India, leveraging an experienced team, strategic partnerships, and state-of-the-art infrastructure. Driving operational efficiency through exclusive partnerships with global textile brands like Luthai, Penfabric, Stylem, and Monti.
              </p>
                </div>
              </div>
              <!-- Card 5: Robust Kommerce -->
              <div class="company-carousel-item">
                <div class="company-card h-100 p-4">
              <img
                src="<?= base_url('assets/img/logo-robustkommerce.png') ?>"
                alt="Robust Kommerce"
                class="mb-3"
                height="44"
              />
              <p class="small text-secondary mb-0">
                Myntra's exclusive partner for international brand collaborations across Retail, Shop-in-Shop, and Digital Marketplace commerce. Offering end-to-end solutions from market entry to retail expansion, delivering world-class fashion through premium retail stores and digital platforms.
              </p>
                </div>
              </div>
              <!-- Card 6: Wishery -->
              <div class="company-carousel-item">
                <div class="company-card h-100 p-4">
              <img
                src="<?= base_url('assets/img/logo-wishery.png') ?>"
                alt="Wishery"
                class="mb-3"
                height="44"
              />
              <p class="small text-secondary mb-0">
                A leading wholesale and retail trader of mobile phones, electronics, and lifestyle products. With operations spanning 19 states in India, Wishery has a stronghold in B2B and B2C segments, combining reliable sourcing, efficient distribution, and a technology-driven approach.
              </p>
                </div>
              </div>
              <!-- Card 7: Westbury -->
              <div class="company-carousel-item">
                <div class="company-card h-100 p-4">
              <img
                src="<?= base_url('assets/img/logo-westbury.png') ?>"
                alt="Westbury"
                class="mb-3"
                height="44"
              />
              <p class="small text-secondary mb-0">
                Westbury Kommerce provides end-to-end e-commerce and omnichannel solutions for retail and fashion brands. Combining deep industry expertise with scalable solutions allowing brands to grow efficiently, reach wider audiences, and deliver seamless shopping experiences.
              </p>
                </div>
              </div>
              <!-- Card 8: Kalandari Capital -->
              <div class="company-carousel-item">
                <div class="company-card h-100 p-4">
              <img
                src="<?= base_url('assets/img/logo-kalandari.png') ?>"
                alt="Kalandari Capital"
                class="mb-3"
                height="44"
              />
              <p class="small text-secondary mb-0">
                A new-age financial services platform focused on making lending transparent, quick, and hassle-free. Our mission is to reduce borrowing costs for new-age businesses while ensuring a seamless and efficient experience by leveraging technology for scale.
              </p>
                </div>
              </div>
              <!-- Card 9: Risingstar -->
              <div class="company-carousel-item">
                <div class="company-card h-100 p-4">
              <div class="text-logo mb-3" style="height: 44px; display: flex; align-items: center; justify-content: center;">
                <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">Rising<span style="color: #FFB800;">Star</span></span>
              </div>
              <p class="small text-secondary mb-0">
                Rising Star Kommerce partners with suppliers to source a wide range of products across categories for listing and sales on Blinkit, one of India's leading quick commerce platforms, ensuring fast and reliable delivery to consumers.
              </p>
                </div>
              </div>
              <!-- Card 10: Rapidkey -->
              <div class="company-carousel-item">
                <div class="company-card h-100 p-4">
              <div class="text-logo mb-3" style="height: 44px; display: flex; align-items: center; justify-content: center;">
                <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">Rapid<span style="color: #E63946;">Key</span></span>
              </div>
              <p class="small text-secondary mb-0">
                An independent TaaS seller for Flipkart, RapidKey is a growth partner for brands, managing the entire e-commerce lifecycle—from procurement and inventory planning to warehousing, delivery, returns, and liquidation. Combining entrepreneurial agility with Flipkart's ecosystem support.
              </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Partnerships -->
      <div class="container mt-5 pt-5">
        <h2 class="section-title text-center text-primary mb-5">Partnerships</h2>

        <div class="partnerships-grid">
          <div class="partner-item">
            <div class="partner-card">
              <img
                class="partner-logo"
                src="<?= base_url('assets/img/Amazon_2024.webp') ?>"
                alt="Amazon"
              />
            </div>
          </div>
          <div class="partner-item">
            <div class="partner-card">
              <img
                class="partner-logo"
                src="<?= base_url('assets/img/flipkart-logo.webp') ?>"
                alt="Flipkart"
              />
            </div>
          </div>
          <div class="partner-item">
            <div class="partner-card">
              <img
                class="partner-logo"
                src="<?= base_url('assets/img/myntra-logo.png') ?>"
                alt="Myntra"
              />
            </div>
          </div>
          <div class="partner-item">
            <div class="partner-card">
              <img
                class="partner-logo"
                src="https://logo.clearbit.com/blinkit.com"
                alt="Blinkit"
              />
            </div>
          </div>
          <div class="partner-item">
            <div class="partner-card">
              <img
                class="partner-logo"
                src="https://logo.clearbit.com/pharmeasy.in"
                alt="PharmEasy"
              />
            </div>
          </div>
          <div class="partner-item">
            <div class="partner-card">
              <img
                class="partner-logo"
                src="<?= base_url('assets/img/CARS24_logo.png') ?>"
                alt="Cars24"
              />
            </div>
          </div>
          <div class="partner-item">
            <div class="partner-card">
              <img
                class="partner-logo"
                src="https://logo.clearbit.com/abfrl.com"
                alt="ABFRL"
              />
            </div>
          </div>
          <div class="partner-item">
            <div class="partner-card">
              <img
                class="partner-logo"
                src="https://logo.clearbit.com/nike.com"
                alt="Nike"
              />
            </div>
          </div>
          <div class="partner-item">
            <div class="partner-card">
              <img
                class="partner-logo"
                src="https://logo.clearbit.com/scapia.com"
                alt="Scapia"
              />
            </div>
          </div>
          <div class="partner-item">
            <div class="partner-card">
              <img
                class="partner-logo"
                src="https://logo.clearbit.com/phonepe.com"
                alt="Pincode by PhonePe"
              />
            </div>
          </div>
        </div>
      </div>
      </div>
    </section>

    <!-- CSR Philosophy -->
    <section id="csr" class="py-5">
      <div class="container">
        <div class="row g-4 align-items-center">
          <div class="col-lg-6">
            <h2 class="section-title text-primary mb-3">RK Trust</h2>
            <p class="text-muted mb-4 fst-italic">CSR Philosophy</p>
            <p class="small text-secondary mb-3">
              RK Trust is the philanthropic arm of RK Group. Founded by Ramesh Kumar Shah, the trust aims to bring about transformation in areas close to his heart.
            </p>
            <p class="small text-secondary mb-3">
              Running multiple initiatives under 2 primary verticals, the RK Trust connects and anchors all our efforts to the group's core philosophies of community centered growth.
            </p>
            <p class="small text-secondary mb-2"><strong>The primary initiatives under RK Trust are:</strong></p>
            <ul class="small text-secondary mb-3">
              <li>Kalandari Foundation</li>
              <li>Kalandari Model Village Pilot</li>
              <li>Prem Ratan Shah Memorial Senior Secondary School for girls</li>
              <li>Ujwala Farm</li>
              <li>The Jain Foundation</li>
              <li>Awareness about Jain Population</li>
              <li>Learning Exchange with Jain temples of Pakistan</li>
              <li>Digital Fasting</li>
            </ul>
            <p class="small text-secondary mb-3">
              From environmental rehabilitation at the grassroots level in Kalandri, Rajasthan to facilitating financial assistance for cancer patients, raising awareness about Jain temples in Pakistan, the work aims to build sustainable and robust people systems that are vibrant, resilient and regenerative.
            </p>
            <p class="small text-secondary mb-4">
              Creating a revolution in our own way, we constantly strive to make a difference, one life at a time.
            </p>
            <a href="https://www.rktrust.in" target="_blank" class="btn btn-custom-primary mt-2">
              Know More &nbsp;<i
                class="fa-solid fa-arrow-right me-2"
                aria-hidden="true"
              ></i>
            </a>
          </div>
          <div class="col-lg-6">
            <img src="<?= base_url('assets/img/csr.png') ?>" width="100%" alt="RK Trust Initiatives" />
          </div>
        </div>
      </div>
    </section>

    <!-- News -->
    <section class="py-5 bg-soft-new">
      <div class="container">
        <h2 class="section-title text-center mb-4 text-primary">News</h2>
        <div class="w-100 d-flex justify-content-center mb-5">
          <p class="mt-2 text-center" style="max-width: 700px">
            News keeps you informed with the latest events and stories from
            around the world. Stay updated on politics, business, technology,
            and more.
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
