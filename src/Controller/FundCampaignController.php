<?php

namespace App\Controller;

use App\Entity\Campaigns;
use App\Entity\User;
use App\Form\FundType;
use App\Entity\Fund;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class FundCampaignController extends AbstractController
{
    #[Route('/FundCampaign/{id}' ,name: 'FundCampaign') ]
    public function FundCampaign(ManagerRegistry $doctrine,UserPasswordHasherInterface $hashing,Request $request ,$id):Response
    {
        $campaignId = $request->attributes->get('id');

        $fund=new Fund();
        $form=$this->createForm(FundType::class,$fund,
            ['campaignId' => $campaignId,]);
        $form->remove('Date');

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user=$doctrine->getRepository(User::class)->findOneByemail($fund->getUserEmail());

            if ($fund->getUserPassword() == $user->getPassword()) {

            $fund->setUserPassword(
                $hashing->hashPassword(
                    $fund,
                    $form->get('UserPassword')->getData()
                )
            );

            $manager=$doctrine->getManager();
            $fund->setCampainId($doctrine->getRepository(Campaigns::class)->find($campaignId));
            $fund->setUserId($user);
            $manager->persist($fund);
            $manager->flush();
            return $this->redirectToRoute('main');}
            else{
                $this->addFlash('error','Mot de passe invalide');
               return $this->redirectToRoute('FundCampaign',['id'=>$campaignId]);
            }
        }
        else {
            return $this->render("FundCampaign/FundCampaign.html.twig", ['form' => $form->createView()]);
        }
    }


}
