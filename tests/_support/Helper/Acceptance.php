<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
    public function _beforeSuite($settings = array()) {
        echo "creating structure dump from dev db\n";
        exec('./structure-dump.sh');
        
        echo "purging screenshot directory\n";
        exec('rm -rf ./tests/_output/');
        exec('mkdir ./tests/_output/');
    }

    public function test_data($config = [])
    {
        $db = $this->getModule('Db');

        if (isset($config['users'])) {
            $db->haveInDatabase('passwd', [
                'uname' => 'supervisor',
                'pw' => 'supervisorpass',
                'role' => 'admin',
                'dpmt' => 4
            ]);

            $db->haveInDatabase('passwd', [
                'uname' => 'library',
                'pw' => 'librarypass',
                'role' => 'library',
                'dpmt' => 4
            ]);

            $db->haveInDatabase('passwd', [
                'uname' => 'data_collector',
                'pw' => 'data_collectorpass',
                'role' => 'data_collector',
                'dpmt' => 4
            ]);

            $db->haveInDatabase('passwd', [
                'uname' => 'proofreader',
                'pw' => 'proofreaderpass',
                'role' => 'proofreader',
                'dpmt' => 4
            ]);

            $db->haveInDatabase('passwd', [
                'uname' => 'jdoe',
                'pw' => 'jdoepass',
                'dpmt' => 4
            ]);
        }

        if (isset($config['types'])) {
            $id = $db->haveInDatabase('super_types', ['name' => 'presentation', 'code' => 'pres']);
            $db->haveInDatabase('ToW', [
                'tow' => '03.01',
                't_desc' => 'Plenarvorträge und Keynotelectures',
                'active' => 1,
                'super_type_id' => $id,
            ]);
            $db->haveInDatabase('ToW', [
                'tow' => '03.04',
                't_desc' => 'contributed/other talk',
                'active' => 1,
                'super_type_id' => $id,
            ]);

            $id = $db->haveInDatabase('super_types', ['name' => 'publication', 'code' => 'pub']);
            $db->haveInDatabase('ToW', [
                'tow' => '01.01',
                't_desc' => 'Referierte Zeitschriften mit Impactfaktor',
                'active' => 1,
                'super_type_id' => $id
            ]);
            $db->haveInDatabase('ToW', [
                'tow' => '01.02',
                't_desc' => 'Referierte Zeitschriften ohne Impactfaktor',
                'active' => 1,
                'super_type_id' => $id
            ]);

            $id = $db->haveInDatabase('super_types', ['name' => 'supervision', 'code' => 'sup']);
            $db->haveInDatabase('ToW', [
                'tow' => '04.01',
                't_desc' => 'Some supervision type of work',
                'active' => 1,
                'super_type_id' => $id
            ]);

            $id = $db->haveInDatabase('super_types', ['name' => 'media relations', 'code' => 'media']);
            $db->haveInDatabase('ToW', [
                'tow' => '09.05',
                't_desc' => 'Some media relations type of work',
                'active' => 1,
                'super_type_id' => $id
            ]);

            $id = $db->haveInDatabase('super_types', ['name' => 'editorial activities', 'code' => 'edit']);
            $db->haveInDatabase('ToW', [
                'tow' => '06.01',
                't_desc' => 'Some editorial activities type of work',
                'active' => 1,
                'super_type_id' => $id
            ]);

            $id = $db->haveInDatabase('super_types', ['name' => 'lecture', 'code' => 'lec']);
            $db->haveInDatabase('ToW', [
                'tow' => '04.06',
                't_desc' => 'Some lecture type of work',
                'active' => 1,
                'super_type_id' => $id
            ]);

            $id = $db->haveInDatabase('super_types', ['name' => 'committee activities', 'code' => 'comm']);
            $db->haveInDatabase('ToW', [
                'tow' => '06.02',
                't_desc' => 'Some committee activities type of work',
                'active' => 1,
                'super_type_id' => $id
            ]);

            $id = $db->haveInDatabase('super_types', ['name' => 'organization of conference or workshop', 'code' => 'conf']);
            $db->haveInDatabase('ToW', [
                'tow' => '07.01',
                't_desc' => 'Some conference type of work',
                'active' => 1,
                'super_type_id' => $id
            ]);

            $id = $db->haveInDatabase('super_types', ['name' => 'review', 'code' => 'rev']);
            $db->haveInDatabase('ToW', [
                'tow' => '10.01',
                't_desc' => 'review',
                'active' => 1,
                'super_type_id' => $id,
            ]);
        }

        if (isset($config['people'])) {
            $db->haveInDatabase('igb_ldb_lom_persons', [
                'Person' => 'Doe, John',
            ]);

            $db->haveInDatabase('igb_ldb_lom_persons', [
                'Person' => 'Mustermann, Hans',
            ]);

            $db->haveInDatabase('igb_ldb_lom_persons', [
                'Person' => 'Dupont, Jean',
            ]);

            $db->haveInDatabase('igb_ldb_lom_persons', [
                'Person' => 'Rossi, Marco',
            ]);
        }

        $iid = NULL;
        if (isset($config['institutions'])) {
            $iid = $db->haveInDatabase('igb_ldb_institutions', [
                'institut' => 'Freie Universität Berlin'
            ]);
        }

        if (isset($config['publications'])) {
            $db->haveInDatabase('publications', [
                'klr_tow' => '01.01',
                'title' => 'Some reviewed journal',
                'fdate' => '2015',
                'end_fdate' => '2015',
                'ct' => TRUE,
                'dpmt' => '4'
            ]);

            $db->haveInDatabase('publications', [
                'klr_tow' => '04.06',
                'dpmt' => '3',
                'institution_id' => $iid,
                'impactf' => '8',
                'semester' => "SS 2015",
                'title' => 'Some lecture',
                'fdate' => '2017',
                'ct' => TRUE,
                'editors' => 'some editors'
            ]);

            $db->haveInDatabase('publications', [
                'klr_tow' => '03.01',
                'title' => 'Some presentation',
                'fdate' => '2017',
                'end_fdate' => '2019',
                'dpmt' => '2'
            ]);

            $db->haveInDatabase('publications', [
                'klr_tow' => '07.01',
                'title' => 'Some conference',
                'dpmt' => '4',
                'fdate' => '2016',
                'ct' => TRUE
            ]);
        }

    }

    public function addPersonToPublication($person, $publication)
    {
        $db = $this->getModule('Db');

        $person_id = $db->grabFromDatabase('igb_ldb_lom_persons', 'lpid', ['Person' => $person]);
        $publication_id = $db->grabFromDatabase('publications', 'pid', ['title' => $publication]);
        $db->haveInDatabase('igb_ldb_lom_authors', [
            'lpid' => $person_id,
            'publication_id' => $publication_id
        ]);
    }
}
