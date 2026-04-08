<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiliereController extends AbstractController
{
    #[Route('/filieres', name: 'filieres')]
    public function index(): Response
    {
        $filieres = [
            ['id' => 1, 'nom' => 'Génie Logiciel',          'niveau' => 'Licence 2', 'description' => 'Formation en développement logiciel et architecture système.'],
            ['id' => 2, 'nom' => 'Réseaux Informatiques',   'niveau' => 'Licence 2', 'description' => 'Formation en administration réseau et sécurité informatique.'],
            ['id' => 3, 'nom' => 'Sécurité Informatique',   'niveau' => 'Licence 3', 'description' => 'Formation avancée en cybersécurité et protection des systèmes.'],
            ['id' => 4, 'nom' => 'Web & Internet Mobile',   'niveau' => 'Licence 2', 'description' => 'Formation en développement web, mobile et technologies internet.'],
        ];

        return $this->render('front/filiere/index.html.twig', [
            'filieres'   => $filieres,
            'page_title' => 'Filières — SchoolPrepar',
        ]);
    }

    #[Route('/filieres/{id}', name: 'filiere_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $filieres = [
            1 => ['id' => 1, 'nom' => 'Génie Logiciel',        'niveau' => 'Licence 2', 'description' => 'Cette filière forme des développeurs spécialisés en logiciels et applications. Les étudiants apprennent la conception, le développement et la maintenance des systèmes informatiques.', 'duree' => '3 ans', 'debouches' => ['Développeur Full-Stack', 'Architecte Logiciel', 'Chef de Projet IT']],
            2 => ['id' => 2, 'nom' => 'Réseaux Informatiques', 'niveau' => 'Licence 2', 'description' => 'Formation spécialisée en infrastructure réseau, protocoles et administration systèmes. Les diplômés maîtrisent la configuration et sécurisation des réseaux d\'entreprise.', 'duree' => '3 ans', 'debouches' => ['Administrateur Réseau', 'Ingénieur Sécurité', 'Expert Télécoms']],
            3 => ['id' => 3, 'nom' => 'Sécurité Informatique', 'niveau' => 'Licence 3', 'description' => 'Formation avancée en cybersécurité, ethical hacking et forensics. Les étudiants apprennent à protéger les systèmes contre les menaces modernes.', 'duree' => '3 ans', 'debouches' => ['Expert Cybersécurité', 'Analyste SOC', 'Consultant Sécurité']],
            4 => ['id' => 4, 'nom' => 'Web & Internet Mobile', 'niveau' => 'Licence 2', 'description' => 'Formation complète en développement web front-end et back-end, ainsi qu\'en développement d\'applications mobiles iOS et Android.', 'duree' => '3 ans', 'debouches' => ['Développeur Web', 'Développeur Mobile', 'UX/UI Designer']],
        ];

        $filiere = $filieres[$id] ?? null;

        if (!$filiere) {
            throw $this->createNotFoundException('Filière non trouvée.');
        }

        return $this->render('front/filiere/show.html.twig', [
            'filiere'    => $filiere,
            'page_title' => 'Filière — ' . $filiere['nom'],
        ]);
    }
}
