<?php

namespace UrlReducer\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository {
	/**
	 * Returns number of rows
	 */
	public function count() {
		return $this->createQueryBuilder('id')
					->select('COUNT(id)')
					->getQuery()
					->getSingleScalarResult();
	}
}
