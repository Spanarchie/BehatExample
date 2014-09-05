Feature: Manage requests to/from SeaChange
  In order our connector to work correctly 
  As a SeaChange client
  I want to send a single request for each data request.


  Scenario: Requesting a single Episode for a series
    Given I am using the SeaChange device
	When I request a specific service
	Then I should see the expected service results
