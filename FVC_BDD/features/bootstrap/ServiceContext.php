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
class ServiceContext extends BehatContext
{
	private $expectedXMLrespService;


    private $responseServiceStatus = 200;
	private $env, $srv, $api, $verNo;

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->expectedXMLrespService = new DOMDocument();
        $this->expectedXMLrespService->load('features/testData/services/service.xml');
    }


    /**
     * @Given /^I am verifying the "([^"]*)" API$/
     */
    public function iAmVerifingTheSelectedAPI($arg1)
    {
        $this->api = $arg1;
    }

	/**
     * @Given /^I am in the "([^"]*)" environment$/
     */
    public function iAmInTheEnvironment($arg1)
    {
        $this->env = $arg1;
    }

    /**
     * @Given /^I am using the Behat server "([^"]*)"$/
     */
    public function iAmUsingTheBehatServer($arg1)
    {
        $this->srv = $arg1;
    }


    /**
     * @Given /^I am using a client device$/
     */
    public function iAmUsingAClientDevice()
    {
        $this->w = 1 + 1;
    }

    /**
     * @When /^I request a specific service$/
     */
    public function iRequestASpecificService()
    {
        //  Send request for specific Service
	    $url = "http://172.28.128.17/app_dev.php/services/1";
		$client = new Client();
		$client->setDefaultOption('headers', array(
			    'Accept' => 'headapplication/vnd.fvc.v0+xml,application/vnd.fvc.v0+xml,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
		));
		$this->responseService = $client->get($url);
    }

	/**
     * @When /^I request a service of Version "([^"]*)"$/
     */
    public function iRequestASpecificServiceVersion($verNoRef)
    {
		$this->verNo = $verNoRef;
    }

	/**
     * @When /^I request a service of ID "([^"]*)"$/
     */
    public function iRequestASpecificServiceId($servID)
    {
        //  Send request for specific Service
	    $url = "http://".$this->srv."/".$this->env."/".$this->api."".$servID;
		$client = new Client();
		$client->setDefaultOption('headers', array(
			    'Accept' => 'headapplication/vnd.fvc.v0+xml,application/vnd.fvc.v0+xml,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
		));
		try{
				$this->responseService = $client->get($url);
                $this->dom = $this->responseService->xml();
				$this->responseServiceStatus = $this->responseService->getStatusCode();
		} catch (Exception $e) {
			$this->responseServiceStatus = $e->getCode();
		}
    }


    /**
     * @Then /^I should see the expected service results$/
     */
    public function iShouldSeeTheExpectedServiceResults()
    {
		$expected = $this->expectedXMLrespService;
        print_r("Expected : @".$expected);
		$actual = $this->responseService->getBody();
        print_r("ACTUAL : @".$actual);
		assertEquals($expected,$actual);
    }

 	/**
     * @Then /^the Response Status code should be "([^"]*)"$/
     */
    public function iShouldSeeTheExpectedServiceResultIs404($expected)
    {
		$actual = $this->responseServiceStatus;
		assertEquals($expected,$actual);
    }


/***********************************************************************
************************************************************************
***                                                                  ***
***                       End of Code                                ***
***                                                                  ***
************************************************************************
***********************************************************************/

}
