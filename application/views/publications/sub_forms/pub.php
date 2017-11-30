<type-notifier selector="input[name=klr_tow]"></type-notifier>

<hr />

<div class="row">
  <div class="col-md-3">

    <departments-selector
      label="igb_field_dpmts"
      departments="<?= implode(',', $departments) ?>"
      value="<?= set_value('dpmt', $publication['dpmt']) ?>"
    ></departments-selector>

    <?= text_field('fdate', [
      'label' => 'igb_field_pub_fdate', 
      'value' => $publication['fdate'],
      'required' => TRUE
    ]); ?>

    <?= check_box('ct', [
      'label' => 'igb_field_ct', 
      'value' => $publication['ct'],
      'disabled' => !can_verify($current_user, $publication)
    ]); ?>

    <?= check_box('open_access', [
      'label' => 'igb_field_open_access', 
      'value' => $publication['open_access']
    ]); ?>

  </div>
  <div class="col-md-6">

    <?= text_area('title', [
      'label' => 'igb_field_pub_title',
      'value' => $publication['title'],
    ]); ?>

    <if-type category="article">
      <!-- semantics: citation -->
      <?= text_field('notes', [
        'label' => 'igb_field_pub_notes',
        'value' => $publication['notes']
      ]); ?>

      <periodical-selector
        label="igb_field_pub_pname_id"
        value="<?= set_value('pname_id', html_escape($publication['pname_id'])) ?>"
        <?php if (isset($publication['periodical_name'])): ?>
          label-value="<?= html_escape($publication['periodical_name']) ?>"
        <?php endif ?>
        name="pname_id"
        label-name="periodical_name"
      ></periodical-selector>

      <?= text_field('doi', [
        'label' => 'igb_field_pub_doi',
        'value' => $publication['doi']
      ]); ?>

      <!-- semantics: publisher -->
      <?= text_field('organization', [
        'label' => 'igb_field_pub_organization',
        'value' => $publication['organization']
      ]); ?>
    </if-type>

    <if-type category="article-special">
      <!-- semantics: citation -->
      <?= text_field('notes', [
        'label' => 'igb_field_pub_notes',
        'value' => $publication['notes']
      ]); ?>

      <periodical-selector
        label="igb_field_pub_pname_id"
        value="<?= html_escape($publication['pname_id']) ?>"
        <?php if (isset($publication['periodical_name'])): ?>
          label-value="<?= html_escape($publication['periodical_name']) ?>"
        <?php endif ?>
        name="pname_id"
        label-name="periodical_name"
      ></periodical-selector>

      <?= text_field('doi', [
        'label' => 'igb_field_pub_doi',
        'value' => $publication['doi']
      ]); ?>

      <!-- semantics: publisher -->
      <?= text_field('organization', [
        'label' => 'igb_field_pub_organization',
        'value' => $publication['organization']
      ]); ?>

      <?= text_field('impactf', [
        'label' => 'igb_field_pub_impactf',
        'value' => $publication['impactf']
      ]); ?>
    </if-type>

    <if-type category="book_part">
      <?= text_field('booktitle', [
        'label' => 'igb_field_pub_booktitle',
        'value' => $publication['booktitle']
      ]); ?>

      <!-- semantics: citation -->
      <?= text_field('notes', [
        'label' => 'igb_field_pub_notes',
        'value' => $publication['notes']
      ]); ?>

      <?= text_field('doi', [
        'label' => 'igb_field_pub_doi',
        'value' => $publication['doi']
      ]); ?>

      <!-- semantics: publisher -->
      <?= text_field('organization', [
        'label' => 'igb_field_pub_organization',
        'value' => $publication['organization']
      ]); ?>
    </if-type>

    <if-type category="independent">
      <?= text_field('booktitle', [
        'label' => 'igb_field_pub_booktitle',
        'value' => $publication['booktitle']
      ]); ?>

      <?= text_field('epage', [
        'label' => 'igb_field_pub_epage',
        'value' => $publication['epage']
      ]); ?>

      <div class="row">
        <div class="col-md-4">
          <!-- semantics: volume -->
          <?= text_field('chapvol', [
            'label' => 'igb_field_pub_chapvol',
            'value' => $publication['chapvol']
          ]); ?>
        </div>
        <div class="col-md-4">
          <?= text_field('issue', [
            'label' => 'igb_field_pub_issue',
            'value' => $publication['issue']
          ]); ?>
        </div>
        <div class="col-md-4">
          <!-- semantics: edition -->
          <?= text_field('volume', [
            'label' => 'igb_field_pub_volume',
            'value' => $publication['volume']
          ]); ?>
        </div>
      </div>

      <?= text_field('place', [
        'label' => 'igb_field_pub_place',
        'value' => $publication['place']
      ]); ?>

      <!-- semantics: publisher -->
      <?= text_field('organization', [
        'label' => 'igb_field_pub_organization',
        'value' => $publication['organization']
      ]); ?>

      <?= text_field('impactf', [
        'label' => 'igb_field_pub_impactf',
        'value' => $publication['impactf']
      ]); ?>
    </if-type>

    <?= text_field('editors', [
      'label' => 'igb_field_pub_editors',
      'value' => $publication['editors']
    ]); ?>
  </div>
  <div class="col-md-3">

    <people-editor
      label="<?= ucfirst(lang('igb_field_pub_people')) ?>"
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

  </div>

</div>
