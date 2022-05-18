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

    <?= text_field('notes', [
      'label' => 'igb_field_conf_notes',
      'value' => $publication['notes']
    ]); ?>

    <?= text_field('abstract', [
      'label' => 'igb_field_conf_abstract',
      'value' => $publication['abstract']
    ]); ?>

    <if-type tow="07.03, 07.04">
      <checkbox-selector
        name="event_purpose"
        label="igb_field_conf_event_purpose"
        choices="information,co-design,co-production,co-publication"
        value="<?= set_value('event_purpose', $publication['event_purpose']) ?>"
      ></checkbox-selector>
    </if-type>

    <if-type except="07.01">
      <?= text_field('impactf', [
        'label' => 'igb_field_conf_impactf',
        'help' => 'igb_help_conf_impactf',
        'value' => $publication['impactf'],
        'type' => 'number'
      ]); ?>
    </if-type>

    <?= text_field('place', [
      'label' => 'igb_field_conf_place',
      'help' => 'igb_help_conf_place',
      'value' => $publication['place'],
      'required' => TRUE
    ]); ?>

    <?= text_field('target_group', [
      'label' => 'igb_field_conf_target_group',
      'value' => $publication['target_group'],
      'help' => 'igb_help_conf_target_group',
    ]); ?>

    <?= text_field('duration', [
      'label' => 'igb_field_conf_duration',
      'value' => $publication['duration']
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
  </div>
  <div class="col-md-3">

    <people-editor
      label="<?= ucfirst(lang('igb_field_conf_people')) ?>"
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
