<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Entity\CustomerMeta;
use App\Entity\User;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class CustomerRepository
 * @package App\Repository
 */
class CustomerRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }
    
    /**
     * @param User $user
     * @return null|array
     */
    public function getCustomersByUser(User $user): ?array
    {
        $qb = $this->createQueryBuilder('customer')
            ->where('customer.user = :user')
            ->setParameter('user', $user);
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * @param array $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveCustomerData(array $data)
    {
        $customer = new Customer();
        $customer->setFirstName($data['firstName']);
        $customer->setLastName($data['lastName']);
        $customer->setAge($data['age']);
        $paymentStartDate = DateTime::createFromFormat('m/d/Y', $data['paymentStartDate']);
        $paymentEndDate = DateTime::createFromFormat('m/d/Y', $data['paymentEndDate']);
        $customer->setHeight($data['height']);
        $customer->setWeight($data['weight']);
        $customer->setContactNumber($data['phoneNo']);
        $customer->setGender($data['gender']);
        $customer->setEmail($data['emailAddress']);
        $customerMeta = new CustomerMeta();
        $customerMeta->setPaymentStartDate($paymentStartDate);
        $customerMeta->setPaymentEndDate($paymentEndDate);
        $customerMeta->setPaymentFrequency($data['frequency']);
        $customerMeta->setPercentStep($data['percentStep']);
        $customerMeta->setProductType($data['productType']);
        $customerMeta->setSmoker($data['smoker']);
        $customerMeta->setHealthStatus($data['healthStatus']);
        $customerMeta->setLegalIssueStatus($data['legalIssues']);
        $customerMeta->setDuiStatus($data['DUI']);
        $customerMeta->setLicenseSuspended($data['licenseSuspended']);
        $customerMeta->setMisdemeanorStatus($data['misdemeanor']);
        $customerMeta->setAnnualCheckupStatus($data['annualCheckup']);
        $customerMeta->setPhysicalExerciseStatus($data['physicalExercise']);
        $customerMeta->setBloodPressureStatus($data['bloodPressure']);
        $customerMeta->setHighCholesterol($data['highCholesterol']);
        $customerMeta->setDrivingInfraction($data['drivingInfraction']);
        
        $this->persist($customerMeta, true);
        $customer->setCustomerMeta($customerMeta);
        $this->persist($customer, true);
    }
}