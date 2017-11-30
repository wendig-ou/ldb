<?php

class PeopleCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->test_data(['users' => TRUE, 'people' => TRUE]);
    }

    // tests

    public function listAndSearch(AcceptanceTester $I)
    {
        $I->login('supervisor');

        $I->amOnPage('/people');
        $I->see('Persons');

        $I->fillField('terms', 'muster');
        $I->click('search');
        $I->see('Mustermann, Hans');
        $I->dontSee('Rossi, Marco');
        $I->dontSee('Doe, John');
        $I->dontSee('Dupont, Jean');
    }

    public function update(AcceptanceTester $I)
    {
        $I->login('supervisor');

        $I->amOnPage('/people');
        $I->click('Mustermann, Hans');
        $I->fillField('Name', 'Mustermann, Klaus');
        $I->click('save');

        $I->see('record updated successfully');
        $I->seeInDatabase('igb_ldb_lom_persons', [
            'Person' => 'Mustermann, Klaus',
        ]);
    }

    public function createDuplicate(AcceptanceTester $I)
    {
        $I->login('supervisor');

        $I->amOnPage('/people');
        $I->click('create', 'h1');
        $I->fillField('Name', 'Doe, John');
        $I->click('save');
        $I->see('The name field must contain a unique value');
    }
}
