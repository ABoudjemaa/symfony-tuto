<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('amine@example.com')
            ->setRoles(['ROLE_USER'])
            ->setUsername('amine')
            ->setPassword($this->hasher->hashPassword($user, '0000'))
            ->setApiToken('1234567890')
            ->setVerified(true);

        $manager->persist($user);
        $manager->flush();
    }
}
