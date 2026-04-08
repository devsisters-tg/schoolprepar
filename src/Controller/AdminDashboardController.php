<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        $stats = [
            'filieres'       => 12,
            'etablissements' => 5,
            'utilisateurs'   => 420
        ];

        return $this->render('admin/dashboard.html.twig', [
            'stats'      => $stats,
            'page_title' => 'Dashboard Admin — SchoolPrepar'
        ]);
    }
}