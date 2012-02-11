Feature: Previewing article
  As a Content Manager
  I want to preview an article before saving it
  In order to make sure it is displayed correctly

  Scenario: Article form is accessible from the homepage
    Given I go to "/"
     When I follow "Add article"
     Then I should see "Title" input on the article form
      And I should see "Body" textarea on the article form

  Scenario: Article is displayed in a preview area
    Given I go to "/"
      And I follow "Add article"
      And I fill in "Hello Behat!" for "Title"
      And I fill in "BDD is fun" for "Body"
     When I press "Preview"
     Then I should see "Hello Behat!" in the preview area
      And I should see "BDD is fun" in the preview area

  Scenario: Preview is not visible initially
    Given I go to "/"
      And I follow "Add article"
     Then the preview area should not be visible
