<?php

namespace App\Form;
use App\Entity\Fund;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\Security;


class FundType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options ): void
    {
        $currentUser = $this->security->getUser();

        $builder
            ->add('CampainId', TextType::class, [ // Use HiddenType for campaign ID
                'data' => $options['campaignId'],
                'disabled' => true,
            ])
            ->add('UserEmail', EmailType::class,
                [
                  'disabled' => true,
                    'data' => $currentUser ? $currentUser->getEmail() : null, // Set default to current user's email if logged in

                ])
            ->add('UserPassword',PasswordType::class, [
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('Date')
            ->add('Amount')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fund::class,
            'campaignId' => null, // Optional default value for campaign ID
        ]);
    }
}
