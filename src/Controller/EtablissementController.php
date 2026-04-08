<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementController extends AbstractController
{
    #[Route('/etablissements', name: 'etablissements')]
    public function index(): Response
    {
        $etablissements = [
            ['id' => 1, 'nom' => 'iP Net Institute of Technology', 'sigle' => 'IPNIT', 'ville' => 'Lomé',       'type' => 'Institut Privé',     'filieres' => ['GL', 'WIM', 'RT']],
            ['id' => 2, 'nom' => 'ESGIS',                          'sigle' => 'ESGIS', 'ville' => 'Cotonou',    'type' => 'École Privée',       'filieres' => ['GL', 'Sécurité']],
            ['id' => 3, 'nom' => 'EPAC',                           'sigle' => 'EPAC',  'ville' => 'Porto-Novo', 'type' => 'Institut Publique',  'filieres' => ['GL', 'RT', 'WIM']],
            ['id' => 4, 'nom' => 'Université de Lomé',             'sigle' => 'UL',    'ville' => 'Lomé',       'type' => 'Université Publique', 'filieres' => ['GL', 'Sécurité', 'RT']],
        ];

        return $this->render('front/etablissement/index.html.twig', [
            'etablissements' => $etablissements,
            'page_title'     => 'Établissements — SchoolPrepar',
        ]);
    }
}
