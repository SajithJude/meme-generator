<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\DefaultLearningPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller {

    public function couseView() {
        return view('course');
    }

    public function viewAllCourses() {
        [$currentCourses, $currentUserCourses, $upcomingCourses] = auth()->user()->userCurrentAndUpcomingCourses();
        return view('admin.course.all_courses', compact('currentCourses', 'upcomingCourses'));
    }
}
