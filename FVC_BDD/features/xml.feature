@XML @Sanity
Feature: Manage XML validation for client device
  As a device client
  I want to verify the xml response
  So that we validate that our connector to work correctly 

  Background:
    Given I am in the "app_dev.php" environment
    And I am using the Behat server "172.28.128.17"
	And I am verifing the "services" API

@xml
  Scenario: Verify XML response detail
	  Given I request a specific xml service
	  When I perform a specific xpath
	  Then I verify it is as expected
