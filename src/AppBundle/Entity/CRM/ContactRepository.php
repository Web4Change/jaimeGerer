<?php

namespace AppBundle\Entity\CRM;

use Doctrine\ORM\EntityRepository;

/**
 * ContactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactRepository extends EntityRepository
{
	public function count($company){
		$result = $this->createQueryBuilder('c')
		->select('COUNT(c)')
		->leftJoin('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
		->where('co.company = :company')
		->andWhere('c.isOnlyProspect = :isOnlyProspect')
		->setParameter('isOnlyProspect', false)
		->setParameter('company', $company)
		->getQuery()
		->getSingleScalarResult();

		return $result;
	}

	public function countNoEmail($company){
		$result = $this->createQueryBuilder('c')
		->select('COUNT(c)')
		->leftJoin('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
		->where('co.company = :company')
		->andWhere('c.email IS NULL')
		->andWhere('c.isOnlyProspect = :isOnlyProspect')
		->setParameter('isOnlyProspect', false)
		->setParameter('company', $company)
		->getQuery()
		->getSingleScalarResult();

		return $result;
	}

	public function countNoTel($company){
		$result = $this->createQueryBuilder('c')
		->select('COUNT(c)')
		->leftJoin('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
		->where('co.company = :company')
		->andWhere('c.telephoneFixe IS NULL AND c.telephonePortable IS NULL')
		->andWhere('c.isOnlyProspect = :isOnlyProspect')
		->setParameter('isOnlyProspect', false)
		->setParameter('company', $company)
		->getQuery()
		->getSingleScalarResult();

		return $result;
	}

	public function countBounce($company){
		$result = $this->createQueryBuilder('c')
		->select('COUNT(c)')
		->leftJoin('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
		->where('co.company = :company')
		->andWhere('c.bounce = :bounce')
		->andWhere('c.isOnlyProspect = :isOnlyProspect')
		->setParameter('isOnlyProspect', false)
		->setParameter('company', $company)
		->setParameter('bounce', 'BOUNCE')
		->getQuery()
		->getSingleScalarResult();

		return $result;
	}

	public function findByCompany($company, $isOnlyProspect = null){
		$qb = $this->createQueryBuilder('c')
		->leftJoin('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
		->where('co.company = :company')
		->setParameter('company', $company);

		if($isOnlyProspect !== null){
			$qb->andWhere('c.isOnlyProspect = :isOnlyProspect')
			->setParameter('isOnlyProspect', $isOnlyProspect);
		}

		$result = $qb->getQuery()
		->getResult();

		return $result;
	}

	public function findByEmailAndCompany($email, $company){
		$result = $this->createQueryBuilder('c')
		->leftJoin('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
		->where('co.company = :company')
		->andWhere('c.email = :email')
        ->andWhere('c.isOnlyProspect = :isOnlyProspect')
        ->setParameter('isOnlyProspect', false)
		->setParameter('company', $company)
		->setParameter('email', $email)
		->getQuery()
		->getResult();

		return $result;
	}
	
	public function findByNameAndCompanyNotCompte($prenom, $nom, $company, $compte){
		$result = $this->createQueryBuilder('c')
		->leftJoin('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
		->where('co.company = :company')
		->andWhere('c.prenom = :prenom')
		->andWhere('c.nom = :nom')
        ->andWhere('c.isOnlyProspect = :isOnlyProspect')
        ->andWhere('co.nom <> :compte')
        ->setParameter('isOnlyProspect', false)
		->setParameter('company', $company)
		->setParameter('prenom', $prenom)
		->setParameter('nom', $nom)
		->setParameter('compte', $compte)
		->getQuery()
		->getResult();

		return $result;
	}

    public function findByImportMauticAndCompany($status, $company){
        $result = $this->createQueryBuilder('c')
            ->leftJoin('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
            ->where('co.company = :company')
            ->andWhere('c.importMauticStatus = :status')
            ->andWhere('c.isOnlyProspect = :isOnlyProspect')
            ->setParameter('isOnlyProspect', false)
            ->setParameter('company', $company)
            ->setParameter('status', false)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        return $result;
    }

	public function findAllExcept($ids = array(), $company, $compte = null){
		$qb = $this->createQueryBuilder('c')
				->leftJoin('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
				->where('co.company = :company')
                ->andWhere('c.isOnlyProspect = :isOnlyProspect')
                ->setParameter('isOnlyProspect', false)
				->setParameter('company', $company);

		if( count($ids) > 0 )
		{
			$qb->andWhere('c.id NOT IN (:ids)')
			   ->setParameter('ids', implode(',',$ids));
		}
		if( !is_null($compte) )
		{
			$qb->andWhere('c.compte = :compte')
			   ->setParameter('compte', $compte);
		}

		return $qb->getQuery()->getResult();
	}

	public function findByCompanyAndCompte($company, $compte){
		$result = $this->createQueryBuilder('c')
		->leftJoin('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
		->where('co.company = :company')
		->andWhere('c.compte = :compte')
        ->andWhere('c.isOnlyProspect = :isOnlyProspect')
        ->setParameter('isOnlyProspect', false)
        ->setParameter('company', $company)
        ->setParameter('compte', $compte)
		->getQuery()
		->getResult();

		return $result;
	}

	public function findAllNoImpulsion($company){

	    $query = $this->createQueryBuilder('c');
        $query->select('c.id, c.nom, c.prenom, co AS compte')
            ->join('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
            ->where('co.company = '.$company)
            ->andWhere('c.isOnlyProspect = :isOnlyProspect')
            ->setParameter('isOnlyProspect', false);
		$result = $query->getQuery()->getResult();

		return $result;

	}

	public function findForList($company, $length, $start, $orderBy, $dir, $search){
		$qb = $this->createQueryBuilder('c')
		->select('c.id', 'c.prenom', 'c.nom', 'co.nom as compte_nom', 'co.id as compte_id', 'c.titre', 'c.telephoneFixe', 'c.telephonePortable', 'c.email', 'c.ville', 'c.region', 'c.pays', 'c.bounce')
		->leftJoin('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
		->where('co.company = :company')
        ->andWhere('c.isOnlyProspect = :isOnlyProspect')
        ->setParameter('isOnlyProspect', false)
		->setParameter('company', $company);

		if($search != ""){
			$search = trim($search);
			$qb->andWhere("c.nom LIKE :search OR c.prenom LIKE :search OR c.email LIKE :search OR c.titre LIKE :search OR co.nom LIKE :search or CONCAT(c.prenom,' ',c.nom) LIKE :search or CONCAT(c.nom,' ',c.prenom) LIKE :search")
			->setParameter('search', '%'.$search.'%');
		}

		$qb->setMaxResults($length)
		->setFirstResult($start);


		if($orderBy == 'compte_nom' ){
			$qb->addOrderBy('co.nom', $dir);
		} else {
			$qb->addOrderBy('c.'.$orderBy, $dir);
		}
		return $qb->getQuery()->getResult();
	}

	public function countForList($company, $search){
		$qb = $this->createQueryBuilder('c')
		->select('COUNT(c)')
		->leftJoin('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
		->where('co.company = :company')
        ->andWhere('c.isOnlyProspect = :isOnlyProspect')
        ->setParameter('isOnlyProspect', false)
		->setParameter('company', $company);

		if($search != ""){
			$search = trim($search);
			$qb->andWhere("c.nom LIKE :search OR c.prenom LIKE :search OR c.email LIKE :search OR c.titre LIKE :search OR co.nom LIKE :search or CONCAT(c.prenom,' ',c.nom) LIKE :search or CONCAT(c.nom,' ',c.prenom) LIKE :search")
			->setParameter('search', '%'.$search.'%');
		}

		return $qb->getQuery()->getSingleScalarResult();
	}

	public function createQueryAndGetResult($arr_filters, $company, $emailing, $bounce = false, $warning = false){

		$qb  = $this->_em->createQueryBuilder();

		$query = $this->createQueryBuilder('c')
		->leftJoin('c.settings', 's');

		$index = 0;
		$newGroup = true;
		$where = '';
		$andorGroup = '';

		foreach($arr_filters as $filter){

			$champ = $filter->getChamp();
			$action = $filter->getAction();
			$andor = $filter->getAndor();
			$endGroup = $filter->getEndGroup();

			$operateur = 'LIKE';

			if($action == 'NOT_EQUALS' || $action == 'NOT_CONTAINS'){
				$operateur = 'NOT LIKE';
			} 
			 elseif ($action == 'MORE_THAN'){
			 	$operateur = '>';
			} elseif ($action == 'LESS_THAN'){
			 	$operateur = '<';
			} elseif ($action == 'MORE_OR_EQUALS'){
			 	$operateur = '>=';
			} elseif ($action == 'LESS_OR_EQUALS'){
			 	$operateur = '<=';
			}

			$arr_valeurs = explode(',', $filter->getValeur());

			if( true === $newGroup ){
				$where.= '(';
				$andorGroup = $andor;
			} else {
				$where.= ' '.$andor.' ';
			}

			if($champ == 'TYPE' || $champ == 'THEME_INTERET' || $champ == 'SERVICE_INTERET' || $champ == 'SECTEUR'){

				if($action == 'EMPTY'){

					$subQueryBuilder = $this->getEntityManager()->createQueryBuilder();
					$subQuery = $subQueryBuilder
					->select(['cs.id'])
					->from('AppBundle\Entity\CRM\Contact', 'cs')
					->innerJoin('cs.settings', 's')
					->where('s.parametre = :parameter')
					->setParameter('parameter', $champ)
					->getQuery()
					->getArrayResult();

					
					$where.= $qb->expr()->notIn('c.id', ':subQuery');
					$query->setParameter('subQuery', $subQuery);
					

				} else if($action == 'NOT_EMPTY'){
					$qb2 = $qb;
					$qb2->select('s'.$index.'.id')
					->from('AppBundle\Entity\Settings', 's'.$index)
					->where('s'.$index.'.parametre = :parametre'.$index);

					$query->setParameter('parametre'.$index, $champ);

					if($index == 0){
						$query->where(($qb->expr()->in('s', $qb2->getDQL())));
					} else {
						if($andor == 'AND'){
							$query->andWhere(($qb->expr()->in('c.settings', $qb2->getDQL())));
						} else{
							$query->orWhere(($qb->expr()->in('c.settings', $qb2->getDQL())));
						}
					}
				}  else {

					//$where = 's.parametre = :param'.$index;
					//$query->setParameter('param'.$index, $champ);

 					for($i=0; $i<count($arr_valeurs); $i++){

 						$param = ':valeur'.$index.$i;

 						$val = '';
 						if($action == 'EQUALS' || $action == 'NOT_EQUALS' || $action == 'MORE_THAN' || $action == 'LESS_THAN' || $action == 'MORE_OR_EQUALS' || $action == 'LESS_OR_EQUALS'){
 							$val = $arr_valeurs[$i];
 						} elseif($action == 'CONTAINS' || $action == 'NOT_CONTAINS'){
 							$val = '%'.$arr_valeurs[$i].'%';
 						} elseif($action == 'BEGINS_WITH'){
 							$val = $arr_valeurs[$i].'%';
 						} elseif($action == 'ENDS_WITH'){
 							$val = '%'.$arr_valeurs[$i];
 						}

 						if($i != 0){
 							$where.=' OR ';
 						}
 				
 						$where.= 's.parametre = :param'.$index.' AND s.valeur '.$operateur.' :valeur'.$index;
 						$query->setParameter('param'.$index, $champ);
 						$query->setParameter('valeur'.$index, $val);
 					}
				}

				if( true === $endGroup or count($arr_filters)-1 == $index ){
					$where.= ')';
					$newGroup = true;
					if($index == 0){
						$query->where($where);
					} else {
						if($andorGroup == 'AND'){
							$query->andWhere($where);
						} else{
							$query->orWhere($where);
						}
					}
					$where = '';
				} else {
					$newGroup = false;
				}

 			} elseif( $champ == 'RESEAU' || $champ == 'ORIGINE' ||  $champ == "compte" ) {
 		
 				if($action == 'EMPTY'){
 					$where.= 'c.'.strtolower($champ).' IS NULL' ;
 				} else if($action == 'NOT_EMPTY'){
 					$where.= 'c.'.strtolower($champ).' IS NOT NULL';

 				} else {

	 				for($i=0; $i<count($arr_valeurs); $i++){

	 					$param = ':valeur'.$index.$i;

	 					$val = '';
	 					if($action == 'EQUALS' || $action == 'NOT_EQUALS' || $action == 'MORE_THAN' || $action == 'LESS_THAN' || $action == 'MORE_OR_EQUALS' || $action == 'LESS_OR_EQUALS'){
	 						$val = $arr_valeurs[0];
	 					} elseif($action == 'CONTAINS' || $action == 'NOT_CONTAINS'){
	 						$val = '%'.$arr_valeurs[0].'%';
	 					} elseif($action == 'BEGINS_WITH'){
	 						$val = $arr_valeurs[0].'%';
	 					} elseif($action == 'ENDS_WITH'){
	 						$val = '%'.$arr_valeurs[0];
	 					}

	 					if($i != 0){
	 						$where.=' OR ';
						}

                        $qb2 = $qb;
						if($champ == 'RESEAU' || $champ == 'ORIGINE'){
                            $qb2->select('s'.$index.'.id')
                                ->from('AppBundle\Entity\Settings', 's'.$index)
                                ->where('s'.$index.'.parametre = :parametre'.$index)
                                ->andWhere('s'.$index.'.valeur '.$operateur.' :valeur'.$index);

                            $query->setParameter('parametre'.$index, $champ)
                                ->setParameter('valeur'.$index, $val);
                        } else {
                            $qb2->select('s'.$index.'.id')
                                ->from('AppBundle\Entity\CRM\Compte', 's'.$index)
                                ->where('s'.$index.'.nom '.$operateur.' :nom'.$index.$i);

               				$query->setParameter('nom'.$index.$i, $val);
                        }

                        $where.= $qb->expr()->in('c.'.strtolower($champ), $qb2->getDQL());
                        if( true === $endGroup or count($arr_filters)-1 == $index ){
							$where.= ')';
							$newGroup = true;
							if($index == 0){
								$query->where($where);
							} else {
								if($andorGroup == 'AND'){
									$query->andWhere($where);
								} else{
									$query->orWhere($where);
								}
							}
						} else {
							$newGroup = false;
						}

	 				}

 				}

 			} else {

				if($action == 'EMPTY'){
					$where.= 'c.'.$champ.' IS NULL';

				} else if($action == 'NOT_EMPTY'){
					$where.= 'c.'.$champ.' IS NOT NULL AND c.'.$champ.' <> :vide'.$index;
					$query->setParameter('vide'.$index, '');

				} else if ($action == "IS_TRUE"){
					if($champ == "bounce"){
						$where.= 'c.'.$champ.' = :bounceString';
						$query->setParameter('bounceString', 'BOUNCE');
					} else {
						$where.= 'c.'.$champ.' =1';
					}
					
				} else if($action == 'IS_FALSE'){
					if($champ == "bounce"){
						$where.= 'c.'.$champ.' = :bounceString';
						$query->setParameter('bounceString', 'VALID');
					} else {
						$where.= 'c.'.$champ.' =0';
					}
					
				} else {

					for($i=0; $i<count($arr_valeurs); $i++){

						$param = ':valeur'.$index.$i;

						$val = '';
						if($action == 'EQUALS' || $action == 'NOT_EQUALS' || $action == 'MORE_THAN' || $action == 'LESS_THAN' || $action == 'MORE_OR_EQUALS' || $action == 'LESS_OR_EQUALS' ){
							$val = $arr_valeurs[$i];
						} elseif($action == 'CONTAINS' || $action == 'NOT_CONTAINS'){
							$val = '%'.$arr_valeurs[$i].'%';
						} elseif($action == 'BEGINS_WITH'){
							$val = $arr_valeurs[$i].'%';
						} elseif($action == 'ENDS_WITH'){
							$val = '%'.$arr_valeurs[$i];
						}

						if($i != 0){
							$where.=' OR ';
						}

						$where.= 'c.'.$champ.' '.$operateur.' '.$param;
						$query->setParameter($param, $val);
					}

				}

	 			if( true === $endGroup or count($arr_filters)-1 == $index ){
					$where.= ')';
					$newGroup = true;
					if($index == 0){
						$query->where($where);
					} else {
						if($andorGroup == 'AND'){
							$query->andWhere($where);
						} else{
							$query->orWhere($where);
						}
					}
					$where = '';
				} else {
					$newGroup = false;
				}
 			}	

 			$index++;
		}

		$query->leftJoin('AppBundle\Entity\CRM\Compte', 'co', 'WITH', 'co.id = c.compte')
				->andWhere('co.company = :company')
				->setParameter('company', $company);

		if($emailing == true){
			$query->andWhere('c.bounce = :bounce  OR c.bounce IS NULL')
				->andWhere('c.email IS NOT NULL')
				->andWhere('c.rejetEmail = :rejetEmail')
				->setParameter('bounce', 'VALID')
				->setParameter('rejetEmail', false);
		}

		if($bounce == true){
			$query->andWhere('c.bounce = :bounce')
				->setParameter('bounce', 'BOUNCE');
		}

		if($warning == true){
			$query->andWhere('c.bounce = :warning')
				->setParameter('warning', 'WARNING');
		}

		$result = $query->getQuery()->getResult();

		return $result;
	}
}
