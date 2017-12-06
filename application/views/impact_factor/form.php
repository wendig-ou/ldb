<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form
      action="/impact_factor/preflight"
      method="POST"
    >
      <h1><?= ucfirst(lang('igb_impact_factor_import')) ?></h1>

      <?php if (isset($errors)): ?>
        <?= $errors ?>
      <?php endif; ?>

      <?= text_field('year', [
        'label' => 'igb_field_fdate',
        'required' => TRUE,
        'autofocus' => TRUE
      ]) ?>

      <?= text_area('mapping', [
        'label' => 'igb_field_mapping',
        'required' => TRUE
      ]); ?>
      
      <hr />

      <div class="pull-right">
        <input
          class="btn btn-primary"
          type="submit"
          value="<?= lang('igb_preflight') ?>"
        />
      </div>
    </form>
  </div>
</div>
