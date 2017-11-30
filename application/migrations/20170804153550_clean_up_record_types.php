<?php 
  class Migration_Clean_up_record_types extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      # modify db
      $this->dbforge
        ->add_field('id')
        ->add_field([
          'name' => ['type' => 'varchar', 'constraint' => 255],
          'description' => ['type' => 'text'],
          'help' => ['type' => 'text'],
          # determines translation matrix and forms to use
          'code' => ['type' => 'varchar', 'constraint' => 255]
        ])
        ->create_table('super_types');

      $this->dbforge->add_column('ToW',
        array(
          'active' => ['type' => 'INT', 'constraint' => 1],
          'super_type_id' => ['type' => 'int', 'constraint' => 11]
        )
      );

      # add new ToWs

      $this->db->insert('ToW', [
        'tow' => '01.15'
      ]);
      
      # activate relevant ToWs
      $ids = [
        '01.01', '01.02', '01.03', '01.04', '01.05', '01.07', '01.10', '01.11', '01.13', '01.14', '01.15',
        '03.01', '03.04', 
        '04.01', '04.02', '04.03', '04.04', '04.06',
        '06.01', '06.02',
        '07.01', '07.02',
        '09.05', '09.10', '09.11', '09.12'
      ];
      $this->db->set('active', 1)->where_in('tow', $ids)->update('ToW');

      # map deprecated ToWs
      $mappings = ['01.12' => '01.07', '01.06' => '01.13', '01.08' => '01.02', '01.09' => '01.10'];
      foreach ($mappings as $from => $to) {
        $this->db->set('klr_tow', $to)->where('klr_tow', $from)->update('publications');
      }

      # create super types and assign ToW to them

      $this->db->insert('super_types', [
        'name' => 'publications',
        'description' => 'Journal articles, book chapters, books, research reports and SSI publications. Entries are managed by IGB Library.',
        'code' => 'pub'
      ]);
      $id = $this->db->insert_id();
      $this->db
        ->set('super_type_id', $id)
        ->where_in('tow', [
          '01.01', '01.02', '01.10', '01.05', '01.11', '01.03', '01.04',
          '01.14', '09.10', '09.11', '09.12', '01.13', '01.07', '01.15'
        ])
        ->update('ToW');

      $this->db->insert('super_types', [
        'name' => 'presentations',
        'description' => 'Keynotes, plenary or invited talks as well as contributed talks at international or national meetings. Including moderation and podium discussion. No Posters.',
        'help' => 'Please choose the type of presentation:
Keynote, plenary or invited talk (both at international or national meetings with particular importance in the field) 

Contributed talk or invited talks at smaller venues or schools/universities. 

Both include moderation and podium discussion. No Posters.

Please submit entries in their original language version (no translation).',
        'code' => 'pres'
      ]);
      $id = $this->db->insert_id();
      $this->db
        ->set('super_type_id', $id)
        ->where_in('tow', ['03.01', '03.02', '03.03', '03.04', '03.05', '09.03', '09.04'])
        ->update('ToW');

      $this->db->insert('super_types', [
        'name' => 'organization of conference or workshop',
        'description' => 'Scientific conference or workshop, which has been (co-)organized by IGB scientist. Including session organization.',
        'help' => 'Scientific conference or workshop, which has been organized by IGB scientist. Including session organization.

For WGL reporting an estimated number of participants is appreciated.

Please submit entries in their original language version (no translation needed).',
        'code' => 'conf'
      ]);
      $id = $this->db->insert_id();
      $this->db
        ->set('super_type_id', $id)
        ->where_in('tow', ['07.01', '07.02'])
        ->update('ToW');

      $this->db->insert('super_types', [
        'name' => 'lectures and courses',
        'description' => 'Lectures or courses as documented by an entry in a university course catalog.',
        'help' => 'Lectures or courses, usually documented by an entry in a university course catalog. Lectures are counted in semester or credit hours (hours per week for the duration of the semester). Minimum duration is one semester hour (roughly about 14 clock hours, equivalent to a two-day compact course). No half hours are counted. If a lecture is repeated over the course of several semesters, it will be counted separately for each semester, so please make an entry for each semester.

Summer semester courses are valid for the year they take place. 
Winter semester courses are valid in the year the semester ends. Example: A block course in November 2016 would be counted in 2017.   

Practical courses / traineeships (before 2017) go here as well.

Please submit entries in their original language version (no translation needed).',
        'code' => 'lec'
      ]);
      $id = $this->db->insert_id();
      $this->db
        ->set('super_type_id', $id)
        ->where_in('tow', ['04.06', '09.06', '09.07'])
        ->update('ToW');

      $this->db->insert('super_types', [
        'name' => 'supervision',
        'description' => 'Supervision of bachelor, master, PhD and habilitation theses. Only completed theses, no on-going supervision.',
        'help' => 'Supervision of bachelor, master, PhD and habilitation theses. Only completed theses, no on-going supervision. For date please use the date of the defense.',
        'code' => 'sup'
      ]);
      $id = $this->db->insert_id();
      $this->db
        ->set('super_type_id', $id)
        ->where_in('tow', ['04.01', '04.02', '04.03', '04.04', '04.05'])
        ->update('ToW');

      $this->db->insert('super_types', [
        'name' => 'media relations',
        'description' => 'Contribution in print, online or broadcast media.',
        'help' => 'Please submit entries in their original language version (no translation needed).',
        'code' => 'media'
      ]);
      $id = $this->db->insert_id();
      $this->db
        ->set('super_type_id', $id)
        ->where_in('tow', ['09.05', '09.08'])
        ->update('ToW');

      $this->db->insert('super_types', [
        'name' => 'committee activities',
        'description' => 'Position in a committee, society or association.',
        'help' => 'Position in a committee, society or association. 

One entry per person (in case several persons are involved in the same activity).',
        'code' => 'comm'
      ]);
      $id = $this->db->insert_id();
      $this->db
        ->set('super_type_id', $id)
        ->where_in('tow', ['06.02'])
        ->update('ToW');

      $this->db->insert('super_types', [
        'name' => 'editorial activities',
        'description' => 'Position as editor-in-chief, co-editor or associate editor in a scientific journal. Not for editorship of a book or journal issue. Not for peer-review.',
        'help' => 'Position as editor-in-chief, co-editor or associate editor in a scientific journal. Not for editorship of a book or journal issue. Not for peer-review.

One entry per person (in case several persons are involved in the same activity).',
        'code' => 'edit'
      ]);
      $id = $this->db->insert_id();
      $this->db
        ->set('super_type_id', $id)
        ->where_in('tow', ['06.01'])
        ->update('ToW');

      # rename tows

      $mapping = [
        '03.01' => 'keynote/plenary or invited talk',
        '03.04' => 'contributed/other talk',
        '07.01' => 'conference w/ more than 50 participants',
        '07.02' => 'conference w/ less than 50 participants',
        '04.06' => 'lecture',
        '04.01' => 'supervision of finalized habilitation treatise',
        '04.02' => 'supervision of finalized PhD thesis',
        '04.03' => 'supervision of finalized master or diploma thesis',
        '04.04' => 'supervision of finalized bachelor thesis',
        '06.01' => 'editorial activities',
        '06.02' => 'committee activities',
        '09.05' => 'media contribution',
        '01.01' => 'peer-reviewed article in journal with IF',
        '01.02' => 'peer-reviewed article in journal without IF',
        '01.10' => 'article without peer-review',
        '01.05' => 'chapter (international)',
        '01.11' => 'chapter (national)',
        '01.04' => 'monograph (international)',
        '01.14' => 'monograph (national)',
        '01.03' => 'editorship (book or journal issue)',
        '01.07' => 'contribution in conference proceedings',
        '01.13' => 'research report',
        '09.10' => 'IGB dossier',
        '09.11' => 'IGB fact sheet',
        '09.12' => 'IGB policy brief',
        '09.15' => 'research data publication',
        '09.08' => 'media contribution online (until 2016 - no longer in use)',
        '03.02' => 'keynote, national (until 2016 - no longer in use)',
        '03.03' => 'contributed talk at university (until 2016 - no longer in use)',
        '03.05' => 'poster (until 2016 - no longer in use)',
        '04.05' => 'supervision of student paper (until 2016 - no longer in use)',
        '09.03' => 'poster, national (until 2016 - no longer in use)',
        '09.04' => 'contributed talk at school (until 2016 - no longer in use)',
        '09.06' => 'traineeships /w school (until 2016 - no longer in use)',
        '09.07' => 'traineeships /w university (until 2016 - no longer in use)',
        '01.15' => 'research data publication'
      ];

      foreach ($mapping as $tow => $desc) {
        $this->db->where('tow', $tow)->set('t_desc', $desc)->update('ToW');
      }
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>