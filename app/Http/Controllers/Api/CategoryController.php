<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Categories",
 *     description="Operations with Categories",
 * ),
 *
 * @OA\SecurityRequirement(name="bearerAuth"),
 */
class CategoryController extends Controller
{
    public function __construct(private readonly CategoryRepository $repository)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/categories",
     *     tags={"Categories"},
     *     summary="Get all categories",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Get list of categories",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/CategoryResource"),
     *         ),
     *     ),
     * ),
     */
    public function index(): AnonymousResourceCollection
    {
        // return response()->json($this->repository->all());    // return all data
        $categories = $this->repository->all();

        return CategoryResource::collection($categories);   // return chosen (in Resource) data
    }

    /**
     * @OA\Get(
     *     path="/api/v1/categories/{id}",
     *     tags={"Categories"},
     *     summary="Get one Category",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Category's ID",
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get one Category by it's ID",
     *         @OA\JsonContent(ref="#/components/schemas/CategoryResource"),
     *     ),
     *     @OA\Response(response=404, description="Category not found"),
     * ),
     */
    public function show($id): CategoryResource|JsonResponse
    {
        $category = $this->repository->find($id);

        return $category
            // ? response()->json($category)              // return all data
            ? new CategoryResource($category)     // return chosen (in Resource) data
            : response()->json(['error' => 'Category not found'], 404);
    }
}
