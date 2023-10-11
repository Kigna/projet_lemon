<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Evenements;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EvenementType;
use App\Entity\Utilisateurs;

class MainController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        $entityManager = $this->doctrine->getManager();
        // ordre par date la plus récemment consultée 
        $evenements = $entityManager->getRepository(Evenements::class)->findBy([], ['dateDebut' => 'ASC']);
        // on va retirer tous les evenements qui sont passés current date
        $evenements = array_filter($evenements, function ($evenement) {
            return $evenement->getDateDebut() > new \DateTime();
        });




        return $this->render('main/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }

     
    #[Route("/inscrire/{id}", name: "app_inscrire")]
    public function inscrire(Evenements $evenement, Request $request, SessionInterface $session): RedirectResponse
    {
        
        // Récupérez l'utilisateur connecté
        $user = $this->getUser();

        // Vérifiez si l'utilisateur existe et n'est pas déjà inscrit à l'événement
        if ($user && !$evenement->getUtilisateurs()->contains($user)) {
            // Ajoutez l'utilisateur à l'événement
            $evenement->addUtilisateur($user);

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();
        }
         $session->getFlashBag()->add('success', 'Vous vous êtes inscrit à cet évenement');

        return $this->redirectToRoute('accueil');
    }

  
    
     #[Route("/desinscrire/{id}", name: "app_desinscrire")]
    public function desinscrire(Evenements $evenement, Request $request , SessionInterface $session): RedirectResponse
    {
        
        // Récupérez l'utilisateur connecté
        $user = $this->getUser();

        // Vérifiez si l'utilisateur existe et est inscrit à l'événement
        if ($user && $evenement->getUtilisateurs()->contains($user)) {
            // Retirez l'utilisateur de l'événement
            $evenement->removeUtilisateur($user);

             $entityManager = $this->doctrine->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();
        }
         $session->getFlashBag()->add('success', "Vous vous êtes désinscrit à cet évenement");

        return $this->redirectToRoute('accueil');
    }

     #[Route("/logout", name: "app_logout")]
    public function logout(): void
    {
        $this->dispatchMessage('security.logout');
    }
}
