@extends('layouts.app')

@section('content')
<div class="quiz-card">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Question</h1>

    <form action="{{ route('questions.update', [$quiz, $question]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="question_text" class="form-label">Question</label>
            <textarea name="question_text" id="question_text" class="form-input" rows="3" required>{{ old('question_text', $question->question_text) }}</textarea>
            @error('question_text')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="question_type" class="form-label">Question Type</label>
            <select name="question_type" id="question_type" class="form-input" required>
                <option value="multiple_choice" {{ old('question_type', $question->question_type) == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                <option value="true_false" {{ old('question_type', $question->question_type) == 'true_false' ? 'selected' : '' }}>True/False</option>
                <option value="short_answer" {{ old('question_type', $question->question_type) == 'short_answer' ? 'selected' : '' }}>Short Answer</option>
            </select>
            @error('question_type')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="points" class="form-label">Points</label>
            <input type="number" name="points" id="points" class="form-input" value="{{ old('points', $question->points) }}" min="1" required>
            @error('points')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        @if(in_array($question->question_type, ['multiple_choice', 'true_false']))
        <div id="answers-section" class="form-group">
            <label class="form-label">Answers</label>
            <div id="answers-container">
                @forelse(old('answers', $question->answers->toArray()) as $index => $answer)
                    <div class="answer-row mb-3 flex items-center">
                        <input type="text" name="answers[{{ $index }}][answer_text]" placeholder="Answer option" class="form-input mr-2 flex-1" value="{{ $answer['answer_text'] ?? '' }}">
                        <label class="flex items-center">
                            <input type="checkbox" name="answers[{{ $index }}][is_correct]" value="1" class="mr-1" {{ isset($answer['is_correct']) && $answer['is_correct'] ? 'checked' : '' }}>
                            Correct
                        </label>
                        <button type="button" class="ml-2 text-red-600 remove-answer">×</button>
                    </div>
                @empty
                    <div class="answer-row mb-3 flex items-center">
                        <input type="text" name="answers[0][answer_text]" placeholder="Answer option" class="form-input mr-2 flex-1">
                        <label class="flex items-center">
                            <input type="checkbox" name="answers[0][is_correct]" value="1" class="mr-1">
                            Correct
                        </label>
                        <button type="button" class="ml-2 text-red-600 remove-answer">×</button>
                    </div>
                @endforelse
            </div>
            <button type="button" id="add-answer" class="btn btn-secondary text-sm mt-2">Add Another Answer</button>
        </div>
        @endif

        <div class="flex justify-end space-x-3">
            <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-secondary">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                Update Question
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const questionType = document.getElementById('question_type');
        const answersSection = document.getElementById('answers-section');
        const answersContainer = document.getElementById('answers-container');
        const addAnswerBtn = document.getElementById('add-answer');
        
        let answerIndex = {{ $question->answers->count() > 0 ? $question->answers->count() : 1 }};
        
        // Toggle answers section based on question type
        questionType.addEventListener('change', function() {
            if (this.value === 'multiple_choice' || this.value === 'true_false') {
                if (!answersSection) {
                    // Create answers section if it doesn't exist
                    const answersSectionDiv = document.createElement('div');
                    answersSectionDiv.id = 'answers-section';
                    answersSectionDiv.className = 'form-group';
                    answersSectionDiv.innerHTML = `
                        <label class="form-label">Answers</label>
                        <div id="answers-container">
                            <div class="answer-row mb-3 flex items-center">
                                <input type="text" name="answers[0][answer_text]" placeholder="Answer option" class="form-input mr-2 flex-1">
                                <label class="flex items-center">
                                    <input type="checkbox" name="answers[0][is_correct]" value="1" class="mr-1">
                                    Correct
                                </label>
                                <button type="button" class="ml-2 text-red-600 remove-answer">×</button>
                            </div>
                        </div>
                        <button type="button" id="add-answer" class="btn btn-secondary text-sm mt-2">Add Another Answer</button>
                    `;
                    document.querySelector('form').insertBefore(answersSectionDiv, document.querySelector('.flex.justify-end'));
                } else {
                    answersSection.style.display = 'block';
                }
            } else if (answersSection) {
                answersSection.style.display = 'none';
            }
        });
        
        // Trigger change event on page load
        questionType.dispatchEvent(new Event('change'));
        
        // Add new answer row
        if (addAnswerBtn) {
            addAnswerBtn.addEventListener('click', function() {
                const answersContainer = document.getElementById('answers-container');
                const answerRow = document.createElement('div');
                answerRow.className = 'answer-row mb-3 flex items-center';
                answerRow.innerHTML = `
                    <input type="text" name="answers[${answerIndex}][answer_text]" placeholder="Answer option" class="form-input mr-2 flex-1">
                    <label class="flex items-center">
                        <input type="checkbox" name="answers[${answerIndex}][is_correct]" value="1" class="mr-1">
                        Correct
                    </label>
                    <button type="button" class="ml-2 text-red-600 remove-answer">×</button>
                `;
                answersContainer.appendChild(answerRow);
                answerIndex++;
            });
        }
        
        // Remove answer row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-answer')) {
                if (document.querySelectorAll('.answer-row').length > 1) {
                    e.target.closest('.answer-row').remove();
                } else {
                    alert('You need at least one answer option.');
                }
            }
        });
    });
</script>
@endsection