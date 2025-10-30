<!-- Vision Hero Section -->
<section class="vision-hero position-relative" style="height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center;">
  <div class="container position-relative z-1 text-white text-center">
    <h1 class="display-3 fw-bold mb-3">OUR VISION</h1>
    <p class="h5 fw-normal">The Guiding Vision At RK Group Is To Bring Out The Best In Everyone.</p>
  </div>
</section>

<!-- RK Group Section -->
<section class="py-5" style="background: #f8f9fa;">
  <div class="container text-center">
    <h2 class="section-title text-primary mb-3">RK GROUP</h2>
    <p class="fs-5 text-secondary mb-3">- Excellence Is Our Passion, Enriching Lives Is Our Goal -</p>
    <p class="text-secondary mb-0" style="max-width: 800px; margin: 0 auto;">
      We are constantly pushing boundaries in everything we do.
    </p>
  </div>
</section>

<?php if (isset($timeline) && !empty($timeline)): ?>
<!-- Timeline Section -->
<section class="timeline-section py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="display-5 fw-bold mb-3" style="color: #2C3E50;">JOURNEY OF RK GROUP</h2>
      <p class="text-secondary">Decades of Excellence and Growth</p>
    </div>

    <div class="timeline">
      <?php foreach ($timeline as $index => $event): ?>
        <div class="timeline-item <?= $event['alignment'] == 'right' ? 'timeline-right' : 'timeline-left' ?>">
          <div class="timeline-year"><?= esc($event['year']) ?></div>
          <div class="timeline-card">
            <?php if (!empty($event['image_url'])): ?>
              <?php
                // Check if it's a URL or filename
                $imageUrl = (strpos($event['image_url'], 'http') === 0)
                  ? $event['image_url']
                  : base_url('assets/uploads/timeline/' . $event['image_url']);
              ?>
              <img src="<?= esc($imageUrl) ?>" alt="<?= esc($event['title']) ?>" class="timeline-image">
            <?php endif; ?>
            <h3 class="timeline-title"><?= esc($event['title']) ?></h3>
            <p class="timeline-description"><?= esc($event['description']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<style>
/* Timeline Styles */
.timeline-section {
  background: #ffffff;
}

.timeline {
  position: relative;
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 0;
}

.timeline::before {
  content: '';
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  width: 4px;
  height: 100%;
  background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
}

.timeline-item {
  position: relative;
  width: 50%;
  padding: 0 40px;
  margin-bottom: 50px;
}

.timeline-left {
  left: 0;
  text-align: right;
}

.timeline-right {
  left: 50%;
  text-align: left;
}

.timeline-year {
  display: inline-block;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: #ffffff;
  padding: 12px 24px;
  border-radius: 25px;
  font-size: 20px;
  font-weight: 700;
  margin-bottom: 20px;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.timeline-card {
  background: #ffffff;
  border-radius: 15px;
  padding: 25px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}

.timeline-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.timeline-image {
  width: 100%;
  height: 250px;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 20px;
}

.timeline-title {
  font-size: 24px;
  font-weight: 600;
  color: #2C3E50;
  margin-bottom: 15px;
}

.timeline-description {
  font-size: 15px;
  color: #7f8c8d;
  line-height: 1.8;
  margin: 0;
}

/* Timeline Dots */
.timeline-left .timeline-year::after {
  content: '';
  position: absolute;
  right: -25px;
  top: 50%;
  transform: translateY(-50%);
  width: 20px;
  height: 20px;
  background: #667eea;
  border: 4px solid #ffffff;
  border-radius: 50%;
  box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
}

.timeline-right .timeline-year::after {
  content: '';
  position: absolute;
  left: -25px;
  top: 50%;
  transform: translateY(-50%);
  width: 20px;
  height: 20px;
  background: #764ba2;
  border: 4px solid #ffffff;
  border-radius: 50%;
  box-shadow: 0 0 0 4px rgba(118, 75, 162, 0.2);
}

/* Responsive */
@media (max-width: 768px) {
  .timeline::before {
    left: 30px;
  }

  .timeline-item {
    width: 100%;
    left: 0 !important;
    padding: 0 0 0 70px;
    text-align: left !important;
  }

  .timeline-left .timeline-year::after,
  .timeline-right .timeline-year::after {
    left: -55px;
    right: auto;
  }

  .timeline-image {
    height: 200px;
  }
}
</style>
<?php endif; ?>

<?php if (isset($board_members) && !empty($board_members)): ?>
<!-- Board Members Section -->
<section class="py-5" style="background: #f8f9fa;">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="display-5 fw-bold mb-3" style="color: #2C3E50;">BOARD OF DIRECTORS</h2>
      <p class="text-secondary">Leadership driving excellence and innovation</p>
    </div>

    <div class="row">
      <?php foreach ($board_members as $member): ?>
        <div class="col-md-4 col-sm-6 mb-4">
          <div class="member-card">
            <?php if (!empty($member['photo'])): ?>
              <?php
                $photoUrl = (strpos($member['photo'], 'http') === 0)
                  ? $member['photo']
                  : base_url('assets/uploads/board_members/' . $member['photo']);
              ?>
              <img src="<?= esc($photoUrl) ?>" alt="<?= esc($member['name']) ?>" class="member-photo">
            <?php else: ?>
              <div class="member-photo-placeholder">
                <i class="fa fa-user"></i>
              </div>
            <?php endif; ?>
            <h4 class="member-name"><?= esc($member['name']) ?></h4>
            <p class="member-position"><?= esc($member['position']) ?></p>
            <?php if (!empty($member['education'])): ?>
              <p class="member-education"><i class="fa fa-graduation-cap"></i> <?= esc($member['education']) ?></p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<style>
.member-card {
  background: #ffffff;
  border-radius: 15px;
  padding: 25px;
  text-align: center;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
  height: 100%;
}

.member-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.member-photo {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  object-fit: cover;
  margin: 0 auto 20px;
  border: 4px solid #f0f0f0;
}

.member-photo-placeholder {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  margin: 0 auto 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 60px;
  color: #ffffff;
}

.member-name {
  font-size: 20px;
  font-weight: 600;
  color: #2C3E50;
  margin-bottom: 10px;
}

.member-position {
  font-size: 14px;
  color: #667eea;
  font-weight: 500;
  margin-bottom: 10px;
}

.member-education {
  font-size: 13px;
  color: #7f8c8d;
  margin: 0;
}
</style>
<?php endif; ?>

<?php if (isset($advisory_members) && !empty($advisory_members)): ?>
<!-- Advisory Board Section -->
<section class="py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="display-5 fw-bold mb-3" style="color: #2C3E50;">ADVISORY BOARD</h2>
      <p class="text-secondary">Strategic guidance from industry experts</p>
    </div>

    <div class="row">
      <?php foreach ($advisory_members as $member): ?>
        <div class="col-md-4 col-sm-6 mb-4">
          <div class="member-card">
            <?php if (!empty($member['photo'])): ?>
              <?php
                $photoUrl = (strpos($member['photo'], 'http') === 0)
                  ? $member['photo']
                  : base_url('assets/uploads/board_members/' . $member['photo']);
              ?>
              <img src="<?= esc($photoUrl) ?>" alt="<?= esc($member['name']) ?>" class="member-photo">
            <?php else: ?>
              <div class="member-photo-placeholder">
                <i class="fa fa-user"></i>
              </div>
            <?php endif; ?>
            <h4 class="member-name"><?= esc($member['name']) ?></h4>
            <p class="member-position"><?= esc($member['position']) ?></p>
            <?php if (!empty($member['education'])): ?>
              <p class="member-education"><i class="fa fa-graduation-cap"></i> <?= esc($member['education']) ?></p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
