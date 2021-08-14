<?php

namespace App\Repository;

use App\Entity\Audio;
use App\Entity\Customer;
use App\Entity\InsuranceCompany;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Audio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Audio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Audio[]    findAll()
 * @method Audio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class AudioRepository
 * @package App\Repository
 */
class AudioRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Audio::class);
    }
    
    /**
     * @param string $tagId
     * @param User $user
     */
    public function getAudio(string $tagId, User $user)
    {
        $qb = $this->createQueryBuilder('audio');
    
        $qb->where('audio.tagId = :tagId')
            ->andWhere('audio.user = :user')
            ->setParameter('tagId' , $tagId)
            ->setParameter('user', $user);
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * @param array $data
     * @param string $filename
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveAudio(array $data, string $filename, User $user)
    {
        $audio = new Audio();
        $audio->setFileName($filename);
        $audio->setTagId($data['tagId']);
        $audio->setUser($user);
        $this->persist($audio, true);
    }
    
    /**
     * @param Customer $customer
     * @param User $user
     * @param string $filename
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveCustomerAudio(Customer $customer, User $user, string $filename)
    {
        $audio = new Audio();
        $audio->setFileName($filename);
        $audio->setUser($user);
        $this->persist($audio, true);
        $customer->setAudio($audio);
        $this->persist($customer,true);
    }
    
    /**
     * @param InsuranceCompany $insuranceCompany
     * @param User $user
     * @param string $filename
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveInsuranceAudio(InsuranceCompany $insuranceCompany, User $user, string $filename)
    {
        $audio = new Audio();
        $audio->setFileName($filename);
        $audio->setUser($user);
        $this->persist($audio, true);
        $insuranceCompany->setAudio($audio);
        $this->persist($insuranceCompany,true);
    }
}
