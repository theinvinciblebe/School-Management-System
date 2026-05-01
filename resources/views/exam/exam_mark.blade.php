@extends('layout.main')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Manage Exam Mark</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('exams_list.index') }}">Exam List</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('exams_grade.index') }}">Grade List</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Mark List
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h4><i class="fas fa-marker"></i> Mark List</h4>
            </div>
        </div>
        <div class="card-body">
            <form id="select-form">
                <div class="row">
                    <div class="col-md-4">
                        <label for="exam-select">Select Exam:</label>
                        <select id="exam-select" class="form-control select2bs4" required>
                            <option value="">Select Exam</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->exam_id }}">{{ $exam->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="class-select">Select Class:</label>
                        <select id="class-select" class="form-control select2bs4" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->class_id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="subject-select">Select Subject:</label>
                        <select id="subject-select" class="form-control select2bs4" required>
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->subject_id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <button type="button" class="btn btn-primary" id="load-students-btn">Load Students</button>
            </form>
        </div>
    </div>

    <!-- Form for Assigning Marks -->
    <div class="card mt-4" id="assign-marks-card" style="display: none;">
        <div class="card-header">
            <h4>Assign Marks</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('marks.assign') }}">
                @csrf
                <input type="hidden" id="exam-id" name="exam_id" value="">
                <input type="hidden" id="class-id" name="class_id" value="">
                <input type="hidden" id="subject-id" name="subject_id" value="">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Roll</th>
                        <th>Student Name</th>
                        <th>Marks Obtained</th>
                        <th>Comment</th>
                    </tr>
                    </thead>
                    <tbody id="students-list"></tbody>
                </table>
                <button type="submit" class="btn btn-success">Save Marks</button>
            </form>
        </div>
    </div>

<script>
    document.getElementById('load-students-btn').addEventListener('click', function () {
        const examId = document.getElementById('exam-select').value;
        const classId = document.getElementById('class-select').value;
        const subjectId = document.getElementById('subject-select').value;

        if (!examId || !classId || !subjectId) {
            alert('Please select all fields.');
            return;
        }

        document.getElementById('exam-id').value = examId;
        document.getElementById('class-id').value = classId;
        document.getElementById('subject-id').value = subjectId;

        // Fetch students and marks
        fetch(`/get-students-for-exam?class_id=${classId}&subject_id=${subjectId}&exam_id=${examId}`)
            .then(response => response.json())
            .then(data => {
                const studentsList = document.getElementById('students-list');
                studentsList.innerHTML = '';

                if (data.students.length === 0) {
                    studentsList.innerHTML = '<tr><td colspan="4" class="text-center">No students found for this class and subject.</td></tr>';
                    return;
                }

                data.students.forEach(student => {
                    const mark = data.marks[student.student_class_id]?.mark_obtained ?? '';
                    const comment = data.marks[student.student_class_id]?.comment ?? '';

                    studentsList.innerHTML += `
                    <tr>
                        <td>${student.roll}</td>
                        <td>${student.name}</td>
                        <td>
                            <input type="number" name="marks[${student.student_class_id}][mark_obtained]" class="form-control" value="${mark}" required>
                        </td>
                        <td>
                            <input type="text" name="marks[${student.student_class_id}][comment]" class="form-control" placeholder="Optional" value="${comment}">
                        </td>
                    </tr>
                `;
                });

                document.getElementById('assign-marks-card').style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading students.');
            });
    });

</script>
@endsection
