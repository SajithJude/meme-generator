<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index()
    {
    	$data = \App\Models\Subscription::getSubscriptions();    	
        if(Auth::check() && (isset(Auth::user()->email_verified_at)  ))
                return redirect('home');

        return view('landing', compact('data'));
    }

    public function home()
    {
        $data = \App\Models\Subscription::getSubscriptions();       
        if(Auth::check() && (isset(Auth::user()->email_verified_at) && !empty(Auth::user()->is_sign_up_free) ))
            return redirect('home');

        return view('landing', compact('data'));
    }

    public function profile()
    {
        return view('profile');
    }
    public function editAboutUs()
    {
        $aboutUs = true;
        return view('editprofile',compact('aboutUs'));
    }
    public function editProfile()
    {
        $aboutUs = false;
        return view('editprofile',compact('aboutUs'));
    }
    public function profileImage(Request $request)
    {
        $this->validate(
            $request,
            [
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            ],
            [
                'image.mimes' => 'The image must be file of type jpeg,png,jpg,gif,svg',
                'image.max'   => 'The image size can not be greater than 500kb',
                'image.dimensions' => 'The image dimensions consists on 1000*1000'
            ]
        );
        $image = $request->file('image');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/profile_images');
        $image->move($destinationPath, $name);
        echo json_encode(['success' => true, 'payload' => url('profile_images/' . $name)]);
    }

    public function updatePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            Auth::user()->update([
                'password' => Hash::make($request->password),
                'password_updated_at' => date('Y-m-d H:i:s'),
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Password Updated Successfully'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
