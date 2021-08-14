<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Entity\CustomerMeta;
use App\Entity\User;
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
}