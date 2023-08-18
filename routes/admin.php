<?php

use App\Http\Controllers\Admin\Auth\TwoFAController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\DefaultLearningPathController;

/*
  |--------------------------------------------------------------------------
  | Admin Routes
  |--------------------------------------------------------------------------
 */

Route::prefix('admin')->group(static function () {

    // Guest routes
    Route::middleware('guest:admin')->group(static function () {
        // Auth routes

        Route::get('login', [\App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'create'])->name('admin.login');
        Route::post('login', [\App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'store']);
        // Forgot password
        Route::get('forgot-password', [\App\Http\Controllers\Admin\Auth\PasswordResetLinkController::class, 'create'])->name('admin.password.request');
        Route::post('forgot-password', [\App\Http\Controllers\Admin\Auth\PasswordResetLinkController::class, 'store'])->name('admin.password.email');
        // Reset password
        Route::get('reset-password/{token}', [\App\Http\Controllers\Admin\Auth\NewPasswordController::class, 'create'])->name('admin.password.reset');
        Route::post('reset-password', [\App\Http\Controllers\Admin\Auth\NewPasswordController::class, 'store'])->name('admin.password.update');

        // Route::get('/customer-detail', [CustomerController::class, 'detail'])->name('customer-detail');
        // Route::get('/customer-status', [CustomerController::class, 'customerStatus'])->name('customer-status');

        // Route::get('/customers/{type?}', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customer/{uuid}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::post('/customer/{uuid}/update', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/logout', [UserController::class, 'adminLogout'])->name('admin-logout');
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('admin.dashboard');

        Route::controller(TwoFAController::class)->group(function(){
            Route::get('two-factor-authentication', 'index')->name('2fa.index');
            Route::post('two-factor-authentication/store', 'store')->name('2fa.store');
            Route::get('two-factor-authentication/resend', 'resend')->name('2fa.resend');
        });
    });


    // Verify email routes
    Route::middleware(['auth:admin'])->group(static function () {
        Route::get('verify-email', [\App\Http\Controllers\Admin\Auth\EmailVerificationPromptController::class, '__invoke'])->name('admin.verification.notice');
        Route::get('verify-email/{id}/{hash}', [\App\Http\Controllers\Admin\Auth\VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('admin.verification.verify');
        Route::post('email/verification-notification', [\App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('admin.verification.send');
    });

    // Authenticated routes
    Route::middleware(['auth:admin', 'verified'])->group(static function () {




        Route::get('instructor-dashboard', 'Admin\InstructorController@dashboard')->name('instructor.dashboard');

        Route::get('instructor-profile', 'Admin\InstructorController@getProfile')->name('instructor.profile.get');
        Route::post('instructor-profile', 'Admin\InstructorController@saveProfile')->name('instructor.profile.save');

        Route::get('course-create', 'Admin\CourseController@createInfo')->name('instructor.course.create');
        // Route::get('instructor-course-list', '\App\Http\Controllers\Admin\@instructorCourseList')->name('instructor.course.list');
        // Route::get('instructor-course-list', [\App\Http\Controllers\Admin\CourseController::class, 'instructorCourseList'])->name('admin.index');


        Route::get('/instructor-course-list', [\App\Http\Controllers\Admin\CourseController::class, 'instructorCourseList'])->name('instructor.course.list');

        Route::get('/instructor-course-info', [\App\Http\Controllers\Admin\CourseController::class, 'instructorCourseInfo'])->name('instructor.course.info');

        // Route::get('instructor-course-info', 'Admin\CourseController@instructorCourseInfo')->name('instructor.course.info');
        // Route::get('instructor-course-info/{course_id}', 'Admin\CourseController@instructorCourseInfo')->name('instructor.course.info.edit');
        Route::get('/instructor-course-info/{course_id}', [\App\Http\Controllers\Admin\CourseController::class, 'instructorCourseInfo'])->name('instructor.course.info.edit');


        Route::match(['get', 'delete'], '/instructor-course-delete/{course_id}', [\App\Http\Controllers\Admin\CourseController::class, 'instructorCourseDelete'])->name('instructor-course-delete.id');

        // Route::post('instructor-course-info-save', 'Admin\CourseController@instructorCourseInfoSave')->name('instructor.course.info.save');
        Route::post('/instructor-course-info-save', [\App\Http\Controllers\Admin\CourseController::class, 'instructorCourseInfoSave'])->name('instructor.course.info.save');

        Route::get('instructor-course-image', 'Admin\CourseController@instructorCourseImage')->name('instructor.course.image');
        // Route::get('instructor-course-image/{course_id}', 'Admin\CourseController@instructorCourseImage')->name('instructor.course.image.edit');
        Route::get('/instructor-course-image/{course_id}', [\App\Http\Controllers\Admin\CourseController::class, 'instructorCourseImage'])->name('instructor.course.image.edit');

        // Route::post('instructor-course-image-save', 'Admin\CourseController@instructorCourseImageSave')->name('instructor.course.image.save');
        Route::post('/instructor-course-image-save', [\App\Http\Controllers\Admin\CourseController::class, 'instructorCourseImageSave'])->name('instructor.course.image.save');

        // Route::get('instructor-course-video/{course_id}', 'Admin\CourseController@instructorCourseVideo')->name('instructor.course.video.edit');
        Route::get('instructor-course-video/{course_id}', [\App\Http\Controllers\Admin\CourseController::class, 'instructorCourseVideo'])->name('instructor.course.video.edit');

        // Route::post('instructor-course-video-save', 'Admin\CourseController@instructorCourseVideoSave')->name('instructor.course.video.save');
        Route::post('iinstructor-course-video-save', [\App\Http\Controllers\Admin\CourseController::class, 'instructorCourseVideoSave'])->name('instructor.course.video.save');

        // Route::get('instructor-course-curriculum/{course_id}', 'Admin\CourseController@instructorCourseCurriculum')->name('instructor.course.curriculum.edit');
        Route::get('instructor-course-curriculum/{course_id}', [\App\Http\Controllers\Admin\CourseController::class, 'instructorCourseCurriculum'])->name('instructor.course.curriculum.edit');


        Route::post('save-course-lesson-vimeo-url/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'saveCourseLessonVimeoUrl'])->name('save.course.lesson.vimeo.url');

        Route::post('instructor-course-curriculum-save', 'Admin\CourseController@instructorCourseCurriculumSave')->name('instructor.course.curriculum.save');

        Route::get('instructor-credits', 'Admin\InstructorController@credits')->name('instructor.credits');

        Route::post('instructor-withdraw-request', 'Admin\InstructorController@withdrawRequest')->name('instructor.withdraw.request');

        Route::get('instructor-withdraw-requests', 'Admin\InstructorController@listWithdrawRequests')->name('instructor.list.withdraw');

        // Save Curriculum
        // Route::post('courses/section/save', 'Admin\CourseController@postSectionSave');
        Route::post('courses/section/save', [\App\Http\Controllers\Admin\CourseController::class, 'postSectionSave']);

        Route::post('courses/section/delete', '\App\Http\Controllers\Admin\CourseController@postSectionDelete');
        // Route::post('courses/lecture/save', 'Admin\CourseController@postLectureSave');
        Route::post('courses/lecture/save', [\App\Http\Controllers\Admin\CourseController::class, 'postLectureSave']);

        // Route::post('courses/video', 'Admin\CourseController@postVideo');
        Route::post('courses/video', [\App\Http\Controllers\Admin\CourseController::class, 'postVideo']);

        // Route::post('courses/lecturequiz/delete', 'Admin\CourseController@postLectureQuizDelete');
        Route::post('courses/lecturequiz/delete', [\App\Http\Controllers\Admin\CourseController::class, 'postLectureQuizDelete']);

        // Route::post('courses/lecturedesc/save', 'Admin\CourseController@postLectureDescSave');
        Route::post('courses/lecturedesc/save', [\App\Http\Controllers\Admin\CourseController::class, 'postLectureDescSave']);

        // Route::post('courses/lecturepublish/save', 'Admin\CourseController@postLecturePublishSave');
        Route::post('ourses/lecturepublish/save', [\App\Http\Controllers\Admin\CourseController::class, 'postLecturePublishSave']);

        // Route::post('courses/lecturevideo/save/{lid}', 'Admin\CourseController@postLectureVideoSave');
        Route::post('courses/lecturevideo/save/{lid}', [\App\Http\Controllers\Admin\CourseController::class, 'postLectureVideoSave']);
        Route::post('courses/lecturevideourl/save', [\App\Http\Controllers\Admin\CourseController::class, 'postLectureVideoUrlSave']);

        Route::post('courses/lectureaudio/save/{lid}', 'Admin\CourseController@postLectureAudioSave');
        Route::post('courses/lecturepre/save/{lid}', 'Admin\CourseController@postLecturePresentationSave');
        Route::post('courses/lecturedoc/save/{lid}', 'Admin\CourseController@postLectureDocumentSave');
        Route::post('courses/lectureres/save/{lid}', 'Admin\CourseController@postLectureResourceSave');
        Route::post('courses/lecturetext/save', 'Admin\CourseController@postLectureTextSave');
        Route::post('courses/lectureres/delete', 'Admin\CourseController@postLectureResourceDelete');
        Route::post('courses/lecturelib/save', 'Admin\CourseController@postLectureLibrarySave');
        Route::post('courses/lecturelibres/save', 'Admin\CourseController@postLectureLibraryResourceSave');
        Route::post('courses/lectureexres/save', 'Admin\CourseController@postLectureExternalResourceSave');

        // Sorting Curriculum
        Route::post('courses/curriculum/sort', '\App\Http\Controllers\Admin\CourseController@postCurriculumSort');

        Route::prefix('default-learning-paths')->group(function () {
            Route::get('/edit', [DefaultLearningPathController::class, 'edit'])
                ->name('default_learning_path.edit');
            Route::post('update', [DefaultLearningPathController::class, 'update'])
                ->name('default_learning_path.update');
        });


        Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories');
        Route::get('/category-form', [\App\Http\Controllers\Admin\CategoryController::class, 'getForm'])->name('admin.categoryForm');
        Route::get('/category-form/{Category_id}', [\App\Http\Controllers\Admin\CategoryController::class, 'getForm']);
        Route::post('/save-category', [\App\Http\Controllers\Admin\CategoryController::class, 'saveCategory'])->name('admin.saveCategory');
        Route::get('/delete-category/{Category_id}', [\App\Http\Controllers\Admin\CategoryController::class, 'deleteCategory']);

        // Confirm password routes
        Route::get('confirm-password', [\App\Http\Controllers\Admin\Auth\ConfirmablePasswordController::class, 'show'])->name('admin.password.confirm');
        Route::post('confirm-password', [\App\Http\Controllers\Admin\Auth\ConfirmablePasswordController::class, 'store']);
        // Logout route
        Route::post('logout', [\App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');
        // General routes
        Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.index');
        Route::get('profile', [\App\Http\Controllers\Admin\HomeController::class, 'profile'])->middleware('password.confirm.admin')->name('admin.profile');

        Route::resource('students', StudentController::class);

        Route::post('student-courses/{id}', [StudentController::class, 'getStudentCourses'])->name('get.student.courses');
        Route::post('save-student-courses', [StudentController::class, 'saveStudentCourses'])->name('save.student.courses');
        Route::get('/subscriptions/', [\App\Http\Controllers\Admin\SubscriptionController::class, 'getList'])->name('subscription.list');
        Route::get('/add-subscription/', [\App\Http\Controllers\Admin\SubscriptionController::class, 'getSubscriptionView'])->name('subscription.add');
        Route::post('/save-subscription/', [\App\Http\Controllers\Admin\SubscriptionController::class, 'saveSubscription'])->name('saveSubscription');
        Route::get('/edit-subscription/{id}', [\App\Http\Controllers\Admin\SubscriptionController::class, 'editSubscription'])->name('subscription.edit');
        Route::post('/updatesubscription/', [\App\Http\Controllers\Admin\SubscriptionController::class, 'updateSubscription'])->name('updateSubscription');

        // Webinar Routes
        Route::get('/add-webinar/', [\App\Http\Controllers\Admin\WebinarController::class, 'getWebinarView'])->name('webinar.add');
        Route::get('/webinars/', [\App\Http\Controllers\Admin\WebinarController::class, 'getList'])->name('webinar.list');
        Route::post('/save-webinar/', [\App\Http\Controllers\Admin\WebinarController::class, 'saveWebinar'])->name('saveWebinar');
        Route::get('/edit-webinar/{id}', [\App\Http\Controllers\Admin\WebinarController::class, 'editWebinar'])->name('webinar.edit');
        Route::post('/update-webinar/', [\App\Http\Controllers\Admin\WebinarController::class, 'updateWebinar'])->name('updateWebinar');
        Route::delete('/webinars/delete/{id}', [\App\Http\Controllers\Admin\WebinarController::class, 'destroy'])->name('webinar.destroy');

        Route::resource('settings', SettingController::class);
        Route::get('/manage/content', [\App\Http\Controllers\Admin\HomeController::class, 'showSiteContent'])->name('showSiteContent');
        Route::post('/content/add', [\App\Http\Controllers\Admin\ContentController::class, 'add'])->name('add');
        Route::get('/getContent', [\App\Http\Controllers\Admin\ContentController::class, 'all'])->name('all');

        // Route::get('/setting', [\App\Http\Controllers\Admin\HomeController::class, 'setting'])->name('setting');
        // Route::post('/setting', [\App\Http\Controllers\Admin\HomeController::class, 'saveSetting'])->name('savesetting');
        Route::get('/subscription/orders', [\App\Http\Controllers\Admin\HomeController::class, 'subsOrder'])->name('subscriptions.orders');
        Route::get('subscription-orders-dt', [\App\Http\Controllers\Admin\HomeController::class, 'dataTable'])->name('subscription-orders-datatable');
        Route::get('/coaching/orders', [\App\Http\Controllers\Admin\HomeController::class, 'coachOrder'])->name('coach.orders');
        Route::get('/course/access', [\App\Http\Controllers\Admin\HomeController::class, 'courseAcess'])->name('access.course');
        Route::get('/user/logs', [\App\Http\Controllers\Admin\HomeController::class, 'userLogs'])->name('user.logs');
        Route::get('/user/activity', [\App\Http\Controllers\Admin\HomeController::class, 'userActivity'])->name('user.activity');
        Route::get('/user/activity/details', [\App\Http\Controllers\Admin\HomeController::class, 'userActivitydetails'])->name('user.activitydetails');
        Route::get('/user/activity/details/{userid}', [\App\Http\Controllers\Admin\HomeController::class, 'userActivitydetaillist'])->name('user.activitydetaillist');
        Route::put('/subscription-dates/update/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'updateSubscriptionDates'])->name('subscription-dates-update');

    });
});

