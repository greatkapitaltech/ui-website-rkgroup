<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= isset($title) ? $title . ' - RK Group' : 'RK Group' ?></title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet" />
    <?php if(isset($additional_css) && is_array($additional_css)): ?>
        <?php foreach($additional_css as $css): ?>
            <link href="<?= base_url($css) ?>" rel="stylesheet" />
        <?php endforeach; ?>
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <script
      src="https://kit.fontawesome.com/ce414fa6c9.js"
      crossorigin="anonymous"
    ></script>
</head>
<body>
    <!-- Top strip -->
    <div class="top-strip small text-white py-2">
      <div
        class="container d-flex justify-content-between align-items-center py-1"
      >
        <div class="d-flex gap-3">
          <a
            class="link-light text-decoration-none"
            href="mailto:contact@rkgroup.biz"
          >
            <i class="fa-solid fa-envelope me-2" aria-hidden="true"></i>
            contact@rkgroup.biz
          </a>
          <span>
            <i class="fa-solid fa-phone me-2" aria-hidden="true"></i>
            +91 80-4264-0241
          </span>
        </div>
        <div class="opacity-75">
          <i class="fa-regular fa-clock me-2" aria-hidden="true"></i>
          8:00 AM until 6:00 PM
        </div>
      </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white sticky-top border-bottom">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
          <img src="<?= base_url('assets/img/RKGroup logo.svg') ?>" height="50px" alt="RK Group" />
        </a>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navMain"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
          <ul
            class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center nav-separated"
          >
            <li class="nav-item">
              <a class="nav-link fw-semibold <?= (isset($active_page) && $active_page == 'home') ? 'actv' : '' ?>" href="<?= base_url('/') ?>">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-semibold <?= (isset($active_page) && $active_page == 'about') ? 'actv' : '' ?>" href="<?= base_url('about') ?>">About us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-semibold <?= (isset($active_page) && $active_page == 'careers') ? 'actv' : '' ?>" href="<?= base_url('careers') ?>">Careers</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-semibold <?= (isset($active_page) && $active_page == 'connect') ? 'actv' : '' ?>" href="<?= base_url('connect') ?>">Connect</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
