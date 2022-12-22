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
        <div class="top d-flex justify-content-between mb-3">
          <div class="ing1 d-flex align-items-center mb-3">
            <!-- <label class="mb-0">Paginate by </label>
            <input type="text" class="form-control" value="General"> -->
          </div>
          <div class="ing1 d-flex align-items-center mb-3 ">
            <!-- <label class="mb-0">Sort by </label>
            <input type="text" class="form-control" value="General"> -->
          </div>
        </div>
        <div class="row">
          <?php
          foreach ($products as $product) {
            $productImage = ($product['product_image'] && file_exists($product['product_image'])) ? $product['product_image'] : 'assets/site/img/img5.png';
          ?>
            <div class="col-sm-4">
              <div class="box_d2">
                <span class="hobb">
                  <a href="<?= site_url('Product-Details/') . $product['id']; ?>"></a>
                  <img src="<?= site_url($productImage); ?>" class="img_r">
                </span>
                <div class="con_st">
                  <h4><?= $product['product_title']; ?></h4>
                  <h2><i class="fa fa-rupee"></i><?= $product['product_price']; ?></h2>
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
          <div class="col-sm-4">
            <div class="box_d2">
              <span class="hobb">
                <a href="Product-Details"></a>
                <img src="<?= site_url('assets/site/'); ?>img/img4.png" alt="" class="img_r"></span>
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
        </div>
        <!-- <div class="d-flex justify-content-center mt-4">
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">«</span>
                  <span class="sr-only">Previous</span>
                </a>
              </li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">»</span>
                  <span class="sr-only">Next</span>
                </a>
              </li>
            </ul>
          </nav>
        </div> -->
      </div>
    </div>
  </div>
</div>