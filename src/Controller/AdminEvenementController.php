<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/evenements", name="admin_evenements_")
 */
class AdminEvenementController extends AbstractController
{
    /**
     * @Route("", name="index", methods={"GET"})
     */
    public function index(EvenementRepository $repo): Response
    {
        return $this->render('admin/evenement/index.html.twig', [
            'evenements' => $repo->findAll(),
            'page_title' => 'Gestion des événements',
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $evenement = new Evenement();
        $form      = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($evenement);
            $em->flush();
            $this->addFlash('success', 'Événement créé avec succès.');
            return $this->redirectToRoute('admin_evenements_index');
        }

        return $this->render('admin/evenement/new.html.twig', [
            'form'       => $form->createView(),
            'page_title' => 'Nouvel événement',
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('admin/evenement/show.html.twig', [
            'evenement'  => $evenement,
            'page_title' => 'Détail : ' . $evenement->getTitre(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Événement modifié avec succès.');
            return $this->redirectToRoute('admin_evenements_index');
        }

        return $this->render('admin/evenement/edit.html.twig', [
            'form'       => $form->createView(),
            'evenement'  => $evenement,
            'page_title' => 'Modifier : ' . $evenement->getTitre(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $evenement->getId(), $request->request->get('_token'))) {
            $em->remove($evenement);
            $em->flush();
            $this->addFlash('success', 'Événement supprimé.');
        }
        return $this->redirectToRoute('admin_evenements_index');
    }
}
