<?php

namespace App\Repository;

use App\Entity\ListDetail;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListDetail[]    findAll()
 * @method ListDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class ListDetailRepository
 * @package App\Repository
 */
class ListDetailRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListDetail::class);
    }
}