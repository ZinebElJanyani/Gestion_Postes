<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
class AppController extends AbstractController
{
    #[Route('/', name: 'app')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('pageInterne_RC', name: 'page_RC')]
    public function showRC(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        
        return $this->render('RC/pageRC_accueil.html.twig', [
                'controller_name' => 'AppController',
                'nom' =>$user->getNom(),
                'prenom' =>$user->getPrenom(),
                'departement'=>$user->getDepartement()->getNomD()


            ]);
    }

    #[Route('pageInterne_EMP', name: 'page_empl')]
    public function showEMP(): Response
    {
        return $this->render('employes/pageEMPLOYE.html.twig', [
            'controller_name' => 'AppController',
        ]);

        
    }

    #[Route('compte_EMP', name: 'compte_empl')]
    public function display(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        
        return $this->render('employes/employeCOMPTE.html.twig', [
            'controller_name' => 'AppController',
            'user' =>$user,
            
        ]);

        
    }
}
