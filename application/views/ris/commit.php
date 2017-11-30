<h1>
  <?= ucfirst(lang('igb_ris_import')) ?>
  (<?= lang('igb_results') ?>)
</h1>

<hr />

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <ul>
      <?php foreach ($report as $item): ?>
        <div class="alert alert-info">
          <a
            href="/publications/edit/<?= $item[0] ?>"
            target="_blank"
          >publication <?= $item[0] ?></a>
          <?php if ($item[1] == 'existed'): ?>
            already existed and it was updated
          <?php else: ?>
            did not exist and was created
          <?php endif ?>
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
