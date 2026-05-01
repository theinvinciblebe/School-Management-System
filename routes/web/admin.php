<?php
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CustomizeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\StaffAttendanceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentAdmissionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassRoutineController;
use App\Http\Controllers\acdSessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ExamListController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ExamMarkController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

// ---------------------- Role: Admin (role:0) ----------------------
Route::middleware(['auth', 'role:0', 'log.activity'])->group(function () {

    Route::get('/admissions', [StudentAdmissionController::class, 'index'])->name('admissions.list');
    Route::put('/admissions/{id}/approve', [StudentAdmissionController::class, 'approve'])->name('admissions.approve');
    Route::put('/admissions/{id}/reject', [StudentAdmissionController::class, 'reject'])->name('admissions.reject');


    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Class routes
    Route::get('/class', [ClassController::class, 'index'])->name('class.index');
    Route::get('/class/add', [ClassController::class, 'create'])->name('class.create');
    Route::post('/class/store', [ClassController::class, 'store'])->name('class.store');
    Route::put('/class/update/{id}', [ClassController::class, 'update'])->name('class.update');
    Route::delete('/class/delete/{id}', [ClassController::class, 'destroy'])->name('class.destroy');

    //section routes
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/{classId}', [SectionController::class, 'getSectionsByClass'])->name('getSectionsByClass');
    Route::post('/section/store', [SectionController::class, 'store'])->name('section.store');
    Route::put('/section/update/{id}', [SectionController::class, 'update'])->name('section.update');
    Route::delete('/section/destroy/{id}', [SectionController::class, 'destroy'])->name('section.destroy');

    // Subject routes
    Route::get('/classes-subject', [SubjectController::class, 'classesSubject'])->name('classesSubject');
    Route::get('/subjects/{class_id}', [SubjectController::class, 'index'])->name('subject.index');
    Route::post('/subject/store', [SubjectController::class, 'store'])->name('subject.store');
    Route::put('/subject/{id}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/subject/{id}', [SubjectController::class, 'destroy'])->name('subject.destroy');

    //ClassRoutine routes
    Route::prefix('class-routines')->group(function () {
        Route::get('/', [ClassRoutineController::class, 'showClasses'])->name('class_routines.show_classes');
        Route::get('/{class_id}/show', [ClassRoutineController::class, 'showClassRoutine'])->name('class_routines.show');
        Route::get('/{class_id}', [ClassRoutineController::class, 'index'])->name('class_routines.index');
        Route::post('/store', [ClassRoutineController::class, 'store'])->name('class_routines.store');
        Route::put('/update/{id}', [ClassRoutineController::class, 'update'])->name('class_routines.update');
        Route::delete('/destroy/{id}', [ClassRoutineController::class, 'destroy'])->name('class_routines.destroy');
    });

    //Parent routes
    Route::get('/parents', [ParentController::class, 'index'])->name('parents.index');
    Route::post('/parents/store', [ParentController::class, 'store'])->name('parent.store');
    Route::put('/parents/{parent_id}', [ParentController::class, 'update'])->name('parent.update'); // Matches form action
    Route::delete('/parents/{parent_id}', [ParentController::class, 'destroy'])->name('parent.destroy');

    //acd_session routes
    Route::get('/sessions', [acdSessionController::class, 'index'])->name('sessions.index');
    Route::post('/sessions/store', [acdSessionController::class, 'store'])->name('sessions.store');
    Route::put('/sessions/{id}/update', [acdSessionController::class, 'update'])->name('sessions.update');
    Route::delete('/sessions/{id}/destroy', [acdSessionController::class, 'destroy'])->name('sessions.destroy');

    // Student Routes
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/get-sections-by-class/{class_id}', [StudentController::class, 'getSectionsByClass'])->name('get.sections.by.class');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students/store', [StudentController::class, 'store'])->name('students.store');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    //student information
    //existing student
    Route::get('/students/class/{class_id}', [StudentController::class, 'showByClass'])->name('students.byClass');
    //new student
    Route::get('/students/add-to-class/{class_id}', [StudentController::class, 'addStudentToClassView'])->name('students.add_to_class_view');
    Route::post('/students/add-to-class', [StudentController::class, 'addStudentToClass'])->name('students.add_to_class');
    Route::put('/students/{student_id}/class/{class_id}/update', [StudentController::class, 'updateClassAssignment'])->name('students.update_class_assignment');
    Route::delete('/students/{student_id}/class/{class_id}/remove', [StudentController::class, 'removeFromClass'])->name('students.remove_from_class');

    //student mark
    Route::get('/marks/class/{class_id}', [MarkController::class, 'showByClass'])->name('marks.byClass');
    Route::get('/marks/class/{class_id}/student/{student_id}', [MarkController::class, 'getStudentMarks']);

    //attendance student
    // Show attendance management page for the class
    Route::get('/attendance/class/{class_id}', [AttendanceController::class, 'index'])->name('attendance.show');
    // Update attendance records
    Route::post('/attendance/update', [AttendanceController::class, 'update'])->name('attendance.update');
    // Fetch sections for the selected class (AJAX)
    Route::get('/get-sections/{class_id}', [AttendanceController::class, 'getSections']);
    // Fetch students for the selected section (AJAX)
    Route::get('/get-students/{section_id}', [AttendanceController::class, 'getStudents']);
    //Viewing Attendance
    Route::get('/attendance/class/{class_id}/date/{date}', [AttendanceController::class, 'viewAttendance'])->name('attendance.view');
    //check if attendance exists
    Route::get('/attendance/check/{class_id}', [AttendanceController::class, 'checkAttendance'])->name('attendance.check');
    //Request Edit
    Route::get('/attendance/request-list', [AttendanceController::class, 'requestList'])->name('attendance.requestList');
    Route::post('/attendance/request-edit', [AttendanceController::class, 'requestEdit'])->name('attendance.requestEdit');
    //admin approve or reject
    Route::put('/attendance/edit-request/{id}', [AttendanceController::class, 'updateRequestStatus'])->name('attendance.updateRequestStatus');


    //teacher route
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::post('/teachers/store', [TeacherController::class, 'store'])->name('teachers.store');
    Route::put('/teachers/{id}/update', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{id}/destroy', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    // exam section
    //exam_list route
    Route::get('/exams', [ExamListController::class, 'index'])->name('exams_list.index');
    Route::post('/exams/store', [ExamListController::class, 'store'])->name('exams_list.store');
    Route::put('/exams/{id}/update', [ExamListController::class, 'update'])->name('exams_list.update');
    Route::delete('/exams/{id}/destroy', [ExamListController::class, 'destroy'])->name('exams_list.destroy');

    //create exam
    Route::get('/exams/create', [ExamListController::class, 'create'])->name('exams.create');
    Route::post('/exams', [ExamListController::class, 'createExam'])->name('exams.store');
    Route::get('/exam/{examId}/questions', [ExamListController::class, 'showExamQuestions'])->name('exam.questions');
    Route::get('/exam/question/{id}/edit', [ExamListController::class, 'editQuestion'])->name('exam.editQuestion');
    Route::delete('/exam/question/{id}/delete', [ExamListController::class, 'deleteQuestion'])->name('exam.deleteQuestion');


    //exam_grade route
    Route::get('/grades', [GradeController::class, 'index'])->name('exams_grade.index');
    Route::post('/grades/store', [GradeController::class, 'store'])->name('exams_grade.store');
    Route::put('/grades/{id}/update', [GradeController::class, 'update'])->name('exams_grade.update');
    Route::delete('/grades/{id}/destroy', [GradeController::class, 'destroy'])->name('exams_grade.destroy');

    //manage_mark
    Route::get('/manage-exam-marks', [ExamMarkController::class, 'index'])->name('exam_marks.index');
    Route::get('/get-students-for-exam', [ExamMarkController::class, 'getStudentsForExam']);
    Route::post('/marks/assign', [ExamMarkController::class, 'assignMarks'])->name('marks.assign');

    //user manage
    Route::get('/user-management', [UserController::class, 'index'])->name('user.index');
    Route::post('/user-management/store', [UserController::class, 'store'])->name('user.store');
    Route::put('/user-management/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user-management/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    //profile-user
    Route::get('/user-profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/photo', [UserController::class, 'getProfilePhoto'])->name('profile.getPhoto');
    Route::get('/user-profile/data', [UserController::class, 'getProfile'])->name('user.getprofile');
    Route::put('/user-profile/update', [UserController::class, 'updateProfile'])->name('user_profile.update');

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');

    // department section
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::post('/departments/store', [DepartmentController::class, 'store'])->name('departments.store');
    Route::put('/departments/update/{id}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/destroy/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

    // staff section
    Route::get('/staffs', [StaffController::class, 'index'])->name('staffs.index');
    Route::post('/staffs/store', [StaffController::class, 'store'])->name('staffs.store');
    Route::put('/staffs/update/{id}', [StaffController::class, 'update'])->name('staffs.update');
    Route::delete('/staffs/destroy/{id}', [StaffController::class, 'destroy'])->name('staffs.destroy');

    // staff attendance
    Route::get('/staff/attendance', [StaffAttendanceController::class, 'index'])->name('staffAttendance.index');
    Route::get('/staff/attendance/view/{date}', [StaffAttendanceController::class, 'view'])->name('staffAttendance.view');
    Route::get('/staff/attendance/pdf/{date}', [StaffAttendanceController::class, 'attendancePDF'])->name('staffAttendance.pdf');
    Route::get('/get-staffAttendance', [StaffAttendanceController::class, 'getAttendance'])->name('attendance.getAttendance');
    Route::post('/staffAttendance/save', [StaffAttendanceController::class, 'saveAttendance'])->name('attendance.save');

    // accounting
    Route::get('/accounting', function () {
        return view('accounting.index');
    });
    // purchase request route
    Route::get('/get-department/{name}', [AccountingController::class, 'getDepartment']);
    Route::get('/purchase_req', [AccountingController::class, 'index'])->name('purchase_req.index');
    Route::post('/purchase-req/store', [AccountingController::class, 'purchase_store'])->name('purchase_req.store');
    Route::get('/purchase-req/{id}', [AccountingController::class, 'purchase_show'])->name('purchase_req.show');
    Route::get('/purchase-requests/{id}/items', [AccountingController::class, 'getItems']);
    Route::put('/purchase-req/{id}', [AccountingController::class, 'purchase_update'])->name('purchase_req.update');
    Route::delete('/purchase-req/{id}', [AccountingController::class, 'purchase_destroy'])->name('purchase_req.destroy');
    Route::put('/purchase-req/{id}/approve', [AccountingController::class, 'Purchaseapprove'])->name('purchase_req.approve');
    Route::put('/purchase-req/{id}/reject', [AccountingController::class, 'Purchasereject'])->name('purchase_req.reject');

    // fee receipt route
    Route::get('/fee_receipt', [AccountingController::class, 'getStudentFee'])->name('fee_receipt.index');
    Route::get('/get-student-details/{id}', [AccountingController::class, 'getStudentDetails']);
    Route::post('/fee-receipt/store', [AccountingController::class, 'storeFeeReceipt'])->name('fee_receipt.store');
    Route::put('/fee-receipt/{id}', [AccountingController::class, 'fee_update'])->name('fee_receipt.update');
    Route::get('/fee-receipt/{id}/edit', [AccountingController::class, 'fee_edit_data']);
    Route::get('/fee-receipt/{id}', [AccountingController::class, 'fee_show'])->name('fee_receipt.show');
    Route::get('/fee-receipt/{id}/items', [AccountingController::class, 'getFeeItems']);
    Route::delete('/fee-receipt/{id}', [AccountingController::class, 'fee_destroy'])->name('fee_receipt.destroy');
    Route::get('/fee-receipt/pdf/{id}', [AccountingController::class, 'generateFeePDF'])->name('fee_receipt.pdf');
    Route::put('/fee-receipt/{id}/approve', [AccountingController::class, 'Feeapprove'])->name('fee_receipt.approve');
    Route::put('/fee-receipt/{id}/reject', [AccountingController::class, 'Feereject'])->name('fee_receipt.reject');

    //inbox notification
    Route::get('/inbox', [InboxController::class, 'AdminInbox'])->name('message.inbox');
    Route::get('/Userinbox', [InboxController::class, 'UserInbox'])->name('message.Userinbox');
    Route::put('/notifications/read/{id}', [InboxController::class, 'markAsRead']);

    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.get');
    Route::get('/user-notifications', [NotificationController::class, 'userNotifications'])->name('notifications.get');
    Route::post('/notifications/delete', [NotificationController::class, 'bulkDelete'])->name('notifications.bulkDelete');


    //customize route
    Route::get('/customize', [CustomizeController::class, 'index'])->name('customize.index');
    Route::post('/customize/update-logo', [CustomizeController::class, 'updateLogo'])->name('customize.updateLogo');
    Route::post('/customize/update-icon', [CustomizeController::class, 'updateIcon'])->name('customize.updateIcon');
    Route::post('/customize/update-brand-title', [CustomizeController::class, 'updateBrandTitle'])->name('customize.updateBrandTitle');
    Route::post('/customize/update-url-title', [CustomizeController::class, 'updateURLTitle'])->name('customize.updateURLTitle');
    Route::get('/customize/get-theme', [CustomizeController::class, 'getTheme'])->name('customize.getTheme');
    Route::post('/customize/update-theme', [CustomizeController::class, 'updateTheme'])->name('customize.updateTheme');

    //Class Material
    Route::get('/myClass', [ClassController::class, 'myClass'])->name('myClass.index');
    Route::get('/getSubject/{class_id}', [ClassController::class, 'getSubject'])->name('getSubject.index');
    Route::get('/class/materials/{subject_id}', [ClassController::class, 'getMaterials'])->name('class.materials');
    Route::get('/materials/create/{subject_id}', [ClassController::class, 'createMaterial'])->name('materials.create');
    Route::post('/materials/store', [ClassController::class, 'createMaterials'])->name('materials.store');
    Route::post('/materials/update-description/{id}', [ClassController::class, 'updateDescription'])->name('materials.updateDescription');
    Route::delete('/materials/delete-description/{id}', [ClassController::class, 'deleteDescription'])->name('materials.deleteDescription');


    Route::post('/materials/update-video/{id}', [ClassController::class, 'updateVideos'])->name('materials.update-video');
    Route::delete('/materials/delete-video/{id}', [ClassController::class, 'deleteVideos'])->name('materials.deleteVideos');


    Route::post('/materials/update-files/{id}', [ClassController::class, 'updateFiles'])->name('materials.update-files');
    Route::delete('/materials/delete-files/{id}', [ClassController::class, 'deleteFiles'])->name('materials.deleteFiles');

    Route::post('/materials/update-gallery/{id}', [ClassController::class, 'updateGallery'])->name('materials.update-gallery');
    Route::delete('/materials/delete-gallery/{id}', [ClassController::class, 'deleteGallery'])->name('materials.deleteGallery');


});
