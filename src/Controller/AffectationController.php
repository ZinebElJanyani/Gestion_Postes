<?php

namespace App\Controller;

use App\Entity\Postes;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\Plateaux;
use App\Entity\Affectation;
use App\Entity\EmployeeUsers;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AffectationController extends AbstractController
{
    #[Route('/affectation', name: 'RC_affectation')]
    public function affecter(ManagerRegistry $doctrine,Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $departement= $user->getDepartement();
        
        $employes = $departement->getEmployeeUsers();
        $plateaux= $doctrine->getRepository(Plateaux::class)->findByExampleField($user->getDepartement());
        
        if($request->request->count()>0){
            
            $Affectation = new Affectation();
            $poste= $doctrine->getRepository(Postes::class)->findOneBySomeField($request->request->get('poste'));
            $employe= $doctrine->getRepository(EmployeeUsers::class)->findOneBySomeField($request->request->get('employe'));
           
            $Affectation->setEmploye($employe)
                ->setPoste($poste)
                ->setDateAffectation(new \DateTimeImmutable());
            
        $entityManager = $doctrine->getManager();
        $entityManager->persist($Affectation);
        $entityManager->flush();
        return $this->redirectToRoute('RC_affectation');
            
    }
        return $this->render('RC/affecte_RC.html.twig', [
            'controller_name' => 'AffectationController',
            'employes' =>$employes,
            'plateaux' =>$plateaux
        ]);
    }

    #[Route('/AFFECshow', name: 'RC_showAFFEC')]
    public function showAffectation(ManagerRegistry $doctrine,Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $departement= $user->getDepartement();
       
        $affectations = $doctrine->getRepository(Affectation::class)->findAll();

        return $this->render('RC/affectations_RC.html.twig', [
            'controller_name' => 'AffectationController',
            'affectations' =>$affectations,
            'departement' =>$departement
        ]);
    }

    #[Route('/AFFecdelete{id}', name: 'RC_supprimerA')]
    public function suppEMP(int $id ,ManagerRegistry $doctrine){
        $entityManager = $doctrine->getManager();
    
        $affectations = $doctrine->getRepository(Affectation::class)->deleteNumber($id);

        return $this->redirectToRoute('RC_showAFFEC');

    }

    #[Route('/postesINFO', name: 'RC_postesINFO')]
    public function postesINFO(ManagerRegistry $doctrine){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $entityManager = $doctrine->getManager();
        $plateaux= $doctrine->getRepository(Plateaux::class)->findByExampleField($user->getDepartement());
        $postes = array();
        foreach($plateaux as $plateau ){
            $valeurs=  $doctrine->getRepository(Postes::class)->findByExampleField($plateau);
           foreach ($valeurs as  $valeur) {
            $postes[]=$valeur;
           }
           
        }
       
        return $this->render('RC/posteINFO_RC.html.twig', [
            'controller_name' => 'AffectationController',
            'postes' =>$postes,
            
        ]);

    }

}
