<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\Models\User;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use App\Mail\NewUserSignUpEmail;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller {

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) {
        DB::beginTransaction();

        $request->validate([
            'first_name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'last_name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'city' => ['required', "regex:/^[\pL\s\-\']+$/u", 'max:255'],
            'phone_number' => ['required', 'regex:/^[0-9+\-\s()]*$/', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],[
            'email.unique' => 'Email already exists in our system. <a href="' . route('login') . '">Try to Log In</a>.',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_sign_up_free' => (isset($_GET['free']))? 1:0
        ]);

        if ($user) {
            $data = [
                'name' => $user->first_name . ' ' . $user->last_name,
                'plan' => $user->userSubscribedPlans ? $user->userSubscribedPlans->subscription->plan_name : 'Free Plan',
                'dateTime' => $user->created_at
            ];
            Mail::to($user->email)->send(new WelcomeEmail());
            Mail::to('academy@susieashfield.com')->send(new NewUserSignUpEmail($data));

            $user->saveToMailchimp();

            DB::commit();
            Auth::login($user);
            return redirect('membership-plans');
        }

        DB::rollback();
        return redirect()->back()->withErrors('Error occurred! please try again');
    }

    public function update(Request $request) {
        DB::beginTransaction();

        $request->validate([
            'id' => ['required', 'exists:users,id'],
            'first_name' => 'nullable',
            'last_name' => ['nullable', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
            'city' => ['nullable', "regex:/^[\pL\s\-\']+$/u", 'max:255'],
            'phone_number' => ['nullable', 'regex:/^[0-9+\-\s()]*$/', 'max:255'],
            'pic' => 'nullable|mimes:jpeg,png,jpg,svg',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults(),'max:25']
        ],[
            'first_name.required_without_all' => 'first name is required.',
        ]);


        if (isset($request->about_hidden)) {
            $user = User::where('id',$request->id)->update(['about' => ($request->about)]);
        } else {
            $updateArray = array(
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'city' => $request->city,
            );

            if ($request->has('password') && $request->password!='' && $request->password!=null) {
                if($request->has('password_confirmation') && $request->password_confirmation!=''
                    && $request->password_confirmation!=null && $request->password==$request->password_confirmation) {

                    $updateArray['password'] = Hash::make($request->password);
                    $updateArray['password_updated_at'] = date('Y-m-d H:i:s');
                }
            }

            if ($request->hasFile('pic')) {
                $image = $request->file('pic');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/profile_images');
                $image->move($destinationPath, $name);
                $updateArray['profile_pic'] = $name;
            }

            $user = User::where('id',$request->id)->update($updateArray);
        }

        if ($user) {
            DB::commit();
            return redirect(route('profile'))->with('success', 'Data saved successfully!');
        }

        DB::rollback();
        return redirect()->back()->with('Error occurred! please try again');
    }
    public function freeMemberShipPlan(Request $request){
        $user = \Auth::user();
        if ($user->is_verified == 1) {
            return redirect('home');
        }

        if ($request->get('free_membership') == 1 && $user->is_verified == 0) {
            event(new Registered($user));
            return redirect('verify-email');
        }
    }
}
