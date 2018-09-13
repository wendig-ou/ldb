<?php 
  class Migration_Add_review_super_type extends CI_Migration {
    public function up() {
      echo get_class($this) . "\n";

      $this->db->insert('super_types', [
        'name' => 'reviews',
        'description' => 'Aggregated numbers of review activities (e.g. commissioned reports, position papers, peer review)',
        'code' => 'rev'
      ]);
      $id = $this->db->insert_id();
      $this->db->insert('ToW', [
        'super_type_id' => $id,
        'tow' => '10.01',
        't_desc' => 'review',
        'active' => 1
      ]);

      $this->dbforge->add_column('publications', [
        'num_comm_reports' => [
          'type' => 'int',
          'constraint' => 11,
          'default' => 0
        ],
        'num_position_papers' => [
          'type' => 'int',
          'constraint' => 11,
          'default' => 0
        ],
        'num_reviews' => [
          'type' => 'int',
          'constraint' => 11,
          'default' => 0
        ],
        'num_reviews_eu' => [
          'type' => 'int',
          'constraint' => 11,
          'default' => 0
        ]
      ]);
    }

    public function down() {
      die("this migration can't be reversed");
    }
  }
?>