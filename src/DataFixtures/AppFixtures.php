<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private $faker;
    private $hasherPassword;
    public function __construct(UserPasswordHasherInterface $hasherPassword)
    {
        $this->faker = Factory::create();
        $this->hasherPassword = $hasherPassword;
    }
    public function load(ObjectManager $manager): void
    {
        $this->loadUser($manager);
        $this->loadArticle($manager);
        $this->loadComment($manager);
    }

    public function loadUser(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("zaho@zaho.fr");
        $user->setPassword(
            $this->hasherPassword->hashPassword($user, "12345")
        );
        $user->setRoles(['ROLE_USER']);
        $this->addReference("user", $user); //Set reference

        $manager->persist($user);
        $manager->flush();
    }

    public function loadArticle(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle("article " . $i);
            $article->setImageURL($this->faker->imageUrl($width = 640, $height = 480));
            $article->setUser($this->getReference("user"));

            $this->addReference("article_" . $i, $article); //Set reference
            $manager->persist($article);
        }
        $manager->flush();
    }

    public function loadComment(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $comment = new Comment();
            $comment->setDescription("description " . $i);
            $comment->setArticle($this->getReference("article_" . rand(0, 9)));
            $manager->persist($comment);
        }
        $manager->flush();
    }
}
