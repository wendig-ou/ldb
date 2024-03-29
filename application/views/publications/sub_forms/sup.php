<div class="row">
  <div class="col-md-3">

    <departments-selector
      label="igb_field_dpmts"
      departments="<?= implode(',', $departments) ?>"
      value="<?= set_value('dpmt', $publication['dpmt']) ?>"
    ></departments-selector>

    <?= text_field('fdate', [
      'label' => 'igb_field_sup_fdate', 
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
      'label' => 'igb_field_sup_title', 
      'help' => 'igb_help_sup_title',
      'value' => $publication['title'],
      'required' => TRUE
    ]); ?>

    <div class="row">
      <div class="col-md-6">
        <?= date_field('edate', [
          'label' => 'igb_field_sup_edate',
          'help' => 'igb_help_sup_edate',
          'value' => $publication['edate'],
          'required' => TRUE
        ]); ?>
      </div>
    </div>

    <?= text_field('notes', [
      'label' => 'igb_field_sup_notes',
      'help' => 'igb_help_sup_notes',
      'value' => $publication['notes']
    ]); ?>

    <institution-selector
      label="igb_field_sup_institution_id"
      value="<?= set_value('institution_id', html_escape($publication['institution_id'])) ?>"
      <?php if (isset($publication['institution_name'])): ?>
        label-value="<?= html_escape($publication['institution_name']) ?>"
      <?php endif ?>
      name="institution_id"
      label-name="institution_name"
      required="true"
    ></institution-selector>

    <?= text_field('faculty', [
      'label' => 'igb_field_sup_faculty',
      'help' => 'igb_help_sup_faculty',
      'value' => $publication['faculty']
    ]); ?>
  </div>
  <div class="col-md-3">
    <people-editor
      label="<?= ucfirst(lang('igb_field_sup_people')) ?>"
      name="people"
      value="<?= html_escape($people) ?>"
    ></people-editor>

    <if-type except="04.01">
      <people-editor
        label="<?= ucfirst(lang('igb_field_sup_supervisors')) ?>"
        name="supervisors"
        value="<?= html_escape($supervisors) ?>"
        ac-title="igb_notice_is_supervisor_autocomplete_title"
        ac-content="igb_notice_is_supervisor_autocomplete_content"
      ></people-editor>
    </if-type>

    <?= text_field('editors', [
      'label' => 'igb_involved_people',
      'value' => $publication['editors'],
      'disabled' => !has_role(['admin', 'library'])
    ]); ?>
    
  </div>

</div>
