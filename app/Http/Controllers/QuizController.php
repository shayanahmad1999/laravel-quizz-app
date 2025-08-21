<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of the quizzes.
     */
    public function index()
    {
        $quizzes = Quiz::where('is_active', true)->get();
        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new quiz.
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created quiz in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        $quiz = Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => true,
            'passing_score' => $request->passing_score,
        ]);

        return redirect()->route('quizzes.show', $quiz->id)
            ->with('success', 'Quiz created successfully!');
    }

    /**
     * Display the specified quiz.
     */
    public function show(Quiz $quiz)
    {
        $quiz->load('questions.answers');
        return view('quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified quiz.
     */
    public function edit(Quiz $quiz)
    {
        return view('quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified quiz in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'passing_score' => $request->passing_score,
        ]);

        return redirect()->route('quizzes.show', $quiz->id)
            ->with('success', 'Quiz updated successfully!');
    }

    /**
     * Remove the specified quiz from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz deleted successfully!');
    }

    /**
     * Start taking a quiz.
     */
    public function take(Quiz $quiz)
    {
        // Check if user has an unfinished attempt
        $attempt = Auth::user()->quizAttempts()
            ->where('quiz_id', $quiz->id)
            ->where('is_completed', false)
            ->first();

        if (!$attempt) {
            // Create a new attempt
            $attempt = Auth::user()->quizAttempts()->create([
                'quiz_id' => $quiz->id,
                'started_at' => now(),
            ]);
        }

        // Load questions and answers
        $quiz->load('questions.answers');

        return view('quizzes.take', compact('quiz', 'attempt'));
    }
}