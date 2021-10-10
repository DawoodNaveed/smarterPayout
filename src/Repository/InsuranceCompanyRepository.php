<?php

namespace App\Repository;

use App\Entity\InsuranceCompany;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InsuranceCompany|null find($id, $lockMode = null, $lockVersion = null)
 * @method InsuranceCompany|null findOneBy(array $criteria, array $orderBy = null)
 * @method InsuranceCompany[]    findAll()
 * @method InsuranceCompany[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class InsuranceCompanyRepository
 * @package App\Repository
 */
class InsuranceCompanyRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InsuranceCompany::class);
    }
    
    /**
     * @return int|mixed|string
     */
    public function getInsuranceCompaniesName()
    {
        return $this->createQueryBuilder('ic')
            ->select('ic.name')
            ->where('ic.isDeleted = :isDeleted')
            ->setParameter('isDeleted', false)
            ->getQuery()
            ->getResult();
    }
}