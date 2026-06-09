<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Jeu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        //fixtures Utilisateurs 
        $admin = new User();
        $admin->setEmail('admin@esportify.fr');
        $admin->setPseudo('Admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin,'Admin123!'));
        $manager->persist($admin);

        $organisateur = new User();
        $organisateur->setEmail('orga@esportify.fr');
        $organisateur->setPseudo('organisateur');
        $organisateur->setRoles(['ROLE_ORGANISATEUR','ROLE_JOUEUR']);
        $organisateur->setPassword($this->passwordHasher->hashPassword($organisateur,'Orga123!'));
        $manager->persist($organisateur);

        $joueur = new User();
        $joueur->setEmail('joueur@esportify.fr');
        $joueur->setPseudo('joueur');
        $joueur->setRoles(['ROLE_JOUEUR']);
        $joueur->setPassword($this->passwordHasher->hashPassword($joueur,'Joueur123!'));
        $manager->persist($joueur);
        
        //Fixtures Jeux
        $valorant = new Jeu();
        $valorant->setNom('Valorant');
        $valorant->setDescription('Jeu de tir tactique en équipe.');
        $valorant->setEditeur('Riot Games');
        $manager->persist($valorant);

        $lol = new Jeu();
        $lol->setNom('League of Legends');
        $lol->setDescription('Jeu compétitif de type MOBA.');
        $lol->setEditeur('Riot Games');
        $manager->persist($lol);

        $rocketLeague = new Jeu();
        $rocketLeague->setNom('Rocket League');
        $rocketLeague->setDescription('Jeu mêlant football et véhicules.');
        $rocketLeague->setEditeur('Psyonix');
        $manager->persist($rocketLeague);

        $cs2 = new Jeu();
        $cs2->setNom('Counter-Strike 2');
        $cs2->setDescription('Jeu de tir compétitif en équipe.');
        $cs2->setEditeur('Valve');
        $manager->persist($cs2);

        $fortnite = new Jeu();
        $fortnite->setNom('Fortnite');
        $fortnite->setDescription('Jeu multijoueur compétitif de type battle royale.');
        $fortnite->setEditeur('Epic Games');
        $manager->persist($fortnite);

        $manager->flush();
    }
}
