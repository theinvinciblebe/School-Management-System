@extends('layout.main')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3>Student Marksheet</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Roll</th>
                        <th>Student Name</th>
                        <th>Section</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>{{ $student->roll }}</td>
                        <td>{{ $student->student_name }}</td>
                        <td>{{ $student->section_name ?? 'N/A' }}</td>
                        <td>
                            <!-- View Marksheet Button -->
                            <button type="button" class="btn btn-primary view-marksheet"
                                    data-student-id="{{ $student->student_id }}"
                                    data-student-name="{{ $student->student_name }}"
                                    data-class-id="{{ $class->class_id }}">
                                <i class="fas fa-eye"></i> View Marksheet
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No students found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal to Display Marks -->
    <div class="modal fade" id="marksheetModal" tabindex="-1" role="dialog" aria-labelledby="marksheetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="marksheetModalLabel">
                        Marksheet for Student: <span  id="student-name-placeholder">N/A</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="accordion"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.view-marksheet').forEach(button => {
                button.addEventListener('click', function () {
                    const studentId = this.getAttribute('data-student-id');
                    const classId = this.getAttribute('data-class-id');
                    const studentName = this.getAttribute('data-student-name');
                    const modal = document.getElementById('marksheetModal');
                    const studentNamePlaceholder = modal.querySelector('#student-name-placeholder');
                    studentNamePlaceholder.innerText = studentName;  // Update modal title

                    const accordion = modal.querySelector('#accordion');
                    accordion.innerHTML = '<p>Loading...</p>'; // Show loading state

                    // Fetch marks data for the selected student
                    // /marks/class/{class_id}/student/{student_id}
                    fetch(`/marks/class/${classId}/student/${studentId}`)
                        .then(response => response.json())
                        .then(data => {
                           // console.log(data); // Add this line to see the JSON data
                            accordion.innerHTML = ''; // Clear loading

                            // Check if the student has any exams or marks
                            if (!data.exams === 0) {
                                accordion.innerHTML = '<p class="text-center text-muted">No marks available for this student.</p>';
                                return;
                            }

                            Object.values(data.exams).forEach((exam, index) => {
                                const examId = `exam-${index}`;
                                const subjects = exam.subjects.map(subject => `
                                    <tr>
                                        <td>${subject.subject_name ?? 'N/A'}</td>
                                        <td>${subject.mark_obtained ?? 'N/A'}</td>
                                        <td>${subject.mark_total ?? 'N/A'}</td>
                                        <td>${subject.grade ?? 'N/A'}</td>
                                        <td>${subject.comment ?? 'No comments'}</td>
                                    </tr>
                                `).join('');

                                accordion.innerHTML += `
                                    <div class="card">
                                        <div class="card-header" id="${examId}-header">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#${examId}" aria-expanded="true" "aria-controls="${examId}">
                                                    ${exam.name || 'No Exam Name'}
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="${examId}" class="collapse ${index === 0 ? 'show' : ''}" aria-labelledby="${examId}-header" data-parent="#accordion">
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>Obtained Marks</th>
                                                            <th>Highest Marks</th>
                                                            <th>Grade</th>
                                                            <th>Comment</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                         ${subjects || `<tr><td colspan="5" class="text-center">No subjects found for this exam</td></tr>`}
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="4">Total Marks</th>
                                                            <td>${exam.total_marks || 'N/A'}</td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="4">GPA (Grade Point Average)</th>
                                                            <td>${exam.gpa || 'N/A'}</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });

                            $('#marksheetModal').modal('show'); // Open modal
                        })
                        .catch(error => {
                            console.error('Error fetching marks:', error);
                            accordion.innerHTML = '<p>Error loading marks. Please try again later.</p>';
                        });
                });
            });
        });
    </script>
@endsection
