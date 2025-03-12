<?php

namespace App\Http\Controllers\Swagger\Api\V1;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *      path="/api/v1/user",
 *      tags={"User"},
 *      summary="Get authenticated user info",
 *      security={{"sanctum": {}}},
 *      @OA\Response(
 *          response=200,
 *          description="Successful retrieval of user data",
 *          @OA\JsonContent(
 *              @OA\Property(property="id", type="integer"),
 *              @OA\Property(property="name", type="string"),
 *              @OA\Property(property="email", type="string")
 *          )
 *      ),
 *      @OA\Response(response=401, description="Unauthenticated")
 *  )
 */
class UserController extends Controller
{
}
