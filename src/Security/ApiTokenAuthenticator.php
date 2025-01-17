<?php

namespace App\Security;

use App\Repository\ApiTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiTokenAuthenticator extends AbstractAuthenticator
{
    private const AUTHORIZATION_HEADER = 'Authorization';
    private $apiTokenRepository;

    public function __construct(ApiTokenRepository $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has(self::AUTHORIZATION_HEADER) &&
            str_starts_with($request->headers->get(self::AUTHORIZATION_HEADER), 'Bearer ');
    }


    public function authenticate(Request $request): Passport
    {
        $authorizationHeader = $request->headers->get(self::AUTHORIZATION_HEADER);

        // Extract the token
        $tokenString = substr($authorizationHeader, 7); // Remove "Bearer " prefix

        // Fetch the token entity from the database
        $apiToken = $this->apiTokenRepository->findOneBy(['token' => $tokenString]);

        if (!$apiToken) {
            throw new CustomUserMessageAuthenticationException('Invalid API Token.');
        }

        // Vérifier si le token est expiré
        if ($apiToken->isExpired()) {
            throw new CustomUserMessageAuthenticationException('API Token has expired.');
        }

        // Create a Passport with the associated User and self-validating credentials
        return new SelfValidatingPassport(new UserBadge($apiToken->getUser()->getUserIdentifier()));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
        // TODO: Implement onAuthenticationSuccess() method.
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['message' => $exception->getMessageKey()], Response::HTTP_UNAUTHORIZED);
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        throw new \Exception('Not used: entry_point from other authentication is used');
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }
}
