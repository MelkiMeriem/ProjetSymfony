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
    #[Route('/FundCampaign/{id?0}' ,name: 'FundCampaign') ]
    public function FundCampaign(ManagerRegistry $doctrine,Request $request ,$id):Response
    {
        // Assuming you get the campaign ID from the route or elsewhere
        $campaignId = $request->attributes->get('id');

        $fund=new Fund();
        $form=$this->createForm(FundType::class,$fund,[// Pass campaign ID as an option
            'campaignId' => $campaignId,]);
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
