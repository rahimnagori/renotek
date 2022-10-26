<?php include('include/header.php'); ?>
<div class="inner_header">
  <div class="container">
    <h2>Product</h2>
    <ul class="ul_set">
      <li><a href="shop.php">All</a></li>
      <li><span> 220-Watt Floor Lamp</span></li>
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
    <div class="item">
        <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
</div>

<div id="sync2" class="owl-carousel owl-theme">
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
    <div class="item">
    <img src="img/img1.png" alt="" class="img_r">
    </div>
</div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="conten_set shop_details2">
            <h2>1274 5-Watt Table Lamp</h2>
            <h4>Unavailable</h4>
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
            
            </ul>
          </div>
        </div>
      </div>
  </div>
</div>
<?php include('include/footer.php'); ?>
<script>
  $(document).ready(function() {

var sync1 = $("#sync1");
var sync2 = $("#sync2");
var slidesPerPage = 3; //globaly define number of elements per page
var syncedSecondary = true;

sync1.owlCarousel({
    items: 1,
    slideSpeed: 2000,
    nav: true,
    autoplay: false, 
    dots: true,
    loop: true,
    responsiveRefreshRate: 200,
    navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>', '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
}).on('changed.owl.carousel', syncPosition);

sync2
    .on('initialized.owl.carousel', function() {
        sync2.find(".owl-item").eq(0).addClass("current");
    })
    .owlCarousel({
        items: slidesPerPage,
        dots: true,
        nav: true,
        smartSpeed: 200,
        slideSpeed: 500,
        slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
        responsiveRefreshRate: 100
    }).on('changed.owl.carousel', syncPosition2);

function syncPosition(el) {
    //if you set loop to false, you have to restore this next line
    //var current = el.item.index;

    //if you disable loop you have to comment this block
    var count = el.item.count - 1;
    var current = Math.round(el.item.index - (el.item.count / 2) - .5);

    if (current < 0) {
        current = count;
    }
    if (current > count) {
        current = 0;
    }

    //end block

    sync2
        .find(".owl-item")
        .removeClass("current")
        .eq(current)
        .addClass("current");
    var onscreen = sync2.find('.owl-item.active').length - 1;
    var start = sync2.find('.owl-item.active').first().index();
    var end = sync2.find('.owl-item.active').last().index();

    if (current > end) {
        sync2.data('owl.carousel').to(current, 100, true);
    }
    if (current < start) {
        sync2.data('owl.carousel').to(current - onscreen, 100, true);
    }
}

function syncPosition2(el) {
    if (syncedSecondary) {
        var number = el.item.index;
        sync1.data('owl.carousel').to(number, 100, true);
    }
}

sync2.on("click", ".owl-item", function(e) {
    e.preventDefault();
    var number = $(this).index();
    sync1.data('owl.carousel').to(number, 300, true);
});
});
</script>