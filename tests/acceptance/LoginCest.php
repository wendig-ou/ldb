<?php

class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->test_data(['users' => TRUE]);
    }

    // tests

    public function seeLogin(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Sign in');
    }

    public function wrongCredentials(AcceptanceTester $I)
    {
        $I->amOnPage('/');

        $I->fillField(['name' => 'username'], 'supervisor');
        $I->fillField(['name' => 'password'], 'wrongpass');
        $I->click('Sign in');
        $I->see('Sign in failed. Please check username and/or password');
    }

    public function correctCredentials(AcceptanceTester $I)
    {
        $I->amOnPage('/');

        $I->fillField(['name' => 'username'], 'supervisor');
        $I->fillField(['name' => 'password'], 'supervisorpass');
        $I->click('Sign in');
        $I->see('signed in successfully as supervisor');
        $I->see('admin', 'nav');
    }

    public function normalUser(AcceptanceTester $I)
    {
        $I->amOnPage('/');

        $I->fillField(['name' => 'username'], 'jdoe');
        $I->fillField(['name' => 'password'], 'jdoepass');
        $I->click('Sign in');
        $I->see('signed in successfully as jdoe');
        $I->dontSee('admin', 'nav');
    }

    public function usersCannotProceedWithoutDepartment(AcceptanceTester $I)
    {
        $I->updateInDatabase('passwd', ['dpmt' => NULL], ['uname' => 'jdoe']);

        $I->amOnPage('/');
        $I->submitForm('form', [
            'username' => 'jdoe',
            'password' => 'jdoepass'
        ]);
        $I->see('your login information is correct but before you can use this application, please contact the IGB library with your username');
        $I->seeLink('I understand');
        $I->dontSee('Password');
    }
}
