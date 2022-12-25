<div class="inner_header">
  <div class="container">
    <h2>Products</h2>
    <ul class="ul_set">
      <li><a href="<?= site_url(); ?>">Home</a></li>
      <li><span>Products</span></li>
    </ul>
  </div>
</div>
<div class="shop_filter sec_pad">
  <div class="container">
    <div class="row"><div class="col-sm-12"><?=$this->session->flashdata('responseMessage');?></div></div>
    <div class="row">
      <div class="col-sm-3 filter">
        <div class="headig3">
          <h4>Search</h4>
        </div>
        <div class="input-group mb-4 set_black">
          <input type="text" class="form-control" placeholder="Enter product to search" aria-label="Username" aria-describedby="basic-addon1">
          <span class="input-group-text d2">
            <button class="btn btn_theme"><i class="fa fa-search"></i></button>
          </span>
        </div>
        <div class="headig3">
          <h4>Categories</h4>
        </div>
        <ul class="ul_set list1 mb-4">
          <?php
          foreach ($categories as $category) {
          ?>
            <li><a href="#"><?= $category['category_name']; ?></a></li>
          <?php
          }
          ?>
        </ul>

        <!-- <div class="headig3">
          <h4>Color</h4>
        </div>
        <ul class="ul_set list1 mb-4 cchek">
          <li>
            <div class="check_b">
              <input type="checkbox">
              <span></span>
            </div>
            Almond (3)
          </li>
          <li>
            <div class="check_b">
              <input type="checkbox">
              <span></span>
            </div>
            Black (6)
          </li>
          <li>
            <div class="check_b">
              <input type="checkbox">
              <span></span>
            </div>
            Brown (14)
          </li>
          <li>
            <div class="check_b">
              <input type="checkbox">
              <span></span>
            </div>
            Green (9)
          </li>
        </ul>
        <div class="headig3">
          <h4>Size</h4>
        </div>
        <ul class="ul_set list1 cchek">
          <li>
            <div class="check_b">
              <input type="checkbox">
              <span></span>
            </div>
            S (32)
          </li>
          <li>
            <div class="check_b">
              <input type="checkbox">
              <span></span>
            </div>
            M (32)
          </li>
          <li>
            <div class="check_b">
              <input type="checkbox">
              <span></span>
            </div>
            L (32)
          </li>
        </ul> -->
      </div>
      <div class="col-sm-9">
        <!-- <div class="top d-flex justify-content-between mb-3">
          <div class="ing1 d-flex align-items-center mb-3">
            <label class="mb-0">Paginate by </label>
            <input type="text" class="form-control" value="General">
          </div>
          <div class="ing1 d-flex align-items-center mb-3 ">
            <label class="mb-0">Sort by </label>
            <input type="text" class="form-control" value="General">
          </div>
        </div> -->
        <!-- Load products here -->
        <div id="products"></div>
      </div>
    </div>
  </div>
</div>

<script>
  setTimeout( () => {
    getProducts(0, 9);
  }, 2000);

  function getProducts(startingIndex = false, totalRecords = false, category = false){
    // let productsEndPoint = `${BASE_URL}Products?startingIndex=${startingIndex}&totalRecords=${totalRecords}&category=${category}`;
    let productsEndPoint = `${BASE_URL}Products`;
    $.ajax({
      type: 'POST',
      url: productsEndPoint,
      dataType: 'HTML',
      beforeSend: function(xhr) {
        $('.page-loader').fadeIn('slow');
      },
      success: function(response) {
        $('.page-loader').fadeOut('slow');
        $("#products").html(response);
      }
    });
  }

  function add_to_cart(product_id){
    $.ajax({
      type: 'POST',
      url: `${BASE_URL}Add-To-Cart/${product_id}`,
      dataType: 'json',
      beforeSend: function(xhr) {
        $(`#add-product-btn-${product_id}`).attr('disabled', true);
      },
      success: function(response) {
        $(`#add-product-btn-${product_id}`).attr('disabled', false);
        $(`#add-product-btn-${product_id}`).hide();
        $(`#remove-product-btn-${product_id}`).show();
        // let removeBtn = `<button class="btn btn-danger" id="remove-product-btn-${product_id}" onclick="remove_from_cart(${product_id})" ><i class="fa fa-times"></i></button>`;
        // $(`#add-product-btn-${product_id}`).after(removeBtn);
        $("#cart-counter").html(response.cart);
      }
    });
  }

function remove_from_cart(product_id){
  $.ajax({
    type: 'POST',
    url: `${BASE_URL}Remove-From-Cart/${product_id}`,
    dataType: 'json',
    beforeSend: function(xhr) {
      $(`#remove-product-btn-${product_id}`).attr('disabled', true);
      $(`#remove-product-btn-${product_id}`).hide();
    },
    success: function(response) {
      $(`#add-product-btn-${product_id}`).show();
      $(`#remove-product-btn-${product_id}`).attr('disabled', false);
      $("#cart-counter").html(response.cart);
    }
  });
}
</script>