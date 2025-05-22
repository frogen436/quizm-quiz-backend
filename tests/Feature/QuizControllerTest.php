<?php

namespace Tests\Feature;

use App\Models\Quiz;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class QuizControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test] public function it_returns_paginated_quizzes_for_valid_category()
    {
        $category = Category::factory()->create();
        Quiz::factory()->count(5)->create(['category_id' => $category->category_id]);

        $response = $this->getJson("/api/v1/quizzes/by-category/{$category->category_id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'current_page',
                'last_page',
                'total',
            ])
            ->assertJsonCount(5, 'data');
    }

    #[Test] public function it_returns_404_when_no_quizzes_in_category()
    {
        $emptyCategory = 3;
        $response = $this->getJson("/api/v1/quizzes/by-category/{$emptyCategory}");

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Quizzes with this category not found',
            ]);
    }

    #[Test] public function it_returns_404_when_category_does_not_exist()
    {
        $nonExistentId = 9999;

        $response = $this->getJson("/api/v1/quizzes/by-category/{$nonExistentId}");

        $response->assertStatus(404);
    }

    #[Test] public function it_returns_404_when_quiz_does_not_exist()
    {
        $nonExistentQuiz = 9999;

        $response = $this->getJson("/api/v1/quizzes/{$nonExistentQuiz}");

        $response->assertStatus(404);
    }

    #[Test] public function it_returns_list_of_categories()
    {
        $response = $this->getJson("/api/v1/quizzes/categories");

        $response->assertStatus(200);
    }
}
