<?php

namespace AppBundle\Entity\Compta;

use Doctrine\ORM\EntityRepository;

/**
 * OperationDiverseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OperationDiverseRepository extends EntityRepository
{
	public function findByCompteForCompany($compteComptable, $company=null, $startDate = null, $endDate = null){

		$qb = $this->createQueryBuilder('o')
		->leftJoin('AppBundle\Entity\Compta\CompteComptable', 'c', 'WITH', 'o.compteComptable = c.id')
		->where('o.compteComptable = :compteComptable')
		->setParameter('compteComptable', $compteComptable);

		if($company){
			$qb->andWhere('c.company = :company')
				->setParameter('company', $company);
		}

		if($startDate && $endDate){
			$qb->andWhere('o.date >= :startDate and o.date <= :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
		}

		$qb->orderBy('o.date', 'DESC')
		->addOrderBy('o.debit', 'DESC');

		$result = $qb	->getQuery()
		->getResult();

		return $result;
	}

	public function findForCompany($company){

		$result = $this->createQueryBuilder('o')
		->leftJoin('AppBundle\Entity\Compta\CompteComptable', 'c', 'WITH', 'o.compteComptable = c.id')
		->where('c.company = :company')
		->setParameter('company', $company)
		->orderBy('o.date', 'DESC')
		->addOrderBy('o.debit', 'DESC')
		->getQuery()
		->getResult();

		return $result;
	}
}
