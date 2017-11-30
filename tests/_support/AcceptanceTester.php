<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    public function login($username)
    {
        $session_name = $username.'_logged_in';
        $I = $this;
        
        if ($I->loadSessionSnapshot($session_name)) return;

        $password = $username . 'pass';
        $I->amOnPage('/');
        $I->submitForm('form', [
            'username' => $username,
            'password' => $password
        ]);

        $I->saveSessionSnapshot($session_name);
    }

    public function logout() {
        $I = $this;
        $I->click('sign out');
    }

    public function sendkeys($locator, $keys)
    {
        $I = $this;
        $I->executeInSelenium(function(\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) use ($locator, $keys) {
          $element = $webdriver->findElement(WebDriverBy::cssSelector($locator));
          $element->sendkeys($keys);
        });
    }

    public function add_person($name)
    {
        $I = $this;
        $I->scrollTo(['css' => 'people-editor']);
        $I->fill_autocomplete('people-editor', $name);
        $I->click('li.list-group-item[person-id]:first-child', 'people-editor');
    }

    public function add_new_person($name)
    {
        $I = $this;
        $I->scrollTo(['css' => 'people-editor']);
        $I->sendkeys('people-editor .ui-autocomplete-input', $name."\n");
    }

    public function remove_person($name)
    {
        $I = $this;
        $I->click(['xpath' => "//people-editor//ul/li[text()[contains(., '".$name."')]]/i"]);
    }

    public function fill_autocomplete($within, $value)
    {
        $I = $this;
        $I->sendkeys($within.' .ui-autocomplete-input', $value);
        // $I->waitForElementVisible($within.' ul.ui-menu');
        $I->waitForElement($within.' ul.ui-menu li.ui-menu-item:first-child', 5);
        $I->click('li.ui-menu-item:first-child', $within);
    }

    public function publication_id_by_title($title)
    {
        $I = $this;
        return $I->grabFromDatabase('publications', 'pid', ['title' => $title]);
    }
}
