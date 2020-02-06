<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }



    //function recherche
    /**
     * @return Article[] Returns an array of Article objects
     */

    public function articleSearch($criteria)
    {
        // 'p' est un alias, je peux utiliser un autre caractère, tant que je l'utilise encore pour mes critères
        return $this->createQueryBuilder('p')
            // je cherche où le prix est égal ou plus petit que les valeurs dans ma CONST PRICE
            ->andWhere('p.price >= :minimumPrice')
            ->setParameter('minimumPrice', $criteria['minimumPrice'])
            // je cherche où le prix est égal ou plus grand que les valeurs dans ma CONST PRICE
            ->andWhere('p.price <= :maximumPrice')
            ->setParameter('maximumPrice', $criteria['maximumPrice'])
            // même chose
            ->andWhere('p.lenght >= :lenght')
            ->setParameter('lenght', $criteria['lenght'])

            ->andWhere('p.diameter >= :diameter')
            ->setParameter('diameter', $criteria['diameter'])

            ->andWhere('p.capacity >= :capacity')
            ->setParameter('capacity', $criteria['capacity'])

            ->andWhere('p.autonomy >= :autonomy')
            ->setParameter('autonomy', $criteria['autonomy'])

            // donne l'ordre et le résultat max lorsque qu'on fait valide la recherche
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
