<?php

namespace App\Controller\API;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class RecipesController extends AbstractController
{

    // function to get all recipes from the database and return them as a JSON response
    #[Route('/api/recipes', name: 'api.recipes.index')]
    public function index(RecipeRepository $repository): JsonResponse
    {
        $recipes = $repository->findAll();
        return $this->json($recipes, 200, [], ['groups' => 'recipes.index']);
    }

    #[Route('/api/recipes/{id}', name: 'api.recipes.show', requirements: ['id' => Requirement::DIGITS])]
    public function show(Recipe $recipe): JsonResponse
    {
        return $this->json($recipe, 200, [], [
            'groups' => ['recipes.show', 'recipes.index']
        ]);
    }
}