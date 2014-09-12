@XSDvalidation
Feature:
  This file is purely for the Validation of the responses against the expected XSD files.

  As a device client
  I want to verify the xml response against the XSD
  So that we validate that our connector is working correctly

  Background:
    Given I am in the "app_dev.php" environment
    And I am using the Behat server "172.28.128.17"
    And I am verifying the "services" API

  @xsdsanity
  Scenario Outline: Verifying the xsd validation is working for known sample files
    Given  I am using a client device
    When I validate <Api>
    And I use xml <Xml>
    And I use xsd <Xsd>
    Then the Response Status should be <Status>

  Examples:
    | Api       | Xml       | Xsd                           | Status |
    | services  | service   | "fvc_extended_metadata.xsd"   | valid  |
    | players   | players   | "fvc_extended_metadata.xsd"   | valid  |
    | schedules | schedules | "fvc_extended_metadata.xsd"   | valid  |

  @xsd
  Scenario Outline: Verifing API requests against xsd files
    Given  I am using a client device
    When I set the api to <Route>
    And I set the Version to <Version>
    And I set request value to <Request>
    Then the Response Status code should be <RespCode>
    And the xml should be valid against <xsd>

  Examples:
    | RespCode | Route       | Version | Request   | xsd                          |
    | 200      | "services"  | "v0"    | "/1"      | "fvc_extended_metadata.xsd"  |
    | 200      | "services"  | "v0"    | "?nid=1"  | "fvc_extended_metadata.xsd"  |
    | 404      | "players"   | "v0"    | "/1"      | "fvc_extended_metadata.xsd"  |
    | 404      | "schedules" | "v0"    | "/1"      | "fvc_extended_metadata.xsd"  |
