@extends('layout.main')

@section('content')
    <div class="container">
        <h2>{{ __('Create Exam') }}</h2>

        <form action="{{ route('exams.store') }}" method="POST">
            @csrf

            <!-- Exam Title -->
            <div class="form-group">
                <label>{{ __('Exam Title') }}</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!-- Exam Description -->
            <div class="form-group">
                <label>{{ __('Exam Description') }}</label>
                <textarea name="comment" class="form-control"></textarea>
            </div>

            <h4>{{ __('Questions') }}</h4>
            <div id="questionContainer"></div>

            <button type="button" class="btn btn-primary mt-3" onclick="addQuestion()">+ {{ __('Add Question') }}</button>
            <button type="submit" class="btn btn-success mt-3">{{ __('Save Exam') }}</button>
        </form>
    </div>

    <script>
        let questionCount = 0;

        function addQuestion() {
            let questionHTML = `
            <div class="question-item border p-3 my-3">
                <label>{{ __('Question') }}</label>
                <input type="text" name="questions[${questionCount}][text]" class="form-control" required>

                <label>{{ __('Question Type') }}</label>
                <select name="questions[${questionCount}][type]" class="form-control" onchange="toggleOptions(${questionCount}, this)">
                    <option value="multiple_choice">{{ __('Multiple Choice') }}</option>
                    <option value="short_answer">{{ __('Short Answer') }}</option>
                    <option value="file_upload">{{ __('File Upload') }}</option>
                </select>

                <div id="optionsContainer${questionCount}" class="mt-2">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="addOption(${questionCount})">+ {{ __('Add Option') }}</button>
                    <div id="options${questionCount}"></div>
                </div>

                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeQuestion(this)">{{ __('Remove') }}</button>
            </div>
        `;

            document.getElementById('questionContainer').insertAdjacentHTML('beforeend', questionHTML);
            questionCount++;
        }

        function toggleOptions(index, selectElement) {
            const container = document.getElementById(`optionsContainer${index}`);
            if (selectElement.value === "multiple_choice") {
                container.style.display = "block";
            } else {
                container.style.display = "none";
            }
        }

        function addOption(index) {
            const optionsDiv = document.getElementById(`options${index}`);
            const optionCount = optionsDiv.children.length;
            let optionHTML = `
            <input type="text" name="questions[${index}][options][]" class="form-control my-1" placeholder="{{ __('Option') }} ${optionCount + 1}">
        `;
            optionsDiv.insertAdjacentHTML('beforeend', optionHTML);
        }

        function removeQuestion(button) {
            button.parentElement.remove();
        }
    </script>
@endsection
