<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * GerechtRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GerechtRepository extends EntityRepository
{
	public function findAllByUser(\AppBundle\Entity\User $user) {
		return $this->createQueryBuilder('g')
			->leftJoin('g.recepten', 'r')
			->addSelect('r')
			->where('r.user = :user')
			->setParameter('user', $user)
			->getQuery()
			->getResult();
	}
}
