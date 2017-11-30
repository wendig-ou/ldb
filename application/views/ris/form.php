<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form
      action="/ris/preflight"
      method="POST"
      enctype="multipart/form-data"
    >
      <h1><?= ucfirst(lang('igb_ris_import')) ?></h1>

      <?php if (isset($errors)): ?>
        <?= $errors ?>
      <?php endif; ?>

      <?= file_field('file', [
        'label' => 'igb_field_ris_file',
        'required' => TRUE,
        'autofocus' => TRUE
      ]); ?>
      
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
