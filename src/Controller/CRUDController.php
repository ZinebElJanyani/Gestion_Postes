<?php

namespace App\Controller;
use App\Entity\Postes;
use App\Entity\Plateaux;
use App\Entity\Affectation;
use App\Entity\Departements;
use App\Form\PostesFormType;
use App\Entity\EmployeeUsers;
use App\Form\EmployeeFormType;
use App\Form\PlateauxFormType;
use Symfony\Component\Mime\Email;
use App\Service\PasswordGenerator;
use App\Repository\PostesRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\EmployeeUsersRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class CRUDController extends AbstractController
{   
    public ?string $password = null;
    
    
    #[Route('/EMPadd', name: 'RC_ajoutEMP')]
    #[Route('/EMPedit{id}', name: 'RC_modifierEMP')]
    public function index(EmployeeUsers $employe=null,MailerInterface $mailer,UserPasswordHasherInterface $hasher,PasswordGenerator $passwordg,Request $request,ManagerRegistry $doctrine)
     {  
        if(!$employe){
            $employe=new EmployeeUsers();
        }

        $form = $this->createForm(EmployeeFormType::class,$employe);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form->get('depart')->setData($user->getDepartement()->getNomD());

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid() ){
           if(!$employe->getId()){
           
            $password=$passwordg->generateRndomStrongPssword(20);
            $employe->setPassword($hasher->hashPassword($employe, $password));
            $employe->setRoles([]);
            $employe->setDepartement($user->getDepartement());
            
            $email = (new TemplatedEmail())
            ->from('admin@noreplay.com')
            ->to($employe->getEmail())
            ->subject('Création du compte')
            ->htmlTemplate('emails/employe.html.twig')
            ->context([
                'password' =>$password,
                'employe'=>$employe,
                'date' => new \DateTimeImmutable()
            ]);
    
            $mailer->send($email);
        }

            $entityManager = $doctrine->getManager();
            $entityManager->persist($employe);
            $entityManager->flush();
    
            return $this->redirectToRoute('RC_showEMP');
        };
                
        return $this->render('RC\RCajouterEMP.twig', [
            'controller_name' => 'CRUDController',
            'formEmploye' =>$form->createView(),
            'Mode' => $employe->getId() ? 'Modifier' : 'Valider'

        ]);
    }

    #[Route('/show', name: 'app_show')]
    public function show(){
        return $this->render('emails/employe.html.twig', [
            'controller_name' => 'CRUDController' ]
        );
    }

    #[Route('/EMPshow', name: 'RC_showEMP')]
    public function showEMP(){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $departement= $user->getDepartement();
        $employes = $departement->getEmployeeUsers();

        return $this->render('RC/showEMP.html.twig', [
            'controller_name' => 'CRUDController',
            'employes' =>$employes
        ]);
    }
    
    #[Route('/EMPdelete{id}', name: 'RC_supprimerEMP')]
    public function suppEMP(EmployeeUsers $employe,ManagerRegistry $doctrine){
        
        if($employe->getNaffectation()){
            $affectation_id = $employe->getNaffectation()->getId();
            $doctrine->getRepository(Affectation::class)->deleteNumber($affectation_id);
        }
        $employe_id = $employe->getId();
        $doctrine->getRepository(EmployeeUsers::class)->deleteEMP($employe_id);
       
        return $this->redirectToRoute('RC_showEMP');

    }


    #[Route('/POSTE', name: 'RC_showPOSTE')]
    public function showPOSTE(Request $request,ManagerRegistry $doctrine){
        $poste = new Postes();
        
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(PostesFormType::class,$poste,[
            'departement' => $user->getDepartement()->getId()
        ]);

        $form->handleRequest($request);

        $plateau = $form->get('plateau')->getData();
        if($form->isSubmitted() && $form->isValid() ){

            $entityManager = $doctrine->getManager();
            $postes= $doctrine->getRepository(Postes::class)->findByExampleField($plateau->getId());
            if(!$postes){
                $n=1;
            }else{
                $dernierPoste = $postes[count($postes)-1];
            
                $n = $dernierPoste->getNPoste()+1;
          }
          
        $poste->setNPoste($n);
        $plateau->addPoste($poste);
        $entityManager->persist($poste);
        $entityManager->flush();
        }
        $plateaux= $doctrine->getRepository(Plateaux::class)->findByExampleField($user->getDepartement());
       
        return $this->render('RC/postes_RC.html.twig', [
            'controller_name' => 'CRUDController',
            'formPoste' =>$form->createView() ,
            'plateaux' =>$plateaux,
           
            ]
        );
     }
     
    // #[ParamConverter('poste', options: ['id_poste' => 'id'])]
    // #[ParamConverter('plateau', options: ['id_plateau' => 'departement'])]
    #[Route('/POSTEdelete{id}', name: 'RC_suppPOSTE')]

    public function deletePOSTE(Postes $poste,ManagerRegistry $doctrine){            $entityManager = $doctrine->getManager();
           
            $poste->getPlateau()->removePoste($poste);

            if($poste->getNaffectation()){
                $affectation_id = $poste->getNaffectation()->getId();
                $doctrine->getRepository(Affectation::class)->deleteNumber($affectation_id);
            }
            $poste_id = $poste->getId();
            $doctrine->getRepository(Postes::class)->deletePOSTE($poste_id);
            
            
            
            return $this->redirectToRoute('RC_showPOSTE');
        
        }
        
    #[Route('/Plateau', name: 'RC_showPLAT')]
    public function showPLATEAU(Request $request,ManagerRegistry $doctrine){
        $plateau = new Plateaux();
        
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(PlateauxFormType::class,$plateau);

        $form->get('depart')->setData($user->getDepartement()->getNomD());

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid() ){
            $plateau->setDepartement($user->getDepartement());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($plateau);
            $entityManager->flush();
        }
        $plateaux= $doctrine->getRepository(Plateaux::class)->findByExampleField($user->getDepartement());

        return $this->render('RC\Plateaux_RC.twig', [
            'controller_name' => 'CRUDController',
            'formPlateau' =>$form->createView(),
           'plateaux' =>$plateaux

        ]);      
        
    }
   
    #[Route('/Plateaudelete{id}', name: 'RC_suppPLAT')]
    public function deletePLATEAU(Plateaux $plateau,ManagerRegistry $doctrine){            
       
        $postes= $doctrine->getRepository(Postes::class)->findByExampleField($plateau->getId());
        for ($i=0; $i < count($postes); $i++) { 
            
            if($postes[$i]->getNaffectation()){
                $affectation_id = $postes[$i]->getNaffectation()->getId();
                $doctrine->getRepository(Affectation::class)->deleteNumber($affectation_id);
            }
            $poste_id = $postes[$i]->getId();
            $doctrine->getRepository(Postes::class)->deletePOSTE($poste_id);
        }
        
        $doctrine->getRepository(Plateaux::class)->deletePLATEAU($plateau->getId());
                
        return $this->redirectToRoute('RC_showPLAT');
                 
    }


}