@extends('layouts.app')

@section('content')
<div class="quiz-card">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ $quiz->title }} - Results</h1>
        @if($quiz->description)
            <p class="text-gray-600 mt-2">{{ $quiz->description }}</p>
        @endif
    </div>

    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
            <div>
                <div class="text-2xl font-bold">{{ $attempt->score ?? 0 }}</div>
                <div class="text-sm text-gray-600">Your Score</div>
            </div>
            <div>
                <div class="text-2xl font-bold">{{ $attempt->total_points ?? 0 }}</div>
                <div class="text-sm text-gray-600">Total Points</div>
            </div>
            <div>
                @php
                    $percentage = $attempt->total_points > 0 ? round(($attempt->score / $attempt->total_points) * 100) : 0;
                @endphp
                <div class="text-2xl font-bold">{{ $percentage }}%</div>
                <div class="text-sm text-gray-600">Percentage</div>
            </div>
            <div>
                @php
                    // Use quiz's passing score
                    $passed = $percentage >= $quiz->passing_score;
                @endphp
                <div class="text-2xl font-bold {{ $passed ? 'text-green-600' : 'text-red-600' }}">
                    {{ $passed ? 'PASSED' : 'FAILED' }}
                </div>
                <div class="text-sm text-gray-600">Result (Passing: {{ $quiz->passing_score }}%)</div>
            </div>
        </div>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Your Answers</h2>
        <div class="space-y-6">
            @foreach($quiz->questions as $question)
                @php
                    $userAnswer = $attempt->userAnswers->firstWhere('question_id', $question->id);
                @endphp
                <div class="border rounded-lg p-4 @if($userAnswer && $userAnswer->is_correct) bg-green-50 @elseif($userAnswer && !$userAnswer->is_correct) bg-red-50 @endif">
                    <div class="flex items-start mb-3">
                        <span class="font-medium mr-2">Q{{ $loop->iteration }}.</span>
                        <span class="flex-1">{{ $question->question_text }}</span>
                        <span class="font-medium">{{ $question->points }} point{{ $question->points > 1 ? 's' : '' }}</span>
                    </div>

                    @if($question->question_type === 'short_answer')
                        <div class="ml-6">
                            <div class="text-sm text-gray-600 mb-1">Your answer:</div>
                            <div class="p-2 bg-white border rounded">
                                {{ $userAnswer->short_answer ?? 'No answer provided' }}
                            </div>
                        </div>
                    @else
                        <div class="ml-6 space-y-2">
                            @foreach($question->answers as $answer)
                                @php
                                    $isSelected = $userAnswer && $userAnswer->answer_id == $answer->id;
                                    $isCorrect = $answer->is_correct;
                                @endphp
                                <div class="flex items-center p-2 rounded @if($isSelected && $isCorrect) bg-green-100 border border-green-300 @elseif($isSelected && !$isCorrect) bg-red-100 border border-red-300 @elseif($isCorrect) bg-green-50 @endif">
                                    <span class="mr-2">{{ chr(64 + $loop->iteration) }}.</span>
                                    <span class="flex-1">{{ $answer->answer_text }}</span>
                                    @if($isSelected && $isCorrect)
                                        <span class="text-green-600 font-medium">✓ Your answer (Correct)</span>
                                    @elseif($isSelected && !$isCorrect)
                                        <span class="text-red-600 font-medium">✗ Your answer</span>
                                    @elseif($isCorrect)
                                        <span class="text-green-600 font-medium">✓ Correct answer</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex justify-between">
        <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">
            Back to Quizzes
        </a>
        <form action="{{ route('quizzes.restart', $quiz) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">
                Retake Quiz
            </button>
        </form>
    </div>
</div>
@endsection