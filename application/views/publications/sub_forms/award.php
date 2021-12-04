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
    <?= text_area('title', [
      'label' => 'igb_field_title',
      'value' => $publication['title'],
    ]); ?>

    <?= text_field('organization', [
      'label' => 'igb_field_award_organization',
      'value' => $publication['organization']
    ]); ?>

    <?= text_field('notes', [
      'label' => 'igb_field_award_notes',
      'value' => $publication['notes']
    ]); ?>

    <?= text_field('contribution_category', [
      'label' => 'igb_field_award_contribution_category',
      'value' => $publication['contribution_category']
    ]); ?>

    <?= text_field('dotation', [
      'label' => 'igb_field_award_dotation',
      'value' => $publication['dotation']
    ]); ?>

    <?= text_field('editors', [
      'label' => 'igb_field_award_editors',
      'value' => $publication['editors']
    ]); ?>

    <div class="row">
      <div class="col-md-6">
        <?= date_field('edate', [
          'label' => 'igb_field_award_edate',
          'value' => $publication['edate'],
          'required' => TRUE
        ]); ?>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <people-editor
      label="<?= ucfirst(lang('igb_field_award_people')) ?>"
      name="people"
      value="<?= html_escape($people) ?>"
    ></people-editor>
  </div>

</div>
