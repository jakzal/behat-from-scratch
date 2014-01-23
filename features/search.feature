Feature: Search
  As a Google User
  I want to search the internetz
  In order to find lolcats

  @javascript
  Scenario: Searching for lolcats
    Given I visited the homepage
     When I search for "lolcats"
     Then I should see a list of "lolcat" websites

  @javascript
  Scenario: Searching for lolcat images
    Given I visited the homepage
      And I search for "lolcats"
     When I change the tab to "Images"
     Then I should see a list of "lolcat" images
