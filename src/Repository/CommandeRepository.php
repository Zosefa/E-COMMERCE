<?php

namespace App\Repository;

use App\Entity\Commande;
use App\Entity\Facture;
use App\Entity\Vendeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }
    public function getbyUserAndFacture(bool $facture,Vendeur $vendeur):array
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.Facture = :facture')
            ->andWhere('c.Vendeur = :vendeur')
            ->setParameter('facture',$facture)
            ->setParameter('vendeur',$vendeur)
            ->getQuery()
            ->getResult();
    }
    public function selectAll(Facture $facture){
        return $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.facture = :facture')
            ->setParameter('facture',$facture)
            ->getQuery()
            ->getResult();
    }
    public function getDernierCommande($n){
        return $this->createQueryBuilder('commande')
            ->orderBy('commande.id','DESC')
            ->setMaxResults($n)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Commande[] Returns an array of Commande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Commande
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
