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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CreateCampaignController extends AbstractController
{
    #[Route('/createcampaign', name:'createcampaign')]
    //#[IsGranted("ROLE_USER")]

    public function create(Request $request ,EntityManagerInterface $entityManager) : Response
    {
        $campaigns = new Campaigns();
        $form = $this->createForm(CampaignsType::class, $campaigns);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$user = $this->getUser();
            //$campaigns->setOwnerId($user->getId());
            $entityManager->persist($campaigns);
            $entityManager->flush();
            $this->addFlash('success', 'Campaign created');

            return $this->redirectToRoute('PrivatePage');
        }

        return $this->render('createcampaign/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
