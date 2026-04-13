<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use App\Repository\EvenementRepository;
use App\Repository\FiliereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(
        FiliereRepository      $filiereRepo,
        EtablissementRepository $etabRepo,
        EvenementRepository    $evRepo
    ): Response {
        return $this->render('admin/dashboard.html.twig', [
            'page_title'        => 'Dashboard',
            'nb_filieres'       => count($filiereRepo->findAll()),
            'nb_etablissements' => count($etabRepo->findAll()),
            'nb_evenements'     => count($evRepo->findAll()),
            'prochains_evts'    => $evRepo->findUpcoming(),
        ]);
    }
}
