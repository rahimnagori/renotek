<div class="inner_header">
  <div class="container">
    <h2>Product</h2>
    <ul class="ul_set">
      <li><a href="<?= site_url('Shop'); ?>">All</a></li>
      <li><span><?= $productDetails['product_title']; ?></span></li>
    </ul>
  </div>
</div>
<div class="shop_details sec_pad">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="slider_dyta">
          <div class="">
            <div id="sync1" class="owl-carousel owl-theme">
              <?php
              foreach ($productImages as $productImage) {
              ?>
                <div class="item">
                  <img src="<?= site_url($productImage['product_image']); ?>" alt="" class="img_r">
                </div>
              <?php
              }
              ?>
              <div class="item">
                <img src="<?= site_url('assets/site/'); ?>img/img1.png" alt="" class="img_r">
              </div>
            </div>

            <div id="sync2" class="owl-carousel owl-theme">
              <?php
              foreach ($productImages as $productImage) {
              ?>
                <div class="item">
                  <img src="<?= site_url($productImage['product_image']); ?>" alt="" class="img_r">
                </div>
              <?php
              }
              ?>
              <div class="item">
                <img src="<?= site_url('assets/site/'); ?>img/img1.png" alt="" class="img_r">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="conten_set shop_details2">
          <h2><?= $productDetails['product_title']; ?></h2>
          <?= $productDetails['product_description']; ?>
          <!-- <h4>Unavailable</h4>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate id est laborum.
          </p>
          <ul class="ul_set list_dettyt mt-4">
            <li>
              <span class="opb1">Size</span>
              <span class="Size_set">
                <div class="check_b">
                  <input type="radio" value="1" name="size">
                  <span>S</span>
                </div>
                <div class="check_b">
                  <input type="radio" value="2" name="size">
                  <span>M</span>
                </div>
                <div class="check_b">
                  <input type="radio" value="3" name="size">
                  <span>L</span>
                </div>
              </span>
            </li>
            <li>
              <span class="opb1">Color</span>
              <span class="opb2">
                <span class="colorrr">
                  <div class="check_b">
                    <input type="radio" value="1" name="size">
                    <span><b style="background:#f00;"></b></span>
                  </div>
                  <div class="check_b">
                    <input type="radio" value="2" name="size">
                    <span><b style="background:#971cce;"></b></span>
                  </div>
                  <div class="check_b">
                    <input type="radio" value="3" name="size">
                    <span><b style="background:#0eb768;"></b></span>
                  </div>
                </span>
              </span>
            </li>
            <li>
              <span class="opb1">Material</span>
              <span class="opb2">Wood</span>
            </li>
            <li>
              <span class="opb1">Vendor</span>
              <span class="opb2">Renotek </span>
            </li>
            <li>
              <span class="opb1">Availability</span>
              <span class="opb2">In stock!</span>
            </li>
          </ul> -->
        </div>
      </div>
    </div>
  </div>
</div>