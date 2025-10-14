<?php

namespace App\Controller;

use App\Entity\Coffeeshop;
use App\Form\CoffeeshopType;
use App\Repository\CoffeeshopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/coffeeshop')]
class CoffeeshopController extends AbstractController
{
    #[Route('/', name: 'coffeeshop_index', methods: ['GET'])]
    public function index(CoffeeshopRepository $repo): Response
    {
        $coffeeshops = $repo->findAll();
        return $this->render('coffeeshop/index.html.twig', [
            'coffeeshops' => $coffeeshops,
        ]);
    }

    #[Route('/new', name: 'coffeeshop_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $coffeeshop = new Coffeeshop();
        $form = $this->createForm(CoffeeshopType::class, $coffeeshop);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($coffeeshop);
            $em->flush();

            $this->addFlash('success', 'Coffeeshop créé avec succès.');
            return $this->redirectToRoute('coffeeshop_index');
        }

        return $this->render('coffeeshop/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'coffeeshop_show', methods: ['GET'])]
    public function show(Coffeeshop $coffeeshop): Response
    {
        return $this->render('coffeeshop/show.html.twig', [
            'coffeeshop' => $coffeeshop,
        ]);
    }

    #[Route('/{id}/edit', name: 'coffeeshop_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Coffeeshop $coffeeshop, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CoffeeshopType::class, $coffeeshop);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->flush();
            $this->addFlash('success', 'Coffeeshop mis à jour.');
            return $this->redirectToRoute('coffeeshop_index');
        }

        return $this->render('coffeeshop/edit.html.twig', [
            'coffeeshop' => $coffeeshop,
            'form' => $form->createView(),
        ]);
    }

#[Route('/delete/{id}', name: 'coffeeshop_delete')]
public function delete($id, CoffeeshopRepository $repo, EntityManagerInterface $em): Response
{
    $coffeeshop = $repo->find($id);

    if ($coffeeshop) {
        $em->remove($coffeeshop);
        $em->flush();
    }

    return $this->redirectToRoute('coffeeshop_index');
}
}
