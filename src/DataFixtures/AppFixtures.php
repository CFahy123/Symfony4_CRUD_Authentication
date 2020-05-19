<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\Internet;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Article;

class AppFixtures extends Fixture
{

    private $faker;
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {

        $this->faker = Factory::create();
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadArticles($manager);
    }

    public function loadUsers(ObjectManager $manager) {
        $roles = [USER::ROLE_USER,USER::ROLE_ADMIN];

        for ($i = 0; $i<10; $i++) {
            $user = new User();
            $user->setUsername($this->faker->userName);
            $user->setEmail($this->faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user,'password123'));
            $user->setRoles([$roles[rand(0,1)]]);
            $user->setFullName($this->faker->name);

            $this->addReference("user_$i", $user);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function loadArticles(ObjectManager $manager) 
    {
        for ($i=0; $i <10; $i++) {
            $article = new Article();
            $article->setTitle($this->faker->sentence());
            $article->setBody($this->faker->paragraph());

            $user = $this->getReference("user_".rand(0,9));
            $article->setAuthor($user);

            $manager->persist($article);
        }

        $manager->flush();
    }
}
