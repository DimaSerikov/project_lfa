<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BestSellerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_results' => $this->collection->count(),
            'books' => BestSellerResource::collection($this->collection),
            'timestamp' => now()->toIso8601String()
        ];
    }
}
