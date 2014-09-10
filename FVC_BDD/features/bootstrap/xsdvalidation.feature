Feature: XSDvalidation
  This file is purely for the Validation of the responces against the expected XSD files.

  As a device client
  I want to verify the xml response against the XSD
  So that we validate that our connector to work correctly

  Background:
    Given I am in the "app_dev.php" environment
    And I am using the Behat server "172.28.128.17"
    And I am verifing the "services" API


  @xsd
  Scenario Outline: Verifing API requests against xsd files
    Given  I am using a client device
    When I set the api to <Route>
    And I set the Version to <Version>
    And I set request value to <Request>
    Then the Response Status code should be <RespCode>
    And the xml should be valid against <xsd>

  Examples:
    | RespCode | Route      | Version | Request   | xsd                |
    | 200      | "services" | "v0"    | "1"       | "serviceXml.xsd"   |
    | 200      | "services" | "v0"    | "?nid=1"  | "serviceXml.xsd"   |
    | 404      | "players"  | "v0"    | "1"       | "playersXml.xsd"   |
    | 404      | "schedule" | "v0"    | "1"       | "scheduleXml.xsd"  |
