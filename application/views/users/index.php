<h1>
  <a href="/users/new" class="btn btn-primary pull-right" title="create">
    <i class="glyphicon glyphicon-plus"></i>
  </a>
  <?= ucfirst($title) ?>
</h1>

<pagination total="<?= $total ?>"></pagination>

<div class="row">
  <div class="col-md-4">
    <form method="GET" class="form-inline">
      <?= text_field('terms', [
        'help' => 'igb_search',
        'value' => $this->input->get('terms'),
        'autofocus' => "true"
      ]); ?>
      <div class="form-group">
        <input
          class="btn btn-primary"
          type="submit"
          name="continue"
          value="<?= lang('igb_search') ?>"
        />
      </div>
    </form>
  </div>
</div>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th><?= sortable_column('uid', ['label' => 'igb_field_id'] ) ?></th>
      <th><?= sortable_column('uname', ['label' => 'igb_field_username'] ) ?></th>
      <th><?= sortable_column('comment', ['label' => 'igb_field_name'] ) ?></th>
      <th><?= ucfirst(lang('igb_field_active')) ?></th>
      <th><?= ucfirst(lang('igb_field_dpmt')) ?></th>
      <th><?= ucfirst(lang('igb_field_role')) ?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user): ?>
      <tr>
        <td><?= $user['uid'] ?></td>
        <td>
          <a href="/users/edit/<?= $user['uid'] ?>">
            <?= $user['uname'] ?>
          </a>
        </td>
        <td>
          <?= $user['comment'] ?>
        </td>
        <td>
          <?= human_bool($user['active']) ?>
        </td>
        <td>
          <?= $user['dpmt'] ?>
        </td>
        <td>
          <?= lang('igb_role_'.$user['role']) ?>
        </td>
        <td class="text-right">
          <a href="/users/edit/<?= $user['uid'] ?>">
            <i class="glyphicon glyphicon-pencil"></i>
          </a>
          <confirm-anchor
            href="/users/delete/<?= $user['uid'] ?>"
          >
            <i class="glyphicon glyphicon-trash"></i>
          </confirm-anchor>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>