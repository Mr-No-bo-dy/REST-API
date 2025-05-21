<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Repositories\ArticleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Articles",
 *     description="Operations with Articles",
 * ),
 *
 * @OA\SecurityRequirement(name="bearerAuth"),
 */
class ArticleController extends Controller
{
    public function __construct(private readonly ArticleRepository $repository)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/articles",
     *     tags={"Articles"},
     *     summary="Get all articles",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Get list of articles",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/ArticleResource"),
     *         ),
     *     ),
     * ),
     */
    public function index(): AnonymousResourceCollection
    {
        // return response()->json($this->repository->all());    // return all data

        $articles = $this->repository->all();

        // return new ArticleCollection($articles);            // return chosen (in Resource) data
        return ArticleResource::collection($articles); // return chosen (in Resource) data
    }

    /**
     * @OA\Get(
     *     path="/api/v1/articles/{id}",
     *     tags={"Articles"},
     *     summary="Get one Article",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Article's ID",
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get one Article by it's ID",
     *         @OA\JsonContent(ref="#/components/schemas/ArticleResource"),
     *     ),
     *     @OA\Response(response=404, description="Article not found"),
     * ),
     */
    public function show($id): ArticleResource|JsonResponse
    {
        $article = $this->repository->find($id);

        return $article
            // ? response()->json($article)              // return all data
            ? new ArticleResource($article)     // return chosen (in Resource) data
            : response()->json(['error' => 'Article not found'], 404);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/articles",
     *     tags={"Articles"},
     *     summary="Create new Article",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreArticleRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get one Article by it's ID",
     *         @OA\JsonContent(ref="#/components/schemas/ArticleResource"),
     *     ),
     *     @OA\Response(response=404, description="Article not found"),
     * ),
     */
    public function store(StoreArticleRequest $request): ArticleResource
    {
        $article = $this->repository->store($request->validated());

        return new ArticleResource($article);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/articles/{id}",
     *     tags={"Articles"},
     *     summary="Update existing Article",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateArticleRequest"),
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Article's ID",
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Updated chosen Article with given data",
     *         @OA\JsonContent(ref="#/components/schemas/ArticleResource"),
     *     ),
     *     @OA\Response(response=404, description="Article not updated"),
     * ),
     */
    public function update(UpdateArticleRequest $request, int $id): ArticleResource|JsonResponse
    {
        /* Update via PUT/PATCH does NOT accept Body->Form-data (array), need json via Body->Raw (json)
        If POST should be ok */
        $article = $this->repository->update($request->validated(), $id);

        return $article
            ? new ArticleResource($article)
            : response()->json(['error' => 'Article not updated'], 404);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/articles/{id}",
     *     tags={"Articles"},
     *     summary="Delete chosen Article",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Article's ID",
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Delete Article by it's ID",
     *     ),
     *     @OA\Response(response=404, description="Article not found"),
     * ),
     */
    public function destroy(int $id): JsonResponse
    {
        $article = $this->repository->destroy($id);

        return $article
            ? response()->json(['message' => 'Article deleted'])
            : response()->json(['error' => 'Article not found'], 404);
    }
}
