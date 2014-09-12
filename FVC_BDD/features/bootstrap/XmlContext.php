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
class XmlContext extends BehatContext
{
	//Xpaths for Service
    private $num = 0;
    public function getServiceAttribs()
    {
        $table = 'ServiceInformationTable';
        $srv = $this->dom->ProgramDescription->$table->ServiceInformation[$this->num]->attributes()->serviceId;
        $xsi = "tva2:ExtendedServiceInformationType";
        //$this->dom->ProgramDescription->$table->ServiceInformation[$this->num]->attributes()->xsi:type;
        $fragId =  $this->dom->ProgramDescription->$table->ServiceInformation[$this->num]->attributes()->fragmentId;
        $fragVer = $this->dom->ProgramDescription->$table->ServiceInformation[$this->num]->attributes()->fragmentVersion;
        return [$srv, $xsi, $fragId, $fragVer];
    }

	public function getName()
    {
        return $this->dom->ProgramDescription->ServiceInformationTable->ServiceInformation[$this->num]->Name;
    } 

    public function getOwner()
    {
        return $this->dom->ProgramDescription->ServiceInformationTable->ServiceInformation[$this->num]->Owner;
    } 

    public function getServiceURL()
    {
        return $this->dom->ProgramDescription->ServiceInformationTable->ServiceInformation[$this->num]->ServiceURL;
    } 

    public function getServiceGenre()
    {
        $type = $this->dom->ProgramDescription->ServiceInformationTable->ServiceInformation[$this->num]->ServiceGenre->attributes()->type;
        $href= $this->dom->ProgramDescription->ServiceInformationTable->ServiceInformation[$this->num]->ServiceGenre->attributes()->href;
        return [$type, $href];
    }

    public function getRelatedMaterial()
    {
        $comment = $this->dom->ProgramDescription->ServiceInformationTable->ServiceInformation[$this->num]->RelatedMaterial->comment;
        $howrelated = (string) $this->dom->ProgramDescription->ServiceInformationTable->ServiceInformation[$this->num]->RelatedMaterial->HowRelated->attributes()->href->__toString();
        $format = ""; //$this->dom->ProgramDescription->ServiceInformationTable->ServiceInformation[$this->num]->RelatedMaterial->Format->attributes()->href;
        $medialocator = ""; //$this->dom->ProgramDescription->ServiceInformationTable->ServiceInformation[0]->RelatedMaterial->MediaLocator;
        $promotionaltext = $this->dom->ProgramDescription->ServiceInformationTable->ServiceInformation[$this->num]->RelatedMaterial->PromotionalText;
        return [$comment, $howrelated, $format, $medialocator, $promotionaltext];
    }


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
     * @Given /^I request a specific xml service$/
     */
    public function iRequestASpecificXmlService()
    {
        //  Send request for specific Service
	    $url = "http://172.28.128.17/app_dev.php/services/1";
		$client = new Client();
		$client->setDefaultOption('headers', array(
			    'Accept' => 'headapplication/vnd.fvc.v0+xml,application/vnd.fvc.v0+xml,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
		));
		$this->responseService = $client->get($url);
		$this->dom = $this->responseService->xml();
        //print_r($this->dom);
    }

/**
     * @Given /^I request a multi xml service$/
     */
    public function iRequestAmultiXmlService()
    {
        //  Send request for specific Service
        $url = "http://172.28.128.17/app_dev.php/services?nid=1";
        $client = new Client();
        $client->setDefaultOption('headers', array(
                'Accept' => 'headapplication/vnd.fvc.v0+xml,application/vnd.fvc.v0+xml,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
        ));
        $this->responseService = $client->get($url);
        $this->dom = $this->responseService->xml();
        //print_r($this->dom);
    }



	/**
     * @When /^I perform a specific xpath$/
     */
    public function iPerformASpecificXpath()
    {
		$this->resultName = $this->getName();
		$this->resultOwner = $this->getOwner();
		$this->resultServiceId = $this->getServiceId();
		$this->resultServiceURL = $this->getServiceURL();	
	}

	/**
     * @Then /^I verify it is as expected$/
     */
    public function iVerifyItIsAsExpected()
    {	
		assertEquals("Service A", $this->resultName );
		assertEquals("Channel7 Ltd.", $this->resultOwner );
		assertEquals("dvb://233a..3039", $this->resultServiceURL );
		assertEquals("1", $this->resultServiceId );
        $res = $this->getServiceGenre();	
        assertEquals("main", $res[0] ); 
        assertEquals("urn:dtg:urn:dtg:metadata:cs:DTGGenreCS:2010-11#4", $res[1] );
        $res1 = $this->getRelatedMaterial();
        assertEquals("urn:mpeg:mpeg7:cs:FileFormatCS:2001:15", $res1[2] ); 
        assertEquals("Service A", $res1[4] );
	}

    /**
     * @Given /^the service Information respId should be ([^"]*)$/
     */
    public function theServiceInformationResponseShouldBeResponse($arg1)
    {
        /** @var TYPE_NAME $this */
        $this->num = (int)$arg1;
    }


    /**
     * @Given /^the service Information name should be ([^"]*)$/
     */
    public function theServiceInformationNameShouldBeServiceA($arg1)
    {
        $this->resultName = $this->getName();
        assertEquals($arg1, $this->resultName ); 
    }

    /**
     * @Given /^the service Information owner should be ([^"]*)$/
     */
    public function theServiceInformationOwnerShouldBeChannel($arg1)
    {
        
        $this->resultOwner = $this->getOwner();
        assertEquals($arg1, $this->resultOwner );
    }

    /**
     * @Given /^the service Information ServiceURL should be ([^"]*)$/
     */
    public function theServiceInformationServiceurlShouldBeServiceA($arg1)
    {
        $this->resultServiceURL = $this->getServiceURL();
        assertEquals($arg1, $this->resultServiceURL );
    }

    /**
     * @Given /^the service Information ServiceGenre Attributes should be ([^"]*), "([^"]*)"$/
     */
    public function theServiceInformationServiceGenreAttributesShouldBe($arg1, $arg2)
    {
        $this->resultServiceGenre = $this->getServiceGenre();
        assertEquals($arg1, $this->resultServiceGenre[0] );
        assertEquals($arg2, $this->resultServiceGenre[1] );
    }



    /**
     * @Given /^the service Information RelatedMaterial should be "([^"]*)", "([^"]*)", "([^"]*)"$/
     */
    public function theServiceInformationRelatedMaterialShouldBe($howrelated, $format, $promotionaltext)
    {
        $resultServiceGenre = $this->getRelatedMaterial();
        assertEquals( $howrelated, $resultServiceGenre[1] );
       // assertEquals( $format, $resultServiceGenre[2] );
        assertEquals( $promotionaltext, $resultServiceGenre[4] );
    }

    /**
     * @Given /^the service information attributes should be "([^"]*)", "([^"]*)", "([^"]*)", "([^"]*)"$/
     */
    public function theServiceInformationAttributesShouldBe($arg1, $arg2, $arg3, $arg4)
    {
        $resultServiceGenre = $this->getServiceAttribs();
        assertEquals( $arg1, $resultServiceGenre[0] );
//        assertEquals( $arg2, $resultServiceGenre[1] );
//        assertEquals( $arg3, $resultServiceGenre[2] );
//        assertEquals( $arg4, $resultServiceGenre[3] );
    }

}
