<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/company")
 */
class CompaniesCrudController extends AbstractController
{
    /**
     * @Route("/new", name="app_companies_crud_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CompanyRepository $companyRepository): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRepository->add($company, true);

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('companies_crud/new.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_companies_crud_show", methods={"GET"})
     */
    public function show(Company $company): Response
    {
        return $this->render('companies_crud/show.html.twig', [
            'company' => $company,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_companies_crud_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Company $company, CompanyRepository $companyRepository): Response
    {
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRepository->add($company, true);

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('companies_crud/edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_companies_crud_delete", methods={"POST"})
     */
    public function delete(Request $request, Company $company, CompanyRepository $companyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$company->getId(), $request->request->get('_token'))) {
            $companyRepository->remove($company, true);
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
