Feature: Previewing article
  As a Content Manager
  I want to preview an article before saving it
  In order to make sure it is displayed correctly

  Scenario: Article form is accessible from the homepage
    Given I go to "/"
     When I follow "Add article"
     Then I should see "Title" input on the article form
      And I should see "Body" textarea on the article form
