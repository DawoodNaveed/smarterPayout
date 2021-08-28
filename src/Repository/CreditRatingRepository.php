<?php

namespace App\Repository;

use App\Entity\CreditRating;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CreditRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreditRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreditRating[]    findAll()
 * @method CreditRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class CreditRatingRepository
 * @package App\Repository
 */
class CreditRatingRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditRating::class);
    }
}
