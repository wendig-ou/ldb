<div class="container-fluid">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <h1><?= ucfirst(lang('igb_sign_in')) ?></h1>

      <form action="/auth/new" method="POST">
        <?= validation_errors() ?>

        <input
          type="hidden"
          name="return_to"
          value="<?= $this->input->get('return_to') ?>"
        />

        <?php if (!$no_form): ?>
          <div class="form-group">
            <label class="control-label">
              <?= ucfirst($this->lang->line('igb_field_username')) ?>
            </label>
            <input
              name="username"
              value="<?= set_value('username') ?>"
              class="form-control"
              type="text"
              autofocus
            />
          </div>
          <div class="form-group">
            <label class="control-label">
              <?= ucfirst($this->lang->line('igb_field_password')) ?>
            </label>
            <input
              name="password"
              value="<?= set_value('password') ?>"
              class="form-control"
              type="password"
            />
          </div>
          <div class="form-group text-right">
            <hr />
            <input
              class="btn btn-primary"
              type="submit"
              value="<?= ucfirst($this->lang->line('igb_sign_in')) ?>"
            />
          </div>
        <?php else: ?>
          <div class="form-group text-right">
            <hr />
            <a class="btn btn-primary" href="/auth/new">
              <?= ucfirst(lang('igb_i_understand')) ?>
            </a>
          </div>
        <?php endif ?>
      </form>
    </div>
  </div>
</div>