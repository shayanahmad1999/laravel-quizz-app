@extends('layouts.app')

@section('content')
<div class="quiz-card">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Available Quizzes</h1>
        <a href="{{ route('quizzes.create') }}" class="btn btn-primary">
            Create New Quiz
        </a>
    </div>

    @if($quizzes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($quizzes as $quiz)
                <div class="border rounded-xl p-6 hover:shadow-lg transition-all duration-300 bg-white">
                    <div class="flex items-start justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex-1">{{ $quiz->title }}</h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $quiz->questions->count() }} Qs
                        </span>
                    </div>
                    
                    @if($quiz->description)
                        <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($quiz->description, 100) }}</p>
                    @else
                        <p class="text-gray-500 mb-4 text-sm italic">No description provided</p>
                    @endif
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="text-sm text-gray-500">
                            <span class="font-medium">Passing Score:</span> {{ $quiz->passing_score }}%
                        </div>
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('quizzes.take', $quiz) }}" class="flex-1 btn btn-success text-center">
                            Take Quiz
                        </a>
                        <a href="{{ route('quizzes.show', $quiz) }}" class="flex-1 btn btn-secondary text-center">
                            Manage
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <p class="text-gray-600 mb-6">No quizzes available yet.</p>
            <a href="{{ route('quizzes.create') }}" class="btn btn-primary">
                Create Your First Quiz
            </a>
        </div>
    @endif
</div>
@endsection