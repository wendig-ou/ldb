<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form
      action="/institutions/<?= (isset($id) ? 'edit/'.$id : 'new') ?>"
      method="POST"
    >
      <h1>
        <?php if (isset($id))
          echo ucfirst(sprintf(lang('igb_edit'), $id));
        else
          echo ucfirst(sprintf(lang('igb_create_new'), lang('igb_institution')));
        ?>
      </h1>

      <?= validation_errors() ?>

      <?php if (isset($id)): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="return_to" value="<?= set_value('return_to', $referrer) ?>" />
      <?php endif; ?>

      <div class="form-group">
        <label class="form-label">
          <?= ucfirst(lang('igb_field_name')) ?>
        </label>
        <input
          class="form-control"
          type="text"
          name="name"
          value="<?= set_value('name', (isset($id) ? $institution['institut'] : NULL)) ?>"
          autofocus
        />
      </div>
      
      <hr />

      <div class="pull-right">
        <input
          class="btn btn-primary"
          type="submit"
          value="<?= lang('igb_save') ?>"
        />
      </div>
    </form>
  </div>
</div>
