<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Lendflow Assessment Test",
 *     version="1.0.0"
 * )
 *
 * @OA\Get(
 *     path="/api/v1/best-sellers",
 *     operationId="getBestSellers",
 *     tags={"Best Sellers"},
 *     summary="Get Best Sellers from NYT",
 *     description="Fetches a list of best sellers from the New York Times API",
 *     security={{"sanctum": {}}},
 *     @OA\Parameter(name="author", in="query", required=false, @OA\Schema(type="string")),
 *     @OA\Parameter(name="isbn[]", in="query", @OA\Schema(type="array", @OA\Items(type="string"))),
 *     @OA\Parameter(name="title", in="query", required=false, @OA\Schema(type="string")),
 *     @OA\Parameter(name="offset", in="query", required=false, @OA\Schema(type="integer", minimum=0)),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *         @OA\JsonContent(type="object")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
class BestSellerController extends Controller
{
}
