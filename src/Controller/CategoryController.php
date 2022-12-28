<?php

namespace App\Controller;

use App\Entity\Cycle;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\ServiceDashboard;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/{CycleId}", name="app_category_index", methods={"GET"})
     */
    public function index(Cycle $CycleId , ServiceDashboard $serviceDashboard , CategoryRepository $categoryRepository): Response
    {

        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), ["CycleId" => $CycleId]);
      
        $data["categories"] = $categoryRepository->findBy(['User' => $this->getUser()]);
        $data["BankAccounts"] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data["BankAccount"] = $BankAccountsAndCycleDashboard['BankAccount'];

        $data["cycle"] = $CycleId;
        return $this->render('category/index.html.twig', $data);
    }

    /**
     * @Route("/{CycleId}/new", name="app_category_new", methods={"GET", "POST"})
     */
    public function new(Cycle $CycleId , ServiceDashboard $serviceDashboard , Request $request, CategoryRepository $categoryRepository): Response
    {
        // dd($CycleId);
        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), ["CycleId" => $CycleId]);

        $category = new Category();
        $category->setUser($this->getUser());
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);
            return $this->redirectToRoute('app_category_index', ["CycleId" => $BankAccountsAndCycleDashboard['Cycle']->getId()], Response::HTTP_SEE_OTHER);
        }

        $data["BankAccounts"] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data["BankAccount"] = $BankAccountsAndCycleDashboard['BankAccount'];
        $data['category'] = $category;
        $data['cycle'] =  $BankAccountsAndCycleDashboard['Cycle'];

        $data['form'] = $form->createView();
        return $this->render('category/new.html.twig', $data);
    }

    /**
     * @Route("/{id}", name="app_category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**

     * @Route("/{CycleId}/{id}/edit", name="app_category_edit", methods={"GET", "POST"})
     */
    public function edit(ServiceDashboard $serviceDashboard ,Cycle $CycleId , Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $BankAccountsAndCycleDashboard = $serviceDashboard->getDashboard($this->getUser(), ["CycleId" => $CycleId]);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);


            return $this->redirectToRoute('app_category_index', ["CycleId" => $BankAccountsAndCycleDashboard['Cycle']->getId()], Response::HTTP_SEE_OTHER);
        }

        $data["categories"] = $categoryRepository->findBy(['User' => $this->getUser()]);
        $data["BankAccounts"] = $BankAccountsAndCycleDashboard['BankAccounts'];
        $data["BankAccount"] = $BankAccountsAndCycleDashboard['BankAccount'];
        $data["cycle"] = $CycleId;
        $data["form"] = $form;
        $data["category"] = $category;

        return $this->renderForm('category/edit.html.twig', $data);

    }

    /**
     * @Route("/{id}", name="app_category_delete", methods={"POST"})
     */
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $categoryRepository->remove($category, true);
        }

        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
