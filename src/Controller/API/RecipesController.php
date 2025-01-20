<?php

namespace App\Controller\API;

use App\DTO\PaginationTDO;
use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;

class RecipesController extends AbstractController
{

    // function to get all recipes from the database and return them as a JSON response
    #[Route('/api/recipes', name: 'api.recipes.index', methods: ['GET'])]
    public function index(
        Request          $request,
        RecipeRepository $repository,
        #[MapQueryString]
        PaginationTDO    $pagination
    ): JsonResponse
    {
        $recipes = $repository->paginateRecipes($pagination->page);
        return $this->json($recipes, 200, [], ['groups' => 'recipes.index']);
    }

    #[Route('/api/recipes/{id}', name: 'api.recipes.show', requirements: ['id' => Requirement::DIGITS])]
    public function show(Recipe $recipe): JsonResponse
    {
        return $this->json($recipe, 200, [], [
            'groups' => ['recipes.show', 'recipes.index']
        ]);
    }

    #[Route('/api/recipes', name: 'api.recipes.create', methods: ['POST'])]
    public function create(
        Request                $request,
        SerializerInterface    $serializer,
        EntityManagerInterface $em
    ): JsonResponse
    {
        $data = $request->getContent();
        $recipe = $serializer->deserialize($data, Recipe::class, 'json', [
            'groups' => 'recipes.create'
        ]);
        $recipe->setCreatedAt(new \DateTimeImmutable());
        $recipe->setUpdatedAt(new \DateTimeImmutable());

        $em->persist($recipe);
        $em->flush();

        return $this->json($recipe, 201, []);
    }
}