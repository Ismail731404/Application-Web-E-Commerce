<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Dechet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Dechet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dechet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dechet[]    findAll()
 * @method Dechet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DechetRepository extends ServiceEntityRepository
{
    private $paginator;
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Dechet::class);
        $this->paginator = $paginator;
    }

    /**
     * Recupere les dechet en lien avec une recherche
     * @return PaginationInterface
     */


    public function findDechetSimulaire(Dechet $dechet)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.categorie = :categorie')
            ->setParameter('categorie', $dechet->getCategorie())
            ->andWhere('d.designation != :designation')
            ->setParameter('designation', $dechet->getDesignation())
            ->andWhere('d.quantiteStock > :val')
            ->setParameter('val', 0)
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findSearch(SearchData $search): PaginationInterface
    {


        $query = $this->getSearchQuery($search)->getQuery();

        return $this->paginator->paginate(
            $query,
            $search->page,
            8
        );
    }

    /**
     * Recupere les prix minimum et maximim xorrespojdant a un recherche
     *
     * @param SearchData $search
     * @return integer[]
     */
    public function findMinMax(SearchData $search): array
    {
        $results = $this->getSearchQuery($search, true)
            ->select('MIN(d.prix) as min', 'MAX(d.prix) as max')
            ->getQuery()
            ->getScalarResult();
        return [(int) $results[0]['min'], (int) $results[0]['max']];
    }



    private function getSearchQuery(SearchData $search, $ignorePrice = false): QueryBuilder
    {
        $query =  $this->createQueryBuilder('d')
            ->andWhere('d.quantiteStock > :val')
            ->setParameter('val', 0)
            ->orderBy('d.id', 'DESC');



        if (!empty($search->q)) {
            $query = $query
                ->andWhere('d.designation LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }


        if (!empty($search->max) && $ignorePrice === false) {
            $query = $query
                ->andwhere('d.prix <= :max')
                ->setParameter('max', $search->max);
        }

        if (!empty($search->min) && $ignorePrice === false) {
            $query = $query
                ->andwhere('d.prix >= :min')
                ->setParameter('min', $search->min);
        }

        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('d.categorie = :categorie')
                ->setParameter('categorie', $search->categories->getid());
        }

        if (!empty($search->promo)) {
            $query = $query
                ->andWhere('d.promo = 1');
        }


        if ($search->origine >= 0 && !is_null($search->origine)) {
            $query = $query
                ->andWhere('d.origine = :origine')
                ->setParameter('origine', $search->origine);
        }

        return $query;
    }
    // /**
    //  * @return Dechet[] Returns an array of Dechet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dechet
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}