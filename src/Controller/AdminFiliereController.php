<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFiliereController extends AbstractController
{
    #[Route('/admin/filieres', name: 'admin_filieres')]
    public function index(): Response
    {
        $filieres = [
            ['id'=>1, 'nom'=>'GL', 'niveau'=>'L2'],
            ['id'=>2, 'nom'=>'Réseaux', 'niveau'=>'L2'],
            ['id'=>3, 'nom'=>'Sécurité', 'niveau'=>'L3']
        ];

        return $this->render('admin/filiere/index.html.twig', [
            'filieres'   => $filieres,
            'page_title' => 'Gestion des filières'
        ]);
    }
}