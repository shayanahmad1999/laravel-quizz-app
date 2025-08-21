@extends('layouts.app')

@section('content')
<div class="quiz-card">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $quiz->title }}</h1>
            @if($quiz->description)
                <p class="text-gray-600 mt-2">{{ $quiz->description }}</p>
            @endif
            <div class="mt-3 p-3 bg-blue-50 rounded-lg text-sm inline-block">
                <span class="font-medium">Passing Score:</span> {{ $quiz->passing_score }}%
            </div>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('quizzes.take', $quiz) }}" class="btn btn-success">
                Take Quiz
            </a>
            <a href="{{ route('questions.create', $quiz) }}" class="btn btn-primary">
                Add Question
            </a>
            <a href="{{ route('quizzes.edit', $quiz) }}" class="btn btn-secondary">
                Edit Quiz
            </a>
        </div>
    </div>

    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
        <div class="flex justify-between">
            <span class="font-medium">Total Questions:</span>
            <span>{{ $quiz->questions->count() }}</span>
        </div>
        <div class="flex justify-between mt-2">
            <span class="font-medium">Total Points:</span>
            <span>{{ $quiz->questions->sum('points') }}</span>
        </div>
    </div>

    @if($quiz->questions->count() > 0)
        <div class="space-y-6">
            <h2 class="text-xl font-semibold mb-4">Questions</h2>
            @foreach($quiz->questions as $question)
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <span class="font-medium mr-2">Q{{ $loop->iteration }}.</span>
                                <span>{{ $question->question_text }}</span>
                            </div>
                            <div class="text-sm text-gray-600 mb-2">
                                Type: {{ ucfirst(str_replace('_', ' ', $question->question_type)) }} |
                                Points: {{ $question->points }}
                            </div>
                            
                            @if(in_array($question->question_type, ['multiple_choice', 'true_false']) && $question->answers->count() > 0)
                                <div class="mt-2 space-y-1">
                                    @foreach($question->answers as $answer)
                                        <div class="flex items-center text-sm @if($answer->is_correct) text-green-600 font-medium @endif">
                                            <span class="mr-2">{{ chr(64 + $loop->iteration) }}.</span>
                                            <span>{{ $answer->answer_text }}</span>
                                            @if($answer->is_correct)
                                                <span class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Correct</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('questions.edit', [$quiz, $question]) }}" class="text-blue-600 hover:text-blue-800">
                                Edit
                            </a>
                            <form action="{{ route('questions.destroy', [$quiz, $question]) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-600 mb-4">No questions added to this quiz yet.</p>
            <a href="{{ route('questions.create', $quiz) }}" class="btn btn-primary">
                Add First Question
            </a>
        </div>
    @endif
</div>
@endsection