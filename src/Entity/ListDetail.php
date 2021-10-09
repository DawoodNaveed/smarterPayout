<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ListDetailRepository;

/**
 * Class ListDetail
 * @package App\Entity
 * @ORM\Entity(repositoryClass=ListDetailRepository::class)
 */
class ListDetail extends AbstractEntity
{
    /**
     * @var string List name
     * @ORM\Column(name="list_name", type="string")
     */
    private $listName;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="listDetail")
     */
    private $customer;
    
    /**
     * @return string
     */
    public function getListName(): string
    {
        return $this->listName;
    }
    
    /**
     * @param string $listName
     */
    public function setListName(string $listName): void
    {
        $this->listName = $listName;
    }
    
    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }
    
    /**
     * @param mixed $customer
     */
    public function setCustomer($customer): void
    {
        $this->customer = $customer;
    }
}