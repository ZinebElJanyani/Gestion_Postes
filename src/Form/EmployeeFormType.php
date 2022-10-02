<?php

namespace App\Form;

use App\Entity\EmployeeUsers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class EmployeeFormType extends AbstractType
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

            ->add('depart',TextType::class, [
                'label' =>'Département',
                // readonly if we're in edit mode

                'attr' => [
                    'readonly' => true,
                    'class' => 'form-control ',
                     ]
            ])
            ->add('titre_poste',TextType::class,['attr' => [
                'class' => 'inputs form-control'],
                'label' =>'Titre de poste'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmployeeUsers::class,
        ]);
    }
}
