@extends('layout.main')

@section('content')
    <div class="container">
        <h2 class="mb-4">Exam: {{ $exam->name }}</h2>

        <table class="table table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Question</th>
                <th>Type</th>
                <th>Options</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($questions as $index => $question)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $question->question_text }}</td>
                    <td>{{ ucfirst($question->question_type) }}</td>
                    <td>
                        @if($question->question_type == 'multiple_choice')
                            @php
                                $options = json_decode($question->options, true);
                            @endphp
                            <ul>
                                @foreach($options as $option)
                                    <li>{{ $option }}</li>
                                @endforeach
                            </ul>
                        @else
                            N/A
                        @endif
                    </td>
{{--                    <td>--}}
{{--                        <a href="{{ route('exam.editQuestion', $question->id) }}" class="btn btn-primary btn-sm">Edit</a>--}}
{{--                        <form action="{{ route('exam.deleteQuestion', $question->id) }}" method="POST" class="d-inline">--}}
{{--                            @csrf--}}
{{--                            @method('DELETE')--}}
{{--                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">--}}
{{--                                Delete--}}
{{--                            </button>--}}
{{--                        </form>--}}
{{--                    </td>--}}
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No questions found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

{{--        <a href="{{ route('exam.addQuestion', $exam->exam_id) }}" class="btn btn-success">Add New Question</a>--}}
    </div>
@endsection

