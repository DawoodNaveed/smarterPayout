<?php

namespace App\Service;

use App\Entity\Customer;
use App\Entity\User;
use App\Helper\CustomHelper;
use App\Repository\CustomerRepository;

/**
 * Class CustomerService
 * @package App\Service
 * @property CustomerRepository customerRepository
 * @property AudioService $audioService
 * @property AwsS3Service $awsS3Service
 */
class CustomerService
{
    /**
     * CustomerService constructor.
     * @param CustomerRepository $customerRepository
     * @param AudioService $audioService
     * @param AwsS3Service $awsS3Service
     */
    public function __construct(
        CustomerRepository $customerRepository,
        AudioService $audioService,
        AwsS3Service $awsS3Service
    ) {
        $this->customerRepository = $customerRepository;
        $this->audioService = $audioService;
        $this->awsS3Service = $awsS3Service;
    }
    
    /**
     * @param int $customerId
     * @return Customer
     */
    public function getCustomer(int $customerId)
    {
        return $this->customerRepository->find($customerId);
    }
    
    /**
     * @param User $user
     * @param bool $isAudioListingCase
     * @return array|null
     */
    public function getCustomersByUser(User $user, bool $isAudioListingCase = false): ?array
    {
        $customersData = [];
        $customers = $this->customerRepository->getCustomersByUser($user);
        if ($isAudioListingCase) {
            return $customers;
        }
        $isGenericAudioCompleted = $this->audioService->isGenericAudiosCompleted($user);
       
        foreach ($customers as $customer) {
            $insuranceCompany = $customer->getInsuranceCompany();
            $audio = $this->audioService->getCompanyAudio($user, $insuranceCompany);
            
            if ($isGenericAudioCompleted && $customer->getAudio() && $insuranceCompany && $audio) {
                $customer = $customer->toArray(true);
            } else {
                $customer = $customer->toArray();
            }
            array_push($customersData, $customer);
        }
        
        return $customersData;
    }
    
    /**
     * @param User $user
     * @param string $customerId
     * @param string $callDay
     * @return false|string
     */
    public function getAllAudios(User $user, string $customerId, string $callDay)
    {
        $customer = $this->customerRepository->find($customerId);
        try {
            $audioFile = $this->awsS3Service->getPreSignedUrl($customer->getAudio()->getFileName());
            $voiceMailAudio = "<Response>" . "<Play>" . $audioFile. "</Play>";
            $callDayAudios = CustomHelper::AUDIO[$callDay];
            foreach ($callDayAudios as $callDayAudio) {
                if ($callDayAudio === CustomHelper::insuranceCompanyAudio) {
                    $insuranceCompany = $customer->getInsuranceCompany();
                    $audio = $this->audioService->getCompanyAudio($user, $insuranceCompany);
                    $audioFile = $this->awsS3Service->getPreSignedUrl($audio->getFileName());
                    $voiceMailAudio = $voiceMailAudio . "<Play>" . $audioFile. "</Play>";
                } else {
                    $audio = $this->audioService->getAudio($callDayAudio, $user);
                    $audioFile = $this->awsS3Service->getPreSignedUrl($audio->getFileName());
                    $voiceMailAudio = $voiceMailAudio . "<Play>" . $audioFile. "</Play>";
                }
            }
            
            return $voiceMailAudio;
        } catch (\Exception $exception) {
            return false;
        }
    }
}