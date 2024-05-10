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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Security;

class CreateCampaignController extends AbstractController
{
    #[Route('/createcampaign', name:'createcampaign')]
    #[IsGranted("ROLE_USER")]

    public function create(Request $request,Security $security ,SluggerInterface $slugger ,EntityManagerInterface $entityManager) : Response
    {
        $campaigns = new Campaigns();
        $form = $this->createForm(CampaignsType::class, $campaigns);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $security->getUser();
            $campaigns->setOwnerId($user);
            $entityManager->persist($campaigns);
            $Image = $form->get('Image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($Image) {
                $originalFilename = pathinfo($Image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$Image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $Image->move(
                        $this->getParameter('campaigns_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $campaigns->setImage($newFilename);
            }

            $entityManager->flush();
            $this->addFlash('campaign_success', 'campaign created');
            return $this->redirectToRoute('PrivatePage');
        }

        return $this->render('createcampaign/index.html.twig', [
            'form' => $form->createView(),
              ]);

    }
}
