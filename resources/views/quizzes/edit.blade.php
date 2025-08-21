@extends('layouts.app')

@section('content')
<div class="quiz-card">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Quiz</h1>

    <form action="{{ route('quizzes.update', $quiz) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title" class="form-label">Quiz Title</label>
            <input type="text" name="title" id="title" class="form-input" value="{{ old('title', $quiz->title) }}" required>
            @error('title')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description (Optional)</label>
            <textarea name="description" id="description" class="form-input" rows="4">{{ old('description', $quiz->description) }}</textarea>
            @error('description')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="passing_score" class="form-label">Passing Score (%)</label>
            <input type="number" name="passing_score" id="passing_score" class="form-input" value="{{ old('passing_score', $quiz->passing_score) }}" min="0" max="100" required>
            <div class="text-sm text-gray-600 mt-1">Enter the minimum percentage required to pass this quiz.</div>
            @error('passing_score')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-secondary">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                Update Quiz
            </button>
        </div>
    </form>
</div>
@endsection