<if-type tow="01.16">
  <div class="row">
    <div class="col-md-3">
      <departments-selector
        label="igb_field_dpmts"
        departments="<?= implode(',', $departments) ?>"
        value="<?= set_value('dpmt', $publication['dpmt']) ?>"
      ></departments-selector>

      <?= text_field('fdate', [
        'label' => 'igb_field_pub_fdate_0116', 
        'value' => $publication['fdate'],
        'required' => TRUE
      ]); ?>

      <?= check_box('ct', [
        'label' => 'igb_field_ct', 
        'value' => $publication['ct'],
        'disabled' => !can_verify($current_user, $publication)
      ]); ?>

      <?= check_box('open_access', [
        'label' => 'igb_field_pub_open_access_0116', 
        'value' => $publication['open_access']
      ]); ?>
    </div>
    <div class="col-md-6">
      <?= text_area('title', [
        'label' => 'igb_field_pub_title_0116',
        'value' => $publication['title'],
      ]); ?>

      <?= text_area('abstract', [
        'label' => 'igb_field_pub_abstract_0116',
        'value' => $publication['abstract'],
      ]); ?>

      <checkbox-selector
        name="participation_category"
        label="igb_field_pub_participation_category_0116"
        choices="model,game,other software"
        value="<?= set_value('participation_category', $publication['participation_category']) ?>"
      ></checkbox-selector>

      <?= text_field('notes', [
        'label' => 'igb_field_pub_notes_0116',
        'value' => $publication['notes']
      ]); ?>

      <?= text_field('weburl1', [
        'label' => 'igb_field_pub_periodical_name_0116',
        'value' => $publication['periodical_name']
      ]); ?>

      <?= text_field('weburl1', [
        'label' => 'igb_field_pub_weburl1_0116',
        'value' => $publication['weburl1']
      ]); ?>

      <?= text_field('weburl2', [
        'label' => 'igb_field_pub_weburl2_0116',
        'value' => $publication['weburl2']
      ]); ?>

      <?= text_field('doi', [
        'label' => 'igb_field_pub_doi',
        'value' => $publication['doi']
      ]); ?>

      <?= text_field('editors', [
        'label' => 'igb_field_pub_editors_0116',
        'value' => $publication['editors']
      ]); ?>
    </div>

    <div class="col-md-3">
      <people-editor
        label="<?= ucfirst(lang('igb_field_pub_people')) ?>"
        name="people"
        value="<?= html_escape($people) ?>"
      ></people-editor>
    </div>
  </div>
</if-type>

<if-type except="01.16">
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

      <if-type tow="01.01, 01.02">
        <?= check_box('green_open_access', [
          'label' => 'igb_field_pub_green_open_access',
          'value' => $publication['green_open_access'],
        ]); ?>
      </if-type>
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

        <if-type except="01.01, 01.02, 01.05, 01.10, 01.11, 01.15">
          <!-- semantics: publisher -->
          <?= text_field('organization', [
            'label' => 'igb_field_pub_organization',
            'value' => $publication['organization']
          ]); ?>
        </if-type>
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

        <if-type except="01.01, 01.02, 01.05, 01.10, 01.11, 01.15">
          <!-- semantics: publisher -->
          <?= text_field('organization', [
            'label' => 'igb_field_pub_organization',
            'value' => $publication['organization']
          ]); ?>
        </if-type>

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

        <if-type except="01.01, 01.02, 01.05, 01.10, 01.11, 01.15">
          <!-- semantics: publisher -->
          <?= text_field('organization', [
            'label' => 'igb_field_pub_organization',
            'value' => $publication['organization']
          ]); ?>
        </if-type>
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

        <if-type except="01.01, 01.02, 01.05, 01.10, 01.11, 01.15">
          <!-- semantics: publisher -->
          <?= text_field('organization', [
            'label' => 'igb_field_pub_organization',
            'value' => $publication['organization']
          ]); ?>
        </if-type>

        <?= text_field('impactf', [
          'label' => 'igb_field_pub_impactf',
          'value' => $publication['impactf']
        ]); ?>
      </if-type>

      <if-type except="01.01, 01.02, 01.05, 01.10, 01.11, 01.15">
        <?= text_field('editors', [
          'label' => 'igb_field_pub_editors',
          'value' => $publication['editors']
        ]); ?>
      </if-type>

      <if-type tow="01.01, 01.02">
        <hr />

        <strong><?= ucfirst(lang('igb_green_open_access')); ?></strong>

        <?= text_field('link', [
          'label' => 'igb_field_pub_link',
          'value' => $publication['link']
        ]); ?>

        <?= date_field('embargo_date', [
          'label' => 'igb_field_pub_embargo_date',
          'value' => $publication['embargo_date']
        ]); ?>
      </if-type>
    </div>

    <div class="col-md-3">
      <people-editor
        label="<?= ucfirst(lang('igb_field_pub_people')) ?>"
        name="people"
        value="<?= html_escape($people) ?>"
      ></people-editor>
    </div>
  </div>
</if-type>
