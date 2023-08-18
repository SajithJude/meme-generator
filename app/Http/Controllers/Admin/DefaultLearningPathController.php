<?php

namespace App\Http\Controllers\Admin;

use App\Models\{
    Course,
    User,
    DefaultLearningPath
};
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DefaultLearningPathController extends Controller
{
    public function edit(User $user) {
        return view('admin.learning-paths.edit', [
            'user' => $user,
            'courses' => Course::with('defaultLearningPath')->where([['is_locked', 1], ['is_active', 1]])->get()
                ->sortBy(function ($course) {
                    return isset($course->defaultLearningPath) ? $course->defaultLearningPath->opens_on : $course->created_at->timestamp;
                }),
            'defaultLearningPaths' => DefaultLearningPath::orderBy('opens_on', 'asc')->get(),
        ]);
    }

    public function update(Request $request, User $user) {
        $attributes = $request->validate([
            'default_learning_path.*.opens_on' => 'required|integer|min:1',
            'default_learning_path.*.course_id' => 'required|integer',
            'default_learning_path.*.id' => 'integer|nullable',
        ]);

        if (!$this->onlyTwoCoursesPerMonth($attributes)) {
            return redirect()->back()->withErrors(
                ['error_message' => 'You can not open more than 2 courses in a given month ']
            );
        }

        DB::beginTransaction();

        foreach($attributes['default_learning_path'] as $defaultLearningPath) {
            DefaultLearningPath::updateOrCreate(
                [
                    'id' => $defaultLearningPath['id'] ?? 0
                ],
                [
                    'course_id' => $defaultLearningPath['course_id'],
                    'opens_on' => $defaultLearningPath['opens_on']
                ]
            );
        }

        DB::commit();

        return redirect()->back();
    }

    private function onlyTwoCoursesPerMonth($attributes) {
        $opensOn = array_map(function ($path) {
            return $path['opens_on'];
        }, $attributes['default_learning_path']);

        foreach (array_count_values($opensOn) as $count) {
            if ($count > 2)
                return false;
        }

        return true;
    }
}
