<div class="ldb-submit pull-right">
  <?php if (isset($id)): ?>
    <input
      class="btn btn-primary"
      type="submit"
      name="continue"
      value="<?= lang('igb_save_and_back_to_list') ?>"
    />
    <input
      class="btn btn-primary"
      type="submit"
      name="continue"
      value="<?= lang('igb_save') ?>"
    />
  <?php else: ?>
    <input
      class="btn btn-primary"
      type="submit"
      name="continue"
      value="<?= lang('igb_save') ?>"
    />
    <input
      class="btn btn-primary"
      type="submit"
      name="continue"
      value="<?= lang('igb_save_and_continue') ?>"
    />
    <input
      class="btn btn-default"
      type="reset"
      name="continue"
      value="<?= lang('igb_reset') ?>"
    />
  <?php endif; ?>

  <?php if (isset($back_to)): ?>
    <a class="btn btn-default" href="<?= $back_to ?>">
      <?= lang('igb_cancel') ?>
    </a>
  <?php else: ?>
    <back-button><?= lang('igb_cancel') ?></back-button>
  <?php endif; ?>
</div>