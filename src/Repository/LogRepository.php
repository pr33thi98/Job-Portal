<?php

namespace App\Repository;

use App\Entity\Log;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Log>
 *
 * @method Log|null find($id, $lockMode = null, $lockVersion = null)
 * @method Log|null findOneBy(array $criteria, array $orderBy = null)
 * @method Log[]    findAll()
 * @method Log[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Log::class);
    }

    public function save(Log $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Log $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function logType($type): array
    {
        // $fresult = (($pageno-1)*10);
        return $this->createQueryBuilder('l')
                    ->andWhere('l.type = :val')
                    ->setParameter('val', $type)
                    ->orderBy('l.id', 'ASC')
                    // ->setFirstResult($fresult)
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getArrayResult()
                    ;
    }    

    public function moduleFilter($module):array
    {
        // $fresult = (($pageno-1)*10);
        return $this->createQueryBuilder('l')
                    ->andWhere('l.module = :val')
                    ->setParameter('val', $module)
                    ->orderBy('l.id','ASC')
                    // ->setFirstResult($fresult)
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getArrayResult()
                    ;
    }

    public function filter($module, $type)
    {
        return $this->createQueryBuilder('f')
                    ->andWhere('f.module = :val AND f.type = :val2')
                    ->setParameter('val',$module)
                    ->setParameter('val2',$type)
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getArrayResult()
                    ;
    }
//    /**
//     * @return Log[] Returns an array of Log objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Log
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
