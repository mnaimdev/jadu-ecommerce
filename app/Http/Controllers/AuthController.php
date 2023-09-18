<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserToken;
use App\services\AuthService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    // register
    public function register(Request $request)
    {

        try {

            if ($request->password != $request->password_confirmation) {
                return response()->json(['message'  => 'Password Not Match', 'status' => 400]);
            } else {
                $service = new AuthService();
                $service->setName($request->name)
                    ->setEmail($request->email)
                    ->setPassword($request->password)
                    ->setConfirmPassword($request->password_confirmation)
                    ->setPhone($request->phone)
                    ->register();

                return response()->json(['message' => 'Registered Successfully', 'status' => 200]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }



    // login
    public function login(Request $request)
    {
        try {

            // check phone number exists
            if ($request->phone != '') {
                if (User::where('phone', $request->phone)->exists()) {

                    $service = new AuthService();
                    $result = $service->setPhone($request->phone)
                        ->login();

                    return response()->json(['token' => $result, 'status' => 200]);
                } else {
                    return response()->json(['message' => 'Phone Number Does Not Match!', 'status' => 404], 400);
                }
            }

            // else
            else {

                // check login process
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    $service = new AuthService();
                    $result = $service->setEmail($request->email)
                        ->login();

                    return response()->json(['token' => $result, 'status' => 200]);
                } else {
                    return response()->json(['message' => 'Email Or Password Not Match', 'status' => 400], 400);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }


    public function profileUpdate(Request $request)
    {

        if (UserToken::where('token', $request->token)->exists()) {
            try {
                $service = new AuthService();
                $service->setName($request->name)
                    ->setPassword($request->password)
                    ->setImage($request->image)
                    ->setCountry($request->country)
                    ->setCity($request->city)
                    ->setAddress($request->address)
                    ->profile($request->token);

                return response()->json(['message' => 'Profile Updated Successfully', 'status' => 200], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 400);
            }
        } else {
            return response()->json(['message' => 'Invalid Token', 'status' => 400], 400);
        }
    }


    public function logout($token)
    {
        try {
            $service = new AuthService();
            $service->logout($token);

            return response()->json(['message' => 'Logout Successfullly', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }


    public function forgetPassword(Request $request)
    {
        try {

            if (User::where('email', $request->email)->exists()) {
                $service = new AuthService();
                $service->forget($request->email);

                return response()->json(['message'  => 'We have sent you a notification to reset your password'], 200);
            } else {
                return response()->json(['message' => 'Email Not Match']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }


    public function passResetForm($token)
    {
        try {
            return view('customer.pass_reset.pass_reset_form', [
                'token'     => $token,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function passResetConfirm(Request $request)
    {
        try {
            if ($request->password != $request->password_confirmation) {
                return back()->with('match', 'Password Not Match');
            } else {
                $service = new AuthService();
                $service->setPassword($request->password)
                    ->reset($request->token);

                return back()->with('pass_reset', 'Successfully Reset Your Password');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
