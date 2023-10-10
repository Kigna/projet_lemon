<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evenements;
use App\Form;
use App\Form\EvenementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Utilisateurs; 
use Symfony\Component\HttpFoundation\Request;





class EvenementController extends AbstractController
{
    #[Route('/evenements', name: 'app_evenement')]
    public function index(): Response
    {
        //ajouter un evenement
       
        return $this->render('evenement/index.html.twig');
    }

    #[Route('/add_evenement', name: 'app_add_evenement')]
    public function add_evenement(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
    {
        //ajouter un evenement
        $evenement = new Evenements();

    // Créez le formulaire en désactivant le jeton CSRF
    $formEvenement = $this->createForm(EvenementType::class, $evenement, [
        'csrf_protection' => false,
    ]);

    // on traite le formulaire
    $formEvenement->handleRequest($request);

    if ($formEvenement->isSubmitted() && $formEvenement->isValid()) {
        // Récupérez l'utilisateur avec l'ID égal à 8 depuis la base de données
        $idUser = 8;
        $utilisateur = $em->getRepository(Utilisateurs::class)->find($idUser);

        if ($utilisateur) {
            // Affectez l'utilisateur à la propriété `createur` de l'événement
            $evenement->setCreateur($utilisateur);

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
            throw new \Exception("L'utilisateur avec l'ID 8 n'a pas été trouvé.");
        }
    }
        


       
        return $this->render('evenement/add_evenement.html.twig', compact('formEvenement'));
    }

    
    //Modification d'un évenement

    #[Route('/edit_evenement/{id}', name: 'app_edit_evenement')]
    public function edit_evenement(Utilisateurs $utilisateur, Request $request, EntityManagerInterface $em, SessionInterface $session, Evenements $evenement): Response
    {
        

    // Créez le formulaire en désactivant le jeton CSRF
    $formEvenement = $this->createForm(EvenementType::class, $evenement, [
        'csrf_protection' => false,
    ]);

    // on traite le formulaire
    $formEvenement->handleRequest($request);

    if ($formEvenement->isSubmitted() && $formEvenement->isValid()) {
        // Récupérez l'utilisateur avec l'ID égal à 8 depuis la base de données
        $idUser = 8;
        $utilisateur = $em->getRepository(Utilisateurs::class)->find($idUser);

        if ($utilisateur) {
            // Affectez l'utilisateur à la propriété `createur` de l'événement
            $evenement->setCreateur($utilisateur);

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
            throw new \Exception("L'utilisateur avec l'ID 8 n'a pas été trouvé.");
        }
    }
        


       
        return $this->render('evenement/edit_evenement.html.twig', compact('formEvenement'));
    }


    
}
