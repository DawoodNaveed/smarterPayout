<?php

namespace App\Repository;

use App\Entity\CustomerMeta;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CustomerMeta|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerMeta|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerMeta[]    findAll()
 * @method CustomerMeta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class CustomerMetaRepository
 * @package App\Repository
 */
class CustomerMetaRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerMeta::class);
    }
}
