<?php

class AuthorizationCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->test_data([
            'users' => TRUE,
            'types' => TRUE,
            'publications' => TRUE,
            'institutions' => TRUE,
            'people' => TRUE
        ]);
    }


    // tests

    public function authorizeAdmin(AcceptanceTester $I)
    {
        $id = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some reviewed journal']);
        $pubs_id = $I->grabFromDatabase('super_types', 'id', ['code' => 'pub']);

        $actions = [
            ['/publications', TRUE],
            ['/users', TRUE],
            ['/periodicals', TRUE],
            ['/institutions', TRUE],
            ['/people', TRUE],
            ['/ris', TRUE],
            ['/publications/new', TRUE],
            ['/publications/new?super-type-id='.$pubs_id, TRUE],
            ['/publications/edit/'.$id, TRUE],
            ['/publications/delete/'.$id, TRUE],
            ['/reports', TRUE],
        ];

        $I->login('supervisor');
        foreach ($actions as $a) {
            $I->amOnPage($a[0]);
            if ($a['1']) {
                $I->dontSee('Permission denied');
            } else {
                $I->see('Permission denied');
            }
        }
    }

    public function authorizeLibrary(AcceptanceTester $I)
    {
        $id = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some reviewed journal']);
        $pubs_id = $I->grabFromDatabase('super_types', 'id', ['code' => 'pub']);

        $actions = [
            ['/publications', TRUE],
            ['/users', TRUE],
            ['/periodicals', TRUE],
            ['/institutions', TRUE],
            ['/people', TRUE],
            ['/ris', TRUE],
            ['/publications/new', TRUE],
            ['/publications/new?super-type-id='.$pubs_id, TRUE],
            ['/publications/edit/'.$id, TRUE],
            ['/publications/delete/'.$id, TRUE],
            ['/reports', TRUE],
        ];

        $I->login('library');
        foreach ($actions as $a) {
            $I->amOnPage($a[0]);
            if ($a['1']) {
                $I->dontSee('Permission denied');
            } else {
                $I->see('Permission denied');
            }
        }
    }

    public function authorizeDataCollector(AcceptanceTester $I)
    {
        $id = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some reviewed journal']);
        $pubs_id = $I->grabFromDatabase('super_types', 'id', ['code' => 'pub']);

        $actions = [
            ['/publications', TRUE],
            ['/users', FALSE],
            ['/periodicals', FALSE],
            ['/institutions', FALSE],
            ['/people', FALSE],
            ['/ris', FALSE],
            ['/publications/new', TRUE],
            ['/publications/new?super-type-id='.$pubs_id, FALSE],
            ['/publications/edit/'.$id, FALSE],
            ['/publications/delete/'.$id, FALSE],
            ['/reports', TRUE],
        ];

        $I->login('data_collector');
        foreach ($actions as $a) {
            $I->amOnPage($a[0]);
            if ($a['1']) {
                $I->dontSee('Permission denied');
            } else {
                $I->see('Permission denied');
            }
        }
    }

    public function authorizeProofreader(AcceptanceTester $I)
    {
        $id = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some reviewed journal']);
        $pubs_id = $I->grabFromDatabase('super_types', 'id', ['code' => 'pub']);

        $actions = [
            ['/publications', TRUE],
            ['/users', FALSE],
            ['/periodicals', FALSE],
            ['/institutions', FALSE],
            ['/people', FALSE],
            ['/ris', FALSE],
            ['/publications/new', TRUE],
            ['/publications/new?super-type-id='.$pubs_id, FALSE],
            ['/publications/edit/'.$id, FALSE],
            ['/publications/delete/'.$id, FALSE],
            ['/reports', FALSE],
        ];

        $I->login('proofreader');
        foreach ($actions as $a) {
            $I->amOnPage($a[0]);
            if ($a['1']) {
                $I->dontSee('Permission denied');
            } else {
                $I->see('Permission denied');
            }
        }
    }

    public function authorizeUser(AcceptanceTester $I)
    {
        $pubs_id = $I->grabFromDatabase('super_types', 'id', ['code' => 'pub']);
        $uid = $I->grabFromDatabase('passwd', 'uid', ['uname' => 'jdoe']);
        $I->updateInDatabase('publications', ['uid' => $uid], ['title' => 'Some reviewed journal']);
        $I->updateInDatabase('publications', ['uid' => $uid, 'ct' => TRUE], ['title' => 'Some presentation']);
        $I->updateInDatabase('publications', ['ct' => FALSE]);

        $own_id = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some reviewed journal']);
        $other_id = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some lecture']);
        $pres_id = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some presentation']);

        $actions = [
            ['/publications', TRUE],
            ['/users', FALSE],
            ['/periodicals', FALSE],
            ['/institutions', FALSE],
            ['/people', FALSE],
            ['/ris', FALSE],
            ['/publications/new', TRUE],
            ['/publications/new?super-type-id='.$pubs_id, FALSE],
            ['/publications/edit/'.$other_id, FALSE],
            ['/publications/edit/'.$own_id, FALSE],
            ['/publications/edit/'.$pres_id, TRUE],
            ['/publications/delete/'.$other_id, FALSE],
            ['/publications/delete/'.$own_id, FALSE],
            ['/reports', FALSE],
        ];

        $I->login('jdoe');
        foreach ($actions as $a) {
            $I->amOnPage($a[0]);
            if ($a['1']) {
                $I->dontSee('Permission denied');
            } else {
                $I->see('Permission denied');
            }
        }
    }

    public function usersCannotCreatePub(AcceptanceTester $I)
    {
        $I->login('jdoe');
        $id = $I->grabFromDatabase('super_types', 'id', ['code' => 'pub']);
        $I->amOnPage('/publications/new?super-type-id='.$id);
        $I->see('permission denied');
    }

    public function usersCannotModifyVerifiedRecords(AcceptanceTester $I)
    {
        $uid = $I->grabFromDatabase('passwd', 'uid', ['uname' => 'jdoe']);
        $I->updateInDatabase('publications', ['uid' => $uid]);

        $verified_id = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some lecture']);
        $id = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some presentation']);

        $I->login('jdoe');

        $I->amOnPage('/publications/edit/'.$verified_id);
        $I->see("Permission denied");

        $I->amOnPage('/publications/edit/'.$id);
        $I->dontSee("Permission denied");
    }

}
