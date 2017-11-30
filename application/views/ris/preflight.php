<h1>
  <?= ucfirst(lang('igb_ris_import')) ?>
  (<?= lang('igb_preflight') ?>)

  <p class="lead"><?= lang('igb_prompt_verify_parsed') ?></p>
</h1>

<div class="row">
  <div class="col-md-6">
    <p>
      A <span class="text-success">green</span> background in the first column
      signals a match with an existing publication entry. Similarly, a person name
      in <span class="text-success">green</span> signals a match with an existing
      person entry.
    </p>
  </div>
</div>

<hr />

<table class="table table-striped table-hover ris-preflight">
  <thead>
    <tr>
      <th><?= ucfirst(lang('igb_field_ris_id')) ?></th>
      <th><?= ucfirst(lang('igb_data')) ?></th>
      <th><?= ucfirst(lang('igb_people')) ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($records as $record): ?>
      <tr>
        <td class="<?= $record['existing'] ? 'success' : '' ?>">
          <span class="text-muted"><?= ucfirst(lang('igb_field_ris_id')) ?>:</span>
          <?= $record['record']['ris_id'] ?><br />
          <span class="text-muted"><?= ucfirst(lang('igb_field_klr_tow')) ?>:</span>
          <?= $record['record']['klr_tow'] ?>
        </td>
        <td>
          <span class="text-muted"><?= ucfirst(lang('igb_field_title')) ?>:</span>
          <?= $record['record']['title'] ?><br />
          <?php if (in_array($record['record']['klr_tow'], ['01.01', '01.02', '01.10', '01.15'])): ?>
            <span class="text-muted"><?= ucfirst(lang('igb_field_pub_pname_id')) ?>:</span>
            <?php if (isset($record['record']['pname_id'])): ?>
              <span class="text-success">
                <?= $record['record']['periodical_name'] ?><br />
              </span>
            <?php else: ?>
              <?= $record['record']['periodical_name'] ?><br />
            <?php endif ?>
          <?php else: ?>
            <span class="text-muted"><?= ucfirst(lang('igb_field_pub_booktitle')) ?>:</span>
            <?= $record['record']['booktitle'] ?><br />
          <?php endif ?>
          <span class="text-muted"><?= ucfirst(lang('igb_field_pub_organization')) ?>:</span>
          <?= $record['record']['organization'] ?><br />
          <span class="text-muted"><?= ucfirst(lang('igb_field_notes')) ?>:</span>
          <?= $record['record']['notes'] ?><br />
          <span class="text-muted"><?= ucfirst(lang('igb_field_fdate')) ?>:</span>
          <?= $record['record']['fdate'] ?><br />
          <span class="text-muted"><?= ucfirst(lang('igb_field_pub_doi')) ?>:</span>
          <?= $record['record']['doi'] ?><br />
          <span class="text-muted"><?= ucfirst(lang('igb_field_pub_epage')) ?>:</span>
          <?= $record['record']['epage'] ?><br />
          <span class="text-muted"><?= ucfirst(lang('igb_field_place')) ?>:</span>
          <?= $record['record']['place'] ?><br />
          <span class="text-muted"><?= ucfirst(lang('igb_field_open_access')) ?>:</span>
          <?= human_bool($record['record']['open_access']) ?><br />
        </td>
        <td class="igb-nowrap">
          <?php foreach ($record['people'] as $person): ?>
            <div class="ldb-person <?= is_numeric($person[1]) ? 'text-success' : '' ?>">
              <div class="igb-label pull-right">
                <?php if ($person[2]): ?>
                  <span class="label label-primary">IGB</span>
                <?php else: ?>
                  <span class="label label-default">IGB</span>
                <?php endif ?>
              </div>
              <strong><?= $person[3] ?></strong>
            </div>
          <?php endforeach ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<hr />

<div class="pull-right">
  <a
    class="btn btn-default"
    href="/ris"
  ><?= lang('igb_cancel') ?></a>
  <a
    class="btn btn-primary"
    href="/ris/commit?file=<?= $file ?>"
  ><?= lang('igb_proceed_with_import') ?></a>
</div>
