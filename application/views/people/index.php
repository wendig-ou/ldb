<h1>
  <a href="/people/new" class="btn btn-primary pull-right" title="create">
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
      <th><?= sortable_column('lpid', ['label' => 'igb_field_id'] ) ?></th>
      <th><?= sortable_column('Person', ['label' => 'igb_field_name'] ) ?></th>
      <th><?= lang('igb_field_references') ?></th>
      <th class="text-right"><?= ucfirst(lang('igb_record_usage_count')) ?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($people as $person): ?>
      <tr>
        <td><?= $person['lpid'] ?></td>
        <td>
          <a href="/people/edit/<?= $person['lpid'] ?>">
            <?= $person['Person'] ?>
          </a>
        </td>
        <td>
          <?= human_person_references($person) ?>
        </td>
        <td class="text-right">
          <?= $person['pub_count'] ?>
        </td>
        <td class="text-right">
          <a href="/publications?person_id=<?= $person['lpid'] ?>">
            <i class="glyphicon glyphicon-tags"></i>  
          </a>
          <a href="/people/edit/<?= $person['lpid'] ?>">
            <i class="glyphicon glyphicon-pencil"></i>
          </a>
          <confirm-anchor
            href="/people/delete/<?= $person['lpid'] ?>"
          >
            <i class="glyphicon glyphicon-trash"></i>
          </confirm-anchor>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>