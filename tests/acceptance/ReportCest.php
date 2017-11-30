<?php

class ReportCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->test_data(['users' => TRUE]);
    }

    public function listReports(AcceptanceTester $I) {
        $I->login('supervisor');
        $I->amOnPage('/');
        $I->click('reports');
        $I->see('Reports', 'h1');
    }

    public function runReport(AcceptanceTester $I)
    {
        $I->login('supervisor');
        $I->amOnPage('/');
        $I->click('reports');
        $I->click('run', 'div.igb-report:last-child');
        $I->see('users.sql', 'h1');
        $I->see('supervisor', 'table');
        $I->see('jdoe', 'table');
    }
}