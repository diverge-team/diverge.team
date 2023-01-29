<?php

namespace App\Controller\Account;

use App\Entity\User;
use App\Form\Account\LoginType;
use App\Repository\UserRepository;
use App\Security\DiscordAuthenticator;
use App\Service\DiscordApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'app_account_security_', host: 'accounts.diverge.local')]
class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function index(DiscordApi $discordApi, Request $request): Response
    {
        $form = $this->createForm(LoginType::class);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $request->getSession()->set(DiscordAuthenticator::DISCORD_AUTH_KEY, true);
            return $this->redirect($discordApi->getAuthorizationUrl(['identify', 'email', 'guilds']));
        }

        return $this->render('account/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/check', name: 'check')]
    public function check(DiscordApi $discordApi, UserRepository $userRepository, Request $request): Response
    {
        $accessToken = $request->get('access_token');

        if (!$accessToken) {
            return $this->render('account/security/check.html.twig');
        }

        $discordUser = $discordApi->fetchUser($accessToken);
        $user        = $userRepository->findOneBy(['discordId' => $discordUser->getId()]);

        if ($user) {
            return $this->redirectToRoute('app_account_security_auth', [
                'access_token' => $accessToken,
            ]);
        }

        $user = new User();
        $user
            ->setAccessToken($accessToken)
            ->setUsername($discordUser->getUsername())
            ->setEmail($discordUser->getEmail())
            ->setDiscordId($discordUser->getId())
        ;

        $userRepository->save($user, true);

        return $this->redirectToRoute('app_account_security_auth', [
            'access_token' => $accessToken,
        ]);
    }

    #[Route('/auth', name: 'auth')]
    public function auth(): Response
    {
        return $this->redirectToRoute('app_home');
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {
        throw new \Exception();
    }
}
