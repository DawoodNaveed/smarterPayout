<?php

namespace App\Repository;

use App\Entity\GpBeneficiaryProtection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GpBeneficiaryProtection|null find($id, $lockMode = null, $lockVersion = null)
 * @method GpBeneficiaryProtection|null findOneBy(array $criteria, array $orderBy = null)
 * @method GpBeneficiaryProtection[]    findAll()
 * @method GpBeneficiaryProtection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class CreditRatingRepository
 * @package App\Repository
 */
class GpBeneficiaryProtectionRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GpBeneficiaryProtection::class);
    }
    
    /**
     * @param int $age
     * @return int|mixed|string
     */
    public function getBeneficiaryProtection(int $age)
    {
        return $this->createQueryBuilder('a')
            ->where(':age BETWEEN a.minAge AND a.maxAge')
            ->setParameter('age', $age)
            ->getQuery()
            ->getResult();
    }
}