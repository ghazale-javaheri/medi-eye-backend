<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    #[Route('/auth', name: 'app_auth')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthController.php',
        ]);
    }

    #[Route('/auth/login', name: 'auth_login')]
    public function login(ClientRegistry $clientRegistry): Response
    {
//        https://eu-north-1tkxujgdoy.auth.eu-north-1.amazoncognito.com/login?client_id=6punk0lbd110t3cg3v9dhhatcf&response_type=code&scope=email+openid+phone&redirect_uri=http%3A%2F%2Flocalhost%3A3003%2Fauth
//        https://eu-north-1tkxujgdoy.auth.eu-north-1.amazoncognito.com/error?error=redirect_mismatch&client_id=6punk0lbd110t3cg3v9dhhatcf
     return $clientRegistry->getClient('cognito')->redirect();
    }

    #[Route('/auth/callback', name: 'auth_callback')]
    public function callback(Request $request, ClientRegistry $clientRegistry): Response
    {
        $client = $clientRegistry->getClient('cognito');

        try {
            $user = $client->fetchUser(); // Fetch user from Cognito /userinfo endpoint
            $userInfo = $user->toArray();

            return $this->json([
                'message' => 'Authenticated!',
                'user' => $userInfo,
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }

}
