<?php

namespace App\Repository;

use App\Entity\Jobs;
use App\Entity\Log;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

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

    public function filter($module, $type, $pageNo)
    {
        try
        {
            $firstResult = ($pageNo-1)*5;

            $query = $this->createQueryBuilder('f');
            
                if(!empty($module))
                {
                    $query->andWhere('f.module = :module')
                        ->setParameter('module',$module);
                }
                if( !empty($type) || ($type === '0'))
                {
                    $query->andwhere('f.type = :type')
                        ->setParameter('type',$type);
                }
                $query->setMaxResults(5)
                    ->setFirstResult($firstResult);
            return $logs = $query->getQuery()->getResult();
        }
        catch(Exception $e)
        {
            print_r($e);
        }
    }
    
    public function recordCount($type, $module):int
    {
        try
        {
            $query =  $this->createQueryBuilder('f')
                           ->select("count(f.id)");
                if( !empty($type) || ($type === '0'))
                {
                    $query->where('f.type = :type')
                          ->setParameter('type',$type);
                }
                if(!empty($module) || $module === '0')
                {
                    $query->andWhere('f.module = :module')
                          ->setParameter('module',$module);
                }
                return  $query ->getQuery()
                               ->getSingleScalarResult();
        }
        catch(Exception $e)
        {
            print_r($e);
        }
    }

    public function fetchuserName(UserRepository $userRepo, $logs)
    {
        foreach( $logs as $id)
        {
            $uid = $id->getUserId();
            $user = $userRepo->find($uid);
            $userName = $user->getUsername();
            return $userName;
        }
    }

    // public function fetchjobName(JobsRepository $jobRepo, $logs)
    // {
    //     $jobid = $logs->getJobId();
    //     $job = $jobRepo->find($jobid);
    //     $jobName = $job->getJobTitle();
    //     return $jobName;
    // }
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
