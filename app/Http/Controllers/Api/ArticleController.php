<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Repositories\ArticleRepository;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    public function __construct(private readonly ArticleRepository $repository)
    {
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        // return response()->json($this->repository->all());    // return all data
        $articles = $this->repository->all();
        // return new ArticleCollection($articles);            // return chosen (in Resource) data
        return ArticleResource::collection($articles); // return chosen (in Resource) data
    }

    public function show($id): ArticleResource|JsonResponse
    {
        $article = $this->repository->find($id);

        return $article
            // ? response()->json($article)              // return all data
            ? new ArticleResource($article)     // return chosen (in Resource) data
            : response()->json(['error' => 'Article not found'], 404);
    }

    public function store(StoreArticleRequest $request): ArticleResource
    {
        $article = $this->repository->store($request->validated());
        return new ArticleResource($article);
    }

    public function update(UpdateArticleRequest $request, int $id): ArticleResource|JsonResponse
    {
        /* Update via PUT/PATCH does NOT accept Body->Form-data (array), need json via Body->Raw (json)
        If POST should be ok */
        $article = $this->repository->update($request->validated(), $id);

        return $article
            ? new ArticleResource($article)
            : response()->json(['error' => 'Article not updated'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        $article = $this->repository->destroy($id);

        return $article
            ? response()->json(['message' => 'Article deleted'])
            : response()->json(['error' => 'Article not found'], 404);
    }
}
