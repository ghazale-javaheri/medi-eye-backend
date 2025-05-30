<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthControllerTest extends WebTestCase
{
    public function testLoginRedirectsToCognito()
    {
        $client = static::createClient();
        $client->request('GET', '/auth/login');

        $response = $client->getResponse();

        $this->assertTrue($response->isRedirect(), 'Expected a redirect response');

        $redirectUrl = $response->headers->get('Location');
        $this->assertStringContainsString('amazoncognito.com/oauth2/authorize', $redirectUrl, 'Redirect URL should point to Cognito');
    }
}
