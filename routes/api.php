<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::prefix('v1')->namespace('Api')->group(function () {
   

//     // Authentication Routes
//     Route::prefix('user')->name('user.')->group(function () {
//         // User Register Route
//         Route::post('/register', 'AuthController@register')->name('register');
//         Route::post('/resendOtp', 'AuthController@resendOtp')->name('resendOtp');
//         Route::post('/verifyOtp', 'AuthController@verifyOtp')->name('verifyOtp');

       


//         // User Login Route
//         Route::post('/login', 'AuthController@login')->name('login');
// 		Route::post('/resendOtp', 'AuthController@resendOtp')->name('resendOtp');
// 		 Route::post('/forgotPassword', 'AuthController@forgotPassword')->name('forgotPassword');
// 		Route::post('/resetPassword', 'AuthController@resetPassword')->name('resetPassword');
// 	    Route::get('/getPage', 'HomeController@getPage')->name('getPage');

		
// 		Route::middleware(['auth:sanctum'])->group(function () {
			
// 			Route::get('/logout', 'AuthController@logout')->name('logout');
// 			Route::post('/changePassword', 'AccountController@changePassword')->name('changePassword');
// 			Route::get('/profile', 'AccountController@getProfile')->name('profile');
// 			Route::post('/updateProfile', 'AccountController@updateProfile')->name('updateProfile');
// 			Route::get('/notification', 'AccountController@notification')->name('notification');
// 			Route::post('/contactUs', 'HomeController@contactUs')->name('contactUs');
// 			Route::post('/chapterListing', 'ChapterController@chapterListing')->name('chapterListing');
// 			Route::post('/searchChapter', 'ChapterController@searchChapter')->name('searchChapter');

// 		    Route::post('/lessonListing', 'LessonController@lessonListing')->name('lessonListing');
// 		    Route::post('/lessonStatus', 'LessonController@lessonStatus')->name('lessonStatus');
// 		    Route::post('/lessonContent', 'LessonController@lessonContent')->name('lessonContent');
		    

// 		    Route::post('/studyQuestion', 'StudyQuestionController@studyQuestionListing')->name('studyQuestion');
// 		    Route::post('/quizQuestion', 'QuizQuestionController@quizQuestionListing')->name('quizQuestion');
// 		    Route::post('/submitResult', 'QuizQuestionController@submitResult')->name('submitResult');
// 		    Route::post('/fullPractice', 'QuizQuestionController@fullPractice')->name('fullPractice');
// 		    Route::post('/proficiency', 'QuizQuestionController@proficiency')->name('proficiency');


// 		    Route::post('/addResult', 'QuizResultController@addResult')->name('addResult');

// 		    Route::get('/reportCategoryList', 'ReportController@reportCategoryList')->name('reportCategoryList');
// 		    Route::post('/reportQuestion', 'ReportController@reportQuestion')->name('reportQuestion');

// 		    Route::post('/subscription', 'TransactionController@subscription')->name('subscription');
// 		    Route::post('/subscriptionHistory', 'TransactionController@subscriptionHistory')->name('subscriptionHistory');
		
// 		});
//     });


// });