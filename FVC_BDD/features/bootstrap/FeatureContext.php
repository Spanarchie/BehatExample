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
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    private $expectedXMLresp = '<?xml version="1.0"?><resource xmlns:xlink="http://www.w3.org/1999/xlink">
        <CUSTOMERList xlink:href="http://www.thomas-bayer.com/sqlrest/CUSTOMER/">CUSTOMER</CUSTOMERList>
        <INVOICEList xlink:href="http://www.thomas-bayer.com/sqlrest/INVOICE/">INVOICE</INVOICEList>
        <ITEMList xlink:href="http://www.thomas-bayer.com/sqlrest/ITEM/">ITEM</ITEMList>
        <PRODUCTList xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/">PRODUCT</PRODUCTList>
        </resource>';

    private $expectedXMLrespProduct = '<?xml version="1.0"?><PRODUCTList xmlns:xlink="http://www.w3.org/1999/xlink">
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/0/">0</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/1/">1</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/2/">2</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/3/">3</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/4/">4</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/5/">5</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/6/">6</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/7/">7</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/8/">8</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/9/">9</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/10/">10</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/11/">11</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/12/">12</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/13/">13</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/14/">14</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/15/">15</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/16/">16</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/17/">17</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/18/">18</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/19/">19</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/20/">20</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/21/">21</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/22/">22</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/23/">23</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/24/">24</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/25/">25</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/26/">26</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/27/">27</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/28/">28</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/29/">29</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/30/">30</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/31/">31</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/32/">32</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/33/">33</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/34/">34</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/35/">35</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/36/">36</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/37/">37</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/38/">38</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/39/">39</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/40/">40</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/41/">41</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/42/">42</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/43/">43</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/44/">44</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/45/">45</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/46/">46</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/47/">47</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/48/">48</PRODUCT>
    <PRODUCT xlink:href="http://www.thomas-bayer.com/sqlrest/PRODUCT/49/">49</PRODUCT>
</PRODUCTList>';


    private $baseURL = "http://www.thomas-bayer.com/sqlrest/";

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
     * @Given /^I am using the SeaChange device$/
     */
    public function iAmUsingTheSeachangeDevice()
    {
        $this->w = 1 + 1;
    }

    /**
     * @Given /^I am using a client device$/
     */
    public function iAmUsingAClientDevice()
    {
        $this->w = 1 + 1;
    }

    /**
     * @When /^I request a specific episodes by ref$/
     */
    public function iRequestASpecificEpisodesByRef()
    {
        //  Send request for specific Episode
	    $url = "http://www.thomas-bayer.com/sqlrest/";
	    $this->response = file_get_contents($url);
	   // var_dump($this->response);
    }



    /**
     * @Then /^I should see the expected result$/
     */
    public function iShouldSeeTheFileName()
    {
        // Verify that the response is as expected
	    $this->expectedXMLresp == $this->response;
    }

    /**
     * @When /^I request all episodes of a series$/
     */
    public function iRequestAllEpisodesOfASeries()
    {
        $client = new Client();
        $this->response = $client->get($this->baseURL."PRODUCT/");
        $code = $this->response->getStatusCode();
        $body = $this->response->getBody();
    }

    /**
     * @Given /^for the "([^"]*)" Series$/
     */
    public function forTheSeries($seriesNo)
    {
        $seriesNo == "#";
    }

    /**
     * @Given /^for the known brand$/
     */
    public function forTheKnownBrand()
    {
         $this->w = 1 + 1;
    }

    /**
     * @Then /^I should see the expected results$/
     */
    public function iShouldSeeTheExpectedResults()
    {
        $this->response->getBody() == $this->expectedXMLrespProduct;
    }

    /**
     * @When /^I request all episodes of brand$/
     */
    public function iRequestAllEpisodesOfBrand()
    {
        throw new PendingException();
    }

/************************************************************************
***                        End of Code                                ***
************************************************************************/

}
