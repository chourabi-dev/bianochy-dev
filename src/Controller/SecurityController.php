<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }



/*
    #[Route(path: '/login/create-admin-account', name: 'create_admin_account')]
    public function create_admin_account( UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em ): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEmail('admin@sentalia.online');
        $password='4567gf(-è';
        $hashedPassword = $userPasswordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $em->persist($user);
        $em->flush();


        return $this->redirectToRoute('app_main');
        
    }*/

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
