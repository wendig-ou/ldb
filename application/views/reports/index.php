<h1>
  <?= ucfirst($title) ?>
</h1>

<?php foreach($reports as $name => $sql): ?>
  <div class="igb-report">
    <h3>
      <div class="btn-group pull-right">
        <a href="/reports/run?name=<?= $name ?>" class="btn btn-primary btn-xs">
          <?= lang('igb_run') ?>
        </a>
        <a href="/reports/run?format=csv&name=<?= $name ?>" class="btn btn-primary btn-xs">
          <?= lang('igb_run_and_csv') ?>
        </a>
      </div>
      <?= $name ?>
    </h3>
    <pre><?= $sql ?></pre>
    <hr />
  </div>
<?php endforeach; ?>