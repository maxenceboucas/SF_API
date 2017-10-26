<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Account;

/**
 * AccountRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AccountRepository extends \Doctrine\ORM\EntityRepository
{
    public function findOneOrCreate(array $criteria)
    {
        $entity = $this->findOneBy($criteria);

        if (null === $entity)
        {
           $entity = new Account();
           $entity->setIdInsta($criteria['idInsta']);
           $this->_em->persist($entity);
           $this->_em->flush();
        }

        return $entity;
    }
}
