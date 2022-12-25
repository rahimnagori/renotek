<?php
  if(count($sliderElements)){
?>
    <div class="home_slider " id="home" data-aos="zoom-in" data-aos-duration="1200">
      <div class="owl-carousel owl-theme slider_arrrw" id="slider1">
        <?php
          foreach($sliderElements as $sliderElement){
        ?>
            <div class="item">
              <div class="slider_img1">
                <img src="<?= site_url($sliderElement['slider_image']); ?>" class="img_r">
                <div class="slidr_cont">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="heading">
                          <h1><?=$sliderElement['heading'];?></h1>
                          <p><?=$sliderElement['sub_heading'];?></p>
                        </div>
                        <?php
                          if($sliderElement['url']){
                        ?>
                            <a href="<?=$sliderElement['url']?>" target="_blank" class="btn btn_theme4 btn_r btn-lg">Read More</a>
                        <?php
                          }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <?php
          }
        ?>
      </div>
    </div>
<?php
  }
?>

<section class="pad_t sec_1">
  <div class="container">
    <div class="heading text-center" data-aos="fade-down" data-aos-duration="1000">

      <h1>
        Renotek Lorem Ipsum
      </h1>
      <p>
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
        has been the industry's standard dummy
      </p>

    </div>
    <div class="row">
      <div class="col-sm-6" data-aos="fade-left" data-aos-duration="1000">
        <div class="box_d1">
          <div class="conten_set">
            <h5>Get Upto</h5>
            <h2>40% OFF</h2>
            <h6>Indoor light Lorem Ipsum</h6>
            <a href="#" class="btn btn_theme2 btn_r">Read More</a>
          </div>
          <img src="<?= site_url('assets/site/'); ?>img/img2.png" alt="" class="img_r">
        </div>
      </div>
      <div class="col-sm-6" data-aos="fade-right" data-aos-duration="1000">
        <div class="box_d1">
          <div class="conten_set">
            <h5>Get Upto</h5>
            <h2>40% OFF</h2>
            <h6>Indoor light Lorem Ipsum</h6>
            <a href="#" class="btn btn_theme2 btn_r">Read More</a>
          </div>
          <img src="<?= site_url('assets/site/'); ?>img/img2.png" alt="" class="img_r">
        </div>
      </div>
    </div>
  </div>
</section>

<section class="sec_pad abhout">
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
          <a href="<?= site_url('About-Us'); ?>" class="btn btn_theme btn_r btn-lg">Read More</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
if (count($homeProducts)) {
?>
  <section class="sec_pad sec_2" data-aos="fade-up" data-aos-duration="1000">
    <div class="container">
      <div class="heading text-center">
        <h1>
          Our Products
        </h1>
        <p>
          Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
          has been the industry's standard dummy
        </p>
      </div>
      <div class="row">
        <?php
        foreach ($homeProducts as $homeProduct) {
        ?>
          <div class="col-sm-4">
            <div class="box_d2">
              <span class="hobb">
                <a href="<?= site_url('Product-Details/' . $homeProduct['id']); ?>"></a>
                <img src="<?= site_url('assets/site/'); ?>img/img4.png" alt="" class="img_r">
              </span>
              <div class="con_st">
                <h4><?= $homeProduct['product_title']; ?></h4>
                <h2><i class="fa fa-inr"></i><?= $homeProduct['product_price']; ?></h2>
                <div class="colr">
                  <span class="active"><i style="background:#c10000;"></i></span>
                  <span><i style="background:#00a6c1;"></i></span>
                </div>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
        <!-- <div class="col-sm-4">
            <div class="box_d2">
              <span class="hobb">
              <a href="Product-Details"></a>    
              <img src="<?= site_url('assets/site/'); ?>img/img5.png" alt="" class="img_r"></span>
              <div class="con_st">
                <h4>Led Backlite panel</h4>
                <h2>RS. 280.00</h2>
                <div class="colr">
                  <span class="active"><i style="background:#c10000;"></i></span>
                  <span><i style="background:#00a6c1;"></i></span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="box_d2">
              <span class="hobb">
              <a href="Product-Details"></a>
                <img src="<?= site_url('assets/site/'); ?>img/img8.png" alt="" class="img_r"></span>
              <div class="con_st">
                <h4>Led Backlite panel</h4>
                <h2>RS. 280.00</h2>
                <div class="colr">
                  <span class="active"><i style="background:#c10000;"></i></span>
                  <span><i style="background:#00a6c1;"></i></span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="box_d2">
              <span class="hobb">
              <a href="Product-Details"></a>  
              <img src="<?= site_url('assets/site/'); ?>img/img10.png" alt="" class="img_r"></span>
              <div class="con_st">
                <h4>Led Backlite panel</h4>
                <h2>RS. 280.00</h2>
                <div class="colr">
                  <span class="active"><i style="background:#c10000;"></i></span>
                  <span><i style="background:#00a6c1;"></i></span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="box_d2">
              <span class="hobb">
              <a href="Product-Details"></a>  
              <img src="<?= site_url('assets/site/'); ?>img/img12.png" alt="" class="img_r"></span>
              <div class="con_st">
                <h4>Led Backlite panel</h4>
                <h2>RS. 280.00</h2>
                <div class="colr">
                  <span class="active"><i style="background:#c10000;"></i></span>
                  <span><i style="background:#00a6c1;"></i></span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="box_d2">
              <span class="hobb">
              <a href="Product-Details"></a>  
              <img src="<?= site_url('assets/site/'); ?>img/img15.png" alt="" class="img_r"></span>
              <div class="con_st">
                <h4>Led Backlite panel</h4>
                <h2>RS. 280.00</h2>
                <div class="colr">
                  <span class="active"><i style="background:#c10000;"></i></span>
                  <span><i style="background:#00a6c1;"></i></span>
                </div>
              </div>
            </div>
          </div> -->
      </div>
    </div>
  </section>
<?php
}
?>
<section class="sec_pad sec_3" data-aos="fade-left" data-aos-duration="2000">
  <div class="container">
    <div class="heading text-center">
      <h1>
        Our Product
      </h1>
      <p>
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
        has been the industry's standard dummy
      </p>
    </div>
    <div class="row">
      <div class="col-sm-3">
        <div class="conter_set">
          <i class="fa fa-diamond"></i>
          <div class="circle">
            <span class="count">20</span>
          </div>
          <h4>
            STEPLIGHT
          </h4>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="conter_set">
          <i class="fa fa-coffee"></i>
          <div class="circle">
            <span class="count">20</span>
          </div>
          <h4>
            STEPLIGHT
          </h4>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="conter_set">
          <i class="fa fa-adjust"></i>
          <div class="circle">
            <span class="count">20</span>
          </div>
          <h4>
            STEPLIGHT
          </h4>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="conter_set">
          <i class="fa fa-building"></i>
          <div class="circle">
            <span class="count">20</span>
          </div>
          <h4>
            STEPLIGHT
          </h4>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
if (count($sellProducts)) {
?>
  <section class="sec_pad sec_4 left_rightaaa">
    <div class="container">
      <div class="heading text-center" data-aos="fade-down" data-aos-duration="2000">
        <h1>
          Best Sell
        </h1>
        <p>
          Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
          has been the industry's standard dummy
        </p>
      </div>
      <div class="owl-carousel owl-theme slider_arrrw" id="slider2" data-aos="zoom-in" data-aos-duration="3000">
        <?php
        foreach ($sellProducts as $sellProduct) {
        ?>
          <div class="item">
            <div class="box_d2">
              <span class="hobb">
                <a href="<?= site_url('Product-Details/' . $sellProduct['id']); ?>"></a>
                <img src="<?= site_url('assets/site/'); ?>img/img4.png" alt="" class="img_r">
              </span>
              <div class="con_st">
                <h4><?= $sellProduct['product_title']; ?></h4>
                <h2><i class="fa fa-inr"></i><?= $sellProduct['product_price']; ?></h2>
                <div class="colr">
                  <span class="active"><i style="background:#c10000;"></i></span>
                  <span><i style="background:#00a6c1;"></i></span>
                </div>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </section>
<?php
}
?>