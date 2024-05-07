<?php

namespace App\Controller;

use App\Entity\Campaigns;
use App\Form\CampaignsType;
use App\Repository\CampaignsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CreateCampaignController extends AbstractController
{
    #[Route('/createcampaign', name:'createcampaign')]

    public function create(Request $request ,EntityManagerInterface $entityManager,SessionInterface $session) : Response
    {
        $campaigns = new Campaigns();
        $form = $this->createForm(CampaignsType::class, $campaigns);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->persist($campaigns);
            $entityManager->flush();


            $session->set('from_create_campaign', true);
            return $this->redirectToRoute('PrivatePage');
        }

        return $this->render('createcampaign/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
