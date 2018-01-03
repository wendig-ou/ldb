<?php

class PublicationCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->test_data([
            'users' => TRUE,
            'types' => TRUE,
            'people' => TRUE,
            'institutions' => TRUE
        ]);
    }

    // tests

    public function list(AcceptanceTester $I)
    {
        $I->login('supervisor');
        $I->click('home');
        $I->see('Work records');
    }

    public function sortAndFilter(AcceptanceTester $I) {
        $I->test_data(['publications' => TRUE]);

        $I->login('supervisor');
        $I->click('home');
        $I->see('Some conference', 'tr:first-child');

        $I->click('Title', 'table');
        $I->see('Some conference', 'tr:first-child');

        $I->click('Title', 'table');
        $I->see('Some reviewed journal', 'tr:first-child');

        $I->click('Type of work', 'table');
        $I->see('Some reviewed journal', 'tr:first-child');

        $I->click('Type of work', 'table');
        $I->see('Some conference', 'tr:first-child');

        $I->click('Year', 'table');
        $I->see('Some reviewed journal', 'tr:first-child');
        
        $I->click('Year', 'table');
        $I->see('Some lecture', 'tr:first-child');

        $I->fillField('fdate', '2015');
        $I->click('search', 'form.search');
        $I->see('Some reviewed journal', 'table');
        $I->dontSee('Some lecture', 'table');
        $I->dontSee('Some presentation', 'table');

        $I->fillField('fdate', '2018');
        $I->click('search', 'form.search');
        $I->dontSee('Some reviewed journal', 'table');
        $I->see('Some lecture', 'table');
        $I->see('Some presentation', 'table');

        $I->fillField('fdate', '2020');
        $I->click('search', 'form.search');
        $I->dontSee('Some reviewed journal', 'table');
        $I->see('Some lecture', 'table');
        $I->dontSee('Some presentation', 'table');

        $I->amOnPage('/');
        $I->checkOption('verified');
        $I->click('search');
        $I->see('Some reviewed journal', 'table');
        $I->see('Some lecture', 'table');
        $I->dontSee('Some presentation', 'table');
        $I->see('Some conference', 'table');
        $I->checkOption('unverified');
        $I->click('search');
        $I->dontSee('Some reviewed journal', 'table');
        $I->dontSee('Some lecture', 'table');
        $I->see('Some presentation', 'table');
        $I->dontSee('Some conference', 'table');
        $I->checkOption('both');
        $I->click('search');
        $I->see('Some reviewed journal', 'table');
        $I->see('Some lecture', 'table');
        $I->see('Some presentation', 'table');
        $I->see('Some conference', 'table');

        $I->amOnPage('/');
        $I->selectOption('tow', '01.01');
        $I->fillField('fdate', '2015,2016');
        $I->click('search');
        $I->see('Some reviewed journal', 'table');
        $I->dontSee('Some lecture', 'table');
        $I->dontSee('Some presentation', 'table');
        $I->dontSee('Some conference', 'table');

        $I->amOnPage('/?tow=01.01,03.01');
        $I->see('Some reviewed journal', 'table');
        $I->dontSee('Some lecture', 'table');
        $I->see('Some presentation', 'table');
        $I->dontSee('Some conference', 'table');
    }

    public function createPresentationWithErrors(AcceptanceTester $I)
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='pres'] a");

        $I->add_person('Doe, John');

        $I->click('save');
        $I->see('The title of presentation or talk field is required');
        $I->scrollTo('input[type=checkbox]');
        $I->dontSee('PHP Error');

        $I->waitForText('Doe, John', 5, 'people-editor');
    }

    public function rememberNewPeopleOnError(AcceptanceTester $I)
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='pres'] a");

        $I->add_new_person('Kolumna, Karla');

        $I->click('save');
        $I->see('The title of presentation or talk field is required');
        $I->dontSee('PHP Error');
        $I->waitForText('Kolumna, Karla', 5, 'people-editor');
    }

    public function createPublicationWithErrors(AcceptanceTester $I)
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='pub'] a");
        $I->see('Publication');

        $I->selectOption('input[name=klr_tow]', '01.01');
        $I->fillField('Citation', 'some citation');
        $I->fillField('DOI', '10.1056/NEJM199710303371801');
        $I->fillField('Publisher', 'Springer');
        $I->fillField('Impact factor', '3.1415');

        $I->click('save');

        $I->see('The title field is required');
        $I->see('You have to associate at least one person with any work record');
        $I->seeInField('Citation', 'some citation');
        $I->seeInField('DOI', '10.1056/NEJM199710303371801');
        $I->seeInField('Publisher', 'Springer');
        $I->seeInField('Impact factor', '3.1415');
    }

    public function createPresentation(AcceptanceTester $I)
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='pres'] a");
        $I->see('Presentation');

        $I->fillField('Title of presentation or talk', 'Ruby talk');
        $I->fillField('Name of conference or workshop, optional: organizer or association', 'Railsconf');
        $I->fillField('Place of conference or workshop', 'San Francisco');
        $I->fillField('Start date of conference', '20170417');
        $I->fillField('End date of conference', '20170421');
        $I->wait(1);
        $I->click('Done'); # close the date picker
        $I->add_person('Doe, John');

        $I->click('save');

        $I->see('record created successfully');
        $I->see('03.01', 'table');
        $I->see('presentation', 'table');
        $I->see('Ruby talk', 'table');
        $I->see('Notes: Railsconf', 'table');
        $I->see('Location: San Francisco', 'table');
        $I->see('Doe, John', 'table');
    }

    public function createSupervision(AcceptanceTester $I) 
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='sup'] a");

        $I->fillField('Title of thesis', 'Eisbär-Analyse – ein Wasserstand');
        $I->add_person('Doe, John');
        $I->fillField('Date of defense', '20170421');
        $I->click('Done'); # close the date picker
        $I->fillField('Additional information', 'some info');
        $I->fill_autocomplete('institution-selector', 'Freie Universität Berlin');

        $I->click('save');

        $I->see('record created successfully');
        $I->see('04.01', 'table');
        $I->see('supervision', 'table');
        $I->see('Eisbär-Analyse – ein Wasserstand', 'table');
        $I->see('Notes: some info', 'table');
        $I->see('Doe, John', 'table');
    }

    public function createSupervisionAndCreateInstitutionOnTheFly(AcceptanceTester $I)
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='sup'] a");

        $I->fillField('Title of thesis', 'Eisbär-Analyse – ein Wasserstand');
        $I->add_person('Doe, John');
        $I->fillField('Date of defense', '20170421');
        $I->click('Done'); # close the date picker
        $I->fillField('Additional information', 'some info');
        $I->fillField('institution-selector input[name=institution_name]', 'Haus des Meeres');

        $I->click('save');

        $I->see('record created successfully');
        $I->seeInDatabase('igb_ldb_institutions', [
            'institut' => 'Haus des Meeres'
        ]);
    }

    public function createMediaRelations(AcceptanceTester $I) 
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='media'] a");

        $I->fillField('Title', 'Twitter post');
        $I->add_person('Doe, John');
        $I->fillField('Date', '20170421');
        $I->click('Done'); # close the date picker
        $I->fillField('Citation', 'some citation');
        $I->fillField('Type of medium', 'online post');
        $I->fillField('Year of performance', '2017');

        $I->click('save');

        $I->see('record created successfully');
        $I->see('09.05', 'table');
        $I->see('media relations', 'table');
        $I->see('Twitter post', 'table');
        $I->see('Notes: some citation', 'table');
        $I->see('Doe, John', 'table');
        $I->dontSee('2017-', 'table');
    }

    public function createEditorialActivities(AcceptanceTester $I) 
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='edit'] a");

        $I->fillField('Function', 'Editor-in-Chief');
        $I->add_person('Doe, John');
        $I->fillField('Journal', 'Inland Waters');

        $I->click('save');

        $I->see('record created successfully');
        $I->see('06.01', 'table');
        $I->see('Editor-in-Chief', 'table');
        $I->see('Inland Waters', 'table');
        $I->see('Doe, John', 'table');
    }

    public function createLecture(AcceptanceTester $I) 
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='lec'] a");
        $I->see('Lecture');

        $I->fillField('Title of lecture or course', 'Some lecture');
        $I->fillField('Optional: additional information about lecture or course', 'Blockseminar');
        $I->fill_autocomplete('institution-selector', 'Freie Universität Berlin');
        $I->fillField('Optional: start date', '20170103');
        $I->click('Done'); # close the date picker
        $I->fillField('Optional: end date', '20170106');
        $I->fillField('Semester hours (SWS)', '4');
        $I->selectOption('Semester', 'SS 2017');
        $I->add_person('Doe, John');

        $I->click('save');

        $I->see('record created successfully');
        $I->see('04.06', 'table');
        $I->see('Some lecture', 'table');
        $I->see('Blockseminar', 'table');
        $I->see('Freie Universität Berlin', 'table');
        $I->see('Doe, John', 'table');
    }

    public function createCommitteeActivities(AcceptanceTester $I) 
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='comm'] a");

        $I->fillField('Year of performance (from)', '2016');
        $I->fillField('Year of performance (to)', '2016');
        $I->fillField('Function', 'Editor-in-Chief');
        $I->fillField('Name of committee, society or association ', 'Gesellschaft zur Rettung des Störs');
        $I->add_person('Doe, John');
        $I->click('save');

        $I->see('record created successfully');
        $I->see('06.02', 'table');
        $I->see('Editor-in-Chief', 'table');
        $I->see('Gesellschaft zur Rettung des Störs', 'table');
        $I->see('Doe, John', 'table');
        $I->seeInDatabase('publications', [
            'title' => 'Editor-in-Chief',
            'fdate' => '2016',
            'end_fdate' => '2016'
        ]);

        $I->click('Editor-in-Chief');
        $I->wait(1);
        $I->fillField('Year of performance (to)', '2017');
        $I->click('save & go back to the list');
        $I->see('record updated successfully');
        $I->seeInDatabase('publications', [
            'title' => 'Editor-in-Chief',
            'fdate' => '2016',
            'end_fdate' => '2017'
        ]);

        $I->click('Editor-in-Chief');
        $I->checkOption('end-year input[type=checkbox]');
        $I->click('save & go back to the list');
        $I->see('record updated successfully');
        $I->seeInDatabase('publications', [
            'title' => 'Editor-in-Chief',
            'fdate' => '2016',
            'end_fdate' => NULL
        ]);
    }

    public function createConference(AcceptanceTester $I) 
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='conf'] a");

        $I->fillField('Name of conference or workshop, optional: organizer or association', 'Railsconf');
        $I->fillField('Place of conference or workshop', 'San Francisco');
        $I->fillField('Start date of conference', '20170417');
        $I->click('Done'); # close the date picker
        $I->fillField('End date of conference', '20170421');
        $I->fillField('Number of participants', '400');
        $I->add_person('Doe, John');

        $I->click('save');

        $I->see('record created successfully');
        $I->see('07.01', 'table');
        $I->see('Railsconf', 'table');
        $I->see('San Francisco', 'table');
        $I->see('Doe, John', 'table');
    }

    public function createInstitutionOnTheFly(AcceptanceTester $I)
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='lec'] a");
        
        $I->fillField('Title of lecture or course', 'Some lecture');
        $I->fillField('Optional: additional information about lecture or course', 'Blockseminar');
        $I->fillField('institution-selector input[name=institution_name]', 'IST Austria');
        $I->fillField('Optional: start date', '20170103');
        $I->click('Done'); # close the date picker
        $I->fillField('Optional: end date', '20170106');
        $I->fillField('Semester hours (SWS)', '4');
        $I->selectOption('Semester', 'SS 2017');
        $I->add_person('Doe, John');

        $I->click('save');

        $I->see('record created successfully');
        $I->seeInDatabase('igb_ldb_institutions', [
            'institut' => 'IST Austria'
        ]);
    }

    public function createPeriodicalOnTheFly(AcceptanceTester $I)
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='pub'] a");
        
        $I->selectOption('input[name=klr_tow]', '01.01');
        $I->fillField('Title', 'Some title');
        $I->fillField('Citation', 'some citation');
        $I->fillField('periodical-selector input[name=periodical_name]', 'Sunflower Revue');
        $I->fillField('DOI', '10.1056/NEJM199710303371801');
        $I->fillField('Publisher', 'some publisher');
        $I->fillField('Impact factor', '3.2');
        $I->add_person('Doe, John');

        $I->click('save');

        $I->see('record created successfully');
        $I->seeInDatabase('periodicals', [
            'pname' => 'Sunflower Revue'
        ]);
    }

    public function dontDuplicateReferencedRecords(AcceptanceTester $I)
    {
        $I->test_data(['publications' => TRUE]);

        $I->login('supervisor');
        $I->click('home', '.navbar');
        $I->click('Some lecture');

        $I->fillField('Semester hours (SWS)', '8');
        $I->selectOption('Semester', 'SS 2017');
        $I->checkOption('D');
        $I->fill_autocomplete('institution-selector', 'Freie Universität Berlin');
        $I->add_person('Doe, John');
        $I->click('save');

        $I->see('record updated successfully');
        $I->seeNumRecords(1, 'igb_ldb_institutions', ['institut' => 'Freie Universität Berlin']);
    }

    public function editPublication(AcceptanceTester $I)
    {
        $I->test_data(['publications' => TRUE]);

        $I->login('supervisor');
        $I->click('home', '.navbar');
        $I->click('Some lecture', 'table');
        $I->fillField('Title of lecture or course', 'Some awesome lecture');
        $I->fill_autocomplete('institution-selector', 'Freie Universität Berlin');
        $I->add_person('Doe, John');
        $I->click('save');

        $I->see('record updated successfully');
        $I->seeInDatabase('publications', [
            'title' => 'Some awesome lecture'
        ]);
    }

    public function deletePublication(AcceptanceTester $I)
    {
        $I->test_data(['publications' => TRUE]);

        $I->login('supervisor');
        $I->click('home', '.navbar');
        $I->wait(1);
        # workaround because the confirm-anchor tag doesn't work in tests
        $id = $I->publication_id_by_title('Some lecture');
        $I->amOnPage('/publications/delete/'.$id);
        $I->see("record deleted successfully");
    }

    public function notFound(AcceptanceTester $I)
    {
        $I->test_data(['publications' => TRUE]);

        $I->login('supervisor');
        $I->amOnPage('/publications/edit/12345678');
        $I->see('The record you are trying to access does not exist');
    }

    public function reDisplayReferencedItemsWhenUsersAreEditing(AcceptanceTester $I)
    {
        $I->login('jdoe');

        $I->amOnPage('/');
        $I->click('create new work record');
        $I->click("[data-code='lec'] a");

        # wait for the departments-editor element to mount
        $I->wait(1);

        $I->seeCheckboxIsChecked('4');
        $I->dontSeeCheckboxIsChecked('5');

        $I->fillField('Title of lecture or course', 'Some lecture');
        $I->fillField('Optional: additional information about lecture or course', 'Blockseminar');
        $I->fill_autocomplete('institution-selector', 'Freie Universität Berlin');
        $I->fillField('Optional: start date', '20170103');
        $I->click('Done'); # close the date picker
        $I->fillField('Optional: end date', '20170106');
        $I->fillField('Semester hours (SWS)', '4');
        $I->selectOption('Semester', 'SS 2017');
        $I->add_person('Doe, John');
        $I->click('save');
        $I->see('record created successfully');
        $I->click('Some lecture');
        $I->seeInField('institution-selector input[type=text]', 'Freie Universität Berlin');
        $I->see('Doe, John', 'people-editor');
    }

    public function usersCantChangeVerifiedRecords(AcceptanceTester $I)
    {
        $I->test_data(['publications' => TRUE]);

        $uid = $I->grabFromDatabase('passwd', 'uid', ['uname' => 'jdoe']);
        $I->updateInDatabase('publications', ['uid' => $uid], ['title' => 'Some lecture']);
        $I->updateInDatabase('publications', ['uid' => $uid], ['title' => 'Some presentation']);

        $I->login('jdoe');

        $I->amOnPage('/');
        $I->dontSeeLink('Some lecture');
        $pid = $I->grabFromDatabase('publications', 'pid', ['title' => 'Some lecture']);
        $I->amOnPage('/publications/edit/'.$pid);
        $I->see('Permission denied');

        $I->amOnPage('/');
        $I->click('Some presentation');
        $I->fillField('Name of conference or workshop, optional: organizer or association', 'Railsconf');
        $I->fillField('Place of conference or workshop', 'San Francisco');
        $I->fillField('Start date of conference', '20170417');
        $I->add_person('Doe, John');
        $I->checkOption('D');
        $I->click('save & go back to the list');
        $I->see('record updated successfully');
    }

    public function returnToListAfterErrors(AcceptanceTester $I)
    {
        $I->test_data(['publications' => TRUE]);

        $I->login('supervisor');
        $I->amOnPage('/');
        $I->click('Some presentation');

        $I->fillField('Name of conference or workshop, optional: organizer or association', 'Railsconf');
        $I->fillField('Place of conference or workshop', 'San Francisco');
        $I->fillField('Start date of conference', '20170417');
        $I->click('save');
        $I->see('You have to associate at least one person with any work record');

        $I->add_person('Doe, John');
        $I->click('save & go back to the list');
        $I->see('record updated successfully');
        $I->see('Work records');
    }

    public function validateNewPeople(AcceptanceTester $I)
    {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='pres'] a");

        $I->add_new_person('Karla Kolumna');
        $I->click('save');
        $I->see('Please make sure to enter new people in the format "Lastname, Firstname"');

        $I->remove_person('Karla Kolumna');
        $I->click('save');
        $I->dontSee('Please make sure to enter new people in the format "Lastname, Firstname"');

        $I->add_new_person('Kolumna, Karla');
        $I->click('save');
        $I->dontSee('Please make sure to enter new people in the format "Lastname, Firstname"');
    }

    public function removeInvolvedPeople(AcceptanceTester $I)
    {
        $I->test_data(['publications' => TRUE]);

        $I->login('supervisor');
        $I->amOnPage('/');
        $I->click('Some lecture');
        $I->add_person('Doe, John');
        $I->fill_autocomplete('institution-selector', 'Freie Universität Berlin');        

        $I->fillField('Involved persons', '');
        $I->click('save & go back to the list');
        $I->see('record updated successfully');
        $I->click('Some lecture');
        $I->dontSeeInField('Involved persons', 'some editors');
    }

    public function manuallyFillInADuplicatePerson(AcceptanceTester $I) {
        $I->login('supervisor');
        $I->click('create new work record');
        $I->click("[data-code='lec'] a");
        $I->see('Lecture');

        $I->fillField('Title of lecture or course', 'Some lecture');
        $I->fillField('Optional: additional information about lecture or course', 'Blockseminar');
        $I->fill_autocomplete('institution-selector', 'Freie Universität Berlin');
        $I->fillField('Optional: start date', '20170103');
        $I->click('Done'); # close the date picker
        $I->fillField('Optional: end date', '20170106');
        $I->fillField('Semester hours (SWS)', '4');
        $I->selectOption('Semester', 'SS 2017');
        $I->add_new_person('Doe, John');

        $I->click('save');

        $I->dontSee('A Database Error Occurred');
        $I->see('record created successfully');
    }

}
