<?php

namespace App\Form;
use App\Entity\Departements;
use App\Entity\Postes;
use App\Entity\Plateaux;
use Doctrine\ORM\EntityRepository;
use App\Repository\PlateauxRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        


        $builder
            ->add('plateau',EntityType::class, [
           
                'class' => Plateaux::class,
                
                'label' =>'Veuillez sélectionner le numéro du plateau',
                
                'attr' => [
                    'class' => 'form-control'],
                    

                'query_builder' => function (PlateauxRepository $er) use ($options) {
                    return $er->createQueryBuilder('p')
                            ->andWhere('p.departement = :val')
                            ->setParameter('val',  $options['departement']);

                },
                'choice_label' => 'id'

                    ])

           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Postes::class,
            'departement' => null,

        ]);
    }
}
