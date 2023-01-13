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

    public function getJobs($pageNo, $searchPost): array
    {
        $firstResult=(($pageNo-1)*5);
        return $this->createQueryBuilder('j')
            // ->select('j')
            ->select("j.id,j.job_title,j.job_location,j.experience,j.job_description,DATE_FORMAT(j.expiry,'%d-%m-%y') as expiry_date")
            ->andWhere('j.job_title LIKE :val OR j.job_location LIKE :val')
            //    ->where("j.expiry in date('j.expiry') ")
            ->setParameter('val', '%'.$searchPost.'%')
            // ->setParameter('val2', '%'.$searchLocation.'%')
            ->setFirstResult($firstResult)
            ->orderBy('j.modified_at', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getArrayResult()
       ;
    }    

    public function recordCount($searchPost): ?int
    {
        return $this->createQueryBuilder('j')
                ->select("count(j.id)")
                ->andWhere('j.job_title LIKE :val OR j.job_location LIKE :val')
                ->setParameter('val', '%'.$searchPost.'%')
                ->getQuery()
                ->getSingleScalarResult();   
    }

    public function fetchJob($id)
    {
        $job=$this->findOneBy(['id'=>$id]);
        return json_encode($job);
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
}
