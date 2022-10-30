<div class="optio_raddipo">
    <div class="form-group">
        <label> Image </label>
        <input type="file" accept="image/*" name="product_image" required="" onchange="preview_image(this, 'preview_update_image');"  />
        <input type="hidden" name="image_id" required="" value="<?= $imageDetails['id']; ?>">
    </div>
    <div id="preview_update_image">
        <img src="<?=site_url($imageDetails['product_image']);?>" style="width:100%" >
    </div>
    <div class="row">
        <div class="col-sm-12" class="responseMessage" id="responseMessage"></div>
    </div>
    <div class="form-group">
        <button class="btn btn_theme2 btn-lg btn_submit" type="submit">Update</button>
    </div>
</div>