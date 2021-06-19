<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('dawood@gmail.com');
        $user->setUsername('David Masseh');
        $user->setJobTitle('Sweeper');
        $user->setPhoneNumber('03310306899');
        $user->setBusinessPhone('03310306899');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
        'Dawood123'
        ));
        $manager->persist($user);
        $manager->flush();
        
    }
}
