<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Form\EtablissementType;
use App\Repository\EtablissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/etablissements", name="admin_etablissements_")
 */
class AdminEtablissementController extends AbstractController
{
    /**
     * @Route("", name="index", methods={"GET"})
     */
    public function index(EtablissementRepository $repo): Response
    {
        return $this->render('admin/etablissement/index.html.twig', [
            'etablissements' => $repo->findAll(),
            'page_title'     => 'Gestion des établissements',
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $etablissement = new Etablissement();
        $form          = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($etablissement);
            $em->flush();
            $this->addFlash('success', 'Établissement créé avec succès.');
            return $this->redirectToRoute('admin_etablissements_index');
        }

        return $this->render('admin/etablissement/new.html.twig', [
            'form'       => $form->createView(),
            'page_title' => 'Nouvel établissement',
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Etablissement $etablissement): Response
    {
        return $this->render('admin/etablissement/show.html.twig', [
            'etablissement' => $etablissement,
            'page_title'    => 'Détail : ' . $etablissement->getNom(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Etablissement $etablissement, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Établissement modifié avec succès.');
            return $this->redirectToRoute('admin_etablissements_index');
        }

        return $this->render('admin/etablissement/edit.html.twig', [
            'form'          => $form->createView(),
            'etablissement' => $etablissement,
            'page_title'    => 'Modifier : ' . $etablissement->getNom(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Etablissement $etablissement, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $etablissement->getId(), $request->request->get('_token'))) {
            $em->remove($etablissement);
            $em->flush();
            $this->addFlash('success', 'Établissement supprimé.');
        }
        return $this->redirectToRoute('admin_etablissements_index');
    }
}
