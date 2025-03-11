## API integrations and Code Reusability
* Implemented a clean architecture: separated logic into a dedicated service class (NYTBestSellerService) instead of calling external APIs directly from the controller.
* Used strict typing for both input and output data.
* Added Swagger API documentation to make integration easier for other teams.

## API Versioning and Breaking Change Strategies
* APIs evolve over time, and versioning prevents breaking changes when updates are introduced.

```php
Route::prefix('v1')->group(function () {
    Route::get('best-sellers', [BestSellerController::class, 'index']);
});
```
* If a future v2 is needed, a new controller can be added without breaking existing clients:
```php
Route::prefix('v2')->group(function () {
    Route::get('best-sellers', [NewBestSellerController::class, 'index']);
});
```

## Caching
* Implemented caching at the service level:
```php
return cache()->remember($cacheKey, now()->addMinutes($this->cacheTtl), function () use ($params) {
    return Http::get("{$this->baseUrl}/lists/best-sellers/history.json", $params)->json();
});
```
## Cross-environment Testing
* Disabled real API requests in tests by faking HTTP responses:
* Configured the application to work with multiple environments using .env settings:
```php
APP_ENV=local
APP_ENV=testing
APP_ENV=production
```
