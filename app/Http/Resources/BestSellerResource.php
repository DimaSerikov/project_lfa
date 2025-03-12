<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BestSellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => data_get($this, 'title', 'Unknown Title'),
            'description' => data_get($this, 'description', 'No description available'),
            'author' => data_get($this, 'author', 'Unknown Author'),
            'contributor' => data_get($this, 'contributor'),
            'publisher' => data_get($this, 'publisher', 'Unknown Publisher'),
            'price' => (float) data_get($this, 'price', 0.00),
            'isbns' => collect(data_get($this, 'isbns', []))->pluck('isbn13')->all(),
            'rank_history' => collect(data_get($this, 'ranks_history', []))->map(fn($rank) => [
                'rank' => data_get($rank, 'rank'),
                'list_name' => data_get($rank, 'list_name'),
                'published_date' => data_get($rank, 'published_date'),
                'weeks_on_list' => data_get($rank, 'weeks_on_list'),
            ])->all(),
        ];
    }
}
