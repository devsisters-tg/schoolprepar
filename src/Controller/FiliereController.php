<?php

namespace App\Controller;

use App\Repository\FiliereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiliereController extends AbstractController
{
    /**
     * @Route("/filieres", name="filieres_index")
     */
    public function index(FiliereRepository $repo): Response
    {
        return $this->render('front/filiere/index.html.twig', [
            'filieres'   => $repo->findAll(),
            'page_title' => 'Filières — SchoolPrepar',
        ]);
    }

    /**
     * @Route("/filieres/{id}", name="filiere_show", requirements={"id"="\d+"})
     */
    public function show(int $id, FiliereRepository $repo): Response
    {
        $filiere = $repo->find($id);
        if (!$filiere) {
            throw $this->createNotFoundException('Filière non trouvée.');
        }
        return $this->render('front/filiere/show.html.twig', [
            'filiere'    => $filiere,
            'page_title' => 'Filière — ' . $filiere->getNom(),
        ]);
    }
}
