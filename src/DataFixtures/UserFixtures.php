<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;


class UserFixtures extends Fixture implements FixtureGroupInterface
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $password = $this->hasher->hashPassword($user, $faker->password());
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            $user->setLastname($faker->lastName());
            $user->setFirstname($faker->firstName());
            $user->setPhone($faker->phoneNumber()); 
            $user->setBiography($faker->paragraph());
            $user->setIsVerified(true);
            $this->addReference('USER_' . $faker->unique()->numberBetween(1, 5), $user);

            $manager->persist($user);
        }
        
        $user = new User();
        $user->setEmail('med@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        //$password = $this->hasher->hashPassword($user, 'med');
        $user->setPassword('med');        
        $user->setLastname('yassine');
        $user->setFirstname('med');
        $user->setPhone('+33 6 25 23 26 02');
        $user->setBiography($faker->paragraph());
        $user->setIsVerified(true);
        $manager->persist($user);




        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group2'];
    }

}
