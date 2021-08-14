<?php

namespace App\Service;

use App\Entity\Audio;
use App\Entity\Customer;
use App\Entity\InsuranceCompany;
use App\Entity\User;
use App\Repository\AudioRepository;
use Symfony\Component\Validator\Constraints\Time;

/**
 * Class AudioService
 * @package App\Service
 * @property AudioRepository audioRepository
 */
class AudioService
{
    /**
     * AudioService constructor.
     * @param AudioRepository $audioRepository
     */
    public function __construct(
        AudioRepository $audioRepository
    ) {
        $this->audioRepository = $audioRepository;
    }
    
    /**
     * @param int $userId
     * @param string $audioTypeId
     * @param string $audioType
     * @return int|string
     */
    public function createFileName(int $userId, string $audioTypeId, string $audioType)
    {
        // audio type is basically differentiate between tag, user and insurance
        return $userId . $audioTypeId . $audioType;
    }
    
    /**
     * @param string $tagId
     * @param User $user
     * @return array
     */
    public function getAudio(string $tagId, User $user): array
    {
        return $this->audioRepository->getAudio($tagId, $user);
    }
    
    /**
     * @param array $data
     * @param string $filename
     * @param User $user
     */
    public function saveAudio(array $data, string $filename, User $user)
    {
        $audio = $this->audioRepository->getAudio($data['tagId'], $user);
        if (!$audio) {
            $this->audioRepository->saveAudio($data, $filename, $user);
        }
    }
    
    /**
     * @param Customer $customer
     * @param User $user
     * @param string $filename
     */
    public function saveCustomerAudio(Customer $customer, User $user, string $filename)
    {
        if (!$customer->getAudio()) {
            $this->audioRepository->saveCustomerAudio($customer, $user, $filename);
        }
    }
    
    /**
     * @param InsuranceCompany $insuranceCompany
     * @param User $user
     * @param string $filename
     */
    public function saveInsuranceAudio(InsuranceCompany $insuranceCompany, User $user, string $filename)
    {
        if (!$insuranceCompany->getAudio()) {
            $this->audioRepository->saveInsuranceAudio($insuranceCompany, $user, $filename);
        }
    }
}