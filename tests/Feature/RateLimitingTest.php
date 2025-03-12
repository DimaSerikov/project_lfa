<?php

use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    RateLimiter::clear('nyt_api_request:*'); // Очистка лимитов перед тестами
});

test('allows up to 10 requests within a minute', function () {
    $user = User::factory()->create();

    test()->actingAs($user, 'sanctum'); // Аутентификация пользователя

    for ($i = 0; $i < 10; $i++) {
        test()->getJson('/api/v1/best-sellers')->assertStatus(200);
    }

    $response = test()->getJson('/api/v1/best-sellers');
    $response->assertStatus(429)->assertSee('Too Many Attempts.');
});

test('rate limit exceeded returns correct status and message', function () {
    $user = User::factory()->create();
    test()->actingAs($user, 'sanctum');

    for ($i = 0; $i < 10; $i++) {
        test()->getJson('/api/v1/best-sellers')->assertStatus(200);
    }

    $response = test()->getJson('/api/v1/best-sellers');
    $response->assertStatus(429)->assertSee('Too Many Attempts.');
});
