<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OtpMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function registrationPage(Request $request)
    {
        return view('auth.registration');
    }
    public function loginPage(Request $request)
    {
        return view('auth.login');
    }
    public function otpPage()
    {
        return view('auth.sendOtp');
    }
    public function otpVerifyPage()
    {
        return view('auth.verifyotp');
    }
    public function resetPasswordPage()
    {
        return view('auth.reset-pass');
    }

    public function userRegistration(Request $request)
    {

        try {


            $validated =   $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:3',
                ]
            );

            User::create($validated);
            return response()->json([
                'status' => 'success',
                'msg' => 'user registration successfull'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'msg' => 'something went wrong',
            ], 200);
        }
    }

    public function userLogin(Request $request)
    {

        $count =  User::where('email', $request->input('email'))->count();
        $userPass = User::where('email', $request->input('email'))->first()->password;

        if ($count !== 0 && Hash::check($request->input('password'), $userPass)) {

            $token = JWTToken::createToken($request->input('email'));

            return response()->json(['status' => 'success', 'msg' => 'user login successful'], 200)->cookie('token', $token, 60 * 60);
        } else {
            return response()->json(['status' => 'failed', 'msg' => 'unauthorized'], 401);
        }
    }

    public function sendOtp(Request $request)
    {


        $email = $request->input('email');
        $otp = rand(3000, 7800);
        $count = User::where('email', $email)->count();


        if ($count == 1) {
            Mail::to($email)->send(new OtpMail($otp));

            User::where('email', $email)->update(['otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'message' => '4 Digit OTP Code has been send to your email !'
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ], 401);
        }
    }


    public function verifyOtp(Request $request)
    {

        $email = $request->input('email');
        $otp = $request->input('otp');

        $count = User::where('email', $email)
            ->where('otp', $otp)
            ->count();

        if ($count == 1) {
            User::where('email', $email)->update(['otp' => 0]);
            $token = JWTToken::createTokenForResetPass($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'OTP Verification Successful',
            ], 200)->cookie('token', $token, 60 * 24 * 30);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ], 401);
        }
    }


    function  resetPassword(Request $request)
    {
        try {
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ], 200);
        }
    }
}
