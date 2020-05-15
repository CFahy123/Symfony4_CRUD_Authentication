<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    const USERS = [
        [
            'username' => 'airjordan',
            'email' => 'michael@nba.com',
            'password' => 'password123',
            'fullname' => 'Michael Jordan',
            'roles' => [USER::ROLE_USER]
        ],
        [
            'username' => 'larrylegend',
            'email' => 'larry@nba.com',
            'password' => 'password123',
            'fullname' => 'Larry Bird',
            'roles' => [USER::ROLE_USER]
        ],
        [
            'username' => 'magic_man33',
            'email' => 'magic@nba.com',
            'password' => 'password123',
            'fullname' => 'Earvin Johnson',
            'roles' => [USER::ROLE_USER]
        ],
        [
            'username' => 'conor',
            'email' => 'conor@berlin.com',
            'password' => 'password123',
            'fullname' => 'Conor Fahy',
            'roles' => [USER::ROLE_ADMIN]
        ]
    ];

    private $passwordEncoder;
    

    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
         
         foreach (self::USERS as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setPassword($this->passwordEncoder->encodePassword($user,$userData['password']));
            $user->setRoles($userData['roles']);
            $user->setFullName($userData['fullname']);
            $manager->persist($user);
         }
         $manager->flush(); 
         
    }
}
