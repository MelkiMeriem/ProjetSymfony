<?php

namespace App\Controller;

use App\Entity\Campaigns;
use App\Entity\Fund;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/users/id{id<\d+>?0}', name: 'app_admin_showUsers'), isGranted('ROLE_ADMIN')]
    public function showUsers(ManagerRegistry $doctrine, $id): Response
    {
        $constraints = [];
        if ($id !== '0') {
            $constraints['id'] = (int)$id;
        }
        $users = $doctrine->getRepository(User::class)->findBy($constraints);
        return $this->render('admin/showUsers.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/users/delete/{id}', name: 'app_admin_deleteUser'), isGranted('ROLE_ADMIN')]
    public function deleteUser(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        // Redirect to a route after deletion
        return $this->redirectToRoute('app_admin_showUsers');
    }

    #[Route('/campaigns/id{id<\d+>?0}/userId{userId<\d+>?0}', name: 'app_admin_showCampaigns'), isGranted('ROLE_ADMIN')]
    public function showCampaigns(ManagerRegistry $doctrine, $id = null, $userId = null): Response
    {
        $constraints = [];
        if ($id !== '0') {
            $constraints['id'] = (int)$id;
        }
        if ($userId !== '0') {
            $constraints['OwnerId'] = (int)$userId;
        }

        $campaigns = $doctrine->getRepository(Campaigns::class)->findBy($constraints);

        return $this->render('admin/showCampaigns.html.twig', [
            'campaigns' => $campaigns
        ]);
    }

    #[Route('/campaigns/delete/{id}', name: 'app_admin_deleteCampaign'), isGranted('ROLE_ADMIN')]
    public function deleteCampaign(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $campaign = $entityManager->getRepository(Campaigns::class)->find($id);

        if (!$campaign) {
            throw $this->createNotFoundException('Campaign not found');
        }

        $entityManager->remove($campaign);
        $entityManager->flush();

        // Redirect to a route after deletion
        return $this->redirectToRoute('app_admin_showCampaigns');
    }


    #[
        Route('/funds/id{id<\d+>?0}/userId{userId<\d+>?0}/campaignId{campaignId<\d+>?0}',
            name: 'app_admin_showFunds'),
        isGranted('ROLE_ADMIN')
    ]
    public function showFunds(ManagerRegistry $doctrine, $id, $userId, $campaignId): Response
    {
        $constraints = [];
        if ($id !== '0') {
            $constraints['id'] = (int)$id;
        }
        if ($userId !== '0') {
            $constraints['OwnerId'] = (int)$userId;
        }

        if ($campaignId !== '0') {
            $constraints['CampainId'] = (int)$campaignId;
        }

        $funds = $doctrine->getRepository(Fund::class)->findBy($constraints);
        return $this->render('admin/showFunds.html.twig', [
            'funds' => $funds
        ]);
    }

    #[Route('/funds/delete/{id}', name: 'app_admin_deleteFund'), isGranted('ROLE_ADMIN')]
    public function deleteFund(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $fund = $entityManager->getRepository(Fund::class)->find($id);

        if (!$fund) {
            throw $this->createNotFoundException('User not found');
        }

        $entityManager->remove($fund);
        $entityManager->flush();

        // Redirect to a route after deletion
        return $this->redirectToRoute('app_admin_showFunds');
    }
}
