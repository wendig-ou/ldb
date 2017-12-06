<h1>
  <?= ucfirst(lang('igb_impact_factor_import')) ?>
  (<?= lang('igb_preflight') ?>)

  <p class="lead"><?= lang('igb_prompt_verify_parsed') ?></p>
</h1>

<div class="row">
  <div class="col-md-6">
    <p>
      A <span class="text-success">green</span> background in the first column
      signals a match with an existing periodical entry.
    </p>
  </div>
</div>

<hr />

<table class="table table-striped table-hover ris-preflight">
  <thead>
    <tr>
      <th><?= ucfirst(lang('igb_field_pname_id')) ?></th>
      <th><?= ucfirst(lang('igb_publications')) ?></th>
      <th class="text-right"><?= ucfirst(lang('igb_field_impact_factor')) ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($records as $record): ?>
      <tr>
        <td class="<?= $record['periodical'] ? 'text-success' : '' ?>">
          <?php if ($record['periodical']): ?>
            <?= $record['periodical']['pname'] ?> (<?= $record['periodical']['pid'] ?>)
          <?php else: ?>
            <?= $record['periodical']['pname'] ?> (NOT FOUND)
          <?php endif ?>
        </td>
        <td>
          <?php foreach ($record['publications'] as $pub): ?>
            <div>
              <a href="/publications/edit/<?= $pub['pid'] ?>" target="_blank">
                <?= $pub['title'] ?> (<?= $pub['pid'] ?>)
              </a>
            </div>
          <?php endforeach ?>
        </td>
        <td class="text-right"><?= $record['impact_factor'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<hr />

<div class="pull-right">
  <form action="/impact_factor/commit" method="POST">
    <input name="mapping" type="hidden" value="<?= set_value('mapping', $mapping) ?>" />
    <input name="year" type="hidden" value="<?= set_value('year', $year) ?>" />

    <a
      class="btn btn-default"
      href="/impact_factor"
    ><?= lang('igb_cancel') ?></a>
    <input
      class="btn btn-primary"
      type="submit"
      value="<?= lang('igb_proceed_with_import') ?>"
    />
  </form>
</div>
