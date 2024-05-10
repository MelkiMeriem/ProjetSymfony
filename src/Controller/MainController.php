<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserFormType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\Campaigns;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    #[Route('/main', name: 'main')]
    #[Route('/')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/PrivatePage' ,name: 'PrivatePage') ]
    public function PrivatePage(ManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $campaigns = $doctrine->getRepository(Campaigns::class)->findAll();

        return $this->render("PrivatePage/PrivatePage.html.twig", [
            'campaigns' => $campaigns,
        ]);

    }


}
