<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface; // Import EntityManagerInterface
use App\Entity\Campaigns; // Import the Campaign entity

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'Profile_Page')]
    public function show_profile(Security $security, ManagerRegistry $entityManager): Response
    {
        $user = $security->getUser();

        // Fetch campaigns associated with the logged-in user
        $campaigns = $entityManager->getRepository(Campaigns::class)->findBy(['OwnerId' => $user]);

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'fullname' => $user->getFullname(),
            'campaigns' => $campaigns, // Pass campaigns to the template
        ]);
    }
}