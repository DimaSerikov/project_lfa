<?php

use App\Models\User;
use Illuminate\Support\Facades\Http;

// Test Registration
it('registers a user successfully', function () {
    $response = $this->postJson('/api/v1/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123'
    ]);

    $response->assertStatus(201)->assertJsonStructure(['user', 'token']);

    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
});

// Test Registration Validation
it('fails registration without required fields', function () {
    $response = $this->postJson('/api/v1/register', []);

    $response->assertStatus(422)->assertJsonValidationErrors(['name', 'email', 'password']);
});

// Test Login
it('logs in a user successfully', function () {
    $user = User::factory()->create(['password' => bcrypt('secret123')]);

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'secret123'
    ]);

    $response->assertStatus(200)->assertJsonStructure(['user', 'token']);
});

// Test Login Failure
it('rejects login with invalid credentials', function () {
    $response = $this->postJson('/api/v1/login', [
        'email' => 'nonexisting@example.com',
        'password' => 'invalidpassword'
    ]);

    $response->assertStatus(401);
});

// Test Authenticated User Endpoint
it('fetches authenticated user data', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/user');

    $response->assertStatus(200)
        ->assertJson([
            'id' => $user->id,
            'email' => $user->email,
        ]);
});

// Test Unauthenticated User Endpoint
it('rejects unauthenticated user request', function () {
    $response = $this->getJson('/api/v1/user');

    $response->assertStatus(401);
});

// Test Best Sellers Endpoint (success)
it('returns best sellers from NYT API', function () {
    Http::fake([
        '*' => Http::response(['results' => ['books' => [['title' => 'Test Book']]]], 200),
    ]);

    $user = User::factory()->create();
    $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/best-sellers?author=John');

    $response->assertStatus(200)->assertJson(['results' => ['books' => [['title' => 'Test Book']]]]);
});

// Test Best Sellers Endpoint (NYT API error)
it('handles NYT API failure gracefully', function () {
    Http::fake([
        '*' => Http::response(['fault' => 'API Error'], 500),
    ]);

    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/best-sellers');
    $response->assertStatus(500)->assertSee('NYT API request failed');
});

// Test Best Sellers Validation
it('validates best sellers request parameters', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/best-sellers?offset=invalid');
    $response->assertStatus(422)->assertJsonValidationErrors(['offset']);
});
