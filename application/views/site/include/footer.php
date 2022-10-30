<footer class="footer_u">
  <div class="container">
    <div class="row coppy align-items-center">
      <div class="col-sm-8">
        <p>
          © Copyright <?= date("Y"); ?> <?= $this->config->item('PROJECT'); ?>. All Rights Reserved
        </p>
      </div>
      <div class="col-sm-4">
        <ul class="ul_set socila_foo">
          <li><a href="#" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
          <li><a href="https://www.facebook.com/profile.php?id=100063714533170" target="_blank"><i class="fa fa-facebook"></i></a></li>
          <li><a href="https://www.instagram.com/renotekelectric/" target="_blank"><i class="fa fa-instagram"></i></a></li>
          <li><a href="#" target="_blank"><i class="fa fa-youtube"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
<script src="<?= site_url('assets/site/'); ?>js/jquery.min.js"></script>
<script src="<?= site_url('assets/site/'); ?>js/popper.min.js"></script>
<script src="<?= site_url('assets/site/'); ?>js/bootstrap.min.js"></script>
<script src="<?= site_url('assets/site/'); ?>js/owl.carousel.js"></script>
<script src="<?= site_url('assets/site/'); ?>js/custom.js"></script>
<script src="<?= site_url('assets/site/'); ?>js/aos.js"></script>
<script>
  AOS.init({
    easing: 'ease-out-back',
    duration: 1000
  });
</script>
<script>
  $(window).on('load', function() {
    setTimeout(function() { // allowing 3 secs to fade out loader
      $('.page-loader').fadeOut('slow');
    }, 500);
  });
</script>

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
  const BASE_URL = "<?= site_url(); ?>";
  const LOADING = "<i class='fa fa-spin fa-spinner' aria-hidden='true'></i> Processing ... ";
</script>
</body>

</html>