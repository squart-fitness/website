<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('index');
Route::post('/contact', 'HomeController@contactStore')->name('save_contact');

Route::get('/research', 'DashBoardController@research');

Route::prefix('dashboard')->middleware(['can:emp-permission,"dashboard"'])->group(function(){
	Route::get('/', 'DashBoardController@index')->name('dashboard');
	Route::get('/attendance/report', 'DashBoardController@showTodayAttendanceReport')->name('today_attendance_report');
	Route::get('/employee/report', 'DashBoardController@showActiveEmployees')->name('active_employee');
	Route::get('/test', 'DashBoardController@test');

});

Route::prefix('enquiry')->group(function(){
	Route::middleware(['can:emp-permission,"enquiry_add"'])->group(function(){
		Route::get('/', 'EnquiryController@showEnquiryForm')->name('add_enquiry');
		Route::post('/', 'EnquiryController@saveEnquiry');
	});

	Route::middleware(['can:emp-permission,"enquiry_detail"'])->group(function(){
		Route::get('/detail', 'EnquiryController@showEnquiries')->name('showall_enquiry');
		Route::get('/month/detail', 'EnquiryController@showEnquiryInMonth')->name('month_enquiry_details');
		Route::get('/filter', 'EnquiryController@filterEnquiry')->name('filter_enquiry');
	});
	
	Route::get('/change/status', 'EnquiryController@setStatus')
			->middleware(['can:emp-permission,"enquiry_status"'])
			->name('change_enquiry_status');

	Route::post('/delete', 'EnquiryController@delete')
			->middleware(['can:emp-permission,"enquiry_delete"'])
			->name('delete_enquiry');

	Route::middleware(['can:emp-permission,"enquiry_update"'])->group(function(){
		Route::get('/update', 'EnquiryController@showUpdateForm')->name('update_enquiry');
		Route::post('/update', 'EnquiryController@updateEnquiry');
	});

	Route::get('/move', 'EnquiryController@moveEnquiry')
			->middleware(['can:emp-permission,"enquiry_move"'])
			->name('move_enquiry');

	Route::get('/profile/{eid?}', 'EnquiryController@enquiryProfile')
			->middleware(['can:emp-permission,"enquiry_profile"'])
			->where('eid', '[\d\-]+')
			->name('enquiry_profile');

});

Route::prefix('gym')->group(function(){
	Route::get('/add', 'GymController@showAddingForm')->name('add_gym');
	Route::post('/add', 'GymController@saveGym');

	Route::get('/update', 'GymController@showUpdateForm')->name('update_gym');
	Route::post('/update', 'GymController@updateGym');

	Route::get('/update/profile', 'GymController@showProfileUpdateForm')->name('update_profile');
	Route::post('/update/profile', 'GymController@updateProfile');

	Route::post('/update/password', 'GymController@updateUserPassword')->name('update_password');

	Route::post('/feedback', 'GymController@storeFeedback')->name('feedback');

});

Route::prefix('customer')->group(function(){
	Route::middleware(['can:emp-permission,"member_add"'])->group(function(){
		Route::get('/add', 'CustomerController@showAddForm')->name('add_customer');
		Route::post('/add', 'CustomerController@addCustomer');
		Route::get('/package/fee', 'CustomerController@getPackageFee')->name('package_fee');
	});

	Route::middleware(['can:emp-permission,"member_detail"'])->group(function(){
		Route::get('/list', 'CustomerController@showCustomerList')->name('customer_list');
	});

	Route::get('/change/status', 'CustomerController@setStatus')
		->middleware(['can:emp-permission,"member_status"'])
		->name('change_customer_status');
	
	Route::post('/delete', 'CustomerController@delete')
		->middleware(['member_delete'])
		->name('delete_customer');
	
	Route::middleware(['can:emp-permission,"member_update"'])->group(function(){
		Route::get('/update', 'CustomerController@showUpdateForm')->name('update_customer');
		Route::post('/update', 'CustomerController@updateCustomer');
	});


	Route::middleware(['can:emp-permission,"member_attendance_add"'])->group(function(){
		Route::get('/attendance', 'AttendanceController@showAttendanceForm')->name('customer_attendance');
		Route::post('/attendance', 'AttendanceController@setAttendance');
		Route::get('/attendance/names', 'AttendanceController@showNames')->name('list_names');
	});

	// Route::get('/attendance/month', 'AttendanceController@showCustomerAttendanceInMonth')->name('month_attendance_details');
	// Route::get('/attendance/id', 'AttendanceController@showSingleCustomerAttendance')->name('one_customer_attendance');
	Route::get('/attendance/date', 'AttendanceController@showAttendanceByDate')
		->middleware(['can:emp-permission,"member_attendance_view"'])
		->name('attendance_data');

	Route::get('/profile/{d}/{username}/', 'CustomerProfileController@showProfile')
		->middleware(['can:emp-permission,"member_profile"'])
		->name('customer_profile')
		->where(['d' => '[0-9]+', 'username' => '[a-zA-Z0-9]+']);


	Route::prefix('payment')->group(function(){
		Route::middleware(['can:emp-permission,"member_payment_add"'])->group(function(){
			Route::get('/', 'PaymentController@showCustomerPaymentForm')->name('customer_payment');
			Route::post('/', 'PaymentController@savePayment');

			Route::get('/customer-data', 'PaymentController@showCustomerNameAndNumber')->name('customer_data');
			Route::get('/username-list', 'PaymentController@showUsernames')->name('list_username');
		});

		Route::middleware(['can:emp-permission,"member_payment_detail"'])->group(function(){
			Route::get('/payment-details', 'PaymentController@showCustomerPaymentDetail')->name('customer_payment_details');
			Route::get('/payment-month', 'PaymentController@showCustomerPaymentInMonth')->name('month_payment_details');
			Route::get('/payment/filter/date', 'PaymentController@showPaymentByDate')->name('filter_payment_by_date');
			Route::get('/payment/filter/expiring', 'PaymentController@showPaymentByExpiringDays')->name('filter_payment_by_expiring_days');
			Route::get('/generate/invoice', 'PaymentController@generateInvoice')->name('generate_invoice');
		});

	});
});


Route::prefix('employee')->group(function(){

	Route::middleware(['can:emp-permission,"staff_add"'])->group(function(){	
		Route::get('/add', 'Employee\EmployeeController@showAddingForm')->name('add_employee');
		Route::post('/add', 'Employee\EmployeeController@saveEmployee');
	});

	Route::middleware(['can:emp-permission,"staff_detail"'])->group(function(){	
		Route::get('/list', 'Employee\EmployeeController@showEmployeeList')->name('employee_list');
	});

	Route::get('/change/status', 'Employee\EmployeeController@setStatus')
		->middleware(['can:emp-permission,"staff_status"'])
		->name('change_employee_status');

	Route::post('/delete', 'Employee\EmployeeController@delete')
		->middleware([])
		->name('delete_employee');

	Route::middleware(['can:emp-permission,"staff_update"'])->group(function(){	
		Route::get('/update', 'Employee\EmployeeController@showUpdateForm')->name('update_employee');
		Route::post('/update', 'Employee\EmployeeController@updateEmployee');
	});


	Route::middleware(['can:emp-permission,"staff_salary_add"'])->group(function(){	
		Route::get('/salary', 'Employee\EmployeeController@showSalaryForm')->name('employee_salary');
		Route::post('/salary', 'Employee\EmployeeController@saveSalary');
		Route::get('/data', 'Employee\EmployeeController@showEmployeeNameAndNumber')->name('employee_data');
		Route::get('/username/list', 'Employee\EmployeeController@showUsernames')->name('list_employee_username');
	});

	Route::middleware(['can:emp-permission,"staff_salary_detail"'])->group(function(){	
		Route::get('/salary/details', 'Employee\EmployeeController@showSalaryDetail')->name('employee_salary_details');
		Route::get('/salary/details/month', 'Employee\EmployeeController@showEmployeeSalaryInMonth')->name('employee_salary_monthly');
		Route::get('/salary/filter/date', 'Employee\EmployeeController@showEmployeeByDate')->name('filter_salary_by_date');
	});
});

Route::prefix('create')->group(function(){
	Route::middleware(['can:emp-permission,"dietplan_formatting"'])->group(function(){	
		Route::get('/diet-plan', 'DietPlanController@showDietForm')->name('create_diet_plan');
		Route::post('/diet-plan', 'DietPlanController@saveDiet');
		Route::post('/diet/delete', 'DietPlanController@delete')->name('delete_diet');
		Route::get('/diet/update', 'DietPlanController@showDietUpdateFrom')->name('update_diet');
		Route::post('/diet/update', 'DietPlanController@updateDietPlan');
	});

	//workout plan creation routes
	Route::middleware(['can:emp-permission,"workoutplan_formatting"'])->group(function(){	
		Route::get('/workout-plan', 'WorkoutController@showWorkoutForm')->name('create_workout_plan');
		Route::post('/workout-plan', 'WorkoutController@saveWorkout');
		Route::post('/workout/delete', 'WorkoutController@delete')->name('delete_workout');
		Route::get('/workout/update', 'WorkoutController@showWorkoutUpdateForm')->name('update_workout');
		Route::post('/workout/update', 'WorkoutController@updateWorkoutPlan');
	});

	//package creation routes
	Route::middleware(['can:emp-permission,"package_formatting"'])->group(function(){	
		Route::get('/package', 'PackageController@showPackageAddingForm')->name('create_package');
		Route::post('/package', 'PackageController@addPackage');
		Route::get('/package/change/status', 'PackageController@setStatus')->name('change_package_status');
		Route::post('/package/delete', 'PackageController@delete')->name('delete_package');
	});

	//batch creation routes
	Route::middleware(['can:emp-permission,"batch_formatting"'])->group(function(){	
		Route::get('/batch', 'BatchController@index')->name('batch');
		Route::post('/batch', 'BatchController@save');
		Route::get('/batch/change/status', 'BatchController@setStatus')->name('change_batch_status');
		Route::post('/batch/delete', 'BatchController@delete')->name('delete_batch');
	});
});

Route::prefix('assign')->group(function(){
	//diet plan assignment show form and post 
	Route::middleware(['can:emp-permission,"dietplan_assignment"'])->group(function(){	
		Route::get('/diet', 'DietPlanController@showAssignDietForm')->name('assign_diet');
		Route::post('/diet', 'DietPlanController@assignDiet');
	});

	//diet plan show assigned routes 
	Route::middleware(['can:emp-permission,"dietplan_assigned"'])->group(function(){	
		Route::get('/diet/show', 'DietPlanController@showAssignedDiet')->name('show_assigned_diet');
		Route::get('/diet/member', 'DietPlanController@getMemberDiet')->name('get_member_diet');
		Route::get('/diet/remove', 'DietPlanController@removeDiet')->name('remove_diet');
	});

	//workout plan assignment show form and routes
	Route::middleware(['can:emp-permission,"workoutplan_assignment"'])->group(function(){	
		Route::get('/workout', 'WorkoutController@showAssignWorkoutForm')->name("assign_workout");
		Route::post('/workout', 'WorkoutController@assignWorkout');
	});

	//workout plan show assigned routes
	Route::middleware(['can:emp-permission,"workoutplan_assigned"'])->group(function(){	
		Route::get('/workout/show', 'WorkoutController@showAssignedWorkout')->name('show_assigned_workout');
		Route::get('/workout/member', 'WorkoutController@getMemberWorkout')->name('get_member_workout');
		Route::get('/workout/remove', 'WorkoutController@removeWorkout')->name('remove_workout');
	});


	//batch change routes
	Route::middleware(['can:emp-permission,"batch_assignment'])->group(function(){
		Route::get('/batch/show', 'BatchController@showAssignBatchForm')->name('assign_batch');
		Route::post('/batch/show', 'BatchController@changeBatch');
		Route::get('/batch/customer', 'BatchController@getCustomerBatch')->name('get_customer_batch');
	});

	//packages change routes
	Route::middleware(['can:emp-permission,"package_assignment'])->group(function(){
		Route::get('/package/show', 'PackageController@showAssignPackageForm')->name('assign_package');
		Route::post('/package/show', 'PackageController@changePackage');
		Route::get('/package/customer', 'PackageController@getCustomerPackage')->name('get_customer_package');
	});
});

Route::prefix('setting')->group(function(){
	//staff permissions setting route
	Route::get('/', 'SettingController@showSettingPage')->name('setting_page');
});

Route::prefix('post')->group(function(){
	Route::get('/create', function(){
		return view('post.create_post');
	})->name('make_post');

	Route::get('/view', function(){
		return view('post.view_post');
	})->name('view_post');
});

Route::prefix('listing')->group(function(){
	Route::get('/', function(){
		return view('listing.listing');
	})->name('create_listing');

	Route::get('/offer', function(){
		return view('listing.offer');
	})->name('listing_offer');

	Route::get('/machine-types', function(){
		return view('listing.machine_types');
	})->name('listing_machine_types');
});


Route::prefix('report')->group(function(){
	Route::get('/enquiry', 'ReportController@enquiryConvergence')->name('enquiry_convergence_report');
});




Auth::routes();

Route::prefix('auth/super/admin')->group(function(){
	Route::get('/register', 'SuperAdmin\RegisterController@showRegistrationForm')->name('super_admin_register');
	Route::post('/register', 'SuperAdmin\RegisterController@register');

});


Route::get('/home', function(){
	var_dump(public_path());
});

Route::get('error/deactivated', 'ErrorController@gymDeactivated')->name('deactivated')->middleware('auth');

Route::get('qrcode', 'QrCodeController@show')->name('show_qrcode');
Route::get('qrcode-data', 'QrCodeController@output')->name('get_qrs');
// Route::get('testqr', 'QrCodeController@createQrCode');


// employee login test
Route::get('emp-login', 'Employee\EmployeeController@showLoginEmployee')->name('emp_login');
Route::post('emp-login', 'Employee\EmployeeController@loginEmployee');


// Route::get('features', function(){
// 	$fet = new App\Models\ApplicationFeature;
// 	$arr = array(
// 				array('features' => 'enquiry_add', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'enquiry_detail', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'enquiry_status', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'enquiry_delete', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'enquiry_update', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'enquiry_move', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'enquiry_profile', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'member_add', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'member_detail', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'member_status', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'member_delete', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'member_update', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'member_attendance_add', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'member_attendance_view', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'member_profile', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'member_payment_add', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'member_payment_detail', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'staff_add', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'staff_detail', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'staff_status', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'staff_update', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'staff_salary_add', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'staff_salary_detail', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'dietplan_formatting', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'workoutplan_formatting', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'package_formatting', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'batch_formatting', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'dietplan_assignment', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'dietplan_assigned', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'workoutplan_assignment', 'created_at' => now(), 'updated_at' => now()), 
// 				array('features' => 'workoutplan_assigned', 'created_at' => now(), 'updated_at' => now()), 
// 			);

// 	return $fet->insert($arr);
// });
