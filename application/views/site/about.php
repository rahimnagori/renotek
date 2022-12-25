<div class="inner_header">
  <div class="container">
    <h2>About Us</h2>
    <ul class="ul_set">
      <li><a href="<?= site_url(); ?>">Home</a></li>
      <li><span>About Us</span></li>
    </ul>
  </div>
</div>
<div class="pad_t abhout">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-sm-6" data-aos="flip-left" data-aos-duration="2000">
        <div class="ab_img2">
          <img src="<?= site_url('assets/site/'); ?>img/img1.png" class="img_r">
        </div>
      </div>
      <div class="col-sm-6" data-aos="flip-right" data-aos-duration="2000">
        <div class="conten_set">
          <h2 class="hea_2">WELCOME TO <?= $this->config->item('PROJECT'); ?></h2>
          <p style="text-align: justify;"><?= $aboutUsContent['about_us_short']; ?></p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="sec_pad">
  <div class="container">
    <div class="conten_set ">
      <?= $aboutUsContent['about_us_long']; ?>
    </div>
  </div>
</div>