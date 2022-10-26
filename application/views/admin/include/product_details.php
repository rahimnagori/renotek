<div class="optio_raddipo">
    <div class="form-group">
        <label> Title </label>
        <input type="text" name="product_title" class="form-control" required="" value="<?= $productDetails['product_title']; ?>">
        <input type="hidden" name="product_id" required="" value="<?= $productDetails['id']; ?>">
    </div>
    <div class="form-group">
        <label> Description </label>
        <textarea class="form-control textarea-edit" name="product_description" required=""><?= $productDetails['product_description']; ?></textarea>
    </div>
    <div class="form-group">
        <label> Price </label>
        <input type="number" step="1" name="product_price" class="form-control" required="" value="<?= $productDetails['product_price']; ?>">
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label> Category </label>
                <select name="category_id" required="" class="form-control">
                    <?php
                    foreach ($categories as $category) {
                    ?>
                        <option value="<?= $category['id']; ?>" <?=($category['id'] == $productDetails['category_id']) ? 'checked' : '';?> ><?= $category['category_name']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Is Home Page</label>
                <input type="radio" name="is_home_page" value="0" <?=($productDetails['is_home_page'] == 0) ? 'checked' : '';?> > No
                <input type="radio" name="is_home_page" value="1" <?=($productDetails['is_home_page'] == 1) ? 'checked' : '';?> > Yes
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Is Best Sell</label>
                <input type="radio" name="is_best_sell" value="0" <?=($productDetails['is_best_sell'] == 0) ? 'checked' : '';?> > No
                <input type="radio" name="is_best_sell" value="1" <?=($productDetails['is_best_sell'] == 1) ? 'checked' : '';?> > Yes
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" class="responseMessage" id="responseMessage"></div>
    </div>
    <div class="form-group">
        <button class="btn btn_theme2 btn-lg btn_submit">Update</button>
    </div>
</div>