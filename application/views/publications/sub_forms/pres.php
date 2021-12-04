<div class="row">
  <div class="col-md-3">

    <departments-selector
      label="igb_field_dpmts"
      departments="<?= implode(',', $departments) ?>"
      value="<?= set_value('dpmt', $publication['dpmt']) ?>"
    ></departments-selector>

    <?= text_field('fdate', [
      'label' => 'igb_field_pres_fdate', 
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
    <if-type except="03.06">
      <?= text_area('title', [
        'label' => 'igb_field_pres_title', 
        'help' => 'igb_help_pres_title',
        'value' => $publication['title'],
        'required' => TRUE
      ]); ?>

      <?= text_area('notes', [
        'label' => 'igb_field_pres_notes',
        'help' => 'igb_help_pres_notes',
        'value' => $publication['notes'],
        'required' => TRUE
      ]); ?>

      <?= text_area('abstract', [
        'label' => 'igb_field_pres_abstract',
        'value' => $publication['abstract'],
      ]); ?>
    </if-type>

    <if-type tow="03.06">
      <?= text_area('title', [
        'label' => 'igb_field_pres_topic', 
        'value' => $publication['title'],
        'required' => TRUE
      ]); ?>

      <?= text_area('notes', [
        'label' => 'igb_field_pres_event',
        'value' => $publication['notes'],
        'required' => TRUE
      ]); ?>
    </if-type>

    <if-type tow="03.07, 03.08">
      <?= text_area('impactf', [
        'label' => 'igb_field_pres_impactf',
        'value' => $publication['impactf'],
      ]); ?>
    </if-type>

    <?= text_field('place', [
      'label' => 'igb_field_pres_place',
      'help' => 'igb_help_pres_place',
      'value' => $publication['place'],
      'required' => TRUE
    ]); ?>

    <if-type except="03.06">
      <?= text_field('participation_category', [
        'label' => 'igb_field_pres_participation_category',
        'value' => $publication['participation_category']
      ]); ?>

      <?= text_field('target_group', [
        'label' => 'igb_field_pres_target_group',
        'value' => $publication['target_group']
      ]); ?>
    </if-type>

    <?= text_field('duration', [
      'label' => 'igb_field_pres_duration',
      'value' => $publication['duration']
    ]); ?>

    <if-type tow="03.04, 03.07, 03.08">
      <?= text_field('contribution_category', [
        'label' => 'igb_field_pres_contribution_category',
        'value' => $publication['contribution_category']
      ]); ?>
      
      <?= text_field('event_category', [
        'label' => 'igb_field_pres_event_category',
        'value' => $publication['event_category']
      ]); ?>
    </if-type>

    <div class="row">
      <div class="col-md-6">
        <?= date_field('edate', [
          'label' => 'igb_field_pres_edate',
          'help' => 'igb_help_pres_edate',
          'value' => $publication['edate'],
          'required' => TRUE
        ]); ?>
      </div>
      <div class="col-md-6">
        <?= date_field('end_date', [
          'label' => 'igb_field_pres_end_date',
          'help' => 'igb_help_pres_end_date',
          'value' => $publication['end_date']
        ]); ?>
      </div>
    </div>
  </div>
  <div class="col-md-3">

    <people-editor
      label="<?= ucfirst(lang('igb_field_pres_people')) ?>"
      name="people"
      value="<?= html_escape($people) ?>"
    ></people-editor>

    <?php if (has_role(['admin', 'library'])): ?>
      <?= text_area('authors', [
        'label' => 'igb_legacy_people',
        'value' => $publication['authors'],
        'disabled' => TRUE
      ]); ?>
    <?php else: ?>
      <?php if (isset($publication['authors']) && $publication['authors'] != ''): ?>
        <div class="text-muted">
          <strong><?= lang('igb_legacy_people') ?>:</strong>
          <?= author_list($publication['authors']) ?>
        </div>
      <?php endif; ?>
    <?php endif?>

    <?= text_field('editors', [
      'label' => 'igb_involved_people',
      'value' => $publication['editors'],
      'disabled' => !has_role(['admin', 'library'])
    ]); ?>
    
  </div>

</div>
