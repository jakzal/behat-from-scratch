Feature: Viewing latest articles
  As a Content Manager
  I want to view a list of latest articles
  In order to see recent updates

  Scenario: Viewing latest articles
    Given following articles were written
      | Title                     | Modification time | Content       |
      | Behat from scratch        | 2 days ago        | Lorem Ipsum 1 |
      | Creating Behat extensions | 3 hours ago       | Lorem Ipsum 2 |
      | Lightning talks           | 5 days ago        | Lorem Ipsum 3 |
      | Case studies              | 15 minutes ago    | Lorem Ipsum 4 |
     When I visit "homepage"
     Then I should see the "Behat from scratch" article
      And I should see the "Creating Behat extensions" article
      And I should see the "Case studies" article
      But I should not see the "Lightning talks" article
