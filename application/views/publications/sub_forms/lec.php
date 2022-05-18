<div class="row">
  <div class="col-md-3">

    <departments-selector
      label="igb_field_dpmts"
      departments="<?= implode(',', $departments) ?>"
      value="<?= set_value('dpmt', $publication['dpmt']) ?>"
    ></departments-selector>

    <?= text_field('fdate', [
      'label' => 'igb_field_lec_fdate', 
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
      'label' => 'igb_field_lec_title', 
      'help' => 'igb_help_lec_title',
      'value' => $publication['title'],
      'autofocus' => TRUE,
      'required' => TRUE
    ]); ?>

    <?= text_field('notes', [
      'label' => 'igb_field_lec_notes',
      'help' => 'igb_help_lec_notes',
      'value' => $publication['notes']
    ]); ?>

    <institution-selector
      label="igb_field_lec_institution_id"
      value="<?= set_value('institution_id', html_escape($publication['institution_id'])) ?>"
      <?php if (isset($publication['institution_name'])): ?>
        label-value="<?= html_escape($publication['institution_name']) ?>"
      <?php endif ?>
      name="institution_id"
      label-name="institution_name"
      required="true"
    ></institution-selector>

    <div class="row">
      <div class="col-md-6">
        <?= date_field('edate', [
          'label' => 'igb_field_lec_edate',
          'value' => $publication['edate'],
        ]); ?>
      </div>
      <div class="col-md-6">
        <?= date_field('end_date', [
          'label' => 'igb_field_lec_end_date',
          'value' => $publication['end_date']
        ]); ?>
      </div>
    </div>

    <?= semester_selector('semester', [
      'value' => $publication['semester'],
      'required' => TRUE
    ]); ?>

    <?= text_field('impactf', [
      'label' => 'igb_field_lec_impactf',
      'help' => 'igb_help_lec_impactf',
      'value' => $publication['impactf'],
      'type' => 'number',
      'required' => TRUE
    ]); ?>

  </div>
  <div class="col-md-3">

    <people-editor
      label="<?= ucfirst(lang('igb_field_lec_people')) ?>"
      name="people"
      value="<?= html_escape($people) ?>"
    ></people-editor>

    <?= text_field('editors', [
      'label' => 'igb_involved_people',
      'value' => $publication['editors'],
      'disabled' => !has_role(['admin', 'library'])
    ]); ?>

  </div>

</div>
