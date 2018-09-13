<div class="row">
  <div class="col-md-3">
    <departments-selector
      label="igb_field_dpmts"
      departments="<?= implode(',', $departments) ?>"
      value="<?= set_value('dpmt', $publication['dpmt']) ?>"
    ></departments-selector>

    <?= text_field('fdate', [
      'label' => 'igb_field_fdate', 
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
    <?= text_field('num_comm_reports', [
      'label' => 'igb_field_rev_num_comm_reports',
      'type' => 'number',
      'value' => $publication['num_comm_reports'],
      'autofocus' => TRUE
    ]); ?>

    <?= text_field('num_position_papers', [
      'label' => 'igb_field_rev_num_position_papers',
      'type' => 'number',
      'value' => $publication['num_position_papers'],
      'autofocus' => TRUE
    ]); ?>

    <?= text_field('num_reviews', [
      'label' => 'igb_field_rev_num_reviews',
      'type' => 'number',
      'value' => $publication['num_reviews'],
      'autofocus' => TRUE
    ]); ?>

    <?= text_field('num_reviews_eu', [
      'label' => 'igb_field_rev_num_reviews_eu',
      'type' => 'number',
      'value' => $publication['num_reviews_eu'],
      'autofocus' => TRUE
    ]); ?>
  </div>

  <div class="col-md-3">
    <people-editor
      label="<?= ucfirst(lang('igb_field_comm_people')) ?>"
      name="people"
      value="<?= html_escape($people) ?>"
    ></people-editor>
  </div>

</div>
