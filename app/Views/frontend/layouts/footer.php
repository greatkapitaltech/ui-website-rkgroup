    <!-- Footer -->
    <footer class="footer pt-5 pb-3">
      <div class="container">
        <!-- Main Footer Content -->
        <div class="row gy-4 pb-4">
          <!-- Brand Column -->
          <div class="col-12 col-lg-4">
            <div class="mb-4">
              <img
                src="<?= base_url('assets/img/RKGroup logo.svg') ?>"
                alt="RK Group"
                class="footer-logo"
              />
            </div>
            <p class="footer-text mb-4">
              India's leading e-commerce conglomerate, driving innovation across retail, fintech, and technology sectors with a commitment to excellence and growth.
            </p>

            <!-- Social Media -->
            <div class="mb-4">
              <h6 class="footer-head mb-3">Follow Us</h6>
              <div class="d-flex gap-3">
                <a class="ic-badge" href="#" aria-label="Instagram">
                  <i class="fa-brands fa-instagram"></i>
                </a>
                <a class="ic-badge" href="#" aria-label="LinkedIn">
                  <i class="fa-brands fa-linkedin-in"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="col-6 col-md-4 col-lg-3">
            <h6 class="footer-head">Quick Links</h6>
            <ul class="list-unstyled footer-links">
              <li><a href="<?= base_url('/') ?>">Home</a></li>
              <li><a href="<?= base_url('about') ?>">About Us</a></li>
              <li><a href="<?= base_url('careers') ?>">Careers</a></li>
              <li><a href="<?= base_url('connect') ?>">Contact</a></li>
            </ul>
          </div>

          <!-- Contact Info -->
          <div class="col-12 col-md-8 col-lg-5">
            <h6 class="footer-head">Get in Touch</h6>
            <ul class="list-unstyled footer-contact mb-0">
              <li>
                <i class="fa-solid fa-location-dot"></i>
                <span>RK Group, No. 1/1, 3rd floor,<br>Vinayaka towers, Bangalore</span>
              </li>
              <li>
                <i class="fa-solid fa-envelope"></i>
                <a class="footer-link" href="mailto:contact@rkgroup.biz">contact@rkgroup.biz</a>
              </li>
              <li>
                <i class="fa-solid fa-phone"></i>
                <a class="footer-link" href="tel:+918042640000">+91 80 4264 0000</a>
              </li>
              <li>
                <i class="fa-regular fa-clock"></i>
                <span>Mon - Sat: 8:00 AM - 6:00 PM</span>
              </li>
            </ul>
          </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom pt-4 mt-4">
          <div class="row align-items-center gy-3">
            <div class="col-md-6 text-center text-md-start">
              <p class="footer-muted mb-0">
                © <?= date('Y') ?> RK Group. All rights reserved.
              </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
              <ul class="list-inline footer-bottom-links mb-0">
                <li class="list-inline-item"><a href="#">Terms of Service</a></li>
                <li class="list-inline-item">•</li>
                <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                <li class="list-inline-item">•</li>
                <li class="list-inline-item"><a href="#">Sitemap</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Coming Soon Modal -->
    <div class="modal fade" id="comingSoonModal" tabindex="-1" aria-labelledby="comingSoonModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content coming-soon-modal-content">
          <button type="button" class="btn-close coming-soon-close" data-bs-dismiss="modal" aria-label="Close"></button>

          <div class="modal-body text-center px-4 py-5">
            <!-- Animated Background Elements -->
            <div class="coming-soon-bg-circles">
              <div class="circle circle-1"></div>
              <div class="circle circle-2"></div>
              <div class="circle circle-3"></div>
            </div>

            <!-- Content -->
            <div class="coming-soon-content">
              <div class="coming-soon-icon-wrapper mb-4">
                <div class="icon-circle">
                  <i class="fa-solid fa-rocket fa-3x"></i>
                </div>
              </div>

              <h2 class="coming-soon-title mb-3">Stay Tuned!</h2>
              <div class="coming-soon-badge mb-3">
                <span>Coming Soon</span>
              </div>

              <p class="coming-soon-description mb-4">
                We're working on something amazing. This section will be available soon with exciting new features!
              </p>

              <div class="coming-soon-animation mb-4">
                <div class="dot-pulse">
                  <div class="dot-pulse__dot"></div>
                </div>
              </div>

              <button type="button" class="btn btn-custom-primary btn-lg px-5" data-bs-dismiss="modal">
                Got it! <i class="fa-solid fa-check ms-2"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php if(isset($additional_js) && is_array($additional_js)): ?>
        <?php foreach($additional_js as $js): ?>
            <script src="<?= base_url($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
    <?php if(isset($inline_script)): ?>
        <script>
            <?= $inline_script ?>
        </script>
    <?php endif; ?>
</body>
</html>
