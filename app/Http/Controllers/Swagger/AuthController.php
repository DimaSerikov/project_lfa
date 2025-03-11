<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *      path="/api/v1/register",
 *      tags={"Auth"},
 *      summary="Register a new user",
 *      operationId="registerUser",
 *      security={{"sanctum": {}}},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"name","email","password"},
 *              @OA\Property(property="name", type="string", example="John Doe"),
 *              @OA\Property(property="email", type="string", example="john@example.com"),
 *              @OA\Property(property="password", type="string", example="secret123")
 *          )
 *      ),
 *      @OA\Response(response=201, description="User registered successfully"),
 *      @OA\Response(response=422, description="Validation errors")
 *  )
 *
 * @OA\Post(
 *      path="/api/v1/login",
 *      tags={"Auth"},
 *      summary="User login",
 *      description="Authenticate a user and return an API token",
 *      security={{"sanctum": {}}},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"email","password"},
 *              @OA\Property(property="email", type="string", example="john@example.com"),
 *              @OA\Property(property="password", type="string", example="password123")
 *          ),
 *      ),
 *      @OA\Response(response=200, description="Successful login",
 *          @OA\JsonContent(
 *              @OA\Property(property="token", type="string"),
 *              @OA\Property(property="user", type="object")
 *          )
 *      ),
 *      @OA\Response(response=401, description="Invalid credentials")
 *  )
 */
class AuthController extends Controller
{
}
