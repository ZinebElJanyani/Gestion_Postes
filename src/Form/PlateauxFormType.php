<?php

namespace App\Form;

use App\Entity\Plateaux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PlateauxFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('depart',TextType::class, [
            'label' =>'Département',
            // readonly if we're in edit mode

            'attr' => [
                'readonly' => true,
                'class' => 'form-control ',
                 ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plateaux::class,
        ]);
    }
}
