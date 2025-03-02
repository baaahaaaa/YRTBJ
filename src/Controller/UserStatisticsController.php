<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class UserStatisticsController extends AbstractController
{
    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    #[Route('/total-users', name: 'total_users', methods: ['GET'])]
    public function totalUsers(UserRepository $userRepository): JsonResponse
    {
        $totalUsers = $userRepository->count([]);

        return $this->json([
            'total_users' => $totalUsers,
        ]);
    }
    #[Route('/api/stats/users-by-role', name: 'users_by_role', methods: ['GET'])]
    public function usersByRole(UserRepository $userRepository): JsonResponse
{
    $stats = $userRepository->countUsersByRole();


    return $this->json($stats);
}
    
    
#[Route('/stat', name: 'user_stats', methods: ['GET'])]
public function showStats(): Response
{
    return $this->render('user/stats.html.twig');
}
#[Route('/monthly-registrations', name: 'monthly_registrations', methods: ['GET'])]
public function monthlyRegistrations(UserRepository $userRepository): JsonResponse
{
    $conn = $this->doctrine->getManager()->getConnection();  

    $sql = "
        SELECT 
            DATE_FORMAT(entry_date, '%Y-%m') AS month, 
            COUNT(id) AS count
        FROM user
        WHERE entry_date IS NOT NULL
        GROUP BY month
        ORDER BY month DESC
        LIMIT 6
    ";

    $stmt = $conn->prepare($sql);
    $resultSet = $stmt->executeQuery(); // Doctrine DBAL 3+

    return $this->json($resultSet->fetchAllAssociative());
}

}
