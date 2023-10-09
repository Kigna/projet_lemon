<?php

namespace App\DataFixtures;

use App\Entity\Evenements;
use App\Entity\Utilisateurs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsersAndEvenementsFixtures extends Fixture
{
     public function load(ObjectManager $manager)
     {
          // Génération de 5 utilisateurs
          $users = [];
          for ($i = 0; $i < 5; $i++) {
               $user = new Utilisateurs();
               $user->setEmail('user' . $i . '@kigna.com');
               $user->setPassword(password_hash('password', PASSWORD_DEFAULT));
               $user->setNom('utilisateur ' . $i);

               $manager->persist($user);

               $users[] = $user;
          }

          // Génération de 10 événements
         // Génération de 10 événements
  $evenements = [];
for ($i = 0; $i < 40; $i++) {
    $evenement = new Evenements();
    $evenement->setTitre('Events ' . $i);
    $evenement->setDescription('description pour l\'événement ' . $i);
    
    // Génération d'une date de début aléatoire entre maintenant et 30 jours plus tard
    
    $dateDebut = new \DateTime();
    $dateDebut->modify('+' . rand(0, 30) . ' days');
    $evenement->setDateDebut($dateDebut);

    // Génération d'une date de fin aléatoire entre la date de début et 10 jours plus tard
    $dateFin = clone $dateDebut;
    $dateFin->modify('+' . rand(1, 10) . ' days');
    $evenement->setDateFin($dateFin);

    // Association de l'événement à un utilisateur aléatoire
    $user = $users[array_rand($users)];
    $evenement->setCreateur($user);

    $manager->persist($evenement);

    $evenements[] = $evenement;
}


          // Association aléatoire des utilisateurs aux événements (ManyToMany)
          foreach ($users as $user) {
               $randomEvenements = $evenements;
               shuffle($randomEvenements);
               $randomEvenements = array_slice($randomEvenements, 0, rand(1, count($evenements)));

               foreach ($randomEvenements as $randomEvenement) {
                    $user->addMesEvenement($randomEvenement);
                    $randomEvenement->addUtilisateur($user);
               }

               $manager->persist($user);
          }

          $manager->flush();
     }
}