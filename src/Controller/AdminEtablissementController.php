<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminEtablissementController extends AbstractController
{
    #[Route('/admin/etablissements', name: 'admin_etablissements')]
    public function index(): Response
    {
        $etablissements = [
            ['id'=>1, 'nom'=>'IPNET', 'ville'=>'Cotonou'],
            ['id'=>2, 'nom'=>'ESGIS', 'ville'=>'Cotonou'],
            ['id'=>3, 'nom'=>'EPAC', 'ville'=>'Porto-Novo'],
        ];

        return $this->render('admin/etablissement/index.html.twig', [
            'etablissements' => $etablissements,
            'page_title' => 'Gestion des établissements'
        ]);
    }
}