<!doctype html>
<html lang="en">

<head>
  <title><?= $this->config->item('PROJECT'); ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="google-site-verification" content="ifbcb1z0-VQakv7HOCIonEEaak3qNA2yDB3EG80vDMM" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= site_url('assets/site/'); ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= site_url('assets/site/'); ?>css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?= site_url('assets/site/'); ?>css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= site_url('assets/site/'); ?>css/aos.css">
  <link rel="stylesheet" href="<?= site_url('assets/site/'); ?>css/style.css">
</head>

<body>
  <div class="page-loader">
    <video autoplay="" muted loop>
      <source src="<?= site_url('assets/site/'); ?>video/light.mp4" type="video/mp4">
    </video>
  </div>
  <div class="man_nav" data-aos="fade-down" data-aos-duration="1000">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="<?= site_url(''); ?>">
          <img src="<?= site_url('assets/site/'); ?>img/logo.png">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="icon-bar line_us1"></span>
          <span class="icon-bar line_us2"></span>
          <span class="icon-bar line_us3"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url(''); ?>">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('About-Us'); ?>">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('Shop'); ?>">Shop</a>
            </li>
            <!-- <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Indoor light </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="<?= site_url('Shop'); ?>">Led Backlite panel</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Outdoor light </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
                <li><a class="dropdown-item" href="<?= site_url('Shop'); ?>">Street light </a></li>
              </ul>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('Contact-Us'); ?>">Contact Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('View-Cart'); ?>">Cart <i class="fa fa-shopping-cart"></i><span id="cart-counter" class="cart-counter"><?=$cart;?></span></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>