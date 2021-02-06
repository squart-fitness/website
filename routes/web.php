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

Route::prefix('dashboard')->group(function(){
	Route::get('/', 'DashBoardController@index')->name('dashboard');
	Route::get('/attendance/report', 'DashBoardController@showTodayAttendanceReport')->name('today_attendance_report');
	Route::get('/employee/report', 'DashBoardController@showActiveEmployees')->name('active_employee');

});

Route::prefix('enquiry')->group(function(){
	Route::get('/', 'EnquiryController@showEnquiryForm')->name('add_enquiry');
	Route::post('/', 'EnquiryController@saveEnquiry');

	Route::get('/detail', 'EnquiryController@showEnquiries')->name('showall_enquiry');
	Route::get('/month/detail', 'EnquiryController@showEnquiryInMonth')->name('month_enquiry_details');
	Route::get('/filter', 'EnquiryController@filterEnquiry')->name('filter_enquiry');
	Route::get('/change/status', 'EnquiryController@setStatus')->name('change_enquiry_status');
	Route::post('/delete', 'EnquiryController@delete')->name('delete_enquiry');
	Route::get('/update', 'EnquiryController@showUpdateForm')->name('update_enquiry');
	Route::post('/update', 'EnquiryController@updateEnquiry');

	Route::get('/move', 'EnquiryController@moveEnquiry')->name('move_enquiry');

	Route::get('/profile/{eid?}', 'EnquiryController@enquiryProfile')
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
	Route::get('/add', 'CustomerController@showAddForm')->name('add_customer');
	Route::post('/add', 'CustomerController@addCustomer');
	Route::get('/package/fee', 'CustomerController@getPackageFee')->name('package_fee');


	Route::get('/list', 'CustomerController@showCustomerList')->name('customer_list');
	Route::get('/change/status', 'CustomerController@setStatus')->name('change_customer_status');
	Route::post('/delete', 'CustomerController@delete')->name('delete_customer');
	Route::get('/update', 'CustomerController@showUpdateForm')->name('update_customer');
	Route::post('/update', 'CustomerController@updateCustomer');


	Route::get('/attendance', 'AttendanceController@showAttendanceForm')->name('customer_attendance');
	Route::post('/attendance', 'AttendanceController@setAttendance');

	Route::get('/attendance/names', 'AttendanceController@showNames')->name('list_names');
	// Route::get('/attendance/month', 'AttendanceController@showCustomerAttendanceInMonth')->name('month_attendance_details');
	// Route::get('/attendance/id', 'AttendanceController@showSingleCustomerAttendance')->name('one_customer_attendance');
	Route::get('/attendance/date', 'AttendanceController@showAttendanceByDate')->name('attendance_data');

	Route::get('/profile/{d}/{username}/', 'CustomerProfileController@showProfile')
		->name('customer_profile')
		->where(['d' => '[0-9]+', 'username' => '[a-zA-Z0-9]+']);


	Route::prefix('payment')->group(function(){
		Route::get('/', 'PaymentController@showCustomerPaymentForm')->name('customer_payment');
		Route::post('/', 'PaymentController@savePayment');

		Route::get('/customer-data', 'PaymentController@showCustomerNameAndNumber')->name('customer_data');
		Route::get('/username-list', 'PaymentController@showUsernames')->name('list_username');

		Route::get('/payment-details', 'PaymentController@showCustomerPaymentDetail')->name('customer_payment_details');
		Route::get('/payment-month', 'PaymentController@showCustomerPaymentInMonth')->name('month_payment_details');
		Route::get('/payment/filter/date', 'PaymentController@showPaymentByDate')->name('filter_payment_by_date');
		Route::get('/payment/filter/expiring', 'PaymentController@showPaymentByExpiringDays')->name('filter_payment_by_expiring_days');
		Route::get('/research', 'PaymentController@research');

	});
});


Route::prefix('employee')->group(function(){
	Route::get('/add', 'Employee\EmployeeController@showAddingForm')->name('add_employee');
	Route::post('/add', 'Employee\EmployeeController@saveEmployee');

	Route::get('/list', 'Employee\EmployeeController@showEmployeeList')->name('employee_list');
	Route::get('/change/status', 'Employee\EmployeeController@setStatus')->name('change_employee_status');
	Route::post('/delete', 'Employee\EmployeeController@delete')->name('delete_employee');
	Route::get('/update', 'Employee\EmployeeController@showUpdateForm')->name('update_employee');
	Route::post('/update', 'Employee\EmployeeController@updateEmployee');


	Route::get('/salary', 'Employee\EmployeeController@showSalaryForm')->name('employee_salary');
	Route::post('/salary', 'Employee\EmployeeController@saveSalary');
	Route::get('/data', 'Employee\EmployeeController@showEmployeeNameAndNumber')->name('employee_data');
	Route::get('/username/list', 'Employee\EmployeeController@showUsernames')->name('list_employee_username');

	Route::get('/salary/details', 'Employee\EmployeeController@showSalaryDetail')->name('employee_salary_details');
	Route::get('/salary/details/month', 'Employee\EmployeeController@showEmployeeSalaryInMonth')->name('employee_salary_monthly');
	Route::get('/salary/filter/date', 'Employee\EmployeeController@showEmployeeByDate')->name('filter_salary_by_date');
});

Route::prefix('create')->group(function(){
	Route::get('/diet-plan', 'DietPlanController@showDietForm')->name('create_diet_plan');
	Route::post('/diet-plan', 'DietPlanController@saveDiet');
	Route::post('/diet/delete', 'DietPlanController@delete')->name('delete_diet');


	Route::get('/workout-plan', function(){
		return view('create.workout_plan');
	})->name('create_workout_plan');

	Route::get('/package', 'PackageController@showPackageAddingForm')->name('create_package');
	Route::post('/package', 'PackageController@addPackage');
	Route::get('/package/change/status', 'PackageController@setStatus')->name('change_package_status');
	Route::post('/package/delete', 'PackageController@delete')->name('delete_package');

	Route::get('/batch', 'BatchController@index')->name('batch');
	Route::post('/batch', 'BatchController@save');
	Route::get('/batch/change/status', 'BatchController@setStatus')->name('change_batch_status');
	Route::post('/batch/delete', 'BatchController@delete')->name('delete_batch');
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
	return view('home');
});

Route::get('error/deactivated', 'ErrorController@gymDeactivated')->name('deactivated')->middleware('auth');

Route::get('qrcode', 'QrCodeController@show')->name('show_qrcode');
Route::get('qrcode-data', 'QrCodeController@output')->name('get_qrs');
// Route::get('testqr', 'QrCodeController@createQrCode');


// employee login test
Route::get('emp-login', 'Employee\EmployeeController@showLoginEmployee')->name('emp_login');
Route::post('emp-login', 'Employee\EmployeeController@loginEmployee');
