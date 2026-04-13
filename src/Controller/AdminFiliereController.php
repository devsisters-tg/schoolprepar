<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Form\FiliereType;
use App\Repository\FiliereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/filieres", name="admin_filieres_")
 */
class AdminFiliereController extends AbstractController
{
    /**
     * @Route("", name="index", methods={"GET"})
     */
    public function index(FiliereRepository $repo): Response
    {
        return $this->render('admin/filiere/index.html.twig', [
            'filieres'   => $repo->findAll(),
            'page_title' => 'Gestion des filières',
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $filiere = new Filiere();
        $form    = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($filiere);
            $em->flush();
            $this->addFlash('success', 'Filière créée avec succès.');
            return $this->redirectToRoute('admin_filieres_index');
        }

        return $this->render('admin/filiere/new.html.twig', [
            'form'       => $form->createView(),
            'page_title' => 'Nouvelle filière',
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Filiere $filiere): Response
    {
        return $this->render('admin/filiere/show.html.twig', [
            'filiere'    => $filiere,
            'page_title' => 'Détail : ' . $filiere->getNom(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Filiere $filiere, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Filière modifiée avec succès.');
            return $this->redirectToRoute('admin_filieres_index');
        }

        return $this->render('admin/filiere/edit.html.twig', [
            'form'       => $form->createView(),
            'filiere'    => $filiere,
            'page_title' => 'Modifier : ' . $filiere->getNom(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Filiere $filiere, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $filiere->getId(), $request->request->get('_token'))) {
            $em->remove($filiere);
            $em->flush();
            $this->addFlash('success', 'Filière supprimée.');
        }
        return $this->redirectToRoute('admin_filieres_index');
    }
}
