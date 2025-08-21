<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a sample quiz
        $quiz = Quiz::create([
            'title' => 'General Knowledge Quiz',
            'description' => 'Test your knowledge with this general knowledge quiz.',
            'is_active' => true,
            'passing_score' => 70,
        ]);

        // Add questions to the quiz
        $question1 = $quiz->questions()->create([
            'question_text' => 'What is the capital of France?',
            'question_type' => 'multiple_choice',
            'points' => 1,
        ]);

        $question1->answers()->createMany([
            ['answer_text' => 'London', 'is_correct' => false],
            ['answer_text' => 'Berlin', 'is_correct' => false],
            ['answer_text' => 'Paris', 'is_correct' => true],
            ['answer_text' => 'Madrid', 'is_correct' => false],
        ]);

        $question2 = $quiz->questions()->create([
            'question_text' => 'The Earth is flat.',
            'question_type' => 'true_false',
            'points' => 1,
        ]);

        $question2->answers()->createMany([
            ['answer_text' => 'True', 'is_correct' => false],
            ['answer_text' => 'False', 'is_correct' => true],
        ]);

        $question3 = $quiz->questions()->create([
            'question_text' => 'What is the largest planet in our solar system?',
            'question_type' => 'multiple_choice',
            'points' => 1,
        ]);

        $question3->answers()->createMany([
            ['answer_text' => 'Earth', 'is_correct' => false],
            ['answer_text' => 'Mars', 'is_correct' => false],
            ['answer_text' => 'Jupiter', 'is_correct' => true],
            ['answer_text' => 'Saturn', 'is_correct' => false],
        ]);

        $question4 = $quiz->questions()->create([
            'question_text' => 'What does CPU stand for?',
            'question_type' => 'short_answer',
            'points' => 2,
        ]);
    }
}