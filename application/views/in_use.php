<table class="table">
  <thead>
    <tr>
      <th><?= ucfirst(lang('igb_link')) ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($usages as $publication): ?>
      <tr>
        <td>
          <a href="/publications/edit/<?= $publication['pid'] ?>">
            <?= $publication['pid'] ?>
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>