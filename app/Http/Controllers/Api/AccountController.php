<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Auth;

class AccountController extends Controller
{
     public function changePassword(Request $request){

     	$rules = [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required|same:new_password',
        ];
         $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }
        $userObj = $request->user();
        if (!$userObj) {
            return returnNotAuthorizedResponse('User is not authorized');
        }

        if(!Hash::check($request->old_password, $userObj->password)){
            throw new HttpResponseException(returnValidationErrorResponse('Invalid old Password'));
        }

        $userObj->password = $request->get('new_password');
        if(!$userObj->save()){
            return returnErrorResponse('Unable to change Password');
        }

        $returnArr = $userObj->jsonResponse();
        $returnArr['auth_token'] = $request->bearerToken();
        return returnSuccessResponse('Password updated successfully', $returnArr);
    }

     public function getProfile(Request $request)
    {
        $userObj = $request->user();
        if (!$userObj) {
            return returnNotAuthorizedResponse('User is not authorized');
        }

        $returnArr = $userObj->jsonResponse();
        $returnArr['auth_token'] = $request->bearerToken();
        $subscription = Subscription::where(['created_by'=>auth()->user()->id])->first();
        $returnArr['subscription_active'] = !empty($subscription)?true:false;

        return returnSuccessResponse('User profile', $returnArr);
    }

    public function notification(Request $request){

    	$rules = [
            'notification_type' => 'required|integer|min:1|max:2'
        ];
         $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $user = auth()->user();

        if($request->notification_type == User::DEVICE_NOTIFICATION){
        	$attribute = "notification";
        }else{
        	 $attribute = "email_notification";

        }

    	if($user->$attribute == 1){
    		$user->$attribute = 0;
    		$message = "Notification off successfully.";
    	}else{
    		$user->$attribute = 1;
    		$message = "Notification on successfully.";
    	}
    	if($user->save())
    		return returnSuccessResponse($message, $user->jsonResponse());

    }

    public function updateProfile(Request $request){

        $rules = [
            'full_name' => 'required'
        ];
         $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }
        $userObj = $request->user();
        if (!$userObj) {
            return returnNotAuthorizedResponse('User is not authorized');
        }

        $userObj->full_name = $request->full_name;
        if(!$userObj->save()){
            return returnErrorResponse('Unable to save data');
        }

        $returnArr = $userObj->jsonResponse();
        return returnSuccessResponse('Password updated successfully', $returnArr);
    }
}
