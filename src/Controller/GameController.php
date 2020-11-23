<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Game;
use App\Form\GameType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GameRepository;

class GameController extends AbstractController
{
    /**
     * @Route("/game/{id}\d+>", name="game_details")
     * @param Game $game
     * @return Response
     */
    public function gameDetails(Game $game): Response
    {
        return $this->render('game/details.html.twig', [
            'game' => $game,
        ]);
    }


    /**
     * @Route("/game/add", name="game_add")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function gameForm(Request $request, EntityManagerInterface $manager): Response
    {
        $game = new Game();

        $gameForm = $this->createForm(GameType::class, $game);

        $gameForm->handleRequest($request);

        if($gameForm->isSubmitted() && $gameForm->isValid()){

            $game->setDateAdd(new DateTime());
            $game->setUser($this->getUser());

            $manager->persist($game);
            $manager->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('game/game-form.html.twig', [
            'game_form' => $gameForm->createView()
    ]);
    }

    /**
     * @Route("game/category/{slug}", name="game_by_category")
     * @param Category $category
     * @param GameRepository $gameRepository
     * @return Response
     */
    public function getProductByCategory(Category $category, GameRepository $gameRepository)
    {
        $games = $gameRepository->findByCategory($category);
        return $this->render('game/game-by-category.html.twig', [
            'category' => $category,
            'games' => $games
        ]);
    }
}
