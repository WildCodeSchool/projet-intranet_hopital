<?php

namespace Application\Sonata\UserBundle\Entity;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function hasNoPhoto()
    {

        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('u')
            ->from($this->_entityName, 'u')// Dans un repository, $this->_entityName est le namespace de l'entité gérée
            ->Where('u.photo is null');
        return $queryBuilder->getQuery()->getResult();

        /*$query = $this->_em->createQuery('SELECT partial p.user FROM IuchBundle:Photo p');
        return $query->getResult();*/
    }
}