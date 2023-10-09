<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evenements;
use Doctrine\Persistence\ManagerRegistry;

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
        // order by most recently accessed datedebut 
        $evenements = $entityManager->getRepository(Evenements::class)->findBy([], ['dateDebut' => 'ASC']);
        // on va retirer tous les evenements qui sont passés current date
        $evenements = array_filter($evenements, function ($evenement) {
            return $evenement->getDateDebut() > new \DateTime();
        });




        return $this->render('main/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }
}
