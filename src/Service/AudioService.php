<?php

namespace App\Service;

use App\Entity\Audio;
use App\Entity\Customer;
use App\Entity\InsuranceCompany;
use App\Entity\User;
use App\Helper\CustomHelper;
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
     * @return null|Audio
     */
    public function getAudio(string $tagId, User $user)
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
        if (!($this->audioRepository->getAudioByCompanyAndUser($insuranceCompany, $user))) {
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
        foreach (CustomHelper::GENERIC_TAGS as $GENERIC_TAG)
        {
            $audio = $this->audioRepository->getAudio($GENERIC_TAG, $user);
            if ($audio) {
                $params[$GENERIC_TAG] = $this->awsS3Service->getPreSignedUrl($audio->getFileName());
            }
        }
        
        return $params;
    }
    
    /**
     * @param null|array $params
     * @param Customer $customer
     * @param User $user
     * @return null|array
     */
    public function getInsuranceCompanyAudio(array $params, Customer $customer, User $user): ?array
    {
        if ($customer->getInsuranceCompany()) {
            $insuranceCompany = $customer->getInsuranceCompany();
            $insuranceCompanyAudio = $this->audioRepository->getAudioByCompanyAndUser($insuranceCompany, $user);
            if ($insuranceCompanyAudio) {
                $params['insuranceCompanyAudio'] = $this->awsS3Service->getPreSignedUrl($insuranceCompanyAudio->getFileName());
            }
        }
        
        return $params;
    }
    
    /**
     * @param User $user
     * @return bool
     */
    public function isGenericAudiosCompleted(User $user): bool
    {
        foreach (CustomHelper::GENERIC_TAGS as $GENERIC_TAG)
        {
            $audio = $this->audioRepository->getAudio($GENERIC_TAG, $user);
            if (!$audio) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * @param User $user
     * @param InsuranceCompany $insuranceCompany
     * @return Audio|null
     */
    public function getCompanyAudio(User $user, InsuranceCompany $insuranceCompany)
    {
        return $this->audioRepository->findOneBy(['user' => $user, 'insuranceCompany' => $insuranceCompany]);
    }
}
