<?php

namespace App\Service;

use App\Controller\TwilioController;
use App\Entity\Customer;
use App\Entity\InsuranceCompany;
use App\Entity\ListDetail;
use App\Entity\User;
use App\Helper\CustomHelper;
use App\Repository\CustomerRepository;
use App\Repository\ListDetailRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CustomerService
 * @package App\Service
 * @property CustomerRepository customerRepository
 * @property AudioService $audioService
 * @property AwsS3Service $awsS3Service
 * @property UtilService utilService
 * @property TwilioService twilioService
 * @property ListDetailRepository listDetailRepository
 */
class CustomerService
{
    /**
     * CustomerService constructor.
     * @param CustomerRepository $customerRepository
     * @param AudioService $audioService
     * @param AwsS3Service $awsS3Service
     * @param UtilService $utilService
     * @param TwilioService $twilioService
     * @param ListDetailRepository $listDetailRepository
     */
    public function __construct(
        CustomerRepository $customerRepository,
        AudioService $audioService,
        AwsS3Service $awsS3Service,
        UtilService $utilService,
        TwilioService $twilioService,
        ListDetailRepository $listDetailRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->audioService = $audioService;
        $this->awsS3Service = $awsS3Service;
        $this->utilService = $utilService;
        $this->twilioService = $twilioService;
        $this->listDetailRepository = $listDetailRepository;
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
        return $this->customerRepository->findOneBy(array_merge($criteria, ['isDeleted' => $isDeleted]));
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
        return true;
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
    
    /**
     * @param array $data
     * @param InsuranceCompany $insuranceCompany
     * @return Customer
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveCustomerData(array $data, InsuranceCompany $insuranceCompany)
    {
        /** @var ListDetail $listDetail */
        $listDetail = $this->listDetailRepository->find(5);
        return $this->customerRepository->saveCustomerData($data, $listDetail, $insuranceCompany);
    }
    
    /**
     * @param string $emailAddress
     * @return bool
     */
    public function checkEmailExistOrNot(string $emailAddress) {
        return (bool)$this->customerRepository->findOneBy(['email' => $emailAddress]);
    }
    
    /**
     * @return null|array
     */
    public function getWebCustomers()
    {
        $customersData = [];
        $customers = $this->customerRepository->findBy(['listDetail' => 5, 'isAuthenticated' => 1, 'isDeleted' => 0]);
        
        foreach ($customers as $customer)
        {
            array_push($customersData, $customer->toArray());
        }
        
        return $customersData;
    }
}
