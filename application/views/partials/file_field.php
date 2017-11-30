<div class="form-group file">
  <label>
    <input
      type="file"
      name="<?= $name ?>"
      style="display: none"
    />

    <div class="input-group">
      <div class="input-group-btn">
        <span class="btn btn-primary">
          <?= ucfirst($label) ?>
        </span>
      </div>
      <input type="text" name="file-feedback" class="form-control" readonly="true" />
    </div>
  </label>
  <file-select-feedback></file-select-feedback>
</div>