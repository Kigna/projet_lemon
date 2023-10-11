<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Evenements;
use App\Form;
use App\Form\EvenementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Utilisateurs; 
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;





class EvenementController extends AbstractController
{
     private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }


    #[Route('/evenements', name: 'app_evenement')]
    public function index(): Response
    {
        $entityManager = $this->doctrine->getManager();
        // order by most recently accessed datedebut 
        $evenements = $entityManager->getRepository(Evenements::class)->findBy([], ['dateDebut' => 'ASC']);
         $user = $this->getUser();
        //  on verife si l'utilisateur est bien connecter 
        if ($user){
          // on recuper uniquement les evenemenet ou le user courent est createur
            $evenements = array_filter($evenements, function ($evenement) use ($user) {
                return $evenement->getCreateur() === $user;
            });
        } else {
            // on redire ver la page de connexion
            return $this->redirectToRoute('app_login');
        }
         
       
        return $this->render('evenement/index.html.twig' , [
            'evenements' => $evenements,
        ]);
    }

    #[Route('/add_evenement', name: 'app_add_evenement')]
    public function add_evenement(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
    {
         $user = $this->getUser();
        //  on verife si l'utilisateur est bien connecter 
        if (!$user){
          return $this->redirectToRoute('app_login');
        }
        //ajouter un evenement
        $evenement = new Evenements();

    // Créez le formulaire en désactivant le jeton CSRF
    $formEvenement = $this->createForm(EvenementType::class, $evenement, [
        'csrf_protection' => false,
    ]);

    // on traite le formulaire
    $formEvenement->handleRequest($request);

    if ($formEvenement->isSubmitted() && $formEvenement->isValid()) {
       

        if ($user) {
            // Affectez l'utilisateur à la propriété `createur` de l'événement
            $evenement->setCreateur($user);

            // On persiste l'événement
            $em->persist($evenement);
            $em->flush();

            // Ajoutez un message de succès à la session flash
            $session->getFlashBag()->add('success', 'L\'événement a été créé avec succès.');

          $evenement = new Evenements();

            // On redirige vers la page de liste des événements avec le message de succès
            // return $this->redirectToRoute('app_evenement');
        } else {
            // Gestion de l'erreur si l'utilisateur avec l'ID 41 n'est pas trouvé
            throw new \Exception("Une erreur inconnue s'est produite");
        }
    }
        


       
        return $this->render('evenement/add_evenement.html.twig', compact('formEvenement'));
    }

    
    //Modification d'un évenement

    #[Route('/edit_evenement/{id}', name: 'app_edit_evenement')]
    public function edit_evenement(Request $request, EntityManagerInterface $em, SessionInterface $session, Evenements $evenement): Response
    {

          $user = $this->getUser();
        //  on verife si l'utilisateur est bien connecter 
        if (!$user){
          return $this->redirectToRoute('app_login');
        }
        

    // Créez le formulaire en désactivant le jeton CSRF
    $formEvenement = $this->createForm(EvenementType::class, $evenement, [
        'csrf_protection' => false,
    ]);

    // on traite le formulaire
    $formEvenement->handleRequest($request);

    if ($formEvenement->isSubmitted() && $formEvenement->isValid()) {
       

        if ($user) {
            // Affectez l'utilisateur à la propriété `createur` de l'événement
            $evenement->setCreateur($user);

            // On persiste l'événement
            $em->persist($evenement);
            $em->flush();

            // Ajoutez un message de succès à la session flash
            $session->getFlashBag()->add('success', 'L\'événement a été modifier avec succès.');

          $evenement = new Evenements();

            // On redirige vers la page de liste des événements avec le message de succès
            // return $this->redirectToRoute('app_evenement');
        } else {
            // Gestion de l'erreur si l'utilisateur avec l'ID 41 n'est pas trouvé
            throw new \Exception("Une erreur inconnue s'est produite");
        }
    }
        


       
        return $this->render('evenement/edit_evenement.html.twig', compact('formEvenement'));
    }

     #[Route("/app_delete_evenement/{id}", name: "app_delete_evenement")]
    public function delete_evenement(Evenements $evenement, Request $request, SessionInterface $session): RedirectResponse
    {
        
        // Récupérez l'utilisateur connecté
        $user = $this->getUser();

        // verifie si l'utilisateur est le createur de l'evenement
        if ($user && $evenement->getCreateur() === $user) {
            // supprimer l'evenement
            $entityManager = $this->doctrine->getManager();
            $entityManager->remove($evenement);
            $entityManager->flush();
            $session->getFlashBag()->add('success', "Evenement supprimer avec succès");
        } else {
          
            // Gestion de l'erreur si l'utilisateur avec l'ID 41 n'est pas trouvé
            throw new \Exception("Une erreur inconnue s'est produite");
        }
         


        return $this->redirectToRoute('app_evenement');
    }


    
}
