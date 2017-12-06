<h1>
  <?= ucfirst(lang('igb_impact_factor_import')) ?>
  (<?= lang('igb_results') ?>)
</h1>

<hr />

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <ul>
      <?php foreach ($report as $item): ?>
        <div class="alert alert-info">
          <a
            href="/publications/edit/<?= $item['pid'] ?>"
            target="_blank"
          >publication <?= $item['pid'] ?></a>
          has been updated with impact factor
          <strong>
            <?php if ($item['impact_factor']): ?>
              <?= $item['impact_factor'] ?>
            <?php else: ?>
              [<?= lang('igb_removed') ?>]
            <?php endif ?>
          </strong>
        </div>
      <?php endforeach ?>
    </ul>
  </div>
</div>

<hr />

<div class="pull-right">
  <a
    class="btn btn-primary"
    href="/"
  ><?= lang('igb_publications') ?></a>
</div>
