<div class="row">
  <div class="col-md-3">

    <departments-selector
      label="igb_field_dpmts"
      departments="<?= implode(',', $departments) ?>"
      value="<?= set_value('dpmt', $publication['dpmt']) ?>"
    ></departments-selector>

    <?= text_field('fdate', [
      'label' => 'igb_field_media_fdate',
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
      'label' => 'igb_field_media_title', 
      'help' => 'igb_help_media_title',
      'value' => $publication['title'],
      'autofocus' => TRUE
    ]); ?>

    <div class="row">
      <div class="col-md-6">
        <?= date_field('edate', [
          'label' => 'igb_field_media_edate',
          'help' => 'igb_help_media_edate',
          'value' => $publication['edate'],
          'required' => TRUE
        ]); ?>
      </div>
    </div>

    <if-type tow="09.05">
      <?= text_field('notes', [
        'label' => 'igb_field_media_notes',
        'help' => 'igb_help_media_notes',
        'value' => $publication['notes'],
        'required' => TRUE
      ]); ?>
    </if-type>

    <if-type tow="09.05, 09.09, 09.10, 09.11, 09.12, 09.13">
      <?= text_field('doi', [
        'label' => 'igb_field_media_doi',
        'value' => $publication['doi']
      ]); ?>
    </if-type>

    <if-type tow="09.16">
      <?= text_field('impactf', [
        'label' => 'igb_field_media_impactf',
        'value' => $publication['impactf']
      ]); ?>
    </if-type>

    <if-type except="09.09, 09.10, 09.11, 09.12, 09.13, 09.14, 09.15, 09.16">
      <?= text_area('mediatype', [
        'label' => 'igb_field_media_mediatype',
        'help' => 'igb_help_media_mediatype',
        'value' => $publication['mediatype']
      ]); ?>
    </if-type>

    <if-type tow="09.13">
      <checkbox-selector
        name="mediatype"
        label="igb_field_media_mediatype_0913"
        choices="annual,brochure or booklet or flyer,book,conference proceeding,website or information portal,other"
        value="<?= set_value('mediatype', $publication['mediatype']) ?>"
      ></checkbox-selector>
    </if-type>

    <?= text_field('weburl1', [
      'label' => 'igb_field_media_weburl1',
      'value' => $publication['weburl1']
    ]); ?>

    <if-type except="09.05, 09.09">
      <checkbox-selector
        name="contribution_category"
        label="igb_field_media_contribution_category"
        choices="lead author,contributing author"
        value="<?= set_value('contribution_category', $publication['contribution_category']) ?>"
      ></checkbox-selector>
    </if-type>

    <?= text_field('language', [
      'label' => 'igb_field_media_language',
      'value' => $publication['language']
    ]); ?>

    <if-type tow="09.13">
      <?= text_field('publication_category', [
        'label' => 'igb_field_media_publication_category',
        'value' => $publication['publication_category']
      ]); ?>
    </if-type>
  </div>
  <div class="col-md-3">

    <if-type tow="09.05, 09.09, 09.10, 09.11, 09.12">
      <people-editor
        label="<?= ucfirst(lang('igb_field_media_people')) ?>"
        name="people"
        value="<?= html_escape($people) ?>"
      ></people-editor>
    </if-type>

    <if-type except="09.05, 09.09, 09.10, 09.11, 09.12">
      <people-editor
        label="<?= ucfirst(lang('igb_field_media_editor')) ?>"
        name="people"
        value="<?= html_escape($people) ?>"
      ></people-editor>
    </if-type>

    <?= text_field('editors', [
      'label' => 'igb_involved_people',
      'value' => $publication['editors'],
      'disabled' => !has_role(['admin', 'library'])
    ]); ?>
    
  </div>

</div>
