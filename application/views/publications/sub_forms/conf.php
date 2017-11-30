<div class="row">

  <div class="col-md-3">
    
    <departments-selector
      label="igb_field_dpmts"
      departments="<?= implode(',', $departments) ?>"
      value="<?= set_value('dpmt', $publication['dpmt']) ?>"
    ></departments-selector>

    <?= text_field('fdate', [
      'label' => 'igb_field_conf_fdate', 
      'value' => $publication['fdate'],
      'required' => TRUE
    ]); ?>

    <?= check_box('ct', [
      'label' => 'igb_field_ct', 
      'value' => $publication['ct'],
      'disabled' => !can_verify($current_user, $publication)
    ]); ?>

  </div>

  <div class="col-md-6">

    <?= text_area('title', [
      'label' => 'igb_field_conf_title', 
      'help' => 'igb_help_conf_title',
      'value' => $publication['title'],
      'required' => TRUE
    ]); ?>

    <?= text_field('place', [
      'label' => 'igb_field_conf_place',
      'help' => 'igb_help_conf_place',
      'value' => $publication['place'],
      'required' => TRUE
    ]); ?>

    <div class="row">
      <div class="col-md-6">
        <?= date_field('edate', [
          'label' => 'igb_field_conf_edate',
          'help' => 'igb_help_conf_edate',
          'value' => $publication['edate'],
          'required' => TRUE
        ]); ?>
      </div>
      <div class="col-md-6">
        <?= date_field('end_date', [
          'label' => 'igb_field_conf_end_date',
          'help' => 'igb_help_conf_end_date',
          'value' => $publication['end_date']
        ]); ?>
      </div>
    </div>

    <?= text_field('impactf', [
      'label' => 'igb_field_conf_impactf',
      'help' => 'igb_help_conf_impactf',
      'value' => $publication['impactf'],
      'type' => 'number'
    ]); ?>

    <?= text_field('notes', [
      'label' => 'igb_field_conf_notes',
      'help' => 'igb_help_conf_notes',
      'value' => $publication['notes']
    ]); ?>

  </div>
  <div class="col-md-3">

    <people-editor
      label="<?= ucfirst(lang('igb_field_conf_people')) ?>"
      name="people"
      value="<?= html_escape($people) ?>"
    ></people-editor>

    <?php if (has_role(['admin', 'library'])): ?>
      <?= text_area('authors', [
        'label' => 'igb_legacy_people',
        'value' => $publication['authors']
      ]); ?>
    <?php else: ?>
      <?php if (isset($publication['authors']) && $publication['authors'] != ''): ?>
        <div class="text-muted">
          <strong><?= lang('igb_legacy_people') ?>:</strong>
          <?= author_list($publication['authors']) ?>
        </div>
      <?php endif; ?>
    <?php endif ?>

    <?= text_field('editors', [
      'label' => 'igb_involved_people',
      'value' => $publication['editors'],
      'disabled' => !has_role(['admin', 'library'])
    ]); ?>
    
  </div>

</div>
