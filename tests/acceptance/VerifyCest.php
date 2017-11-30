<?php

class VerifyCest
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

    public function authorize(AcceptanceTester $I)
    {
        $matrix = [
            'supervisor' => [
                ['Some lecture', TRUE],
                ['Some reviewed journal', TRUE]
            ],
            'library' => [
                ['Some lecture', TRUE],
                ['Some reviewed journal', TRUE]
            ]
        ];

        $I->addPersonToPublication('Doe, John', 'Some lecture');
        $I->addPersonToPublication('Doe, John', 'Some reviewed journal');

        foreach ($matrix as $user => $perms) {
            # so that these tests are not influenced by general auth for records
            $uid = $I->grabFromDatabase('passwd', 'uid', ['uname' => $user]);
            $I->updateInDatabase('publications', ['uid' => $uid]);

            $I->login($user);

            foreach ($perms as $case) {
                $I->amOnPage('/publications');
                $I->click($case[0]);
                $I->uncheckOption('Verified');
                $I->click('save');
                if ($case[1]) {
                    $I->see('record updated successfully');
                    $I->seeInDatabase('publications', [
                        'title' => $case[0],
                        'ct' => FALSE
                    ]);
                } else {
                    $I->see("You don't have sufficient permissions to verify records");
                    $I->updateInDatabase('publications', ['ct' => '0'], ['title' => $case[0]]);
                }

                $I->amOnPage('/publications');
                $I->click($case[0]);
                $I->checkOption('Verified');
                $I->click('save');
                if ($case[1]) {
                    $I->see('record updated successfully');
                    $I->seeInDatabase('publications', [
                        'title' => $case[0],
                        'ct' => TRUE
                    ]);
                } else {
                    $I->see("You don't have sufficient permissions to verify records");
                    $I->updateInDatabase('publications', ['ct' => '1'], ['title' => $case[0]]);
                }

            }

            $I->amOnPage('/');
            $I->click('create new work record');
            $I->click("[data-code='pres'] a");
            $I->dontSeeElement('input[name=ct][disabled]');

            $I->logout();
        }
    }

    public function authorizeProofreader(AcceptanceTester $I)
    {
        $uid = $I->grabFromDatabase('passwd', 'uid', ['uname' => 'proofreader']);
        $I->updateInDatabase('publications', ['uid' => $uid], ['title' => 'Some presentation']);

        $I->login('proofreader');

        $I->amOnPage('/publications');
        $I->dontSeeLink('Some reviewed journal');
        $pid = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some reviewed journal']);
        $I->amOnPage('/publications/edit/'.$pid);
        $I->see('Permission denied');

        $I->amOnPage('/publications');
        $I->dontSeeLink('Some lecture');
        $pid = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some lecture']);
        $I->amOnPage('/publications/edit/'.$pid);
        $I->see('Permission denied');

        $I->amOnPage('/publications');
        $I->click('Some presentation');
        $I->checkOption('Verified');
        $I->click('save & go back to the list');
        $I->dontSee("You don't have sufficient permissions to verify records");

        $I->amOnPage('/publications');
        $I->click('Some conference');
        $I->checkOption('Verified');
        $I->click('save & go back to the list');
        $I->dontSee("You don't have sufficient permissions to verify records");

        $I->amOnPage('/');
        $I->click('create new work record');
        $I->click("[data-code='pres'] a");
        $I->dontSeeElement('input[name=ct][disabled]');
    }

    public function authorizeDatacollector(AcceptanceTester $I)
    {
        $uid = $I->grabFromDatabase('passwd', 'uid', ['uname' => 'data_collector']);
        $I->updateInDatabase('publications', ['uid' => $uid], ['title' => 'Some presentation']);

        $I->login('data_collector');

        $I->amOnPage('/publications');
        $I->dontSeeLink('Some reviewed journal');
        $pid = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some reviewed journal']);
        $I->amOnPage('/publications/edit/'.$pid);
        $I->see('Permission denied');

        $I->amOnPage('/publications');
        $I->dontSeeLink('Some lecture');
        $pid = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some lecture']);
        $I->amOnPage('/publications/edit/'.$pid);
        $I->see('Permission denied');

        $I->amOnPage('/publications');
        $I->click('Some presentation');
        $I->checkOption('Verified'); # its disabled so this should have no effect
        $I->click('save & go back to the list');
        $I->dontSeeCheckboxIsChecked('Verified');

        $I->amOnPage('/publications');
        $I->dontSeeLink('Some conference');
        $pid = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some conference']);
        $I->amOnPage('/publications/edit/'.$pid);
        $I->see('Permission denied');

        $I->amOnPage('/');
        $I->click('create new work record');
        $I->click("[data-code='pres'] a");
        $I->seeElement('input[name=ct][disabled]');
    }

    public function authorizeUser(AcceptanceTester $I)
    {
        $uid = $I->grabFromDatabase('passwd', 'uid', ['uname' => 'jdoe']);
        $I->updateInDatabase('publications', ['uid' => $uid], ['title' => 'Some presentation']);

        $I->login('jdoe');

        $I->amOnPage('/publications');
        $I->dontSeeLink('Some reviewed journal');
        $pid = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some reviewed journal']);
        $I->amOnPage('/publications/edit/'.$pid);
        $I->see('Permission denied');

        $I->amOnPage('/publications');
        $I->dontSeeLink('Some lecture');
        $pid = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some lecture']);
        $I->amOnPage('/publications/edit/'.$pid);
        $I->see('Permission denied');

        $I->amOnPage('/publications');
        $I->click('Some presentation');
        $I->checkOption('Verified');
        $I->click('save & go back to the list');
        $I->dontSeeCheckboxIsChecked('Verified');

        $I->amOnPage('/publications');
        $I->dontSeeLink('Some conference');
        $pid = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some conference']);
        $I->amOnPage('/publications/edit/'.$pid);
        $I->see('Permission denied');

        $I->amOnPage('/');
        $I->click('create new work record');
        $I->click("[data-code='pres'] a");
        $I->seeElement('input[name=ct][disabled]');
    }

}