<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Course,
    UserSubscribedPlan,
    Subscription
};
use App\Models\TextContent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DB;
use PDF;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $paginate_count = 10;

        if ($request->has('search')) {
            $search = $request->input('search');

            $courses = DB::table('courses')
                ->select('courses.*', 'course_videos.*', 'categories.name as category_name')
                ->leftJoin('categories', 'categories.id', '=', 'courses.category_id')
                ->leftJoin('course_videos', 'course_videos.id', '=', 'courses.id')
                ->where('courses.course_title', 'LIKE', '%' . $search . '%')
                ->orWhere('courses.course_slug', 'LIKE', '%' . $search . '%')
                ->orWhere('categories.name', 'LIKE', '%' . $search . '%')
                ->orWhere('is_active', 1)
                ->paginate($paginate_count);
        } else {
            [$userCourses, $currentCourses, $lockedCourses] = auth()->user()->userCurrentAndUpcomingCourses();
            $monthly_progress = $this->calculateMonthlyProgressPercentage($currentCourses);

            $allCourses = $userCourses->concat($lockedCourses);
            $lockedCount = $lockedCourses->where('is_locked', 0)->count() + $userCourses->count();
            $lastWatchCourse = auth()->user()->logs()->where('page', 'course-lesson-detail')->with('curriculumLecturesQuiz.courseVideo')
                ->orderBy('created_at', 'desc')->first();

            $lastWatch = null;

            if (isset($lastWatchCourse)) {
                $sectionId = $lastWatchCourse->curriculumLecturesQuiz->section_id;
                $course_id = DB::table('curriculum_sections')->select('course_id')->where('section_id', '=', $sectionId)->pluck('course_id')->first();
                $courseStatus = Course::select('overview', 'is_active')->where('id', $course_id)->first();

                if ($courseStatus) {
                    if ($lastWatchCourse->curriculumLecturesQuiz->media == null)
                        $lesson_video_url = 'https://player.vimeo.com/video/798543316';
                    else
                        $lesson_video_url = $lastWatchCourse->curriculumLecturesQuiz->courseVideo->video_title;

                    $lastWatch = [
                        'course_id' => $course_id,
                        'course_title' => $lastWatchCourse->objecttype,
                        'lesson_title' => $lastWatchCourse->objectname,
                        'description' => $courseStatus->description,
                        'lesson_video_url' => $lesson_video_url,
                        'lesson_id' => $lastWatchCourse->objectid
                    ];
                }
            }
        }


        return view('home', compact('allCourses', 'lockedCount', 'lastWatch', 'monthly_progress'));
    }

    public function courseLesson($id, $lesson_id = '')
    {

        $course = Course::join('admins', 'instructor_id', 'admins.id')->where('courses.id', $id)->select('courses.*', 'admins.name')->first();
        $user_id = 1;
        $coursecurriculum = Course::getcurriculuminfo($id, $user_id);
        $data['course'] = $course;
        $data['course_video'] = Course::get_course_video($id); //->course_videos();
        $data['sections'] = $coursecurriculum['sections'];
        $data['lecturesquiz'] = $coursecurriculum['lecturesquiz'];
        $data['lecturesquizquestions'] = $coursecurriculum['lecturesquizquestions'];
        $data['lecturesmedia'] = $coursecurriculum['lecturesmedia'];
        $data['lecturesresources'] = $coursecurriculum['lecturesresources'];
        $data['uservideos'] = $coursecurriculum['uservideos'];
        $data['useraudios'] = $coursecurriculum['useraudios'];
        $data['userpresentation'] = $coursecurriculum['userpresentation'];
        $data['userdocuments'] = $coursecurriculum['userdocuments'];
        $data['userresources'] = $coursecurriculum['userresources'];
        $data['lecturesnotes'] = $coursecurriculum['lecturesnotes'];
        //dd($coursecurriculum['lecturesnotescompleted']);
        $data['completed_lesson_count'] = Course::join('curriculum_sections', 'curriculum_sections.course_id', 'courses.id')->join('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', 'curriculum_sections.section_id')->join('user_notes', 'curriculum_lectures_quiz.lecture_quiz_id', 'user_notes.lesson_id')->where('courses.id', $id)->where('user_notes.user_id', \Auth::user()->id)->where('completed', 1)->count();

        $data['totalquiz'] = $coursecurriculum['totallectures'];
        $segments = request()->segments();
        $last = $id;
        $firstLecture = false;

        if ($lesson_id == null) {
            $lesson = Course::get_lesson_id($last);
            $lesson_id = $lesson->lecture_quiz_id;
            $data['slectedsessionid'] = $lesson->section_id;
        } else {
            $lesson = Course::get_lesson_section_id($lesson_id);
            $data['slectedsessionid'] = $lesson->section_id;

            $dynamicKey = null;
            foreach ($data['lecturesquiz'] as $key => $value) {
                $dynamicKey = $key;
                break;
            }

            if ($dynamicKey !== null)
                $firstLecture = collect($data['lecturesquiz'][$dynamicKey])->where('lecture_quiz_id', $lesson_id)->first();
        }
        if ($firstLecture)
            $mediaId = $firstLecture->media;
        else {
            $lectureQuiz = collect($data['lecturesquiz'])->first();
            $firstLecture = $lectureQuiz->first();
            $mediaId = $firstLecture->media;
        }

        $firstVideo = DB::table('course_videos')->where('id', $mediaId)->get()->toArray();
        if ($firstVideo)
            $data['first_video'] = $firstVideo[0];
        else {
            $first_video = new \stdClass();
            $first_video->video_title = "https://player.vimeo.com/video/798543316?title=0&byline=0&portrait=0&speed=0&badge=0&autopause=0&share=0";
            $data['first_video'] = $first_video;
        }
        $promoVideo = DB::table('course_videos')->where('course_id', $id)->where('video_name', 'Video Link')->first();
        if ($promoVideo)
            $data['promo_video'] = $promoVideo->video_title;
        else {
            $data['promo_video'] = "https://www.youtube.com/embed/YLExFohPbBc";

        }
        $data['notes'] = DB::table('user_notes')->where('lesson_id', $lesson_id)->first();

        if (isset($data['lecturesquiz'][$last]) && !empty($data['lecturesquiz'])) {
            //$intro = DB::table('course_videos')->where('id', $data['lecturesquiz'][$last][0]->media)->where('video_name','!=','Video Link')->get()->toArray();
            $data['quiz_description'] = $data['lecturesquiz'][$last][0]->description;
            $data['slectedsessionid'] = $data['lecturesquiz'][$last][0]->section_id;
            //$data['first_video'] = isset($intro[0]) ? $intro[0] : array();
            $data['subscriptionPlanMonthly'] = Subscription::where('plans', 'monthly')->first();
            $data['subscriptionPlanAnually'] = Subscription::Where('plans', 'yearly')->first();
            $data['subscriptionPlans'] = array();
            $data['access'] = 'true';
            if (!empty($lesson_id)) {
                $lection_quiz = DB::table('curriculum_lectures_quiz')->where('lecture_quiz_id', $lesson_id)->first();
                $data['quiz_description'] = $lection_quiz->description;
                //$intro = DB::table('course_videos')->where('id', $lection_quiz->media)->get()->toArray();
                //$data['first_video'] = isset($intro[0]) ? $intro[0] : array();
                $userSubscriptionPlan = UserSubscribedPlan::where('user_id', auth()->user()->id)->first();
                $data['slectedsessionid'] = $lection_quiz->section_id;

                $data['subscriptionPlanMonthly'] = Subscription::where('plans', 'monthly')->first();
                $data['subscriptionPlanAnually'] = Subscription::Where('plans', 'yearly')->first();
                if (isset($userSubscriptionPlan->id)) {
                    $data['access'] = 'true';
                } else {
                    $data['access'] = 'false';
                }
            }
        }
        $userSubscriptionPlan = UserSubscribedPlan::where('user_id', auth()->user()->id)->first();
        if (isset($userSubscriptionPlan->id)) {
            $data['access'] = 'true';
            $data['selectedlesson'] = $lesson_id;
            $data['selectedLessonUserNotes'] = DB::table('user_notes')
                ->where([['user_id', auth()->id()], ['lesson_id', $lesson_id]])->first();
            $data['subscriptionPlanMonthly'] = Subscription::where('plans', 'monthly')->first();
            $data['subscriptionPlanAnually'] = Subscription::Where('plans', 'yearly')->first();
            $data['progressPercentage'] = $this->calculateProgressPercentage($id);
            return view('lesson', $data);
        } else {
            $access['user_id'] = Auth::user()->id;
            $access['course_id'] = $id;
            $access['created_at'] = date('Y-m-d H:i:s');
            $access['updated_at'] = date('Y-m-d H:i:s');
            DB::table('free_user_course_access')->insertGetId($access);
            return redirect()->route('membershipPlans')->with($data);
        }
    }

    public function courseLessonDetail($id, $lesson_id = '')
    {
        $course = Course::join('admins', 'instructor_id', 'admins.id')->where('courses.id', $id)
            ->select('courses.*', 'admins.name')->first();
        $lesson = DB::table('curriculum_lectures_quiz')->where('lecture_quiz_id', $lesson_id)->first();
        $notes = DB::table('user_notes')->where([['lesson_id', '=', $lesson_id], ['user_id', '=', Auth::user()->id]])
            ->first();

        if ($notes == NULL) { # to maintain when the lesson put in progress
            $note = [
                'created_at' => date("Y-m-d H:i:s"),
                'last_played' => date("Y-m-d H:i:s"),
                'user_id' => Auth::user()->id,
                'lesson_id' => $lesson_id,
                'notes' => ''
            ];

            DB::table('user_notes')->insertGetId($note);

            $data['notes'] = '';
            $data['completed'] = 0;
        } else {
            DB::table('user_notes')->where([['lesson_id', '=', $lesson_id], ['user_id', '=', Auth::user()->id]])
                ->update(['last_played' => date("Y-m-d H:i:s")]);

            $data['notes'] = trim($notes->notes);
            $data['completed'] = $notes->completed;
            $data['lesson_timestamp'] = $notes->lesson_timestamp;
        }

        $data['desc'] = $course != NULL ? trim($lesson->description) : '';

        return response()->json($data);
    }

    public function calendly()
    {

        $id = Auth::user()->id;
        //dd($id);
        $availableCount = \App\Models\AvailableBookingCount::where('user_id', $id)->first();
        $price = \App\Models\GeneralSetting::where('key', 'booking_credits_price')->pluck('value')->first();
        $count = !empty($availableCount) ? $availableCount->booking_count : 0;
        return view('calendly', compact('count', 'price'));
    }

    public function practise()
    {
        return view('yoodli');
    }

    public function saveLessonNotes()
    {
        $notes = trim($_GET['notes']);
        $lesson_id = $_GET['lesson_id'];
        $completed = isset($_GET['is_completed']) ? $_GET['is_completed'] : 0;
        $completed_at = (isset($_GET['is_completed']) && $_GET['is_completed'] == 1) ? date('Y-m-d H:i:s') : null;

        if ($lesson_id == 'undefined') {
            $lesson = Course::get_lesson_id($_GET['course_id']);
            $lesson_id = $lesson->lecture_quiz_id;
        }

        $lesson = DB::table('user_notes')->where('lesson_id', $lesson_id)->first();
        if ($lesson != NULL) {
            DB::table('user_notes')->where('lesson_id', $lesson_id)->update(
                [
                    'notes' => $notes,
                    'lesson_timestamp' => $lesson->completed ? null : $lesson->lesson_timestamp,
                    'completed' => $completed,
                    'completed_at' => $completed_at
                ]
            );
        } else {
            DB::table('user_notes')->Insert(
                [
                    'user_id' => auth()->user()->id,
                    'notes' => $notes,
                    'lesson_id' => $lesson_id,
                    'completed' => $completed,
                    'completed_at' => $completed_at,
                    'lesson_timestamp' => null
                ]
            );
        }

        return response()->json(['success' => true, 'progress_percentage' => $this->calculateProgressPercentage($_GET['course_id'])]);
    }

    public function saveLessonTimestamp(Request $request)
    {
        $attributes = $request->validate([
            'lesson_id' => 'required|integer',
            'lesson_timestamp' => 'required|integer',
        ]);

        $user_note = DB::table('user_notes')->where(
            [
                ['lesson_id', '=', $attributes['lesson_id']],
                ['user_id', '=', auth()->id()]
            ]
        )->first();

        if (isset($user_note->id)) {
            DB::table('user_notes')->where(
                [
                    ['lesson_id', '=', $attributes['lesson_id']],
                    ['user_id', '=', auth()->id()]
                ]
            )->update(['lesson_timestamp' => $attributes['lesson_timestamp']]);
        } else {
            DB::table('user_notes')->Insert(array_merge($attributes, ['user_id' => auth()->id()]));
        }

        return response()->json(['success' => true]);
    }

    public function termofservice(Request $request)
    {
        $content = TextContent::where('type', 'TC')->first();
        return view('content', compact('content'));
    }
    public function cookiepolicy(Request $request)
    {
        $content = TextContent::where('type', 'CP')->first();
        return view('content', compact('content'));
    }
    public function privacypolicy(Request $request)
    {
        $content = TextContent::where('type', 'PP')->first();
        return view('content', compact('content'));
    }

    public function calculateProgressPercentage($id)
    {
        $courseCurriculum = Course::getcurriculuminfo($id, auth()->user());
        $totalLectures = $courseCurriculum['totallectures'];
        $completedLessonCount = Course::join('curriculum_sections', 'curriculum_sections.course_id', 'courses.id')
            ->join('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', 'curriculum_sections.section_id')
            ->join('user_notes', 'curriculum_lectures_quiz.lecture_quiz_id', 'user_notes.lesson_id')
            ->where('courses.id', $id)->where('user_notes.user_id', auth()->id())
            ->where('completed', 1)->count();

        return $totalLectures > 0 ? round(($completedLessonCount / $totalLectures) * 100) : 0;
    }

    public function calculateMonthlyProgressPercentage($currentPath)
    {
        if ($currentPath->count()) {
            $courseCurriculum = Course::getcurriculuminfo($currentPath->first()->id, auth()->user());
            $totalLectures = $courseCurriculum['totallectures'];
            $completedLessonCount = Course::join('curriculum_sections', 'curriculum_sections.course_id', 'courses.id')
                ->join('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', 'curriculum_sections.section_id')
                ->join('user_notes', 'curriculum_lectures_quiz.lecture_quiz_id', 'user_notes.lesson_id')
                ->where('courses.id', $currentPath->first()->id)->where('user_notes.user_id', auth()->id())
                ->where('completed', 1)->count();
        }

        if ($currentPath->count() > 1) {
            $courseCurriculum = Course::getcurriculuminfo($currentPath->last()->id, auth()->user());
            $totalLectures += $courseCurriculum['totallectures'];
            $completedLessonCount += Course::join('curriculum_sections', 'curriculum_sections.course_id', 'courses.id')
                ->join('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', 'curriculum_sections.section_id')
                ->join('user_notes', 'curriculum_lectures_quiz.lecture_quiz_id', 'user_notes.lesson_id')
                ->where('courses.id', $currentPath->last()->id)->where('user_notes.user_id', auth()->id())
                ->where('completed', 1)->count();
        }

        return $currentPath->count() && $totalLectures > 0 ? round(($completedLessonCount / $totalLectures) * 100) : 0;
    }


    public function downloadLessonNotes(Request $request)
    {
        $course = Course::with('chapters.lessons.notes')->findOrFail($request->course_id);
        $courseTitle = $course->course_title;
        $pdf = PDF::loadView('course_notes_pdf_template', compact('course'));
        $directory = 'user-notes';
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory("$directory");
        }
        $course_name = str_replace(' ','_', $courseTitle);
        $path = $directory . '/' . $course_name . '.pdf';
        Storage::disk('public')->put($path, $pdf->output());
        return ['url' => url('/storage/' .$path), 'name' => $courseTitle];
    }

}
