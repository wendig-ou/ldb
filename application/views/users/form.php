<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form
      action="/users/<?= (isset($id) ? 'edit/'.$id : 'new') ?>"
      method="POST"
    >
      <h1>
        <?php if (isset($id))
          echo ucfirst(sprintf(lang('igb_edit'), $user['uname']));
        else
          echo ucfirst(sprintf(lang('igb_create_new'), lang('igb_user')));
        ?>
      </h1>

      <?= validation_errors() ?>

      <?php if (isset($id)): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="return_to" value="<?= set_value('return_to', $referrer) ?>" />
      <?php endif; ?>

      <?= text_field('uname', [
        'value' => $user['uname'],
        'label' => 'igb_field_username'
      ]); ?>

      <?= text_field('comment', [
        'value' => $user['comment'],
        'label' => 'igb_field_name'
      ]); ?>

      <?= department_selector('dpmt', [
        'value' => $user['dpmt'],
        'label' => 'igb_field_dpmt'
      ]); ?>

      <div class="form-group">
        <label class="form-label">
          <?= ucfirst(lang('igb_field_role')) ?>
        </label>
        <select
          class="form-control"
          name="role"
          autofocus
        >
          <?php foreach ($roles as $role): ?>
            <option
              value="<?= $role ?>"
              <?= set_select('role', $role, $role == ($user['role'] ?? 'user')) ?>
            >
              <?= lang('igb_role_'.$role) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      
      <hr />

      <?= text_field('pw', [
        'type' => 'password',
        'label' => 'igb_field_password'
      ]); ?>

      <?= text_field('password_confirmation', [
        'type' => 'password',
        'label' => 'igb_field_password_confirmation'
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
