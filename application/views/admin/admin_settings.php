<?php include 'include/header.php'; ?>

<div class="conten_web">
  <div class="ddd">
    <div class="row">
      <div class="col-sm-12">
        <div id="responseMessage"><?= $this->session->flashdata('responseMessage'); ?></div>
        <div class="white_box">
          <div class="card_bodym">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Update Profile</h3>
              </div>
              <form id="socialForm" name="socialForm" method="post" onsubmit="update_social_account(event);">
                <?php
                  foreach($socialAccounts as $socialAccount){
                ?>
                    <div class="form-group">
                      <div class="form-group-prepend">
                        <span class="form-group-text"><i class="fa fa-<?=$socialAccount['icon'];?>"></i></span>
                      </div>
                      Active<input type="radio" name="<?=$socialAccount['icon'];?>_active" value="1" <?=($socialAccount['is_active'] == 1) ? 'checked' : '';?> />
                      In-Active<input type="radio" name="<?=$socialAccount['icon'];?>_active" value="0" <?=($socialAccount['is_active'] == 0) ? 'checked' : '';?>  />
                      <input type="text" class="form-control" name="<?=$socialAccount['icon'];?>_url" value="<?=$socialAccount['url'];?>" required />
                    </div>
                <?php
                  }
                ?>
                <button type="submit" class="btn btn-info social_btn_submit">Update</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'include/footer.php'; ?>

<script>
  function update_social_account(e){
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
        $("#responseMessage").html('');
        $("#responseMessage").hide();
      },
      success: function(response) {
        $(".social_btn_submit").prop('disabled', false);
        $(".social_btn_submit").html('Update');
        if (response.status == 1) location.reload();
      }
    });
  }

</script>