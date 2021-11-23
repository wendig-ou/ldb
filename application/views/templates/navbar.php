<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-links" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>

    <div class="navbar-header">
      <a class="navbar-brand" href="/">
        <?= getenv('LDB_APP_NAME') ?>
      </a>
    </div>

    <div class="collapse navbar-collapse" id="navbar-links">
      <ul class="nav navbar-nav">
        <?php if ($current_user): ?>
          <li><a href="/publications"><?= lang('igb_home') ?></a></li>
          <?php if (has_role(['admin', 'library', 'data_collector'])): ?>
            <li><a href="/reports"><?= lang('igb_reports') ?></a></li>
          <?php endif; ?>
          <li>
            <a href="/publications/new">
              <i class="glyphicon glyphicon-star"></i>
              <?= sprintf(lang('igb_create_new'), lang('igb_publication')) ?>
            </a>
          </li>
          <?php if (has_role(['admin', 'library'])): ?>
            <li>
              <a
                href="#"
                class="dropdown-toggle"
                data-toggle="dropdown"
                role="button"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <?= lang('igb_admin') ?>
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="/users"><?= lang('igb_users') ?></a></li>
                <li><a href="/people"><?= lang('igb_people') ?></a></li>
                <li><a href="/institutions"><?= lang('igb_institutions') ?></a></li>
                <li><a href="/periodicals"><?= lang('igb_periodicals') ?></a></li>
                <li><a href="/ris"><?= lang('igb_ris_import') ?></a></li>
                <li><a href="/impact_factor"><?= lang('igb_impact_factor_import') ?></a></li>
              </ul>
            </li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>

      <p class="navbar-text navbar-right text-right">
        <?php if ($current_user): ?>
          <?= $this->lang->line('igb_signed_in_as') ?>
          <strong><?= $current_user['uname'] ?></strong>
          (<?= $current_user['role'] ?>)
          |
          <a class="navbar-link" href="/auth/delete">
            <?= $this->lang->line('igb_sign_out') ?>
          </a>
        <?php else: ?>
          <a class="navbar-link" href="/auth/new">
            <?= $this->lang->line('igb_sign_in') ?>
          </a>
        <?php endif; ?>
      </p>
    </div>
  </div>
</nav>