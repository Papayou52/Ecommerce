<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Form\ProductsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/products', name: 'admin_products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request,EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Créer un nouveau produit
        $product = new Products();

        //  On crée le formulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        //Traitement de la requete du formulaire
        $productForm->handleRequest($request);

        // Vérification du formulaire (soumis et valide)
        if($productForm->isSubmitted() && $productForm->isValid()){

            //On arrondit le prix
            $prix= $product->getPrice() * 100;
            $product->setPrice($prix);


            //Stockage
            $em->persist($product);
            $em->flush();

            //Redirection
            return $this->redirectToRoute('admin_products_index');

        }


        // return $this->render('admin/products/add.html.twig',[
        //     'productForm'=>$productForm->createView()
        // ]);

        return $this->renderForm('admin/products/add.html.twig',compact('productForm'));
    }






    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Products $product,Request $request,EntityManagerInterface $em): Response
    {

        // On utilise le Voter
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);

        //On divise le prix par 100
        $prix= $product->getPrice() / 100;
        $product->setPrice($prix);

        //  On crée le formulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        //Traitement de la requete du formulaire
        $productForm->handleRequest($request);

        // Vérification du formulaire (soumis et valide)
        if($productForm->isSubmitted() && $productForm->isValid()){

            //On arrondit le prix
            $prix= $product->getPrice() * 100;
            $product->setPrice($prix);

            //Stockage
            $em->persist($product);
            $em->flush();

            //Redirection
            return $this->redirectToRoute('admin_products_index');

        }
        return $this->renderForm('admin/products/edit.html.twig',compact('productForm'));
    }

    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Products $product): Response
    {
        $this->denyAccessUnlessGranted('PRODUCT_DELETE', $product);
        return $this->render('admin/products/index.html.twig');
    }
}
