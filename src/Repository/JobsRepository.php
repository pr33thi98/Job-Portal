<?php

namespace App\Repository;

use App\Entity\Jobs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Jobs>
 *
 * @method Jobs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jobs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jobs[]    findAll()
 * @method Jobs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jobs::class);
    }

    public function save(Jobs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Jobs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Jobs[] Returns an array of Jobs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Jobs
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findList($pageNo): array
    {
        $date =  new \DateTime('@'.strtotime('now'));
        $firstResult=($pageNo-1)*5;
        return $this->createQueryBuilder('f')
                ->select("f")
                ->setParameter('first', $date)
                ->andWhere('f.expiry >= :first')
                ->setMaxResults(5)
                ->setFirstResult($firstResult)
                ->getQuery()
                ->getArrayResult();
    }

//    public function recordCount(): ?int
//    {
//         return $this->createQueryBuilder('f')
//             ->select("count(f.id)")
//             ->getQuery()
//             ->getSingleScalarResult(); 
//    }
   public function recordCount(): ?int
   {
        $date =  new \DateTime('@'.strtotime('now'));
        return $this->createQueryBuilder('f')
                ->select("count(f.id)")
                ->setParameter('first', $date)
                ->andWhere('f.expiry >= :first')
                ->getQuery()
                ->getSingleScalarResult();   
    }


}
