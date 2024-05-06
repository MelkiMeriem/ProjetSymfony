<?php
// src/Form/CampaignType.php

namespace App\Form;

use App\Entity\Campaigns;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampaignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('CampaignName', TextType::class, [
                'label' => 'Campaign Name',
            ])
            ->add('Description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('Budget', MoneyType::class, [
                'label' => 'Budget',
                // Optional: customize options for the MoneyType
                'currency' => 'USD',
                'scale' => 2,
            ])
            ->add('Image', FileType::class, [
                'label' => 'Image',
                // Optional: customize options for the FileType
                'mapped' => false, // This tells Symfony not to try to map this field to any property on your entity
                'required' => false, // This allows the field to be optional
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Campaigns::class,
        ]);
    }


public function mapDataToForms($viewData, $forms, array $options)
    {
        $campaign = $viewData;

        // Set the data from the entity to the form
        $forms['campaignName']->setData($campaign->getCampaignName());
        $forms['description']->setData($campaign->getDescription());
        $forms['budget']->setData($campaign->getBudget());
        $forms['image']->setData($campaign->getImage());

    }

    // This method ensures that the data from the form is mapped to the entity using setter methods
    public function mapFormsToData($forms, &$viewData)
    {
        $campaign = $viewData;

        // Set the data from the form to the entity
        $campaign->setCampaignName($forms['campaignName']->getData());
        $campaign->setDescription($forms['description']->getData());
        $campaign->setBudget($forms['budget']->getData());
        $campaign->setImage($forms['image']->getData());
    }
}
