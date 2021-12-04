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
    <if-type tow="10.01">
      <?= text_field('title', [
        'label' => 'igb_field_rev_project_title',
        'value' => $publication['title']
      ]); ?>
    </if-type>

    <if-type tow="10.03, 10.04">
      <?= text_field('title', [
        'label' => 'igb_field_rev_title_subtitle',
        'value' => $publication['title']
      ]); ?>
    </if-type>

    <if-type tow="10.02, 10.05">
      <?= text_field('title', [
        'label' => 'igb_field_rev_title',
        'value' => $publication['title']
      ]); ?>
    </if-type>

    <if-type tow="10.02, 10.03, 10.04">
      <?= text_field('notes', [
        'label' => 'igb_field_rev_notes',
        'value' => $publication['notes']
      ]); ?>
    </if-type>

    <if-type tow="10.03, 10.04">
      <?= text_field('doi', [
        'label' => 'igb_field_rev_doi',
        'value' => $publication['doi']
      ]); ?>
    </if-type>

    <if-type tow="10.05">
      <?= text_field('organization', [
        'label' => 'igb_field_rev_organization',
        'value' => $publication['organization']
      ]); ?>

      <?= text_field('abstract', [
        'label' => 'igb_field_rev_abstract',
        'value' => $publication['abstract']
      ]); ?>
    </if-type>

    <if-type tow="10.03, 10.04, 10.05">
      <?= text_field('weburl1', [
        'label' => 'igb_field_rev_weburl1',
        'value' => $publication['weburl1']
      ]); ?>
    </if-type>

    <if-type tow="10.03, 10.04">
      <?= text_field('target_group', [
        'label' => 'igb_field_rev_target_group',
        'value' => $publication['target_group']
      ]); ?>
    </if-type>

    <if-type tow="10.02">
      <?= text_field('target_group', [
        'label' => 'igb_field_rev_panel_or_stakeholder',
        'value' => $publication['target_group']
      ]); ?>

      <?= text_field('duration', [
        'label' => 'igb_field_rev_duration',
        'value' => $publication['duration']
      ]); ?>

      <?= text_field('contribution_category', [
        'label' => 'igb_field_rev_contribution_category',
        'value' => $publication['contribution_category']
      ]); ?>
    </if-type>

    <if-type tow="10.03, 10.04">
      <?= text_field('publication_category', [
        'label' => 'igb_field_rev_publication_category',
        'value' => $publication['publication_category']
      ]); ?>
    </if-type>

    <div class="row">
      <div class="col-md-6">
        <?= date_field('edate', [
          'label' => 'igb_field_rev_edate',
          'value' => $publication['edate'],
          'required' => TRUE
        ]); ?>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <people-editor
      label="<?= ucfirst(lang('igb_field_rev_people')) ?>"
      name="people"
      value="<?= html_escape($people) ?>"
    ></people-editor>
  </div>

</div>
