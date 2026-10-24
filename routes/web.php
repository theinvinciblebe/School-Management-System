<?php

use App\Http\Controllers\AccountingController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CustomizeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StaffAttendanceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentAdmissionController;
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
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes & User Access Rights
|--------------------------------------------------------------------------
| Role Mapping:
| 0: Admin
| 1: Teacher
| 2: Student
| 3: Accountant
| 4: Receptionist
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. PUBLIC ROUTES (No Authentication Required)
// =========================================================================
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/do_login', [LoginController::class, 'do_login'])->name('do_login');

Route::get('/admission-form', function () {
    return view('student_admission.admission-form');
});
Route::post('/admission-form/store', [StudentAdmissionController::class, 'store'])
    ->name('studentsAdmission.store');

Route::get('/123', function () {
    return view('calendar');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'km', 'kh'])) {
        $standardLocale = ($locale === 'kh') ? 'km' : $locale;
        session(['locale' => $standardLocale]);
        cookie()->queue(cookie('locale', $standardLocale, 60 * 24 * 365, null, null, false, false));
    }
    return redirect()->back();
})->name('lang.switch');


// =========================================================================
// 2. AUTHENTICATED BASE ROUTES (All Authenticated Users: Roles 0, 1, 2, 3, 4)
// =========================================================================
Route::middleware(['auth', 'log.activity'])->group(function () {

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chartData');

    // User Profile
    Route::get('/user-profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/photo', [UserController::class, 'getProfilePhoto'])->name('profile.getPhoto');
    Route::get('/user-profile/data', [UserController::class, 'getProfile'])->name('user.getprofile');
    Route::put('/user-profile/update', [UserController::class, 'updateProfile'])->name('user_profile.update');

    // Unified Inbox & Notifications
    Route::get('/inbox', [InboxController::class, 'index'])->name('message.inbox');
    Route::get('/Userinbox', [InboxController::class, 'index'])->name('message.Userinbox');
    Route::get('/inbox/detail/{id}', [InboxController::class, 'getDetail'])->name('inbox.detail');
    Route::put('/notifications/read/{id}', [InboxController::class, 'markAsRead'])->name('notifications.markRead');
    Route::put('/notifications/unread/{id}', [InboxController::class, 'markAsUnread'])->name('notifications.markUnread');
    Route::post('/notifications/toggle-star/{id}', [InboxController::class, 'toggleStar'])->name('notifications.toggleStar');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::post('/notifications/bulk-action', [InboxController::class, 'bulkAction'])->name('notifications.bulkAction');
    Route::post('/notifications/delete', [NotificationController::class, 'bulkDelete'])->name('notifications.bulkDelete');
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.get');
    Route::get('/user-notifications', [NotificationController::class, 'userNotifications'])->name('notifications.user');

    // Student Information Hub & Class Roster (shared view)
    Route::get('/students/information', [StudentController::class, 'info'])->name('students.info');
    Route::get('/students/info', [StudentController::class, 'info']);
    Route::get('/students/class/{class_id}', [StudentController::class, 'showByClass'])->name('students.byClass');
});


// =========================================================================
// 3. ADMIN ONLY ROUTES (Role 0)
// =========================================================================
Route::middleware(['auth', 'role:0', 'log.activity'])->group(function () {

    // User Management
    Route::get('/user-management', [UserController::class, 'index'])->name('user.index');
    Route::post('/user-management/store', [UserController::class, 'store'])->name('user.store');
    Route::put('/user-management/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user-management/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');

    // UI Customization
    Route::get('/customize', [CustomizeController::class, 'index'])->name('customize.index');
    Route::post('/customize/update-logo', [CustomizeController::class, 'updateLogo'])->name('customize.updateLogo');
    Route::post('/customize/update-icon', [CustomizeController::class, 'updateIcon'])->name('customize.updateIcon');
    Route::post('/customize/update-brand-title', [CustomizeController::class, 'updateBrandTitle'])->name('customize.updateBrandTitle');
    Route::post('/customize/update-url-title', [CustomizeController::class, 'updateURLTitle'])->name('customize.updateURLTitle');
    Route::get('/customize/get-theme', [CustomizeController::class, 'getTheme'])->name('customize.getTheme');
    Route::post('/customize/update-theme', [CustomizeController::class, 'updateTheme'])->name('customize.updateTheme');

    // Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');

    // Admin Messages & Approval Quick Action
    Route::post('/inbox/quick-action', [InboxController::class, 'quickAction'])->name('inbox.quickAction');

    // Teacher Management (CRUD)
    Route::post('/teachers/store', [TeacherController::class, 'store'])->name('teachers.store');
    Route::put('/teachers/{id}/update', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{id}/destroy', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    // Admission Approvals & Decisions
    Route::put('/admissions/{id}/approve', [StudentAdmissionController::class, 'approve'])->name('admissions.approve');
    Route::put('/admissions/{id}/reject', [StudentAdmissionController::class, 'reject'])->name('admissions.reject');
    Route::delete('/admissions/{id}/delete', [StudentAdmissionController::class, 'destroy'])->name('admissions.destroy');

    // Attendance Approvals
    Route::get('/attendance/request-list', [AttendanceController::class, 'requestList'])->name('attendance.requestList');
    Route::match(['PUT', 'POST'], '/attendance/edit-request/{id}', [AttendanceController::class, 'updateRequestStatus'])->name('attendance.updateRequestStatus');

    // Accounting Approvals & Deletions
    Route::put('/purchase-req/{id}/approve', [AccountingController::class, 'Purchaseapprove'])->name('purchase_req.approve');
    Route::put('/purchase-req/{id}/reject', [AccountingController::class, 'Purchasereject'])->name('purchase_req.reject');
    Route::delete('/purchase-req/{id}', [AccountingController::class, 'purchase_destroy'])->name('purchase_req.destroy');

    Route::put('/fee-receipt/{id}/approve', [AccountingController::class, 'Feeapprove'])->name('fee_receipt.approve');
    Route::put('/fee-receipt/{id}/reject', [AccountingController::class, 'Feereject'])->name('fee_receipt.reject');
    Route::delete('/fee-receipt/{id}', [AccountingController::class, 'fee_destroy'])->name('fee_receipt.destroy');

    // Department & Staff CRUD
    Route::post('/departments/store', [DepartmentController::class, 'store'])->name('departments.store');
    Route::put('/departments/update/{id}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/destroy/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

    Route::post('/staffs/store', [StaffController::class, 'store'])->name('staffs.store');
    Route::put('/staffs/update/{id}', [StaffController::class, 'update'])->name('staffs.update');
    Route::delete('/staffs/destroy/{id}', [StaffController::class, 'destroy'])->name('staffs.destroy');
});


// =========================================================================
// 4. FINANCIAL & ACCOUNTING ROUTES (Roles 0, 3, 4: Admin, Accountant, Receptionist)
// =========================================================================
Route::middleware(['auth', 'role:0,3,4', 'log.activity'])->group(function () {

    Route::get('/accounting', [AccountingController::class, 'dashboard'])->name('accounting.index');

    // Profit & Transactions (Admin & Accountant)
    Route::middleware(['role:0,3'])->group(function () {
        Route::get('/profit', [AccountingController::class, 'transactions'])->name('accounting.transactions');
        Route::get('/transaction/data', [AccountingController::class, 'transactionData']);
        Route::post('/transactions/store', [AccountingController::class, 'transactionStore'])->name('transactions.store');
        Route::put('/transaction/update/{id}', [AccountingController::class, 'transactionUpdate']);
        Route::delete('/transaction/delete/{id}', [AccountingController::class, 'transactionDelete']);
    });

    // Purchase Requests
    Route::get('/get-department/{name}', [AccountingController::class, 'getDepartment']);
    Route::get('/purchase_req', [AccountingController::class, 'index'])->name('purchase_req.index');
    Route::post('/purchase-req/store', [AccountingController::class, 'purchase_store'])->name('purchase_req.store');
    Route::get('/purchase-req/{id}', [AccountingController::class, 'purchase_show'])->name('purchase_req.show');
    Route::get('/purchase-requests/{id}/items', [AccountingController::class, 'getItems']);
    Route::put('/purchase-req/{id}', [AccountingController::class, 'purchase_update'])->name('purchase_req.update');

    // Fee Receipts
    Route::get('/fee_receipt', [AccountingController::class, 'getStudentFee'])->name('fee_receipt.index');
    Route::get('/get-student-details/{id}', [AccountingController::class, 'getStudentDetails']);
    Route::post('/fee-receipt/store', [AccountingController::class, 'storeFeeReceipt'])->name('fee_receipt.store');
    Route::put('/fee-receipt/{id}', [AccountingController::class, 'fee_update'])->name('fee_receipt.update');
    Route::get('/fee-receipt/{id}/edit', [AccountingController::class, 'fee_edit_data']);
    Route::get('/fee-receipt/{id}', [AccountingController::class, 'fee_show'])->name('fee_receipt.show');
    Route::get('/fee-receipt/{id}/items', [AccountingController::class, 'getFeeItems']);
    Route::get('/fee-receipt/pdf/{id}', [AccountingController::class, 'generateFeePDF'])->name('fee_receipt.pdf');
});


// =========================================================================
// 5. DEPARTMENT & STAFF MANAGEMENT (Roles 0, 4: Admin, Receptionist)
// =========================================================================
Route::middleware(['auth', 'role:0,4', 'log.activity'])->group(function () {

    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/staffs', [StaffController::class, 'index'])->name('staffs.index');

    // Staff Attendance
    Route::get('/staff/attendance', [StaffAttendanceController::class, 'index'])->name('staffAttendance.index');
    Route::get('/staff/attendance/view/{date}', [StaffAttendanceController::class, 'view'])->name('staffAttendance.view');
    Route::get('/staff/attendance/pdf/{date}', [StaffAttendanceController::class, 'attendancePDF'])->name('staffAttendance.pdf');
    Route::get('/get-staffAttendance', [StaffAttendanceController::class, 'getAttendance'])->name('attendance.getAttendance');
    Route::post('/staffAttendance/save', [StaffAttendanceController::class, 'saveAttendance'])->name('attendance.save');

    // Admissions View
    Route::get('/admissions', [StudentAdmissionController::class, 'index'])->name('admissions.list');
    Route::get('/admissions-view/{id}', [StudentAdmissionController::class, 'show'])->name('studentsAdmission.show');
});


// =========================================================================
// 6. ACADEMIC STAFF ROUTES: CLASSES, SECTIONS & STUDENTS
//    (Roles 0, 1, 3, 4: Admin, Teacher, Accountant, Receptionist)
// =========================================================================
Route::middleware(['auth', 'role:0,1,3,4', 'log.activity'])->group(function () {

    // Class Management
    Route::get('/class', [ClassController::class, 'index'])->name('class.index');
    Route::get('/class/add', [ClassController::class, 'create'])->name('class.create');
    Route::post('/class/store', [ClassController::class, 'store'])->name('class.store');
    Route::put('/class/update/{id}', [ClassController::class, 'update'])->name('class.update');
    Route::delete('/class/delete/{id}', [ClassController::class, 'destroy'])->name('class.destroy');

    // Section Management
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/{classId}', [SectionController::class, 'getSectionsByClass'])->name('getSectionsByClass');
    Route::post('/section/store', [SectionController::class, 'store'])->name('section.store');
    Route::put('/section/update/{id}', [SectionController::class, 'update'])->name('section.update');
    Route::delete('/section/destroy/{id}', [SectionController::class, 'destroy'])->name('section.destroy');

    // Academic Sessions
    Route::get('/sessions', [acdSessionController::class, 'index'])->name('sessions.index');
    Route::post('/sessions/store', [acdSessionController::class, 'store'])->name('sessions.store');
    Route::put('/sessions/{id}/update', [acdSessionController::class, 'update'])->name('sessions.update');
    Route::delete('/sessions/{id}/destroy', [acdSessionController::class, 'destroy'])->name('sessions.destroy');

    // Student Management
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/get-sections-by-class/{class_id}', [StudentController::class, 'getSectionsByClass'])->name('get.sections.by.class');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students/store', [StudentController::class, 'store'])->name('students.store');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

    Route::get('/students/add-to-class/{class_id}', [StudentController::class, 'addStudentToClassView'])->name('students.add_to_class_view');
    Route::post('/students/add-to-class', [StudentController::class, 'addStudentToClass'])->name('students.add_to_class');
    Route::put('/students/{student_id}/class/{class_id}/update', [StudentController::class, 'updateClassAssignment'])->name('students.update_class_assignment');
    Route::delete('/students/{student_id}/class/{class_id}/remove', [StudentController::class, 'removeFromClass'])->name('students.remove_from_class');
});


// =========================================================================
// 7. TEACHING & LEARNING - SHARED VIEWS
//    (Roles 0, 1, 2: Admin, Teacher, Student; and Role 4 where applicable)
// =========================================================================
Route::middleware(['auth', 'role:0,1,2,4', 'log.activity'])->group(function () {

    // Subjects (View)
    Route::get('/classes-subject', [SubjectController::class, 'classesSubject'])->name('classesSubject');
    Route::get('/subjects/{class_id}', [SubjectController::class, 'index'])->name('subject.index');

    // Class Routines (View)
    Route::prefix('class-routines')->group(function () {
        Route::get('/', [ClassRoutineController::class, 'showClasses'])->name('class_routines.show_classes');
        Route::get('/{class_id}/show', [ClassRoutineController::class, 'showClassRoutine'])->name('class_routines.show');
        Route::get('/{class_id}', [ClassRoutineController::class, 'index'])->name('class_routines.index');
    });
});

Route::middleware(['auth', 'role:0,1,2', 'log.activity'])->group(function () {

    // Teachers List (View)
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');

    // Parents List (View)
    Route::get('/parents', [ParentController::class, 'index'])->name('parents.index');

    // Exam Lists & Grades (View)
    Route::get('/exams', [ExamListController::class, 'index'])->name('exams_list.index');
    Route::get('/grades', [GradeController::class, 'index'])->name('exams_grade.index');

    // Student Marks (View)
    Route::get('/marks/class/{class_id}', [MarkController::class, 'showByClass'])->name('marks.byClass');
    Route::get('/marks/class/{class_id}/student/{student_id}', [MarkController::class, 'getStudentMarks']);

    // Class Materials (View)
    Route::get('/myClass', [ClassController::class, 'myClass'])->name('myClass.index');
    Route::get('/getSubject/{class_id}', [ClassController::class, 'getSubject'])->name('getSubject.index');
    Route::get('/class/materials/{subject_id}', [ClassController::class, 'getMaterials'])->name('class.materials');

    // Attendance View
    Route::get('/attendance/class/{class_id}/date/{date}', [AttendanceController::class, 'viewAttendance'])->name('attendance.view');
});


// =========================================================================
// 8. TEACHING MANAGEMENT, GRADING & EVALUATION (Roles 0, 1: Admin, Teacher)
// =========================================================================
Route::middleware(['auth', 'role:0,1', 'log.activity'])->group(function () {

    // Subject Management
    Route::post('/subject/store', [SubjectController::class, 'store'])->name('subject.store');
    Route::put('/subject/{id}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/subject/{id}', [SubjectController::class, 'destroy'])->name('subject.destroy');

    // Class Routine Management
    Route::prefix('class-routines')->group(function () {
        Route::post('/store', [ClassRoutineController::class, 'store'])->name('class_routines.store');
        Route::put('/update/{id}', [ClassRoutineController::class, 'update'])->name('class_routines.update');
        Route::delete('/destroy/{id}', [ClassRoutineController::class, 'destroy'])->name('class_routines.destroy');
    });

    // Parent Management
    Route::post('/parents/store', [ParentController::class, 'store'])->name('parent.store');
    Route::put('/parents/{parent_id}', [ParentController::class, 'update'])->name('parent.update');
    Route::delete('/parents/{parent_id}', [ParentController::class, 'destroy'])->name('parent.destroy');

    // Class Materials Management
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

    // Exam Management
    Route::post('/exams/store', [ExamListController::class, 'store'])->name('exams_list.store');
    Route::put('/exams/{id}/update', [ExamListController::class, 'update'])->name('exams_list.update');
    Route::delete('/exams/{id}/destroy', [ExamListController::class, 'destroy'])->name('exams_list.destroy');
    Route::get('/exams/create', [ExamListController::class, 'create'])->name('exams.create');
    Route::post('/exams', [ExamListController::class, 'createExam'])->name('exams.store');
    Route::get('/exam/{examId}/questions', [ExamListController::class, 'showExamQuestions'])->name('exam.questions');
    Route::get('/exam/question/{id}/edit', [ExamListController::class, 'editQuestion'])->name('exam.editQuestion');
    Route::delete('/exam/question/{id}/delete', [ExamListController::class, 'deleteQuestion'])->name('exam.deleteQuestion');

    // Exam Grades Management
    Route::post('/grades/store', [GradeController::class, 'store'])->name('exams_grade.store');
    Route::put('/grades/{id}/update', [GradeController::class, 'update'])->name('exams_grade.update');
    Route::delete('/grades/{id}/destroy', [GradeController::class, 'destroy'])->name('exams_grade.destroy');

    // Exam Marks Assignment
    Route::get('/manage-exam-marks', [ExamMarkController::class, 'index'])->name('exam_marks.index');
    Route::get('/get-students-for-exam', [ExamMarkController::class, 'getStudentsForExam']);
    Route::post('/marks/assign', [ExamMarkController::class, 'assignMarks'])->name('marks.assign');

    // Attendance Management
    Route::get('/attendance/class/{class_id}', [AttendanceController::class, 'index'])->name('attendance.show');
    Route::get('/attendance/pdf/{class_id}/{date}', [AttendanceController::class, 'exportPdf'])->name('attendance.exportPdf');
    Route::post('/attendance/update', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::get('/get-sections/{class_id}', [AttendanceController::class, 'getSections']);
    Route::get('/get-students/{section_id}', [AttendanceController::class, 'getStudents']);
    Route::get('/attendance/check/{class_id}', [AttendanceController::class, 'checkAttendance'])->name('attendance.check');
    Route::post('/attendance/request-edit', [AttendanceController::class, 'requestEdit'])->name('attendance.requestEdit');
});
