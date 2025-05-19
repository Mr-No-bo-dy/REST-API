<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryRepository $repository)
    {
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        // return response()->json($this->repository->all());    // return all data
        $categories = $this->repository->all();

        return CategoryResource::collection($categories);   // return chosen (in Resource) data
    }

    public function show($id): CategoryResource|JsonResponse
    {
        $category = $this->repository->find($id);

        return $category
            // ? response()->json($category)              // return all data
            ? new CategoryResource($category)     // return chosen (in Resource) data
            : response()->json(['error' => 'Category not found'], 404);
    }
}
