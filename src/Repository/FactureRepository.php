<?php

namespace App\Repository;

use App\Entity\Facture;
use App\Entity\Vendeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Facture>
 *
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }
    public function selectbyVendeur(Vendeur $vendeur,bool $etat){
        return $this->createQueryBuilder('facture')
            ->join('facture.Commande','Commande')
            ->select('facture')
            ->where('Commande.Vendeur = :vendeur')
            ->andWhere('facture.Facturer = :etat')
            ->setParameter('vendeur',$vendeur)
            ->setParameter('etat',$etat)
            ->getQuery()
            ->getResult();
    }
    public function getLastFacture(){
        return $this->createQueryBuilder('facture')
            ->orderBy('facture.id','DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Facture[] Returns an array of Facture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Facture
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
