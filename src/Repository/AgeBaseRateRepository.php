<?php

namespace App\Repository;

use App\Entity\AgeBaseRate;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AgeBaseRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgeBaseRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgeBaseRate[]    findAll()
 * @method AgeBaseRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class AgeBaseRateRepository
 * @package App\Repository
 */
class AgeBaseRateRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgeBaseRate::class);
    }
    
    /**
     * @param string $age
     * @return int|mixed|string
     */
    public function getAgeBaseRate(string $age)
    {
        return $this->createQueryBuilder('a')
            ->where(':age BETWEEN a.minAge AND a.maxAge')
            ->setParameter('age', $age)
            ->getQuery()
            ->getResult();
    }
}
