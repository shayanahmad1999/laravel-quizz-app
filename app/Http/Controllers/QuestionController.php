<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    /**
     * Show the form for creating a new question.
     */
    public function create(Quiz $quiz)
    {
        return view('questions.create', compact('quiz'));
    }

    /**
     * Store a newly created question in storage.
     */
    public function store(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,short_answer',
            'points' => 'required|integer|min:1',
            'answers' => 'array',
            'answers.*.answer_text' => 'required|string|max:255',
            'answers.*.is_correct' => 'nullable|boolean',
            // 'correct_answers' => 'array|required_if:question_type,multiple_choice,true_false',
        ]);

        $question = $quiz->questions()->create([
            'question_text' => $request->question_text,
            'question_type' => $request->question_type,
            'points' => $request->points,
        ]);

        // Save answers if it's a multiple choice or true/false question
        if (in_array($request->question_type, ['multiple_choice', 'true_false']) && $request->has('answers')) {
            foreach ($request->answers as $answerData) {
                $question->answers()->create([
                    'answer_text' => $answerData['answer_text'],
                    'is_correct' => $answerData['is_correct'] ?? false,
                ]);
            }
        }

        return redirect()->route('quizzes.show', $quiz->id)
            ->with('success', 'Question added successfully!');
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(Quiz $quiz, Question $question)
    {
        $question->load('answers');
        return view('questions.edit', compact('quiz', 'question'));
    }

    /**
     * Update the specified question in storage.
     */
    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,short_answer',
            'points' => 'required|integer|min:1',
            'answers' => 'array',
            'answers.*.answer_text' => 'required|string|max:255',
            'answers.*.is_correct' => 'nullable|boolean',
        ]);

        $question->update([
            'question_text' => $request->question_text,
            'question_type' => $request->question_type,
            'points' => $request->points,
        ]);

        // Update answers if it's a multiple choice or true/false question
        if (in_array($request->question_type, ['multiple_choice', 'true_false'])) {
            // Delete existing answers
            $question->answers()->delete();

            // Create new answers
            if ($request->has('answers')) {
                foreach ($request->answers as $answerData) {
                    $question->answers()->create([
                        'answer_text' => $answerData['answer_text'],
                        'is_correct' => $answerData['is_correct'] ?? false,
                    ]);
                }
            }
        }

        return redirect()->route('quizzes.show', $quiz->id)
            ->with('success', 'Question updated successfully!');
    }

    /**
     * Remove the specified question from storage.
     */
    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();

        return redirect()->route('quizzes.show', $quiz->id)
            ->with('success', 'Question deleted successfully!');
    }
}
