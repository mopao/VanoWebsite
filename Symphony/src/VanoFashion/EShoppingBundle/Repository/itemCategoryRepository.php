<?php

namespace VanoFashion\EShoppingBundle\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * itemCategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class itemCategoryRepository extends \Doctrine\ORM\EntityRepository
{

	/**
	 *get category with its products
	 */

	public function getCategoryWithProducts(){

		$qb=$this->createQueryBuilder('c')
                 ->innerJoin('c.products', 'p')
                 ->addSelect('p');

        return $qb->getQuery()
                  ->getResult();

	}
}
