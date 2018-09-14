<h1>
  <?= ucfirst($title) ?>
  <p class="visible-print-block small">
    <strong><?= ucfirst(lang('igb_filter_criteria')) ?>:</strong>
    <?= filters_for_print($criteria) ?>
  </p>
</h1>

<form class="search hidden-print" method="GET">
  <div class="row">
    <div class="col-md-1">
      <?= text_field('pid', [
        'help' => 'igb_field_pid',
        'value' => $criteria['pid']
      ]); ?>
    </div>
    <div class="col-md-1">
      <?= text_field('fdate', [
        'help' => 'igb_field_fdate',
        'value' => $criteria['fdate']
      ]); ?>
    </div>
    <div class="col-md-2">
      <?= type_selector('tow', [
        'label' => '',
        'value' => $criteria['tow'],
        'help' => 'igb_type',
        'types' => $all_types
      ]); ?>
    </div>
    <div class="col-md-2">
      <?= text_field('terms', [
        'help' => 'igb_field_title',
        'value' => $criteria['terms']
      ]); ?>
    </div>
    <div class="col-md-2">
      <?= text_field('people', [
        'help' => 'igb_field_person',
        'value' => $criteria['people']
      ]); ?>
    </div>
    <div class="col-md-2">
      <?= text_field('creator', [
        'help' => 'igb_field_uid',
        'value' => $criteria['creator']
      ]); ?>
    </div>
    <div class="col-md-1">
      <?= department_selector('dpmt', [
        'help' => 'igb_field_dpmt',
        'value' => $criteria['dpmt']
      ]); ?>
    </div>
    <div class="col-md-1">
      <div class="form-group text-right">
        <input
          class="btn btn-primary"
          type="submit"
          name="search"
          value="<?= lang('igb_search') ?>"
        />
      </div>
    </div>
  </div>
  <div class="pull-right">
    <div class="radio">
      <span class="ldb-show"><?= lang('igb_show') ?>:</span>
      <label class="ldb-verified">
        <input
          type="radio"
          name="ct"
          value="1"
          <?= set_radio('ct', '1', $criteria['ct'] == '1') ?>
        />
        <?= lang('igb_verified') ?>
      </label>
      <label class="ldb-verified">
        <input
          type="radio"
          name="ct"
          value="0"
          <?= set_radio('ct', '0', $criteria['ct'] == '0') ?>
        />
        <?= lang('igb_unverified') ?>
      </label>
      <label class="ldb-verified">
        <input
          type="radio"
          name="ct"
          value=""
          <?= set_radio('ct', '', $criteria['ct'] == '') ?>
        />
        <?= lang('igb_both') ?>
      </label>
    </div>
  </div>
  <pagination
    class="hidden-print"
    total="<?= $total ?>"
    show-all="true"
  ></pagination>

  <div class="clearfix"></div>
</form>

<table class="table table-striped table-hover publications">
  <thead>
    <tr>
      <th>
        <?= sortable_column('pid', ['label' => 'igb_field_pid'] ) ?><br />
        <?= sortable_column('klr_tow', ['label' => 'igb_field_klr_tow'] ) ?>
      </th>
      <th class="igb-nowrap">
        <?= ucfirst(lang('igb_field_uid')) ?> |
        <?= ucfirst(lang('igb_field_dpmt')) ?><br />
        <?= sortable_column('fdate', ['label' => 'igb_field_fdate'] ) ?> |
        <?= ucfirst(lang('igb_field_ct')) ?>
      </th>
      <th>
        <?= sortable_column('title', ['label' => 'igb_field_title'] ) ?>
      </th>
      <th>
        <?= sortable_column('people', ['label' => 'igb_field_people'] ) ?>
      </th>
      <th class="hidden-print"></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($publications as $publication): ?>
      <tr data-id="<?= $publication['pid'] ?>">
        <td title="<?= $types[$publication['klr_tow']]['t_desc'] ?>">
          <span class="text-muted"><?= ucfirst(lang('igb_field_pid')) ?>:</span>
          <?= $publication['pid'] ?><br />
          <span class="text-muted"><?= ucfirst(lang('igb_field_klr_tow')) ?>:</span>
          <?= $publication['klr_tow'] ?>
          (<?= $types[$publication['klr_tow']]['super_type_name'] ?>)
        </td>
        <td class="igb-nowrap">
          <span class="text-muted"><?= ucfirst(lang('igb_field_uid')) ?>:</span>
          <?php if (isset($publication['uid']) && is_numeric($publication['uid'])): ?>
            <?= $creators[$publication['uid']]['comment'] ?>
          <?php else: ?>
            <?= lang('igb_unknown') ?>
          <?php endif; ?>
          <br />
          <span class="text-muted"><?= ucfirst(lang('igb_field_dpmt')) ?>:</span>
          <?= $publication['dpmt'] ?><br />
          <span class="text-muted"><?= ucfirst(lang('igb_field_fdate')) ?>:</span>
          <?= to_year_range($publication['fdate'], $publication['end_fdate']) ?><br />
          <span class="text-muted"><?= ucfirst(lang('igb_field_ct')) ?>:</span>
          <?= human_bool($publication['ct']) ?><br />
        </td>
        <td>
          <?php if ($publication['title']): ?>
            <div>
              <?php if (can_edit($current_user, $publication)): ?>
                <a
                  href="/publications/edit/<?= $publication['pid'] ?>"
                ><?= $publication['title'] ?></a>
              <?php else: ?>
                <?= $publication['title'] ?>
              <?php endif; ?>

              <?php if ($types[$publication['klr_tow']]['super_type_code'] == 'pub'): ?>
                <?php if ($publication['open_access']): ?>
                  <img
                    title="<?= lang('igb_field_open_access') ?>"
                    src="/images/oa.png"
                    width="8px"
                  />
                <?php endif ?>
              <?php endif ?>
            </div>
          <?php endif; ?>
          <?php if ($publication['notes']): ?>
            <div>
              <span class="text-muted"><?= ucfirst(lang('igb_field_notes')) ?>:</span>
              <?= $publication['notes'] ?>
            </div>
          <?php endif; ?>
          <?php if ($publication['place']): ?>
            <div>
              <span class="text-muted"><?= ucfirst(lang('igb_field_place')) ?>:</span>
              <?= $publication['place'] ?>
            </div>
          <?php endif; ?>

          <?php if ($types[$publication['klr_tow']]['super_type_code'] == 'sup'): ?>
            <?php if ($people[$publication['pid']]): ?>
              <span class="text-muted"><?= ucfirst(lang('igb_field_people')) ?>:</span>
              <?= people_list($people[$publication['pid']]) ?>
            <?php endif; ?>
            <div>
              <span class="text-muted"><?= ucfirst(lang('igb_field_sup_faculty')) ?>:</span>
              <?= $publication['faculty'] ?>
            </div>
            <?php if (isset($publication['institution_id'])): ?>
              <div>
                <span class="text-muted"><?= ucfirst(lang('igb_field_sup_institution_id')) ?>:</span>
                <?= $institutions[$publication['institution_id']]['institut'] ?>
              </div>
            <?php endif; ?>
          <?php endif; ?>
          
          <?php if ($types[$publication['klr_tow']]['super_type_code'] == 'lec'): ?>
            <?php if (isset($publication['institution_id'])): ?>
              <div>
                <span class="text-muted"><?= ucfirst(lang('igb_field_lec_institution_id')) ?>:</span>
                <?= $institutions[$publication['institution_id']]['institut'] ?>
              </div>
            <?php endif; ?>
            <div>
              <span class="text-muted"><?= ucfirst(lang('igb_field_lec_impactf')) ?>:</span>
              <?= $publication['impactf'] ?>
            </div>
            <div>
              <span class="text-muted"><?= ucfirst(lang('igb_field_semester')) ?>:</span>
              <?= $publication['semester'] ?>
            </div>
          <?php endif; ?>

          <?php if ($types[$publication['klr_tow']]['super_type_code'] == 'media'): ?>
            <div>
              <span class="text-muted"><?= ucfirst(lang('igb_field_media_edate')) ?>:</span>
              <?= human_date($publication['edate']) ?>
            </div>
          <?php endif; ?>

          <?php if ($types[$publication['klr_tow']]['super_type_code'] == 'conf'): ?>
            <div>
              <span class="text-muted"><?= ucfirst(lang('igb_field_date')) ?>:</span>
              <?= human_date($publication['edate']) ?>
              <?php if ($publication['end_date']): ?>
                to
                <?= human_date($publication['end_date']) ?>
              <?php endif ?>
            </div>
          <?php endif; ?>

          <?php if ($types[$publication['klr_tow']]['super_type_code'] == 'pres'): ?>
            <div>
              <span class="text-muted"><?= ucfirst(lang('igb_field_date')) ?>:</span>
              <?= human_date($publication['edate']) ?>
              <?php if ($publication['end_date']): ?>
                to
                <?= human_date($publication['end_date']) ?>
              <?php endif ?>
            </div>
          <?php endif; ?>

          <?php if ($types[$publication['klr_tow']]['super_type_code'] == 'rev'): ?>
            <a
              href="/publications/edit/<?= $publication['pid'] ?>"
            >Reviews (aggregated)</a>
          <?php endif; ?>

          <?php if ($publication['klr_tow'] == '01.01'): ?>
            <div>
              <span class="text-muted"><?= ucfirst(lang('igb_field_pub_impactf')) ?>:</span>
              <?= $publication['impactf'] ?>
            </div>
          <?php endif; ?>

          <?= dimension_badge($publication['doi'], [
            'style' => 'small_rectangle',
            'data_legend' => 'hover_right'
          ]) ?>
        </td>
        <td>
          <?php if ($types[$publication['klr_tow']]['super_type_code'] == 'sup'): ?>
            <?= people_list($supervisors[$publication['pid']]) ?>
          <?php else: ?>
            <?= people_list($people[$publication['pid']]) ?>
          <?php endif; ?>

          <?php if ($publication['authors'] != ''): ?>
            <div class="text-muted">
              <strong><?= lang('igb_legacy_people') ?>:</strong>
              <?= author_list($publication['authors']) ?>
            </div>
          <?php endif; ?>

          <?php if ($publication['editors'] != ''): ?>
            <div class="text-muted">
              <?php if ($types[$publication['klr_tow']]['super_type_code'] == 'pub'): ?>
                <strong><?= lang('igb_legacy_editors') ?>:</strong>
              <?php else: ?>
                <strong><?= lang('igb_involved_people') ?>:</strong>
              <?php endif; ?>
              <?= author_list($publication['editors']) ?>
            </div>
          <?php endif; ?>
        </td>
        <td class="text-right igb-nowrap hidden-print">
          <?php if (can_edit($current_user, $publication)): ?>
            <a href="/publications/edit/<?= $publication['pid'] ?>">
              <i class="glyphicon glyphicon-pencil"></i>
            </a>
          <?php endif; ?>
          <?php if (can_delete($current_user, $publication)): ?>
            <confirm-anchor
              href="/publications/delete/<?= $publication['pid'] ?>"
            >
              <i class="glyphicon glyphicon-trash"></i>
            </confirm-anchor>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
