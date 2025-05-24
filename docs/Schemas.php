<?php

namespace Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CategoryResponse",
 *     type="object",
 *     description="Optional Schema-wrapper for examples for CategoryController's object",
 *     @OA\Property(
 *         property="data",
 *         ref="#/components/schemas/CategoryResponse",
 *     ),
 * ),
 *
 * @OA\Schema(
 *     schema="CategoryCollectionResponse",
 *     type="object",
 *     description="Optional Schema-wrapper for examples for CategoryController's collection",
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/CategoryResponse"),
 *     ),
 * ),
 *
 * @OA\Schema(
 *     schema="ArticleResponse",
 *     type="object",
 *     description="Optional Schema-wrapper for examples for ArticleController's object",
 *     @OA\Property(
 *         property="data",
 *         ref="#/components/schemas/ArticleResource",
 *     ),
 * ),
 *
 * @OA\Schema(
 *     schema="ArticleCollectionResponse",
 *     type="object",
 *     description="Optional Schema-wrapper for examples for ArticleController's collection",
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ArticleResource"),
 *     ),
 * ),
 */
class Schemas{}
