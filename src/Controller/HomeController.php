<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GameRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @Route("/page/{page}", name="home_paginated")
     */
    public function index(GameRepository $gameReposity, PaginatorInterface $paginator, $page = 1): Response
    {
        $games = $gameReposity->getLatestPaginatedGames($paginator, $page);
        $games->setUsedRoute('home_paginated');

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'games' => $games
        ]);
    }
}
