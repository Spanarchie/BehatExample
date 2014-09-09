<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use GuzzleHttp\Client;

//
// Require 3rd-party libraries here:
//
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class ApplicationContext extends BehatContext
{
	/**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }


    /**
     * @Given /^there are (\d+) cucumbers$/
     */
    public function thereAreCucumbers($arg1)
    {
	$this->cucum1 = $arg1;
        assertEquals(12, $arg1);
    }

    /**
     * @When /^I eat (\d+) cucumbers$/
     */
    public function iEatCucumbers($arg1)
    {
       $this->cucum2 = $arg1;
       assertEquals(5, $arg1);
    }

    /**
     * @Then /^I should have (\d+) cucumbers$/
     */
    public function iShouldHaveCucumbers($arg1)
    {
       $ans = $this->cucum1 - $this->cucum2;
       assertEquals(7, $ans);
    }




}
