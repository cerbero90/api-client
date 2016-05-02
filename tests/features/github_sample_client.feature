Feature: GitHub client
  In order to call GitHub v3 endpoints
  As a developer
  I need to create an HTTP client

  Scenario: User's followers endpoint
    Given I have an implementation of GitHub APIs "v3"
    When I call the endpoint to show the user "cerbero90" followers
    Then I should see a correct response

  Scenario: User's gists endpoint
    Given I have an implementation of GitHub APIs "v3"
    When I call the endpoint to show the user "cerbero90" gists
    Then I should see a correct response

  Scenario: Asynchronous call
    Given I have an implementation of GitHub APIs "v3"
    When I asynchronously call the endpoint to show the user "cerbero90" gists
    Then I should see a promise as a response

  Scenario: JSON response
    Given I have an implementation of GitHub APIs "v3"
    When I call the endpoint to show the user "cerbero90" gists as a JSON
    Then I should see a correct JSON response

  Scenario: Array response
    Given I have an implementation of GitHub APIs "v3"
    When I call the endpoint to show the user "cerbero90" gists as an array
    Then I should see a correct array response
