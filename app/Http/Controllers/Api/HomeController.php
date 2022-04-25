<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\ContactUs;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;

class HomeController extends Controller
{
    public function getPage(Request $request){

       $page_type = $request->page_type;

       if(empty($page_type))
          return returnErrorResponse('Please send page type.');

      $page = Page::where('page_type',$page_type)->first();

   return returnSuccessResponse('Data sent successfully',$page);

}

public function contactUs(Request $request,ContactUs $contactUs){

	$rules = [
            'full_name' => 'required',
            'email' => 'required',
            'category' => 'required|integer|min:1|max:3',
            'description' => 'required'

        ];
         $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $contactUs = $contactUs->fill($request->all());
        if($contactUs->save())
        	return returnSuccessResponse('Message sent successfully',$contactUs);

        return returnErrorResponse("Something went wrong.");

}
}
