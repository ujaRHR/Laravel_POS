<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function loginPage(Request $request)
    {
        return view('pages.auth.login-page');
    }

    public function registrationPage(Request $request)
    {
        return view('pages.auth.registration-page');
    }

    public function sendOTPPage(Request $request)
    {
        return view('pages.auth.send-otp-page');
    }

    public function verifyOTPPage(Request $request)
    {
        return view('pages.auth.verify-otp-page');
    }

    public function resetPasswordPage(Request $request)
    {
        return view('pages.auth.reset-pass-page');
    }

    public function userProfilePage(Request $request)
    {
        return view('pages.dashboard.profile-page');
    }

    public function userRegistration(Request $request)
    {
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName'  => $request->input('lastName'),
                'email'     => $request->input('email'),
                'mobile'    => $request->input('mobile'),
                'password'  => Hash::make($request->input('password'))
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'user registered successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'something is wrong! try again',
                // For Development Purpose
                // 'reason' => $e->getMessage()
            ], 200);
        }
    }

    public function userLogin(Request $request)
    {
        try {
            $user = User::where('email', $request->input('email'))
                ->first();

            $userID         = $user->id;
            $hashedPassword = $user->password;

            if (Hash::check($request->input('password'), $hashedPassword)) {
                $email = $request->input('email');
                $token = JWTToken::createToken($email, $userID);
                return response()->json([
                    'status'  => 'success',
                    'message' => 'User Logged In Successfully'
                ])->cookie('token', $token, 24 * 60);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }

    public function sendOTPCode(Request $request)
    {
        $email = $request->input('email');
        $otp   = rand(100000, 999999);

        $count = User::where('email', '=', $email)->count();

        if ($count == 1) {
            Mail::to($email)->send(new OTPMail($otp));

            User::where('email', '=', $email)
                ->update([
                    'otp' => $otp
                ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'OTP sent successfully'
            ], 200);

        } else {
            return response()->json([
                'status'  => 'failed',
                'message' => 'something is wrong!'
            ], 400);
        }
    }

    public function verifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp   = $request->input('otp');

        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)
            ->count();


        if ($count == 1) {
            User::where('email', '=', $email)->update([
                'otp' => 0
            ]);

            $token = JWTToken::passwordResetToken($email);

            return response()->json([
                'status'  => 'success',
                'message' => 'OTP verification successful',
            ], 200)->cookie('token', $token, 15 * 60 * 60);
        } else {
            return response()->json([
                'status'  => 'failed',
                'message' => 'OTP verification failed'
            ], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        $email              = $request->header('email');
        $newPassword        = $request->input('newPassword');
        $confirmNewPassword = $request->input('confirmNewPassword');

        try {
            if ($newPassword == $confirmNewPassword) {
                User::where('email', '=', $email)->update([
                    'password' => Hash::make($newPassword)
                ]);
                return response()->json([
                    'status'  => 'success',
                    'message' => 'password updated successfully'
                ], 200);
            } else {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'password mismatch'
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'something is wrong'
            ], 400);
        }
    }

    public function userLogout(Request $request)
    {
        return redirect('/user-login')->cookie('token', '', -1);
    }


    public function userProfile(Request $request)
    {
        try {
            $email = $request->header('email');
            $user  = User::where('email', '=', $email)->first();
            $data  = [
                'firstName' => $user->firstName,
                'lastName'  => $user->lastName,
                'email'     => $user->email,
                'mobile'    => $user->mobile
            ];

            return response()->json([
                'status'  => 'success',
                'message' => 'user fetched successfully',
                'data'    => $data
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'something went wrong',
            ], 400);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $email = $request->header('email');
            User::where('email', '=', $email)->update([
                'firstName' => $request->input('firstName'),
                'lastName'  => $request->input('lastName'),
                'mobile'    => $request->input('mobile'),
                'password'  => Hash::make($request->input('password'))
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'profile updated successfully'
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'something went wrong',
            ]);
        }
    }
}
