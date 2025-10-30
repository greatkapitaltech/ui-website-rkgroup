<!-- Connect Hero Section -->
<section class="vision-hero position-relative">
  <div class="vision-hero-bg" style="background-image: url('<?php
    if (isset($images['connect_hero_background'])) {
      $img = $images['connect_hero_background'];
      echo !empty($img['image_file']) ? base_url('assets/img/' . $img['image_file']) : (!empty($img['image_url']) ? esc($img['image_url']) : 'https://images.unsplash.com/photo-1556761175-b413da4baf72?w=1920&h=1080&fit=crop&q=80');
    } else {
      echo 'https://images.unsplash.com/photo-1556761175-b413da4baf72?w=1920&h=1080&fit=crop&q=80';
    }
  ?>');"></div>
  <div class="vision-overlay"></div>
  <div class="container position-relative z-1 h-100 d-flex align-items-center">
    <div class="text-white">
      <h1 class="display-3 fw-bold mb-3"><?= isset($settings['connect_hero_title']) ? esc($settings['connect_hero_title']) : 'CONNECT WITH US' ?></h1>
      <p class="h5 fw-normal"><?= isset($settings['connect_hero_subtitle']) ? esc($settings['connect_hero_subtitle']) : 'We\'d Love To Hear From You. Reach Out To Us For Any Inquiries.' ?></p>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-7">
        <div class="contact-form-wrapper">
          <h2 class="section-title text-primary mb-4"><?= isset($settings['connect_form_title']) ? esc($settings['connect_form_title']) : 'Get In Touch' ?></h2>
          <form id="contactForm" data-base-url="<?= base_url() ?>">
            <?= csrf_field() ?>
            <div class="row g-3">
              <div class="col-md-6">
                <label for="name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required placeholder="Your full name" />
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="your.email@example.com" />
              </div>
              <div class="col-md-6">
                <label for="phone" class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="phone" name="phone" required placeholder="+91 XXXXX XXXXX" />
              </div>
              <div class="col-md-6">
                <label for="interest" class="form-label fw-semibold">Interest <span class="text-danger">*</span></label>
                <select class="form-select" id="interest" name="interest" required>
                  <option value="" selected disabled>Select your interest</option>
                  <option value="jobs">Jobs</option>
                  <option value="business">Business</option>
                  <option value="csr">CSR/Philanthropy</option>
                  <option value="other">Other</option>
                </select>
              </div>
              <div class="col-12">
                <label for="subject" class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="subject" name="subject" required placeholder="Brief subject of your message" />
              </div>
              <div class="col-12">
                <label for="message" class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                <textarea class="form-control" id="message" name="message" rows="6" required placeholder="Tell us more about your inquiry..."></textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-custom-primary btn-lg">
                  Send Message &nbsp;<i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="contact-info-wrapper">
          <h2 class="section-title text-primary mb-4"><?= isset($settings['connect_info_title']) ? esc($settings['connect_info_title']) : 'Contact Information' ?></h2>
          <div class="contact-info-item mb-4">
            <div class="d-flex align-items-start">
              <div class="contact-icon"><i class="fa-solid fa-location-dot"></i></div>
              <div>
                <h5 class="fw-bold mb-2">Address</h5>
                <p class="text-secondary mb-0">
                  <?php if (isset($settings['connect_address'])): ?>
                    <?= $settings['connect_address'] ?>
                  <?php else: ?>
                    RK Group, No. 1/1, 3rd floor,<br>Vinayaka towers, Bangalore
                  <?php endif; ?>
                </p>
              </div>
            </div>
          </div>
          <div class="contact-info-item mb-4">
            <div class="d-flex align-items-start">
              <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
              <div>
                <h5 class="fw-bold mb-2">Email</h5>
                <a href="mailto:<?= isset($settings['connect_email']) ? esc($settings['connect_email']) : 'contact@rkgroup.biz' ?>" class="text-secondary text-decoration-none">
                  <?= isset($settings['connect_email']) ? esc($settings['connect_email']) : 'contact@rkgroup.biz' ?>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Map Section -->
<section class="py-5 bg-soft-new">
  <div class="container">
    <h2 class="section-title text-center text-primary mb-4"><?= isset($settings['connect_map_title']) ? esc($settings['connect_map_title']) : 'Find Us' ?></h2>
    <div class="map-container">
      <iframe
        src="<?= isset($settings['connect_map_embed_url']) ? esc($settings['connect_map_embed_url']) : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3887.4716709726643!2d77.5758343!3d12.9755136!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae3d97cea66535%3A0xf3800177961d026a!2sRK%20Group!5e0!3m2!1sen!2sin!4v1730110000000!5m2!1sen!2sin' ?>"
        width="100%"
        height="400"
        style="border:0; border-radius: 12px;"
        allowfullscreen=""
        loading="lazy">
      </iframe>
    </div>
  </div>
</section>
