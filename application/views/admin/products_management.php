<?php include 'include/header.php'; ?>

<div class="conten_web">
  <h4 class="heading">
    Products <small>Management</small>
    <?php
    if (true || isset($permissions[8]) && $permissions[8]) {
    ?>
      <span><button class="btn btn_theme2" data-toggle="modal" data-target="#addProductModal">Add</button></span>
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
              <th>Title</th>
              <th>Description</th>
              <th>Price</th>
              <th>Home Page</th>
              <th>Best Sell</th>
              <th>Created</th>
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
            foreach ($products as $serialNumber => $product) {
              $description = strip_tags(substr($product['product_description'], 0, 100));
            ?>
              <tr>
                <td><?= $serialNumber + 1; ?></td>
                <td><?= $product['category_name']; ?></td>
                <td>
                  <a href="<?=site_url('Product-Details/' .$product['id']);?>" target="_blank" ><?= $product['product_title']; ?></a>
                </td>
                <td><?= $description; ?></td>
                <td><?= $product['product_price']; ?></td>
                <td><?= ($product['is_home_page'] == 1) ? 'Yes' : 'No'; ?></td>
                <td><?= ($product['is_best_sell'] == 1) ? 'Yes' : 'No'; ?></td>
                <td><?= date("d M, Y", strtotime($product['created'])); ?></td>
                <?php
                if (true || isset($permissions[9]) && $permissions[9]) {
                ?>
                  <td>
                    <button onclick="edit_product(<?= $product['id'] ?>)" class="btn btn-info btn-xs">Edit</button>
                    <button class="btn btn-danger btn-xs" onclick="open_delete_modal(<?= $product['id'] ?>)">Delete</button>
                    <a class="btn btn-info btn-xs" href="<?=site_url('Admin-Image/' .$product['id']);?>">Images</a>
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
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="addForm" name="addForm" onsubmit="add_product(event);">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Category</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="la la-times-circle"></i></span></button>
        </div>

        <div class="modal-body">
          <div class="optio_raddipo">
            <div class="form-group">
              <label> Title </label>
              <input type="text" name="product_title" class="form-control" required="">
            </div>
            <div class="form-group">
              <label> Description </label>
              <textarea class="form-control textarea" name="product_description" required=""></textarea>
            </div>
            <div class="form-group">
              <label> Price </label>
              <input type="number" step="1" name="product_price" class="form-control" required="">
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Category </label>
                  <select name="category_id" required="" class="form-control" >
                    <?php
                      foreach($categories as $category){
                    ?>
                        <option value="<?=$category['id'];?>"><?=$category['category_name'];?></option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Is Home Page</label>
                  <input type="radio" name="is_home_page" value="0" checked > No
                  <input type="radio" name="is_home_page" value="1"> Yes
                </div>
              </div>
              <div class="col-sm-4">
              <div class="form-group">
                  <label>Is Best Sell</label>
                  <input type="radio" name="is_best_sell" value="0" checked > No
                  <input type="radio" name="is_best_sell" value="1"> Yes
                </div>
              </div>
            </div>
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
    <form id="deleteForm" name="deleteForm" onsubmit="delete_product(event);">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmation</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="la la-times-circle"></i></span></button>
        </div>

        <div class="modal-body">
          <div class="optio_raddipo">
            <div class="form-group">
              <label> Are you sure you want to delete this Category? </label>
              <input type="hidden" name="delete_product_id" id="delete_product_id" />
            </div>
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
    <form id="editForm" name="editForm" onsubmit="update_product(event);">
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
<?php include 'include/tinymce.php'; ?>

<script>
  function add_product(e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: BASE_URL + 'Admin-Products/Add',
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
    $("#delete_product_id").val(id);
    $("#deleteCategoryModal").modal("show");
  }

  function delete_product(e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: BASE_URL + 'Admin-Products/delete',
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

  function edit_product(product_id) {
    $.ajax({
      type: 'GET',
      url: BASE_URL + 'Admin-Products/Get/' + product_id,
      dataType: 'HTML',
      beforeSend: function(xhr) {
        $("#editModal").html("<i class='fa fa-spin fa-spinner' aria-hidden='true'></i>")
        $("#editJobModal").modal("show");
      },
      success: function(response) {
        $("#editModal").html(response);
        update_tiny('textarea-edit');
      }
    });
  }

  function update_product(e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: BASE_URL + 'Admin-Products/Update',
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