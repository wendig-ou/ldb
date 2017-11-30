<h1>
  <a href="/institutions/new" class="btn btn-primary pull-right">
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
      <th><?= sortable_column('iid', ['label' => 'igb_field_id'] ) ?></th>
      <th><?= sortable_column('institut', ['label' => 'igb_field_name'] ) ?></th>
      <th class="text-right"><?= ucfirst(lang('igb_record_usage_count')) ?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($institutions as $institution): ?>
      <tr>
        <td><?= $institution['iid'] ?></td>
        <td>
          <a href="/institutions/edit/<?= $institution['iid'] ?>">
            <?= $institution['institut'] ?>
          </a>
        </td>
        <td class="text-right"><?= $institution['pub_count'] ?></td>
        <td class="text-right">
          <a href="/publications?institution_id=<?= $institution['iid'] ?>">
            <i class="glyphicon glyphicon-tags"></i>  
          </a>
          <a href="/institutions/edit/<?= $institution['iid'] ?>">
            <i class="glyphicon glyphicon-pencil"></i>
          </a>
          <confirm-anchor
            href="/institutions/delete/<?= $institution['iid'] ?>"
          >
            <i class="glyphicon glyphicon-trash"></i>
          </confirm-anchor>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>