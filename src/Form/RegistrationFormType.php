<?php

namespace App\Form;

use App\Entity\Departements;

use App\Entity\RCusers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'attr' => [
                'class' => 'inputs form-control'],
                'label' =>'E-mail'
                 
                ])

            ->add('nom',TextType::class, ['attr' => [
                'class' => 'inputs form-control'],
                'label' =>'Nom'
                ])

            ->add('prenom',TextType::class,['attr' => [
                'class' => 'inputs form-control'],
                'label' =>'Prénom'
                ])

            ->add('departement',EntityType::class, [
                'class' => Departements::class,
                'choice_label' => 'nom_D',
                'label' =>'Département',
               
                'attr' => [
                    'class' => 'inputs form-control'],
                    
                    ])

            ->add('rgbdConsent', CheckboxType::class, [
                'label' =>'En m\'inscrivant à ce site j\'accepte  les conditions générales d\'utilisation....',
                'attr' => [
                    'class' => ' form-check-input',
                                                        ],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' =>'Mot de passe',
                
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password' ,
                            'class' => 'inputs form-control'    ],
                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RCusers::class,
        ]);
    }
}
