<div class="row">
  <div class="col-md-3">

    <departments-selector
      label="igb_field_dpmts"
      departments="<?= implode(',', $departments) ?>"
      value="<?= set_value('dpmt', $publication['dpmt']) ?>"
    ></departments-selector>

    <?= text_field('fdate', [
      'label' => 'igb_field_edit_fdate', 
      'value' => $publication['fdate'],
      'required' => TRUE
    ]); ?>

    <end-year
      name="end_fdate"
      label="<?= ucfirst(lang('igb_field_comm_end_fdate')) ?>"
      value="<?= set_value('end_fdate', $publication['end_fdate']) ?>"
    ></end-year>

    <?= check_box('ct', [
      'label' => 'igb_field_ct', 
      'value' => $publication['ct'],
      'disabled' => !can_verify($current_user, $publication)
    ]); ?>

  </div>
  <div class="col-md-6">

    <?= text_area('title', [
      'label' => 'igb_field_edit_title', 
      'help' => 'igb_help_edit_title',
      'value' => $publication['title'],
      'autofocus' => TRUE,
      'required' => TRUE
    ]); ?>

    <if-type tow="06.01">
      <?= text_field('notes', [
        'label' => 'igb_field_edit_journal',
        'value' => $publication['notes'],
      ]); ?>
    </if-type>

    <if-type except="06.01">
      <?= text_field('notes', [
        'label' => 'igb_field_edit_notes',
        'value' => $publication['notes'],
      ]); ?>
    </if-type>
    
  </div>
  <div class="col-md-3">

    <people-editor
      label="<?= ucfirst(lang('igb_field_edit_people')) ?>"
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
