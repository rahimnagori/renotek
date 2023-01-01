<div class="optio_raddipo">
    <div class="form-group">
        <label> Heading </label>
        <input type="text" name="heading" class="form-control" required="" value="<?= $sliderDetails['heading']; ?>">
        <input type="hidden" name="slider_id" required="" value="<?= $sliderDetails['id']; ?>">
    </div>
    <div class="form-group">
        <label> Sub Heading </label>
        <input type="text" name="sub_heading" class="form-control" required="" value="<?= $sliderDetails['sub_heading']; ?>">
    </div>
    <div class="form-group">
        <label> URL </label>
        <input type="url" name="url" class="form-control" value="<?= $sliderDetails['url']; ?>">
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label> Image </label>
                <input type="file" name="update_slider_image" onchange="preview_image(this, 'preview-update-image');">
                <input type="hidden" name="old_slider_image" value="<?= $sliderDetails['slider_image'] ?>" required="">
            </div>
        </div>
        <div class="col-sm-6" id="preview-update-image">
            <img src="<?= site_url($sliderDetails['slider_image']); ?>" width="100">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" class="responseMessage" id="responseMessage"></div>
    </div>
    <div class="form-group">
        <button class="btn btn_theme2 btn-lg btn_submit">Update</button>
    </div>
</div>