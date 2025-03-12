<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BestSellerRequest;
use App\Http\Resources\BestSellerCollection;
use App\Http\Services\NYTBestSellerService;

class BestSellerController extends Controller
{
    public function index(BestSellerRequest $request, NYTBestSellerService $service): BestSellerCollection
    {
        $data = $service->getBestSellers($request->validated());

        return new BestSellerCollection(collect($data['results']));
    }
}
