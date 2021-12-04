<?php 
  class Migration_Restructure_types extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->dbforge->add_column('publications', [
        'participation_category' => [
          'type' => 'varchar',
          'constraint' => 255
        ],
        'target_group' => [
          'type' => 'varchar',
          'constraint' => 255
        ],
        'duration' => [
          'type' => 'varchar',
          'constraint' => 255
        ],
        'contribution_category' => [
          'type' => 'varchar',
          'constraint' => 255
        ],
        'event_category' => [
          'type' => 'varchar',
          'constraint' => 255
        ],
        'language' => [
          'type' => 'varchar',
          'constraint' => 255
        ],
        'publication_category' => [
          'type' => 'varchar',
          'constraint' => 255
        ],
        'dotation' => [
          'type' => 'varchar',
          'constraint' => 255
        ]
      ]);

      $this->db->
        set('name', 'presentations and participation in panels')->
        set('description', 'Scientific keynote, plenary or invited talk (incl. moderation and podium discussion); lecture, panel participation and other contribution to a scientific, public or stakeholder event.')->
        where('code', 'pres')->
        update('super_types');

      # merge previous 'edit' and 'comm' super_types and rename
      $edit_id = $this->db->where('code', 'edit')->get('super_types')->result_array()[0]['id'];
      $comm_id = $this->db->where('code', 'comm')->get('super_types')->result_array()[0]['id'];
      $this->db->
        set('name', 'editorial and committee activities')->
        set('description', 'Position as editor-in-chief or co-editor for a scientific journal, and position in scientific and non-scientific committees.')->
        where('id', $edit_id)->
        update('super_types');
      $this->db->
        set('super_type_id', $edit_id)->
        where('super_type_id', $comm_id)->
        update('ToW');
      $this->db->
        where('id', $comm_id)->
        delete('super_types');
      
      $this->db->
        set('name', 'organization of conferences or events')->
        set('description', 'Scientific and non-scientific event or conference (co-) organized by IGB scientist, including session organisation.')->
        where('code', 'conf')->
        update('super_types');

      $this->db->
        set('name', 'Science communication')->
        set('description', 'Active contributions to transfer publications or to science communication (not media reports on the research) in print, online or broadcast media with a target audience outside the scientific community.')->
        where('code', 'media')->
        update('super_types');

      $this->db->
        set('name', 'Reviews and expert advice')->
        set('description', 'Review activities and advisory services. ')->
        where('code', 'rev')->
        update('super_types');

      # ToW changes for pres super_type
      $id = $this->db->where('code', 'pres')->get('super_types')->result_array()[0]['id'];
      $this->db->
        set('super_type_id', $id)->
        set('t_desc', 'scientific event (contributed/other talk)')->
        where('tow', '03.04')->
        update('ToW');
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '03.08',
        't_desc' => 'official public outreach event',
        'active' => 1
      ]);
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '03.07',
        't_desc' => 'official stakeholder event',
        'active' => 1
      ]);
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '03.06',
        't_desc' => 'non-scientific high-level panel',
        'active' => 1
      ]);

      # ToW changes for pres super_type
      $id = $this->db->where('code', 'edit')->get('super_types')->result_array()[0]['id'];
      $this->db->
        set('super_type_id', $id)->
        set('t_desc', 'editorial activities')->
        where('tow', '06.01')->
        update('ToW');
      $this->db->
        set('super_type_id', $id)->
        set('t_desc', 'committee activities in science')->
        where('tow', '06.02')->
        update('ToW');
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '06.03',
        't_desc' => 'committee activities beyond the scientific community',
        'active' => 1
      ]);

      # ToW changes for conf super_type
      $id = $this->db->where('code', 'conf')->get('super_types')->result_array()[0]['id'];
      $this->db->
        set('super_type_id', $id)->
        set('t_desc', 'scientific conference or event')->
        where('tow', '07.01')->
        update('ToW');
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '07.03',
        't_desc' => 'official public outreach event',
        'active' => 1
      ]);
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '07.04',
        't_desc' => 'official stakeholder event',
        'active' => 1
      ]);

      # ToW changes for media super_type
      $id = $this->db->where('code', 'media')->get('super_types')->result_array()[0]['id'];
      $this->db->
        set('super_type_id', $id)->
        set('t_desc', 'interview')->
        where('tow', '09.05')->
        update('ToW');
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '09.09',
        't_desc' => 'audio-visual format',
        'active' => 1
      ]);
      $this->db->
        set('super_type_id', $id)->
        set('t_desc', 'IGB Dossier')->
        where('tow', '09.10')->
        update('ToW');
      $this->db->
        set('super_type_id', $id)->
        set('t_desc', 'IGB Fact Sheet')->
        where('tow', '09.11')->
        update('ToW');
      $this->db->
        set('super_type_id', $id)->
        set('t_desc', 'IGB Policy Brief')->
        where('tow', '09.12')->
        update('ToW');
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '09.13',
        't_desc' => 'science communication publication',
        'active' => 1
      ]);
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '09.14',
        't_desc' => 'press release',
        'active' => 1
      ]);
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '09.15',
        't_desc' => 'news item',
        'active' => 1
      ]);
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '09.16',
        't_desc' => 'newsletter',
        'active' => 1
      ]);

      # ToW changes for media super_type
      $id = $this->db->where('code', 'rev')->get('super_types')->result_array()[0]['id'];
      $this->db->
        set('super_type_id', $id)->
        set('t_desc', 'EU project review')->
        where('tow', '10.01')->
        update('ToW');
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '10.03',
        't_desc' => 'self-initiated expert report or position paper',
        'active' => 1
      ]);
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '10.04',
        't_desc' => 'commissioned expert report or position paper',
        'active' => 1
      ]);
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '10.05',
        't_desc' => 'standardization',
        'active' => 1
      ]);
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '10.02',
        't_desc' => 'individual scientific advice',
        'active' => 1
      ]);

      # new award super type
      $this->db->insert('super_types', [
        'name' => 'Awards',
        'code' => 'award',
        'description' => 'Awards and other honours received for remarkable achievements in research, teaching, communication or transfer.'
      ]);
      $id = $this->db->insert_id();
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '11.01',
        't_desc' => 'awards and prizes',
        'active' => 1
      ]);
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>
