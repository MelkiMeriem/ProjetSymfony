<?php

namespace App\Controller;

use App\Entity\Campaigns;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/users', name: 'app_admin_showUsers')]
    public function showUsers(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findAll();
        return $this->render('admin/showUsers.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/campaigns/id{id<\d+>?0}/userId{userId<\d+>?0}', name: 'app_admin_showCampaigns')]
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


    #[Route('/funds', name: 'app_admin_showFunds')]
    public function showFunds(ManagerRegistry $doctrine): Response
    {
        //$fund = $doctrine->getRepository(Funds::class)->findAll();
        return $this->render('admin/showFunds.html.twig', []);
    }
}
