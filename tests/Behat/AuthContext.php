<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class AuthContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Response|null */
    private $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given I am on :path
     */
    public function iAmOn($path)
    {
        $this->client = static::createClient();
        $this->client->request('GET', $path);
    }

    /**
     * @Then I should be redirected to Cognito's login page
     */
    public function iShouldBeRedirectedToCognito()
    {
        $response = $this->client->getResponse();
        $redirectUrl = $response->headers->get('Location');

        if (!str_contains($redirectUrl, 'amazoncognito.com/oauth2/authorize')) {
            throw new \Exception('Not redirected to Cognito login.');
        }
    }

}
