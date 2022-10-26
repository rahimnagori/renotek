<div class="form-group">
    <label> Content </label>
    <textarea class="form-control textarea-edit" name="content" required=""><?= $emailData['content']; ?></textarea>
    <input type="hidden" name="email_id" value="<?= $emailData['id']; ?>" />
</div>
<div class="row">
    <div class="col-sm-12" class="responseMessage" id="editResponseMessage"></div>
</div>
<div class="form-group">
    <button class="btn btn-info btn-lg btn_submit">Update</button>
</div>