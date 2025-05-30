Feature: User authentication via Cognito

    Scenario: User logs in successfully
        Given I am on "/auth/login"
        Then I should be redirected to Cognito's login page

