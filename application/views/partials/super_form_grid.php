<p><?= lang('igb_prompt_select_type') ?></p>

<panel-clicker></panel-clicker>

<div class="row igb-grid">
  <?php foreach ($super_types as $super_type): ?>
    <div
      class="col-md-4"
      data-code="<?= $super_type['code'] ?>"
    >
      <a
        href="?super-type-id=<?= $super_type['id'] ?>"
      >
        <div class="panel panel-default igb-grid-panel">
          <div class="panel-body">
            <div class="pull-right icon">
              <img src="/images/<?= $super_type['code'] ?>.png" />
            </div>
            <h3><?= ucfirst($super_type['name']) ?></h3>
            <p><?= $super_type['description'] ?></p>
          </div>
        </div> 
      </a>

    </div>
  <?php endforeach; ?>
</div>
