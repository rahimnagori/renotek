<?php include 'include/header.php'; ?>

<div class="conten_web">
  <h4 class="heading">
    Categories <small>Management</small>
    <?php
    if (true || isset($permissions[8]) && $permissions[8]) {
    ?>
      <span><button class="btn btn_theme2" data-toggle="modal" data-target="#addCategoryModal">Add</button></span>
    <?php
    }
    ?>
  </h4>
  <div class="white_box">
    <?= $this->session->flashdata('responseMessage'); ?>
    <div class="card_bodym">
      <div class="table-responsive">
        <table id="extent_tbl1" class="table display">
          <thead>
            <tr>
              <th>S.No.</th>
              <th>Category</th>
              <?php
              if (true || isset($permissions[9]) && $permissions[9]) {
              ?>
                <th>Action</th>
              <?php
              }
              ?>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($categories as $serialNumber => $category) {
            ?>
              <tr>
                <td><?= $serialNumber + 1; ?></td>
                <td><?= $category['category_name']; ?></td>
                <?php
                if (true || isset($permissions[9]) && $permissions[9]) {
                ?>
                  <td>
                    <button onclick="edit_category(<?= $category['id'] ?>)" class="btn btn-info btn-xs">Edit</button>
                    <button class="btn btn-danger btn-xs" onclick="open_delete_modal(<?= $category['id'] ?>)">Delete</button>
                  </td>
                <?php
                }
                ?>
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
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="addForm" name="addForm" onsubmit="add_category(event);">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Category</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="la la-times-circle"></i></span></button>
        </div>

        <div class="modal-body">
          <div class="optio_raddipo">
            <div class="form-group">
              <label> Category Name </label>
              <input type="text" name="category_name" class="form-control" required="">
            </div>
            <?php
              if(count($parentCategories)){
            ?>
                <div class="form-group">
                  <label> Parent Category </label>
                  <select class="form-control" name="parent_id">
                    <option value="0"></option>
                    <?php
                      foreach($parentCategories as $parentCategory){
                    ?>
                        <option value="<?=$parentCategory['id'];?>" ><?=$parentCategory['category_name'];?></option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
            <?php
              }
            ?>
            <div class="row">
              <div class="col-sm-12" class="responseMessage" id="responseMessage"></div>
            </div>
            <div class="form-group">
              <button class="btn btn_theme2 btn-lg btn_submit">Add</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal close-->

<!-- Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="deleteForm" name="deleteForm" onsubmit="delete_category(event);">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmation</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="la la-times-circle"></i></span></button>
        </div>

        <div class="modal-body">
          <div class="optio_raddipo">
            <div class="form-group">
              <label> Are you sure you want to delete this Category? </label>
              <input type="hidden" name="delete_category_id" id="delete_category_id" />
            </div>
            <div id="delete_modal_new_categories"></div>
            <div class="row">
              <div class="col-sm-12" class="responseMessage" id="responseMessage"></div>
            </div>
            <div class="form-group">
              <button class="btn btn_theme2 btn-lg btn_submit">Yes</button>
              <button class="btn btn-lg btn-info" class="close" data-dismiss="modal" aria-label="Close">No</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal close-->

<!-- Modal -->
<div class="modal fade" id="editJobModal" tabindex="-1" role="dialog">
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

  function open_delete_modal(id) {
    $("#delete_category_id").val(id);
    $("#deleteCategoryModal").modal("show");
    // $.ajax({
    //   type: 'GET',
    //   url: BASE_URL + 'Admin-Categories/Get-New-Categories/' + id,
    //   dataType: 'HTML',
    //   beforeSend: function(xhr) {
    //     $("#editModal").html("<i class='fa fa-spin fa-spinner' aria-hidden='true'></i>")
    //     $("#editJobModal").modal("show");
    //   },
    //   success: function(response) {
    //     $("#editModal").html(response);
    //   }
    // });
  }

  function delete_category(e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: BASE_URL + 'Admin-Categories/delete',
      data: new FormData($('#deleteForm')[0]),
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
        $(".btn_submit").html(' Yes ');
        if (response.status == 1) location.reload();
      }
    });
  }

  function edit_category(category_id) {
    $.ajax({
      type: 'GET',
      url: BASE_URL + 'Admin-Categories/Get/' + category_id,
      dataType: 'HTML',
      beforeSend: function(xhr) {
        $("#editModal").html("<i class='fa fa-spin fa-spinner' aria-hidden='true'></i>")
        $("#editJobModal").modal("show");
      },
      success: function(response) {
        $("#editModal").html(response);
      }
    });
  }

  function update_category(e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: BASE_URL + 'Admin-Categories/Update',
      data: new FormData($('#editForm')[0]),
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
        $(".btn_submit").html(' Update ');
        if (response.status == 1) location.reload();
      }
    });
  }

  function update_location(locationType) {
    if (locationType == 'other') {
      $("#addLocationHtml").html(`<input type="text" name="name" id="location" class="form-control" required="" placeholder="Add other..." />`);
      $("#addLocationHtml").show();
    } else {
      $("#addLocationHtml").hide();
      $("#addLocationHtml").html("");
    }
  }
</script>