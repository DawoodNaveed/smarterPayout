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
 * @property AwsS3Service awsS3Service
 */
class AudioService
{
    const GENERIC_TAGS = ['1(B)', '1(C)', '1(D)', '2(B)', '3(B)'];
    
    /**
     * AudioService constructor.
     * @param AudioRepository $audioRepository
     * @param AwsS3Service $awsS3Service
     */
    public function __construct(
        AudioRepository $audioRepository,
        AwsS3Service $awsS3Service
    ) {
        $this->audioRepository = $audioRepository;
        $this->awsS3Service = $awsS3Service;
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
    
    /**
     * @param null|array $params
     * @param User $user
     * @return null|array
     */
    public function getGenericTagAudios($params, User $user): ?array
    {
        foreach (AudioService::GENERIC_TAGS as $GENERIC_TAG)
        {
            $audio = $this->audioRepository->getAudio($GENERIC_TAG, $user);
            if ($audio) {
                $params[$GENERIC_TAG] = $this->awsS3Service->getPreSignedUrl($audio[0]->getFileName());
            }
        }
        
        return $params;
    }
    
    /**
     * @param null|array $params
     * @param Customer $customer
     * @return null|array
     */
    public function getInsuranceCompanyAudio(array $params, Customer $customer): ?array
    {
        if ($customer->getInsuranceCompany()) {
            $insuranceCompany = $customer->getInsuranceCompany();
            if ($insuranceCompany->getAudio()) {
                $params['insuranceCompanyAudio'] = $this->awsS3Service->getPreSignedUrl($insuranceCompany->getAudio()->getFileName());
            }
        }
        
        return $params;
    }
}
