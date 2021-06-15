<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

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
        return $this->userRepository->findAll();
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
    public function addOrEditUser($user)
    {
        $this->userRepository->addOrEditUser($user);
    }
}