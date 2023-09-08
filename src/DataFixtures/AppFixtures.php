<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker;
use App\Entity\Bien;
use App\Entity\FoodTruck;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        // ------------ VILLES ------------

        for($i = 0; $i < 10; $i++){
            $ville = new Ville();
            $ville->setNom($faker->city);
            $ville->setCodePostal($faker->postcode);
            $manager->persist($ville);
        }

        // ------------ FOOD TRUCK ------------

        $foodTruck = new FoodTruck();
        $foodTruck->setNom('La cuisine de Mama');
        $foodTruck->setTypeCuisine('Française');
        $manager->persist($foodTruck);

        // ------------ BIENS ------------

        $bien = new Bien();
        $bien->setNom('Appart T2');
        $bien->setPrix(5000);
        $bien->setDateDispo(new \DateTime('2023-12-12'));
        $bien->setVille($ville);
        $bien->setAvecJardin(true);
        $manager->persist($bien);

        // ------------ USER ------------

        $user = new User();
        $user->setPrenom("Alan");
        $user->setNom("PL");
        $user->setEmail("admin@admin.fr");
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                "123"
            )
        );
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);

        $user = new User();
        $user->setPrenom("Bob");
        $user->setNom("Le Bricoleur");
        $user->setEmail("bob@admin.fr");
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                "123"
            )
        );
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);


        $manager->flush();
    }
}
