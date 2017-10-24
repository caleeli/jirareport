<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterScenarioScope;

require 'config.php';

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     *
     * @var Browser $browser
     */
    protected $browser;

    /**
     *
     * @var string $clipboard
     */
    protected $clipboard;

    /**
     *
     * @var Array $parameters
     */
    protected $parameters;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /** @AfterScenario */
    public function after(AfterScenarioScope $scope)
    {
        //Close the browser if it was opened.
        $this->closeTheBrowser();
    }

    /**
     * @Given a new workspace
     */
    public function aNewWorkspace()
    {
        $this->setupDB();
        $this->installLicense(__DIR__.'/../resources/license_*.dat');
        $this->config(['CFG_UID' => 'getStarted', 'CFG_VALUE' => '1']);
        $this->setTranslation('ID_INVALID_VALUE_CAN_NOT_BE_EMPTY',
                              'ID_INVALID_VALUE_CAN_NOT_BE_EMPTY({0})');
        $this->setTranslation('ID_UNDEFINED_VALUE_IS_REQUIRED',
                              'ID_UNDEFINED_VALUE_IS_REQUIRED({0})');
        $this->setTranslation('ID_WEB_ENTRY_EVENT_DOES_NOT_EXIST',
                              'ID_WEB_ENTRY_EVENT_DOES_NOT_EXIST({0})');
        $this->setTranslation('ID_INVALID_VALUE_ONLY_ACCEPTS_VALUES',
                              'ID_INVALID_VALUE_ONLY_ACCEPTS_VALUES({0},{1})');
    }

    /**
     * @Then Config env.ini with :arg1
     */
    public function configEnvIniWith($arg1)
    {
        $args = explode("=", $arg1);
        $name = trim($args[0]);
        $value = isset($args[1]) ? trim($args[1]) : '';
        $this->setEnvIni($name, $value);
    }

    /**
     * @Then Config env.ini without :arg1
     */
    public function configEnvIniWithout($arg1)
    {
        $this->unsetEnvIni($arg1);
    }

    /**
     * @Given Import process :arg1
     */
    public function importProcess($arg1)
    {
        $this->import(__DIR__.'/../resources/'.$arg1);
    }

    /**
     * @Then Go to Processmaker login
     */
    public function goToProcessmakerLogin()
    {
        $session = $this->browser;
        $session->visit($this->getBaseUrl('login/login'));
    }

    /**
     * @Then Login as :arg1 :arg2
     */
    public function loginAs($arg1, $arg2)
    {
        $session = $this->browser;
        $username = $session->getElementById('form[USR_USERNAME]');
        $username->setValue('admin');
        $password = $session->getElementById('form[USR_PASSWORD_MASK]');
        $password->setValue('admin');
        $submit = $session->getElementById('form[BSUBMIT]');
        $submit->click();
    }

    /**
     * @When Inside :arg1
     */
    public function inside($arg1)
    {
        $this->browser->switchToIFrame($arg1);
    }

    /**
     * @Then Copy :arg1 of :arg2
     */
    public function copyOf($arg1, $arg2)
    {
        $element = $this->browser->getElementByXpath($arg2);
        $this->clipboard = $element->getAttribute($arg1);
    }

    /**
     * @Then Double click on :arg1
     */
    public function doubleClickOn($arg1)
    {
        $process = $this->browser->getElementByTextContent($arg1);
        $process->doubleClick();
    }

    /**
     * @Then Right click on :arg1
     */
    public function rightClickOn($arg1)
    {
        $this->browser->getElementByTextContent($arg1)->rightClick();
    }

    /**
     * @Then Click on :arg1 inside :arg2
     */
    public function clickOnInside($arg1, $arg2)
    {
        $this->browser->getElementByTextContent($arg1, $arg2)->click();
    }

    /**
     * @Then Copy value of :arg1 like :arg2
     */
    public function copyValueOfLike($arg1, $arg2)
    {
        $this->clipboard = $this->browser->getElementByValue($arg1, $arg2)->getValue();
    }

    /**
     * @Then Logout Processmaker
     */
    public function logoutProcessmaker()
    {
        $this->browser->visit($this->getBaseUrl('login/login'));
    }

    /**
     * @Then open url copied
     */
    public function openUrlCopied()
    {
        $this->browser->visit($this->clipboard);
    }

    /**
     * @Then Verify the page does not redirect to the standard \/login\/login
     */
    public function verifyThePageDoesNotRedirectToTheStandardLoginLogin()
    {
        $this->assertEquals($this->clipboard, $this->browser->getCurrentUrl());
    }

    /**
     * @Then Verify the page goes to the WebEntry steps
     */
    public function verifyThePageGoesToTheWebentrySteps()
    {
        $this->assertLessThan(count($this->browser->getElementsByTextContent('Next Step')),
                                                                             0);
    }

    /**
     * @Then close the browser
     */
    public function closeTheBrowser()
    {
        if ($this->browser) {
            $sessionId = $this->browser->getWebDriverSessionId();
            $this->browser->wait(1000);
            $this->browser->stop();
            echo "Video available at:\n";
            echo $this->parameters['webDriverHost']."/grid/admin/HubVideoDownloadServlet?sessionId=".$sessionId;
            $this->browser = null;
        }
    }

    /**
     *
     * @return \Browser
     */
    private function openBrowser()
    {
        $capabilities = $this->parameters['capabilities'];
        $capabilities['seleniumProtocol'] = "WebDriver";
        if (empty($capabilities['browserName'])) {
            $capabilities['browserName'] = 'chrome';
        }
        $driver = new \Behat\Mink\Driver\Selenium2Driver(
            $capabilities['browserName'], $capabilities,
            $this->parameters['webDriverHost'].'/wd/hub'
        );
        $session = new Browser($driver);
        $session->start();
        return $session;
    }

    public function __destruct()
    {
        $this->closeTheBrowser();
    }
    ////OFFICIAL

    /**
     * @Then Open a browser
     */
    public function openABrowser()
    {
        $this->browser = $this->openBrowser();
    }

    /**
     * @Then Visit :arg1
     */
    public function visit($arg1)
    {
        try {
            $this->browser->visit($arg1);
        } catch (Exception $ex) {
            $this->closeTheBrowser();
            throw $ex;
        }
    }

    /**
     * @Then Write on :arg1 :arg2
     */
    public function writeOn($arg1, $arg2)
    {
        try {
            $element = $this->browser->getElementById($arg1);
            $element->setValue($arg2);
        } catch (Exception $ex) {
            $this->closeTheBrowser();
            throw $ex;
        }
    }

    /**
     * @Then Click on :arg1
     */
    public function clickOn($arg1)
    {
        try {
            $element = $this->browser->getElementByIdLike($arg1);
            $element->click();
        } catch (Exception $ex) {
            $this->closeTheBrowser();
            throw $ex;
        }
    }

    /**
     * @Then Click at :arg1
     */
    public function clickAt($arg1)
    {
        try {
            $element = $this->browser->getElementByTextContent($arg1);
            $element->click();
        } catch (Exception $ex) {
            $this->closeTheBrowser();
            throw $ex;
        }
    }


    /**
     * @Then Wait :arg1 ms
     */
    public function waitMs($arg1)
    {
        try {
            $this->browser->wait($arg1);
        } catch (Exception $ex) {
            $this->closeTheBrowser();
            throw $ex;
        }
    }

    /**
     * @Then Wait for :arg1 :arg2 ms
     */
    public function waitFor($arg1, $arg2)
    {
        $element = $this->browser->waitElementsByTextContent($arg1, $arg2);
    }
}
