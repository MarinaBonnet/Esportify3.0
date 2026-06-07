<?php

namespace App\DataFixtures;

use App\Entity\User;
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
        $admin = new User();
        $admin->setEmail('admin@esportify.fr');
        $admin->setPseudo('Admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin,'Admin123!'));
        $manager->persist($admin);

        $organisateur = new User();
        $organisateur->setEmail('orga@esportify.fr');
        $organisateur->setPseudo('organisateur');
        $organisateur->setRoles(['ROLE_ORGANISATEUR']);
        $organisateur->setPassword($this->passwordHasher->hashPassword($organisateur,'Orga123!'));
        $manager->persist($organisateur);

        $joueur = new User();
        $joueur->setEmail('joueur@esportify.fr');
        $joueur->setPseudo('joueur');
        $joueur->setRoles(['ROLE_JOUEUR']);
        $joueur->setPassword($this->passwordHasher->hashPassword($joueur,'Joueur123!'));
        $manager->persist($joueur);
        

        $manager->flush();
    }
}
