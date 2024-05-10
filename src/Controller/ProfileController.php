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
    #[Route('/campaign/delete/{id}', name: 'delete_campaign')]
    public function deleteCampaign(int $id, EntityManagerInterface $entityManager): Response
    {
        $campaign = $entityManager->getRepository(Campaigns::class)->find($id);

        if (!$campaign) {
            throw $this->createNotFoundException('Campaign not found');
        }

        // Check if the logged-in user is the owner of the campaign
        if ($campaign->getOwnerId() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You are not allowed to delete this campaign');
        }

        $entityManager->remove($campaign);
        $entityManager->flush();

        return $this->redirectToRoute('Profile_Page');
    }
}