@extends('layouts.app')

@section('content')
<div class="quiz-card">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ $quiz->title }}</h1>
        @if($quiz->description)
            <p class="text-gray-600 mt-2">{{ $quiz->description }}</p>
        @endif
    </div>

    @if($quiz->questions->count() > 0)
        <div class="mb-4">
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Progress</span>
                <span>{{ $attempt->userAnswers->count() }} / {{ $quiz->questions->count() }} answered</span>
            </div>
            <div class="quiz-progress">
                <div class="quiz-progress-bar" style="width: {{ ($attempt->userAnswers->count() / $quiz->questions->count()) * 100 }}%"></div>
            </div>
        </div>

        @php
            $currentQuestion = $quiz->questions->first(function ($question) use ($attempt) {
                return !$attempt->userAnswers->contains('question_id', $question->id);
            }) ?? $quiz->questions->first();
        @endphp

        @if($currentQuestion)
            <form action="{{ route('attempts.answers.store', [$quiz, $attempt]) }}" method="POST">
                @csrf
                <input type="hidden" name="question_id" value="{{ $currentQuestion->id }}">

                <div class="mb-6">
                    <div class="flex items-center mb-4">
                        <span class="font-medium mr-2">Q{{ $quiz->questions->search($currentQuestion) + 1 }}.</span>
                        <h2 class="text-lg font-medium">{{ $currentQuestion->question_text }}</h2>
                    </div>

                    @if($currentQuestion->question_type === 'short_answer')
                        <div class="form-group">
                            <textarea name="short_answer" class="form-input" rows="3" placeholder="Enter your answer here..."></textarea>
                        </div>
                    @else
                        <div class="space-y-2">
                            @foreach($currentQuestion->answers as $answer)
                                <label class="question-option">
                                    <input type="radio" name="answer_id" value="{{ $answer->id }}" class="mr-2">
                                    {{ $answer->answer_text }}
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="flex justify-between">
                    <button type="submit" class="btn btn-primary">
                        {{ $attempt->userAnswers->count() + 1 >= $quiz->questions->count() ? 'Finish Quiz' : 'Next Question' }}
                    </button>
                </div>
            </form>
        @else
            <div class="text-center py-8">
                <p class="text-gray-600 mb-4">You have answered all questions.</p>
                <a href="{{ route('quizzes.results', [$quiz, $attempt]) }}" class="btn btn-primary">
                    View Results
                </a>
            </div>
        @endif
    @else
        <div class="text-center py-8">
            <p class="text-gray-600">This quiz has no questions yet.</p>
        </div>
    @endif
</div>
@endsection