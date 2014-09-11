@sanity
Feature: Manage requests to/from client device
  In order our connector to work correctly 
  As a SeaChange client
  I want to send a single request for each data request.


  Background:
    Given I am in the "app_dev.php" environment
    And I am using the Behat server "172.28.128.17"
	And I am verifing the "services" API

  Scenario Outline: controlling order
	  Given there are <start> cucumbers
	  When I eat <eat> cucumbers
	  Then I should have <left> cucumbers

	  Examples:
	    | start | eat | left |
	    |  12   |  5  |  7   |

	 
