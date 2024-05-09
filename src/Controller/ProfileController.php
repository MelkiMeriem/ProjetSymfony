<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'Profile_Page')]
    public function show_profile(Security $security): Response
    {   $user = $security->getUser();
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'fullname'=> $user->getFullname()
        ]);
    }
}
