<h1>
  <a href="/periodicals/new" class="btn btn-primary pull-right">
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

<table class="table table-hover table-striped">
  <thead>
    <tr>
      <th><?= sortable_column('pid', ['label' => 'igb_field_id'] ) ?></th>
      <th><?= sortable_column('pname', ['label' => 'igb_field_name'] ) ?></th>
      <th class="text-right"><?= ucfirst(lang('igb_record_usage_count')) ?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($periodicals as $periodical): ?>
      <tr>
        <td><?= $periodical['pid'] ?></td>
        <td><?= $periodical['pname'] ?></td>
        <td class="text-right">
          <?= $periodical['pub_count'] ?>
        </td>
        <td class="text-right">
          <a href="/publications?pname_id=<?= $periodical['pid'] ?>">
            <i class="glyphicon glyphicon-tags"></i>  
          </a>
          <a href="/periodicals/edit/<?= $periodical['pid'] ?>">
            <i class="glyphicon glyphicon-pencil"></i>
          </a>
          <confirm-anchor
            href="/periodicals/delete/<?= $periodical['pid'] ?>"
          >
            <i class="glyphicon glyphicon-trash"></i>
          </confirm-anchor>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>