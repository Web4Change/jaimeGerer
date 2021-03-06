<?php

namespace AppBundle\Entity\TimeTracker;

use Doctrine\ORM\EntityRepository;

/**
 * TempsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TempsRepository extends EntityRepository
{
	public function findForCompanyByYear($company, $year){

		$qb = $this->createQueryBuilder('t')
		->innerJoin('t.user', 'u')
		->where('u.company = :company')
		->andWhere('t.date >= :start')
		->andWhere('t.date <= :end')
		->setParameter('company', $company)
		->setParameter('start', $year.'-01-01')
		->setParameter('end',  $year.'-12-31');

		return $qb->getQuery()->getResult();
	}
}
