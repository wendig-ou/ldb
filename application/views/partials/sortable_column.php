<a class="ldb-sortable-column" href="<?= $url ?>">
  <?= ucfirst($label) ?>
  <?php if ($current_direction == 'desc'): ?>
    <i class="glyphicon glyphicon-chevron-down"></i>
  <?php endif; ?>
  <?php if ($current_direction == 'asc'): ?>
    <i class="glyphicon glyphicon-chevron-up"></i>
  <?php endif; ?>
</a>