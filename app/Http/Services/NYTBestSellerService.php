<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class NYTBestSellerService
{
    public function __construct(
        protected string $baseUrl = '',
        protected string $apiKey = '',
        protected int $cacheTtl = 60
    ) {
        $this->baseUrl = config('services.nyt.base_url', $this->baseUrl);
        $this->apiKey = config('services.nyt.key', $this->apiKey);
        $this->cacheTtl = config('services.nyt.cache_ttl', 60);
    }

    public function getBestSellers(array $params): array
    {
        $params['api-key'] = $this->apiKey;
        $cacheKey = 'nyt_' . md5(json_encode($params));

        return cache()->remember($cacheKey, now()->addMinutes($this->cacheTtl), function () use ($params) {
            $response = Http::get("{$this->baseUrl}/lists/best-sellers/history.json", $params);

            if ($response->failed()) {
                abort($response->status(), 'NYT API request failed.');
            }

            return $response->json();
        });
    }
}
