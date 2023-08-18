<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Course;
use App\Mail\NewUserMail;
use App\Models\Subscription;
use App\Models\UserLearningPlan;
use Illuminate\Http\Request;
use App\Jobs\SendUserMailJob;
use Illuminate\Http\JsonResponse;
use App\DataTables\UsersDataTable;
use App\Models\UserSubscribedPlan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\AvailableBookingCount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller {

    public function index(UsersDataTable $datatable)
    {
        return $datatable->render('admin.student.index');
    }

    public function create() {
        $plans = Subscription::where('status', 1)->get();
        return view('admin.student.add-student', compact('plans'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[A-Za-z ]+$/',
            'email' => 'required|email|unique:users',
            'booking_count' => 'required',
            'fee_price' => 'required_with:selected_plan',
            'start_date' => 'required_with:selected_plan',
            'end_date' => 'required_with:selected_plan|nullable|after:start_date',
        ],[
            'first_name.required' => 'First name is required.',
            'booking_count.required' => 'First name is required.',
            'fee_price.required_with' => 'Fee price is required.',
            'start_date.required_with' => 'Subscription start date is required.',
            'end_date.required_with' => 'Subscription end date is required.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            DB::beginTransaction();
            $password = mt_rand(10000000,99999999);
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'phone_number' => $request->phone_number,
                'city' => $request->city,
                'status' => $request->status,
                'created_by' => 'admin',
            ]);
            if (isset($request->selected_plan)) {
                UserSubscribedPlan::create([
                    'subscription_id' => $request->selected_plan,
                    'user_id' => $user->id,
                    'price' => $request->fee_price,
                    'subscription_start_date' => $request->start_date . ' 23:59:59',
                    'subscription_end_date' => $request->end_date . ' 23:59:59',
                    'paid_with' => 'cash',
                    'is_active' => 1,
                ]);
            }
            AvailableBookingCount::create([
                'user_id' => $user->id,
                'booking_count' => $request->booking_count,
            ]);
            $data = [
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'password' => $password,
                'subject' => 'Account Created',
                'message' => 'Your account has been created successfully in Speak2Impact',
                'note' => 'Please update your password as soon as possible.'
            ];
            SendUserMailJob::dispatch($data);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Student added successfully'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $error->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit($id) {
        $user = $results = User::with('availableBookingCounts')->where('id', $id)->first();
        $data = !empty($results) ? $results->toArray() : [];
        return view('admin.student.edit-student', compact('data'));
    }

    public function update(Request $request) {
        $data = self::prepareData($request);
        $data['id'] = $request->id;
        $save = User::updateData($data, true);
        if ($save) {
            return redirect()->route('students.index')->with('Saved Successfully!');
        } else {
            return redirect()->back()->with('Error occurred! please try again');
        }
    }

    public function destroy($id)
    {
        try
        {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->availableBookingCounts()->delete();
            $user->coachPayments()->delete();
            $user->eventBookings()->delete();
            $user->payments()->delete();
            $user->userSubscribedPlans()->delete();
            $user->delete();
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'User Deleted successfully'
            ], JsonResponse::HTTP_OK);
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public static function prepareData($request)
    {
        $inputs['first_name'] = $request['first_name'];
        $inputs['last_name'] = $request['last_name'];
        $inputs['phone_number'] = $request['phone_number'];
        $inputs['city'] = $request['city'];
        $inputs['status'] = $request['status'];
        $inputs['booking_count'] = $request['booking_count'];

        return $inputs;
    }

    public function getStudentCourses($id) {
        $student = User::with('courses')->findOrFail($id);
        $courses = Course::with(['users' => function ($q) use ($id) { $q->where('users.id', $id); }])
            ->where([['is_active', '=', 1], ['is_locked', '=', 1]])->select('id', 'course_title')->get();

        return view('admin.modals.student_courses_modal', compact('student', 'courses', 'id'))->render();
    }

    public function saveStudentCourses(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'learning_path' => 'in:manual|nullable',
            'courses.*.course_id' => 'required|integer',
            'courses.*.is_accessible' => 'integer|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $courses = [];
        foreach ($validator->validated()['courses'] as $id => $course) {
            if (isset($course['is_accessible'])) {
                $courses[$id]['course_id'] = $course['course_id'];
                $courses[$id]['created_at'] = date('Y-m-d H:i:s');
            }
        }

        try {
            $student = User::findOrFail($request->user_id);
            $student->learning_path = $request->learning_path;
            $student->save();
            $student->courses()->sync($courses);

            return response()->json([
                'status' => true,
                'message' => 'Student courses Updated Successfully'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
