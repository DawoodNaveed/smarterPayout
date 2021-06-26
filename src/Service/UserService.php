<?php

namespace App\Service;

use App\Entity\User;
use App\Helper\CustomHelper;
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
     * @param $searchKey
     */
    public function findOneBy($searchKey)
    {
        return $this->userRepository->findOneBy($searchKey);
    }
    
    /**
     * @param User $user
     */
    public function addEditUser($user)
    {
        $this->userRepository->addEditUser($user);
    }
    
    /**
     * @param User $user
     */
    public function deleteUser($user)
    {
        $this->userRepository->remove($user);
    }
    
    /**
     * @param User $user
     * @param string $resetPasswordToken
     * @param string $expireDateTime
     * @return bool
     */
    public function validateResetPasswordLink(User $user, string $resetPasswordToken, string $expireDateTime)
    {
        if ($user->getResetPasswordToken() != $resetPasswordToken) {
            return false;
        }
        if (date(CustomHelper::DATE_FORMAT) > $expireDateTime)
        {
            return false;
        }
        return true;
    }
}