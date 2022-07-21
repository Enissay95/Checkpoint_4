<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $article = new Article();
            $article->setTitle($faker->title());
            $article->setContent($faker->text());
            $article->setTags($faker->word());
            $article->setAdTime($faker->dateTime());
            $article->setUser($this->getReference('USER_' . $faker->unique()->numberBetween(1, 5)));
            $this->addReference('ARTICLE_' . $faker->unique()->numberBetween(6, 10), $article);
            $manager->persist($article);
        }
        
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          UserFixtures::class,
        ];
    }

    
}
