<?php

namespace App\Controller;
use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/categories',name:'categories_')]
class CategoriesController extends AbstractController
{

    #[Route('/{name}', name: 'list')]
    public function list(Categories $category) : Response {
        

        //liste des produits
        $products = $category->getProducts();

        return $this->render('categories/list.html.twig',compact('category','products'));
    }
}
