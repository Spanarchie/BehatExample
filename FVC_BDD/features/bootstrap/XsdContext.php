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
class XsdContext extends BehatContext
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
     * @When /^I set the api to "([^"]*)"$/
     */
    public function iSetTheApiTo($arg1)
    {
        $this->api = $arg1;
    }

    /**
     * @When /^I set the Version to "([^"]*)"$/
     */
    public function iSetTheVersionTo($arg1)
    {
        $this->ver = $arg1;
    }

    /**
     *@When /^I set request value to "([^"]*)"$/
     */
    public function iSetRequestValueTo($arg1)
    {
        $this->req = $arg1;
        //$this->restCall($this->api, $this->ver, $this->req);
        //  Send request for specific Service
        $url = "http://172.28.128.17/app_dev.php/".$this->ver."/".$this->api."/".$this->req;
        $client = new Client();
        $client->setDefaultOption('headers', array(
            'Accept' => 'headapplication/vnd.fvc.v0+xml,application/vnd.fvc.v1+xml,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
        ));
        try{
            $this->responseService = $client->get($url);
            $this->domOrig = $this->responseService->xml();
            print_r($this->domOrig);
            $this->dom = new DOMDocument();
            $this->dom->loadXML($this->domOrig->asXML());
            print_r($this->dom);

            $this->responseServiceStatus = $this->responseService->getStatusCode();
        }catch (Exception $e) {
            $this->responseServiceStatus = $e->getCode();
        }
    }


    /**
     * @Then /^the Response Status code should be ([^"]*)$/
     */
    public function theResponseStatusCodeShouldBe($arg1)
    {
        $statusCode = $arg1;
        assertEquals( $statusCode , $this->responseServiceStatus);

    }

    /**
     * @Then /^the xml should be valid against "([^"]*)"$/
     */
    public function theBeValidAgainstXsd($arg1)
    {
        $is_valid_xml = $this->dom->schemaValidate('features/testData/'.$this->api.'/fvc_extended_metadata.xsd');
        assertTrue($is_valid_xml);

    }


/**
  Area for the sanity checking of Known files both xml & xsd
*/
    /**
     * @When /^I validate ([^"]*)$/
     */
    public function iValidateServices($arg1)
    {
        $this->sampleServ = $arg1;
    }

    /**
     * @Given /^I use xml ([^"]*)$/
     */
    public function iUseXml($arg1)
    {
        $this->sampleXML = $arg1;
    }

    /**
     * @Given /^I use xsd "([^"]*)"$/
     */
    public function iUseXsd($arg1)
    {
        $this->sampleXsd = $arg1;
    }


    /**
     * @Then /^the Response Status should be ([^"]*)$/
     */
    public function theResponseStatus()
    {
        $doc = new DOMDocument();
        $doc->load('features/testData/'.$this->sampleServ.'/'.$this->sampleXML.'.xml');
        $is_valid_xml = $doc->schemaValidate('features/testData/'.$this->sampleServ.'/'.$this->sampleXsd);
        assertTrue($is_valid_xml);
    }

}
