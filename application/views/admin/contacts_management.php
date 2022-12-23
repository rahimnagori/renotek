<?php include 'include/header.php'; ?>

<div class="conten_web">
  <h4 class="heading">
    Contact <small>Requests</small></h4>
  <div class="white_box">
    <?= $this->session->flashdata('responseMessage'); ?>
    <div class="card_bodym">
      <div class="table-responsive">
        <table id="extent_tbl1" class="table display">
          <thead>
            <tr>
              <th>S.No.</th>
              <th>Name</th>
              <th>Email</th>
              <th>Number</th>
              <th>Message</th>
              <th>Sent on</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($contactRequests as $serialNumber => $contactRequest) {
            ?>
              <tr>
                <td><?= $serialNumber + 1; ?></td>
                <td><?= $contactRequest['user_name']; ?></td>
                <td><?= $contactRequest['email']; ?></td>
                <td><?= $contactRequest['phone']; ?></td>
                <td><?= $contactRequest['message']; ?></td>
                <td><?= date("d M, Y", strtotime($contactRequest['created'])); ?></td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewContactModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="editForm" name="editForm" onsubmit="update_category(event);">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Category</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="la la-times-circle"></i></span></button>
        </div>

        <div class="modal-body" id="editModal">
          <i class='fa fa-spin fa-spinner' aria-hidden='true'></i>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal close-->

<?php include 'include/footer.php'; ?>

<script>
  function add_category(e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: BASE_URL + 'Admin-Categories/Add',
      data: new FormData($('#addForm')[0]),
      dataType: 'JSON',
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function(xhr) {
        $(".btn_submit").attr('disabled', true);
        $(".btn_submit").html(LOADING);
        $("#responseMessage").html('');
        $("#responseMessage").hide();
      },
      success: function(response) {
        $(".btn_submit").prop('disabled', false);
        $(".btn_submit").html(' Add ');
        if (response.status == 1) location.reload();
      }
    });
  }
</script>