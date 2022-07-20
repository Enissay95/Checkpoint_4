<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
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
            $user->setRole(['ROLE_USER']);
            $user->setLastname($faker->lastName());
            $user->setFirstname($faker->firstName());
            $user->setPhone($faker->phoneNumber()); 
            $user->setBiography($faker->paragraph());
            $user->setComment($this->getReference('COMMENT_' . $faker->numberBetween(11, 13)));
            $user->setIsVerified(true);
            $this->addReference('USER_' . $faker->unique()->numberBetween(1, 5), $user);

            $manager->persist($user);
        }
        
        $user = new User();
        $user->setEmail('med@gmail.com');
        $user->setRole(['ROLE_ADMIN']);
        $password = $this->hasher->hashPassword($user, 'med');
        $user->setPassword($password);
        $user->setLastname('yassine');
        $user->setFirstname('med');
        $user->setPhone('+33 6 25 23 26 02');
        $user->setBiography($faker->paragraph());
        $user->setIsVerified(true);
        $user->setComments($this->getReference('COMMENT_' . $faker->numberBetween(11, 13)));
        $manager->persist($user);




        $manager->flush();
    }

    
    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          CommentFixtures::class,
        ];
    }
}
