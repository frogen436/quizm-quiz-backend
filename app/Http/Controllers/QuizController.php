<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Quiz;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Cookie;

use function PHPUnit\Framework\isEmpty;

class QuizController extends Controller
{
    public function create_quiz(Request $request)
    {
        $raw_cookie = $_COOKIE['users_access_token'];

        $response = Http::withHeader('Cookie', 'users_access_token='.$raw_cookie)->get("http://192.168.202.71:8888/api/v1/users:current-user/");

        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|integer|exists:categories,category_id',
        'description' => 'nullable|string',
        'details' => 'nullable|string',
        'questions' => 'nullable|array',
        ]);

        $validated['author_id'] = $response->json('data.id');

        $quiz = Quiz::create([
            'name' => trim($validated['name']),
            'category_id' => $validated['category_id'],
            'author_id' => $validated['author_id'],
        ]);

        try {
            $quiz->description = trim($validated['description']);
            $quiz->details = trim($validated['details']);
        } catch (\Exception $exception) {
        }

        foreach ($validated['questions'] as $question) {
            $new_question = $quiz->questions()->create(['content' => trim($question['content'])]);
            foreach ($question['answers'] as $answer) {
                $new_question->answers()->create(['content' => trim($answer)]);
            }
        }

        return response()->json($quiz, 201);
    }

    public function get_quiz_by_id($id)
    {
        $quiz = Quiz::query()->find($id);

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        return response()->json($quiz);
    }

    public function get_categories()
    {

        return response()->json(Category::all()->toArray());
    }

    public function get_questions($id)
    {
        $quiz = Quiz::with('questions')->find($id);

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $quiz->playcount = $quiz->playcount + 1;
        $quiz->save();
        return response()->json($quiz->questions->toArray());
    }

    public function check_answer(Request $request)
    {
        $quiz = Quiz::query()->find($request['quiz_id']);
        $question = $quiz->questions()->find($request['question_id']);
        $answers = $question->answers->toArray();

        foreach ($answers as $answer) {
            if (mb_strtolower($answer['content']) == mb_strtolower(trim($request['input']))) {
                return response()->json(["answer" => $answer['content']]);
            }
        }

        return response()->json(['message' => 'Answer not found'], 404);
    }

    public function search_quiz(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = $request->input('query');
        $perPage = $request->input('per_page', 10);

        $words = preg_split('/\s+/', $query); // разбиваем строку на слова

        $quizzes = Quiz::query();

        foreach ($words as $word) {
            $quizzes->orWhere('name', 'ILIKE', "%$word%");
        }

        return response()->json($quizzes->paginate($perPage));
    }

    public function search_quiz_by_category(Request $request, $categoryId)
    {
        $perPage = $request->input('per_page', 10); // по умолчанию 10 квизов на страницу

        $quizzes = Quiz::query()->where('category_id', $categoryId)->paginate($perPage);
        if ($quizzes->total() == 0) {
            return response()->json(['message' => 'Quizzes with this category not found'], 404);
        }
        return response()->json($quizzes);
    }

    public function get_random_quizzes(Request $request)
    {
        $count = $request->input('count', 10);
        $quizzes = Quiz::query()->inRandomOrder()->limit($count)->get();

        return response()->json($quizzes);
    }
}
