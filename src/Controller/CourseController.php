<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends AbstractController
{
    public function index(): Response
    {
        $courses = [
            ['id' => 1, 'titre' => 'Algèbre Linéaire',     'niveau' => 'Terminale', 'categorie' => 'Maths',    'nb_exercices' => 24],
            ['id' => 2, 'titre' => 'Mécanique Newtonienne', 'niveau' => 'Première',  'categorie' => 'Physique', 'nb_exercices' => 18],
            ['id' => 3, 'titre' => 'Équilibres Chimiques',  'niveau' => 'Terminale', 'categorie' => 'Chimie',   'nb_exercices' => 15],
            ['id' => 4, 'titre' => 'Grammaire Avancée',     'niveau' => 'Seconde',   'categorie' => 'Français', 'nb_exercices' => 30],
        ];

        return $this->render('course/index.html.twig', [
            'courses'    => $courses,
            'page_title' => 'Cours disponibles — SchoolPrepar',
        ]);
    }

}