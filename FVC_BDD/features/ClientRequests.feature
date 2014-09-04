Feature: Manage requests from client devices
  In order to retreive the Program listing
  As a client device
  I want to send a single request for each data request.


  Scenario: Requesting a single Episode for a series
    Given I am using a client device
    When I request a specific episodes by ref
    Then I should see the expected result

  Scenario: Requesting all Episodes for a specific series
    Given I am using a client device
    When I request all episodes of a series
    And for the "#" Series
    And for the known brand 
    Then I should see the expected results

  Scenario: Requesting all Episodes for Brand
    Given I am using a client device
    When I request all episodes of brand
    Then I should see the expected results
