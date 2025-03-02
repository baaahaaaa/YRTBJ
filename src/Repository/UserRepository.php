<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Admin;
use App\Entity\Student;
use App\Entity\Tutor;
use App\Entity\Agent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;   


/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function canCreateAdmin(): bool
    {
        return $this->count(['roles' => ['ROLE_ADMIN']]) === 0;
    }
    public function countByMonth()
    {
        return $this->createQueryBuilder('u')
            ->select("DATE_FORMAT(u.Entry_Date, '%Y-%m') AS month, COUNT(u.id) AS count")
            ->groupBy('month')
            ->orderBy('month', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }
    public function countUsersByRole(): array
    {
        $conn = $this->getEntityManager()->getConnection();
    
        $sql = "
            SELECT type AS role, COUNT(id) AS count
            FROM user
            WHERE type IS NOT NULL
            GROUP BY type
        ";
    
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
    
        return  $resultSet->fetchAll();
        
    }
    


}
   
//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')   
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

