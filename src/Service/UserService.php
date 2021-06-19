<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    
    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }
    
    /**
     * @return User[]
     */
    public function getAllUsers()
    {
        return $this->userRepository->findBy(['isDeleted' => false]);
    }
    
    /**
     * @param string | null $userId
     * @return User
     */
    public function findUserById($userId)
    {
        return $this->userRepository->find($userId);
    }
    
    /**
     * @param User $user
     */
    public function addEditUser($user,UserPasswordEncoderInterface $encoder = null)
    {
        $encodedPassword = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);
        $this->userRepository->addEditUser($user);
    }
    
    /**
     * @param User $user
     */
    public function deleteUser($user)
    {
        $this->userRepository->remove($user);
    }
}