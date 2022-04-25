<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\ErrorLog;
use App\Models\EmailQueue;






class AuthController extends Controller
{
    public function register(Request $request, User $user)
    {
    	$rules = [
    		'full_name'=>'required',
            'email' => 'required|email:rfc,dns,filter|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required',
            'device_type' => 'required|boolean',
            'fcm_token' => 'required'

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $user = $user->fill($request->all());
        $user->email_verification_otp = User::generateEmailVerificationOtp();

        if(!$user->save()){
            return returnErrorResponse('Unable to register user. Please try again later');
        }


        EmailQueue::add([
            'to' => $user->email,
            'subject' => "Verification Code",
            'view' => 'mail',
            'type'=>0,
            'viewArgs' => [
                'name' => $user->full_name,
                'body' => "Your verification otp is: ".$user->email_verification_otp
            ]
        ]);

        return returnSuccessResponse('You are registered successfully. please verify email to proceed.', $user->jsonResponse());
    }

   public function verifyOtp(Request $request, User $user)
   {
       $rules = [
           'user_id' => 'required',
           'otp' => 'required'
       ];

       $inputArr = $request->all();
       $validator = Validator::make($inputArr, $rules);
       if ($validator->fails()) {
           $errorMessages = $validator->errors()->all();
           throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
       }

       $userObj = User::where('id', $inputArr['user_id'])
                       ->where('email_verification_otp', $inputArr['otp'])
                       ->first();
       if (!$userObj) {
           return returnNotFoundResponse('Invalid OTP');
       }

       $userObj->email_verified_at = Carbon::now();
       $userObj->email_verification_otp = null;
       $userObj->save();

       $updatedUser = User::find($inputArr['user_id']);
       $authToken = $updatedUser->createToken('authToken')->plainTextToken;
       $returnArr = $updatedUser->jsonResponse();
       $returnArr['auth_token'] = $authToken;
       return returnSuccessResponse('Otp verified successfully', $returnArr);
    }

     public function resendOtp(Request $request, User $user)
    {
        $userId = $request->get('user_id');
        if(!$userId){
            throw new HttpResponseException(returnValidationErrorResponse('Please send user id with this request'));
        }
        $userObj = User::where('id', $userId)->first();
        if (!$userObj) {
            return returnNotFoundResponse('User not found with this user id');
        }
       
        $verificationOtp = $userObj->generateEmailVerificationOtp();
        $userObj->email_verification_otp = $verificationOtp;
        $userObj->save();

        EmailQueue::add([
            'to' => $userObj->email,
            'subject' => "Verification Code",
            'view' => 'mail',
            'type'=>0,
            'viewArgs' => [
                'name' => $userObj->full_name,
                'body' => "Your verification otp is: ".$userObj->email_verification_otp
            ]
        ]);
    

        return returnSuccessResponse('Otp resend successfully!',$userObj->jsonResponse());
    }

    public function login(Request $request)
    {
    	$rules = [
    		'email' => 'required',
            'password' => 'required',
            'device_type' => 'required',
            'fcm_token' => 'required'

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $inputArr = $request->all();

        $userObj = User::where('email', $inputArr['email'])->first();
        if(empty($userObj))
            return returnNotFoundResponse('User Not found.');

        if($userObj->status == User::STATUS_INACTIVE)
            return returnErrorResponse("Your account is inactive please contact with admin.");


        if(empty($userObj->email_verified_at))
        	return returnNotFoundResponse('Please verify your email.',$userObj->jsonResponse());


        if (!Auth::attempt(['email' => $inputArr['email'], 'password' => $inputArr['password']])) {
            return returnNotFoundResponse('Invalid credentials');
        }
        
        $userObj->device_type = $inputArr['device_type'];
        $userObj->fcm_token = $inputArr['fcm_token'];
        $userObj->save();

        $userObj->tokens()->delete();
        $authToken = $userObj->createToken('authToken')->plainTextToken;
        $returnArr = $userObj->jsonResponse();
        $returnArr['auth_token'] = $authToken;

        return returnSuccessResponse('User logged in successfully', $returnArr);
    }

     public function logout(Request $request)
    {
        $userObj = $request->user();
        if (!$userObj) {
            return returnNotAuthorizedResponse('You are not authorized');
        }

        $userObj->tokens()->delete();
        $userObj->fcm_token = null;
        $userObj->save();
        return returnSuccessResponse('User logged out successfully');
    }

    public function forgotPassword(Request $request, User $user)
    {
        $rules = [
            'email' => 'required',
        ];

        $messages = [
            'email.required' => 'Please enter email address.'
        ];

        $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules, $messages);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $userObj = User::where('email', $inputArr['email'])
                        ->first();
        if (!$userObj) {
            return returnNotFoundResponse('User not found with this email address');
        }

        if(empty($userObj->email_verified_at))
            return returnNotFoundResponse('Please verify your email.');

        $resetPasswordOtp = $userObj->generateEmailVerificationOtp();
        $userObj->email_verification_otp = $resetPasswordOtp;
        $userObj->save();

          EmailQueue::add([
            'to' => $userObj->email,
            'subject' => "Reset Password OTP",
            'view' => 'mail',
            'type'=>0,
            'viewArgs' => [
                'name' => $userObj->full_name,
                'body' => "Your reset password otp is: ".$userObj->email_verification_otp
            ]
        ]);

        return returnSuccessResponse('Reset password OTP sent successfully', $userObj->jsonResponse());
    }


    public function resetPassword(Request $request, User $user)
    {

    	$rules = [
                    'user_id' => 'required',
                    'reset_password_otp' => 'required',
                    'new_password' => 'required',
                    'confirm_new_password' => 'required|same:new_password'

                ];
         $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $userObj = User::where('id', $inputArr['user_id'])
                        ->where('email_verification_otp', $inputArr['reset_password_otp'])
                        ->first();
        if (!$userObj) {
            return returnNotFoundResponse('Invalid reset password OTP');
        }

        $userObj->email_verification_otp = null;
        $userObj->password = $inputArr['new_password'];
        $userObj->save();

        return returnSuccessResponse('Password reset successfully');
    }
}
