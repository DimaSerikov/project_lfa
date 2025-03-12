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
        if (app()->environment('testing') || app()->environment('local')) {
            return $this->loadMockData($params);
        }

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

    private function loadMockData(array $params = []): array
    {
        $mockPath = storage_path('app/mocks/nyt_best_sellers.json');

        if (!file_exists($mockPath)) {
            return ['error' => 'Mock file not found'];
        }

        $data = json_decode(file_get_contents($mockPath), true);
        $books = collect($data['results'] ?? []);

        if (!empty($params['author'])) {
            $books = $books->filter(fn($book) => str_contains(strtolower($book['author']), strtolower($params['author'])));
        }

        if (!empty($params['title'])) {
            $books = $books->filter(fn($book) => str_contains(strtolower($book['title']), strtolower($params['title'])));
        }

        if (!empty($params['isbn']) && is_array($params['isbn'])) {
            $books = $books->filter(fn($book) =>
                !empty($book['isbns']) &&
                collect($book['isbns'])->pluck('isbn13')->intersect($params['isbn'])->isNotEmpty()
            );
        }

        $offset = isset($params['offset']) ? max(0, (int) $params['offset']) : 0;
        $books = $books->slice($offset)->values();

        return [
            'status' => 'OK',
            'num_results' => $books->count(),
            'results' => $books->all()
        ];
    }
}
