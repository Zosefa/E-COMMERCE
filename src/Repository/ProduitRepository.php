<?php

namespace App\Repository;

use App\Entity\Produit;
use App\Entity\Vendeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Produit::class);
    }

    public function findbyVendeur(Vendeur $vendeur){
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.Vendeur = :vendeur')
            ->andWhere('p.QteDispo > 0')
            ->setParameter('vendeur' , $vendeur)
            ->getQuery()
            ->getResult();
    }
    public function recherche($valeur,Vendeur $vendeur){
        $query = $this->createQueryBuilder('produit')
            ->select('produit'); 
        if($valeur){
            return $query
                ->where(
                $query->expr()->orX(
                    $query->expr()->like('produit.Produit',':valeur')
                    )
                )
                ->andWhere('produit.Vendeur = :vendeur')
                ->setParameter('valeur',"%$valeur%")
                ->setParameter('vendeur',$vendeur)
                ->getQuery()
                ->getResult();
        } 
    }
    public function paginator(int $page,int $limit,Vendeur $vendeur): PaginationInterface
    {
        return $this->paginator->paginate(
            $this
            ->createQueryBuilder('p')
            ->select('p')
            ->where('p.Vendeur = :vendeur')
            ->setParameter('vendeur' , $vendeur)
            ->getQuery()
            ->getResult(),
            $page,
            $limit
        );
        // return new Paginator($this
        // ->createQueryBuilder('p')
        // ->select('p')
        // ->where('p.Vendeur = :vendeur')
        // ->setParameter('vendeur' , $vendeur)
        // ->setFirstResult(($page - 1) * $limit )
        // ->setMaxResults($limit)
        // ->getQuery()
        // ->setHint(Paginator::HINT_ENABLE_DISTINCT, false),
        // false
        // );
    }

    // public function findbyVendeur()

//    /**
//     * @return Produit[] Returns an array of Produit objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Produit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
