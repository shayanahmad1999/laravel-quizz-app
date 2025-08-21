<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Question;
use App\Models\Answer;
use App\Models\UserAnswer;
use Illuminate\Http\Request;

class QuizAttemptController extends Controller
{
    /**
     * Store a user's answer to a question.
     */
    public function storeAnswer(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'nullable|exists:answers,id',
            'short_answer' => 'nullable|string|max:1000',
        ]);

        $question = Question::findOrFail($request->question_id);

        // Check if user already answered this question
        $userAnswer = $attempt->userAnswers()
            ->where('question_id', $question->id)
            ->first();

        if (!$userAnswer) {
            $userAnswer = new UserAnswer([
                'quiz_attempt_id' => $attempt->id,
                'question_id' => $question->id,
            ]);
        }

        // Save the answer based on question type
        if ($question->question_type === 'short_answer') {
            $userAnswer->short_answer = $request->short_answer;
            $userAnswer->answer_id = null;
            $userAnswer->is_correct = null; // Will be graded manually
        } else {
            $userAnswer->answer_id = $request->answer_id;
            $userAnswer->short_answer = null;
            
            // Check if the selected answer is correct
            $selectedAnswer = Answer::find($request->answer_id);
            $userAnswer->is_correct = $selectedAnswer ? $selectedAnswer->is_correct : false;
        }

        $userAnswer->save();

        // Check if all questions have been answered
        $totalQuestions = $quiz->questions()->count();
        $answeredQuestions = $attempt->userAnswers()->count();

        if ($answeredQuestions >= $totalQuestions) {
            // All questions answered, complete the quiz
            return $this->completeQuiz($attempt);
        }

        // Redirect to next unanswered question or complete quiz
        return redirect()->back()->with('success', 'Answer saved!');
    }

    /**
     * Complete the quiz and calculate score.
     */
    public function completeQuiz(QuizAttempt $attempt)
    {
        // Calculate score
        $correctAnswers = $attempt->userAnswers()->where('is_correct', true)->count();
        $totalQuestions = $attempt->quiz->questions()->count();
        
        // Calculate points-based score
        $totalPoints = $attempt->quiz->questions()->sum('points');
        $earnedPoints = $attempt->userAnswers()
            ->join('questions', 'user_answers.question_id', '=', 'questions.id')
            ->where('user_answers.is_correct', true)
            ->sum('questions.points');

        $attempt->update([
            'score' => $earnedPoints,
            'total_points' => $totalPoints,
            'completed_at' => now(),
            'is_completed' => true,
        ]);

        return redirect()->route('quizzes.results', [$attempt->quiz->id, $attempt->id])
            ->with('success', 'Quiz completed successfully!');
    }

    /**
     * Display quiz results.
     */
    public function results(Quiz $quiz, QuizAttempt $attempt)
    {
        $attempt->load(['userAnswers.question.answers', 'userAnswers.answer']);
        
        return view('quizzes.results', compact('quiz', 'attempt'));
    }

    /**
     * Restart a quiz attempt.
     */
    public function restart(Quiz $quiz)
    {
        // Delete any existing incomplete attempts
        auth()->user()->quizAttempts()
            ->where('quiz_id', $quiz->id)
            ->where('is_completed', false)
            ->delete();

        // Create a new attempt
        $attempt = auth()->user()->quizAttempts()->create([
            'quiz_id' => $quiz->id,
            'started_at' => now(),
        ]);

        return redirect()->route('quizzes.take', $quiz->id)
            ->with('success', 'Quiz restarted!');
    }
}