<?php

class UserCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->test_data(['users' => TRUE]);
    }

    // tests

    public function listAndSearch(AcceptanceTester $I)
    {
        $I->login('supervisor');

        $I->amOnPage('/users');
        $I->see('Users');
        $I->see('supervisor');
        $I->see('jdoe');

        $I->fillField('terms', 'sup');
        $I->click('search');
        $I->see('supervisor');
        $I->dontSee('jdoe');
    }

    public function update(AcceptanceTester $I)
    {
        $I->login('supervisor');

        $I->amOnPage('/users');
        $I->click('jdoe');
        $I->fillField('Name', 'Jonathan Doe');
        $I->fillField('Username', 'jodo');
        $I->selectOption('Department', 'D');
        $I->click('save');

        $I->see('record updated successfully');
        $I->seeInDatabase('passwd', [
            'uname' => 'jodo',
            'comment' => 'Jonathan Doe',
            'dpmt' => 'D'
        ]);
    }

    public function createDuplicate(AcceptanceTester $I)
    {
        $I->login('supervisor');

        $I->amOnPage('/users');
        $I->click('create', 'h1');
        $I->fillField('Name', 'Doe, John');
        $I->fillField('Username', 'jdoe');
        $I->selectOption('Department', 'D');
        $I->click('save');
        $I->see('The username field must contain a unique value');
    }
}
