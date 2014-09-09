@API
Feature: Manage requests from client device using API Versioning
  As a Client Device 
  I want to know the API version
  So That I knw it is Comaptible with my infrastructure.


  Background:
    Given I am in the "app_dev.php" environment
    And I am using the Behat server "172.28.128.17"
	And I am verifing the "services" API
@api @Sanity
  Scenario: Requesting a specific Version of API
    Given I am using a client device
  	When I request a service of Version "v0"
  	And I request a service of ID "1"
  	Then I should see the expected service results
  	And the Response Status code should be "200"

  Scenario: Requesting a specific invalid API Version of API
    Given I am using a client device
  	When I request a service of Version "x0"
  	And I request a service of ID "1"
  	Then the Response Status code should be "404"

  Scenario: Requesting a specific incorrect Version of API
    Given I am using a client device
  	When I request a service of Version "v1"
  	And I request a service of ID "2"
  	Then the Response Status code should be "404"
