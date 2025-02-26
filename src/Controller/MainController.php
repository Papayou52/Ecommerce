<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('main/index.html.twig',[
            'categories' => $categoriesRepository->findBy([],['categoryOrder'=>'asc'])
        ]);
    }
}
