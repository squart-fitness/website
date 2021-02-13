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

Route::prefix('mobile')->group(function(){
	Route::get('/', function(){
		return view('testapi');
	});

	// login to application
	Route::post('/member/login', 'CustomerMobileAPI\APIController@login')->name('member_login');
	
	//get gym information
	Route::get('/member/gym/{gym_id}/{customer_id}', 'CustomerMobileAPI\APIController@memberJoinedGym')
			->where(['gym_id' => '[0-9]+', 'customer_id' => '[0-9]+'])
			->name('member_joined_gym');

	//get attendance information
	Route::get('/member/attendance/show/{gym_id}/{customer_id}', 'CustomerMobileAPI\APIController@getAttendance')
			->where(['gym_id' => '[0-9]+', 'customer_id' => '[0-9]+'])
			->name('member_attendance');

	//create attendance for a gym member
	Route::post('/member/attendance/{gym_username}/{customer_id}', 'CustomerMobileAPI\APIController@createAttendance')
			->where(['gym_username' => '[a-zA-Z0-9]+', 'customer_id' => '[0-9]+']);

	//get payment details of a member
	Route::get('/member/payment/{gym_id}/{customer_id}', 'CustomerMobileAPI\APIController@getPayment')
			->where(['gym_id' => '[0-9]+', 'customer_id' => '[0-9]+'])
			->name('member_payment');

	//deactivate member account from  gym 
	Route::Post('/member/changestatus/{gym_id}/{customer_id}', 'CustomerMobileAPI\APIController@changeCustomerStatus')
			->where(['gym_id' => '[0-9]+', 'customer_id' => '[0-9]+'])
			->name('member_status');

	Route::post('/member/update/{gym_id}/{customer_id}', 'CustomerMobileAPI\APIController@updateInformation')
			->where(['gym_id' => '[0-9]+', 'customer_id' => '[0-9]+'])
			->name('member_update');

	Route::get('/member/show/diet/{gym_id}/{customer_id}', 'CustomerMobileAPI\APIController@showCustomerDiet')
			->where(['gym_id' => '[0-9]+', 'customer_id' => '[0-9]+'])
			->name('show_member_diet');

	Route::post('/member/social/link/{gym_id}/{customer_id}', 'CustomerMobileAPI\APIController@saveSocialLink')
			->where(['gym_id' => '[0-9]+', 'customer_id' => '[0-9]+'])
			->name('save_social_link');

	// update customer image
	Route::post('/member/update/image/{gym_id}/{customer_id}', 'CustomerMobileAPI\APIController@customerImageUpdate')
			->where(['gym_id' => '[0-9]+', 'customer_id' => '[0-9]+'])
			->name('update_customer_image');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
