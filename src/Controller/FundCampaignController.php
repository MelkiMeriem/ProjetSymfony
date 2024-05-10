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
use Symfony\Component\Security\Core\Security;



class FundCampaignController extends AbstractController
{
    private $hash;
    private $security;

    public function __construct(UserPasswordHasherInterface $hash, Security $security)
    {
        $this->hash = $hash;
        $this->security = $security;
    }

    #[Route('/FundCampaign/{id}' ,name: 'FundCampaign') ]
    public function FundCampaign(ManagerRegistry $doctrine,UserPasswordHasherInterface $hashing,Request $request ,Security $security):Response
    {
        $currentUser = $this->security->getUser();

        $campaignId = $request->attributes->get('id');
        $campaign=$doctrine->getRepository(Campaigns::class)->find($campaignId);

        $fund=new Fund();
        $form=$this->createForm(FundType::class,$fund,
             ['campaignId' => $campaignId,]
              );
        $form->remove('Date');

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $enteredPassword = $form->get('UserPassword')->getData();


            if ($this->hash->isPasswordValid($currentUser, $enteredPassword))  {
            $fund->setUserPassword(
                $hashing->hashPassword(
                    $fund,
                    $form->get('UserPassword')->getData()
                )
            );

            $manager=$doctrine->getManager();
            $fund->setCampainId($campaign);
            $fund->setUserId($currentUser);
            $fund->setUserEmail($currentUser->getEmail());
            $fund->setDate(new \DateTime('now'));
            $manager->persist($fund);
            $campaign->setBudget($campaign->getBudget() + $fund->getAmount());
            $manager->persist($campaign);

            $manager->flush(); $this->addFlash('success','fund effectué avec succès');

                return $this->redirectToRoute('PrivatePage');

            }
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
