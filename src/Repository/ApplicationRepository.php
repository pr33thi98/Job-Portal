<?php

namespace App\Repository;

use App\Entity\Application;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Application>
 *
 * @method Application|null find($id, $lockMode = null, $lockVersion = null)
 * @method Application|null findOneBy(array $criteria, array $orderBy = null)
 * @method Application[]    findAll()
 * @method Application[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

    public function save(Application $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Application $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getApplication($pageNo, $userId): array
    {
        $firstResult=(($pageNo-1)*5);
        return $this->createQueryBuilder('a')
            ->andWhere('a.user_id = :val')
            ->setParameter('val', $userId)
            ->setFirstResult($firstResult)
            ->orderBy('a.applied_at', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getArrayResult()
       ;
    }    

    public function recordCount($userId): ?int
   {
        return $this->createQueryBuilder('a')
                ->select("count(a.id)")
                ->andWhere('a.user_id=:val')
                ->setParameter('val', $userId)
                ->getQuery()
                ->getSingleScalarResult();   
    }

//    /**
//     * @return Application[] Returns an array of Application objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Application
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
// ->select("DATE_FORMAT(j.expiry,'%d-%m-%y')")
            // ->andWhere('a.job_title LIKE :val OR a.job_location LIKE :val')
            //    ->where("j.expiry in date('j.expiry') ")
                        // ->setParameter('val2', '%'.$searchLocation.'%')


}
