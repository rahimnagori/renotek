<div class="optio_raddipo">
    <div class="form-group">
        <label> Category Name </label>
        <input type="text" name="category_name" class="form-control" required="" value="<?= $categoryDetails['category_name']; ?>">
        <input type="hidden" name="category_id" required="" value="<?= $categoryDetails['id']; ?>">
    </div>
    <div class="form-group">
        <label> Parent Category </label>
        <select class="form-control" name="parent_id">
        <option value="0" style="font-style: italic;" > - none - </option>
        <?php
            foreach($parentCategories as $parentCategory){
        ?>
            <option value="<?=$parentCategory['id'];?>" <?=($parentCategory['id'] == $categoryDetails['parent_id']) ? 'selected' : ''; ?> ><?=$parentCategory['category_name'];?></option>
        <?php
            }
        ?>
        </select>
    </div>
    <div class="row">
        <div class="col-sm-12" class="responseMessage" id="responseMessage"></div>
    </div>
    <div class="form-group">
        <button class="btn btn_theme2 btn-lg btn_submit">Update</button>
    </div>
</div>