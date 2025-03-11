<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BestSellerRequest;
use App\Http\Services\NYTBestSellerService;
use Illuminate\Http\JsonResponse;

class BestSellerController extends Controller
{
    public function index(BestSellerRequest $request, NYTBestSellerService $service): JsonResponse
    {
        return response()->json($service->getBestSellers($request->validated()));
    }
}
