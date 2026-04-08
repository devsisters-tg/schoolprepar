<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $stats = [
            'students'  => 1240,
            'courses'   => 87,
            'exercises' => 3500,
        ];

        $recentCourses = [
            ['id' => 1, 'titre' => 'Mathématiques – Algèbre',  'niveau' => 'Terminale', 'categorie' => 'Maths'],
            ['id' => 2, 'titre' => 'Physique – Mécanique',     'niveau' => 'Première',  'categorie' => 'Physique'],
            ['id' => 3, 'titre' => 'Chimie – Thermodynamique', 'niveau' => 'Terminale', 'categorie' => 'Chimie'],
        ];

        return $this->render('front/home.html.twig', [
            'stats'          => $stats,
            'recent_courses' => $recentCourses,
            'page_title'     => 'Accueil — SchoolPrepar',
        ]);
    }
}
