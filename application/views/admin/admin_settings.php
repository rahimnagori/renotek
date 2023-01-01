<?php include 'include/header.php'; ?>
<style>
  .btn_dd {
    margin-top: 5px;
  }
</style>
<div class="conten_web">
  <div class="ddd">
    <div class="row">
      <div class="col-sm-12">
        <?= $this->session->flashdata('responseMessage'); ?>
        <div class="white_box">
          <div class="card_bodym">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Update Profile</h3>
              </div>
              <form id="socialForm" name="socialForm" method="post" onsubmit="update_social_account(event);">
                <div class="row">
                  <?php
                  foreach ($socialAccounts as $socialAccount) {
                  ?>
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-<?= $socialAccount['icon']; ?>"></i></span>
                          <input type="text" class="form-control" name="<?= $socialAccount['icon']; ?>_url" value="<?= $socialAccount['url']; ?>" required />
                          <span style="display: table-cell; width: 60px; text-align: right;">
                            <div class="switch">
                              <input name="<?= $socialAccount['icon']; ?>_active" id="switch-<?= $socialAccount['id']; ?>" type="checkbox" class="switch-input" <?= ($socialAccount['is_active'] == 1) ? 'checked' : ''; ?>>
                              <label for="switch-<?= $socialAccount['id']; ?>" class="switch-label">Switch</label>
                            </div>
                          </span>
                        </div>


                        <!-- <div class="btn_dd">
                    <label class="radio-inline">Active<input type="radio" name="<?= $socialAccount['icon']; ?>_active" value="1" <?= ($socialAccount['is_active'] == 1) ? 'checked' : ''; ?> />
                    </label>
                    <label class="radio-inline">In-Active<input type="radio" name="<?= $socialAccount['icon']; ?>_active" value="0" <?= ($socialAccount['is_active'] == 0) ? 'checked' : ''; ?> />
                    </label>
                    </div> -->
                      </div>
                    </div>
                  <?php
                  }
                  ?>
                </div>
                <button type="submit" class="btn btn-info social_btn_submit">Update</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="white_box">
          <div class="card_bodym">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">About Us Page</h3>
              </div>
              <form id="aboutForm" name="aboutForm" method="post" onsubmit="update_about(event);">
                <div class="row">
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Home page about</label>
                      <textarea class="form-control" name="about_us_short" rows="9" required><?= $pagesContent['about_us_short']; ?></textarea>
                    </div>
                  </div>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <label>About Us Page</label>
                      <textarea class="form-control textarea" name="about_us_long" required><?= $pagesContent['about_us_long']; ?></textarea>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-info about_btn_submit">Update</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="white_box">
          <div class="card_bodym">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Update Catalogue</h3>
              </div>
              <div class="row">
                <div class="col-sm-3">
                  <form id="catalogueForm" name="catalogueForm" method="post" onsubmit="update_catalogue(event);">
                    <div class="form-group">
                      <label>New Catalogue <small>This will replace the old catalogue</small></label>
                      <input type="file" id="catalogueFile" name="catalogue" required="" accept=".pdf" />
                    </div>
                    <button type="submit" class="btn btn-info catalogue_btn_submit">Update</button>
                  </form>
                </div>
                <div class="col-sm-9">
                  <?php
                  if (file_exists(site_url($settings['catalogue']))) {
                  ?>
                    <iframe id="cataloguePreview" width="100%" height="500px" src="<?= site_url($settings['catalogue']); ?>"></iframe>
                  <?php
                  } else {
                  ?>
                    <!-- <strong>File not found</strong> -->
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'include/footer.php'; ?>

<?php include_once('include/tinymce.php'); ?>

<script>
  function update_social_account(e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: BASE_URL + 'Admin-Social-Update',
      data: new FormData($('#socialForm')[0]),
      dataType: 'JSON',
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function(xhr) {
        $(".social_btn_submit").attr('disabled', true);
        $(".social_btn_submit").html(LOADING);
      },
      success: function(response) {
        $(".social_btn_submit").prop('disabled', false);
        $(".social_btn_submit").html('Update');
        if (response.status == 1) location.reload();
      }
    });
  }

  function update_about(e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: BASE_URL + 'Admin-About-Update',
      data: new FormData($('#aboutForm')[0]),
      dataType: 'JSON',
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function(xhr) {
        $(".about_btn_submit").attr('disabled', true);
        $(".about_btn_submit").html(LOADING);
      },
      success: function(response) {
        $(".about_btn_submit").prop('disabled', false);
        $(".about_btn_submit").html('Update');
        if (response.status == 1) location.reload();
      }
    });
  }

  function update_catalogue(e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: BASE_URL + 'Update-Catalogue',
      data: new FormData($('#catalogueForm')[0]),
      dataType: 'JSON',
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function(xhr) {
        $(".catalogue_btn_submit").attr('disabled', true);
        $(".catalogue_btn_submit").html(LOADING);
      },
      success: function(response) {
        $(".catalogue_btn_submit").prop('disabled', false);
        $(".catalogue_btn_submit").html('Update');
        if (response.status == 1) location.reload();
      }
    });
  }
</script>