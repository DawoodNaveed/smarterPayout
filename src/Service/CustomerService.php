<?php

namespace App\Service;

use App\Entity\Customer;
use App\Entity\User;
use App\Helper\CustomHelper;
use App\Repository\CustomerRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CustomerService
 * @package App\Service
 * @property CustomerRepository customerRepository
 * @property AudioService $audioService
 * @property AwsS3Service $awsS3Service
 * @property UtilService utilService
 * @property TwilioService twilioService
 */
class CustomerService
{
    /**
     * CustomerService constructor.
     * @param CustomerRepository $customerRepository
     * @param AudioService $audioService
     * @param AwsS3Service $awsS3Service
     * @param UtilService $utilService
     */
    public function __construct(
        CustomerRepository $customerRepository,
        AudioService $audioService,
        AwsS3Service $awsS3Service,
        UtilService $utilService,
        TwilioService $twilioService
    ) {
        $this->customerRepository = $customerRepository;
        $this->audioService = $audioService;
        $this->awsS3Service = $awsS3Service;
        $this->utilService = $utilService;
        $this->twilioService = $twilioService;
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

    /**
     * @param array $criteria
     * @param bool $isDeleted
     * @return Customer|null
     */
    public function findOneBy(array $criteria, bool $isDeleted = false): ?Customer
    {
        return $this->customerRepository->findOneBy(array_merge([$criteria, ['isDeleted' => $isDeleted]]));
    }

    /**
     * @param string $customerId
     * @param string $contactNumber
     * @return false|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function sendOTP(string $customerId, string $contactNumber)
    {
        /** @var Customer $customer */
        $customer = $this->findOneBy(['id' => $customerId]);

        if (!$customer instanceof Customer) {
            return false;
        }

        $authCode = $this->utilService->generateOTP();
        $customer->setContactNumber($contactNumber);
        $customer->setAuthToken($authCode);
        $this->customerRepository->flush();
        $this->twilioService->sendMessage('verificationCode', $contactNumber, ['code' => $authCode]);
    }

    /**
     * @param string $code
     * @param string $customerId
     * @return bool|JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function verifyOTP(string $code, string $customerId)
    {
        /** @var Customer $customer */
        $customer = $this->findOneBy(['id' => $customerId]);

        if (!$customer instanceof Customer) {
            return false;
        }

        if ($customer->getAuthToken() !== $code) {
            return false;
        }

        $customer->setIsAuthenticated(true);
        $this->customerRepository->flush();

        return true;
    }
}
