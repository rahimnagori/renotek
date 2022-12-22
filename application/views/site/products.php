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