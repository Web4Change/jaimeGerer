<?php

namespace AppBundle\Entity\Compta;

use Doctrine\ORM\EntityRepository;

/**
 * RelanceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MouvementBancaireRepository extends EntityRepository
{

	public function findByYearAndCompany($year, $company){

		$result = $this->createQueryBuilder('m')
		->leftJoin('AppBundle\Entity\Compta\CompteBancaire', 'co', 'WITH', 'co.id = m.compteBancaire')
		->where('co.company = :company')
		->andWhere('m.date >= :dateDebut and m.date <= :dateFin')
		->setParameter('company', $company)
		->setParameter('dateDebut', $year.'-01-01')
		->setParameter('dateFin', $year.'-12-31')
		->getQuery()
		->getResult();

		return $result;

	}
}
