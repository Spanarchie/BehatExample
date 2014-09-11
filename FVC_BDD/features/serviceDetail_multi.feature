@ServiceDetailMulti
Feature: Validating the details returned from a multiple Service Request.
  As a Client Device 
  I want to know the data being returned is correct version
  So That I know it will work as expected.

  Background:
    Given I am in the "app_dev.php" environment
    And I am using the Behat server "172.28.128.17"
	And I am verifing the "services" API

@ServiceInfoAttr
  Scenario Outline: Verifing Service Information (@Attributes)
    Given I am using a client device
    When I request a multi xml service
    And I request a service of Version "v0"
    Then the Response Status code should be "200"
    And the service Information respId should be <RespId>
    And the service information attributes should be <ServiceId>, <XsiType>, <FragmentId>, <FragmentVersion>

  Examples:
    | RespId | ServiceId | XsiType | FragmentId | FragmentVersion |
    | 0      | "12345"   | "null"  | "null"     | "null"          |
    | 1      | "67890"   | "null"  | "null"     | "null"          |


  @sanity
  Scenario Outline: Verifing Service Information (Head/Owner/ServiceURL)
    Given I am using a client device
	When I request a multi xml service
	And I request a service of Version "v0"
	Then the Response Status code should be "200"
    And the service Information respId should be <RespId>
	And the service Information name should be <Name>
	And the service Information owner should be <Owner>
	And the service Information ServiceURL should be <ServiceURL>

	  Examples:
	 | RespId | Name      | Owner         | ServiceURL         |
	 | 0      | Service A | Channel7 Ltd. | dvb://233a..3039   |
	 | 1      | Service B | Channel8 Inc. | dvb://233a..10932  |


  Scenario Outline: Verifing Service Information ServiceGenre (Attributes)
    Given I am using a client device
    When I request a multi xml service
    And I request a service of Version "v0"
    Then the Response Status code should be "200"
    And the service Information respId should be <RespId>
    And the service Information ServiceGenre Attributes should be <Type>, <Href>

    Examples:
    | RespId | Type  | Href                                             |
    | 0      | main  | " urn:dtg:urn:dtg:metadata:cs:DTGGenreCS:2010-11#4" |
    | 1      | main  | " urn:dtg:urn:dtg:metadata:cs:DTGGenreCS:2010-11#4" |


  Scenario Outline: Verifing Service Information RelatedMaterial (Element& Attributes)
    Given I am using a client device
    When I request a multi xml service
    And I request a service of Version "v0"
    Then the Response Status code should be "200"
    And the service Information respId should be <RespId>
    And the service Information RelatedMaterial should be <HowRelated>, <Format>, <PromotionalText>

  Examples:
    | RespId | HowRelated                                 | Format                                   | PromotionalText |
    | 0      | "urn:tva:metadata:cs:HowRelatedCS:2011:19" | "urn:mpeg:mpeg7:cs:FileFormatCS:2001:15" | "Service A"     |
    | 1      | "urn:tva:metadata:cs:HowRelatedCS:2011:19" | "urn:mpeg:mpeg7:cs:FileFormatCS:2001:15" | "Service B"     |



