<?php

namespace App\Controller;

use App\Form\FundType;
use App\Entity\Fund;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FundCampaignController extends AbstractController
{
    #[Route('/FundCampaign' ,name: 'FundCampaign') ]
    public function FundCampaign(ManagerRegistry $doctrine,Request $request ):Response
    {
        $fund=new Fund();
        $form=$this->createForm(FundType::class,$fund);
        $form->remove('Date');

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager=$doctrine->getManager();
            $manager->persist($fund);
            $manager->flush();
            return $this->redirectToRoute('main');
        }
        else {
            return $this->render("FundCampaign/FundCampaign.html.twig", ['form' => $form->createView()]);
        }
    }


}
