<div class="row">
  <div class="col-md-12">
    <form
      action="/publications/<?= (isset($id) ? 'edit/'.$id : 'new') ?>?super-type-id=<?= $super_type_id ?>"
      method="POST"
    >
      <?php if (getenv('LDB_USE_DIMENSION_BADGES') == 'true'): ?>
        <div class="pull-right">
          <?= dimension_badge($publication['doi'], ['data_legend' => 'hover-left']); ?>
        </div>
      <?php endif ?>
      <h1>
        <?php if (isset($id)): ?>
          <?= ucfirst(sprintf(lang('igb_edit'), $id)) ?>
        <?php else: ?>
          <?= ucfirst(sprintf(lang('igb_create_new'), lang('igb_publication'))) ?>

          <?php if (isset($super_type)): ?>
            <p class="lead">
              <?= $super_type['name'] ?>
            </p>
          <?php endif ?>
        <?php endif ?>
      </h1>

      <?php if ($super_type_id && $super_type['description']): ?>
        <div class="panel panel-default text-muted ldb-help">
          <div class="panel-body">
            <i class="glyphicon glyphicon-info-sign"></i>
            <strong>
              <?= ucfirst($super_type['name']) ?>
            </strong>
            <p>
              <?= $super_type['description'] ?>
            </p>
          </div>
        </div>
      <?php endif ?>

      <?= validation_errors() ?>

      <?php if (isset($id)): ?>
        <input type="hidden" name="id" value="<?= $id ?>" />
        <input type="hidden" name="return_to" value="<?= set_value('return_to', $referrer) ?>" />
      <?php endif; ?>

      <?php if (! $super_type_id): ?>
        <?php $this->load->view('partials/super_form_grid'); ?>
      <?php else: ?>
        <?php $this->load->view('publications/type') ?>
        <?php $this->load->view('publications/sub_forms/'.$super_type['code']) ?>
        <hr />
        <?php $this->load->view('partials/form_submit', ['continue' => TRUE]) ?>
      <?php endif; ?>
    </form>
  </div>
</div>

<type-notifier selector="input[name=klr_tow]"></type-notifier>
