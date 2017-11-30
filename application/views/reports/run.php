<h1>
  <?= $name ?>
</h1>

<div class="<?= ($massive_resultset ? 'igb-report-frame' : '') ?>">
  <?php if (!$any_results): ?>
    <?= lang('igb_notice_no_results') ?>
  <?php else: ?>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <?php foreach ($records[0] as $column => $value): ?>
            <th><?= $column ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($records as $record): ?>
          <tr>
            <?php foreach ($record as $column => $value): ?>
              <td><?= $value ?></td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>