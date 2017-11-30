<?php if (isset($_SESSION['notice'])): ?>
  <p class="alert alert-success">
    <?= $_SESSION['notice'] ?>
  </p>
  <?php unset($_SESSION['notice']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  <p class="alert alert-danger">
    <?= $_SESSION['error'] ?>
  </p>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>