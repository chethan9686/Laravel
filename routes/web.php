<?php

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

Route::get('/', function () {return view('welcome');});

Auth::routes();
//To Verify the the User Through Confirmation Mail
Route::get('register/{confirmationCode}','Auth\RegisterController@verifyRegister');


////////////////////////////////////////// HomeController ////////////////////////////////////////////////////////////////
//Home Admin or Employee Option Page
Route::get('/home', 'HomeController@index')->name('home');

////////////////////////////////////////// Admin /////////////////////////////////////////////////////////////////////////

Route::prefix('admin')->group(function() {
   Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
   Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
   Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

////////////////////////////////////////// AdminController ////////////////////////////////////////////////////////////////
   //Admin Dashboard
   Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
   //Admin Profile
   Route::get('/profile', 'AdminController@profile')->name('admin.profile');
   //Admin Update Name and Profile Pic
   Route::post('/update-profile-pic', 'AdminController@updateprofilepicture')->name('admin.update_profile_pic');
   //Admin Reset Password
   Route::post('/update-password', 'AdminController@update_password')->name('admin.update_password'); 
   //Admin Notice
   Route::get('/notice', 'AdminController@notice')->name('admin.notice');
   //Admin Add Notice
   Route::post('/add-notice', 'AdminController@addnotice')->name('admin.add_notice');
   //Admin Edit Notice
   Route::post('/edit-notice', 'AdminController@editnotice')->name('admin.edit_notice');
   //Admin Delete Notice
   Route::post('/delete-notice', 'AdminController@deletenotice')->name('admin.delete_notice');
   //Admin View Notice
   Route::get('/view-notice/{EncryptedID}','AdminController@viewnotice')->name('admin.view_notice');
   //Admin Appreciation
   Route::get('/appreciation','AdminController@indexappriciation')->name('admin.appreciation');
   //Admin Submit Appreciation Form
   Route::post('/appriciation-form','AdminController@appriciationform')->name('admin.appriciation_form');
   //Admin View Appreciation Mail 
   Route::get('/view-appriciation/{EncryptedId}','AdminController@viewappriciation')->name('admin.view_appriciation');
   //Admin Edit Appreciation Mail
   Route::post('update-appriciation', 'AdminController@updateappriciation')->name('admin.update_appriciation');
   //Admin Delete Appreciation Mail
   Route::post('appreciation-delete', 'AdminController@appreciation_delete')->name('admin.appreciation_delete'); 
   //Admin Holiday List
   Route::get('/holiday', 'AdminController@holidaysfile')->name('admin.holiday');
   //Admin Upload Holiday List
   Route::post('import-Holiday-File', 'AdminController@importfile')->name('import_Holiday_File');
   //Admin HR Policy List
   Route::get('/hr-policy', 'AdminController@hrpolicies')->name('admin.hr_policy');
   //Company Policy(ACCEPTABLE USAGE POLICY - AUP)
   Route::get('/aup', 'AdminController@aup')->name('admin.aup');


   ////////////////////////////////////// AdminWishesController ////////////////////////////////////////////////////////////

   //Admin Submit Wishes Form
   Route::post('/appriciation-wish', 'AdminWishesController@appriciationwish')->name('admin.appriciation_wish');

   ////////////////////////////////////// AdminUserController ////////////////////////////////////////////////////////////
   //Admin Employee Activation
   Route::get('/employee-activation', 'AdminUserController@useractivation')->name('admin.user_activation');
   //Admin Send Activation Link
   Route::post('/emp-activate', 'AdminUserController@sendEmpActivation')->name('admin.send_activate_link');
   //Admin Employee List
   Route::get('/employee-list', 'AdminUserController@employeelist')->name('admin.employeelist');
   //Admin Ajax Call For Updating Block and Active Status
   Route::post('/block-user', 'AdminUserController@blockUser')->name('admin.block_user');
   //Admin Ajax Call For Updating Confirm User
   Route::post('/confirm-user', 'AdminUserController@confirmUser')->name('admin.confirm_user');
   //Admin Newly Joined Employee List
   Route::get('/new-employee-list', 'AdminUserController@newemployeelist')->name('admin.new_employee_list');
   //Admin Resigned Employee List
   Route::get('/resigned-employees', 'AdminUserController@resignedemployeelist')->name('admin.resigned_employee_list');
   //Admin Submit/Add Resigned Employee List
   Route::post('/add-resigned-employees', 'AdminUserController@addresignedemployee')->name('admin.add_resigned_emp');

   ////////////////////////////////////// AdminUserProfileController /////////////////////////////////////////////////////////

   //Admin To View User Profile
   Route::get('/user-profile/{EncryptedUserID}','AdminUserProfileController@showUserProfile')->name('admin.user-view');
   //Admin Update User Basic Details
   Route::post('/admin-update-basic', 'AdminUserProfileController@update_basic_details')->name('admin.update_basic_details');
   //Admin Update User Passport Details
   Route::post('/admin-update-passport','AdminUserProfileController@update_passport_details')->name('admin.update_passport_details');
   //Admin Update User Bank Account Details
   Route::post('/admin-update-bank-account','AdminUserProfileController@update_bank_details')->name('admin.update_bank_details');
   //Admin Update User PF Form Details
   Route::post('/admin-update-pf-form','AdminUserProfileController@update_pf_form')->name('admin.update_pf_form');
   //Admin Ajax Call For Academics Data
   Route::get('/admin-academics-data', 'AdminUserProfileController@academics_data');
   Route::post('/admin-add-academic-data', 'AdminUserProfileController@add_academic_data')->name('admin.add_academic_data');
   Route::post('/admin-update-academic-data', 'AdminUserProfileController@update_academic_data')->name('admin.update_academic_data');
   Route::post('/admin-delete-academic-data', 'AdminUserProfileController@delete_academic_data')->name('admin.delete_academic_data');
   //Admin Ajax Call For Employment Data
   Route::get('/admin-employment-data', 'AdminUserProfileController@employment_data');
   Route::post('/admin-add-employment-data', 'AdminUserProfileController@add_employment_data')->name('admin.add_employment_data');
   Route::post('/admin-update-employment-data', 'AdminUserProfileController@update_employment_data')->name('admin.update_employment_data');
   Route::post('/admin-delete-employment-data', 'AdminUserProfileController@delete_employment_data')->name('admin.delete_employment_data');
   //Admin Ajax Call For Family Background Data
   Route::get('/admin-family-data', 'AdminUserProfileController@family_data');
   Route::post('/admin-add-family-data', 'AdminUserProfileController@add_family_data')->name('admin.add_family_data');
   Route::post('/admin-update-family-data', 'AdminUserProfileController@update_family_data')->name('admin.update_family_data');
   Route::post('/admin-delete-family-data', 'AdminUserProfileController@delete_family_data')->name('admin.delete_family_data');
   //Admin Upload User Personal Documents
   Route::post('/admin-upload-personal-document', 'AdminUserProfileController@upload_personal_documents')->name('admin.upload_personal_documents');
   //Admin Upload User Academic Documents
   Route::post('/admin-upload-academic-document', 'AdminUserProfileController@upload_academic_documents')->name('admin.upload_academic_documents');
   //Admin Upload User Personal Documents
   Route::post('/admin-career-objective', 'AdminUserProfileController@career_objective')->name('admin.career_objective');
   //Admin Upload User Personal Documents
   Route::post('/admin-user-other-activity', 'AdminUserProfileController@user_other_activity')->name('admin.user_other_activity');
   //Admin Upload User Personal Documents
   Route::post('/admin-user-references', 'AdminUserProfileController@user_references')->name('admin.user_references');
   //Admin Download User Documents
   Route::get('/admin-document/{EncryptedId}/{EncryptedProof}', 'AdminUserProfileController@document_download')->name('admin.download');

   ////////////////////////////////////AdminUserMeetingController/////////////////////////////////////////////////////

    //Admin View Meeting 
   Route::get('/admin-meeting-list', 'AdminUserMeetingController@usermeeting')->name('admin.meeting');  
   // Ajax Call For Admin View Meeting Completed
   Route::post('/admin-view-completed', 'AdminUserMeetingController@viewcompleted')->name('admin.view_completed');
    //Admin Networking Meeting List
   Route::get('/admin-networking-meeting-list', 'AdminUserMeetingController@usernetworkingmeeting')->name('admin.networking_meeting');  


   ////////////////////////////////////AdminFollowUpMeetingController/////////////////////////////////////////////////////

   //Admin View Follow up Meeting 
   Route::get('/admin-followup-meeting-list', 'AdminFollowUpMeetingController@followupmeeting')->name('admin.followup_meeting'); 

   ////////////////////////////////////// AdminDepartment ////////////////////////////////////////////////////////////
   //Admin Department List
   Route::get('/department-list', 'AdminDepartment@departmentlist')->name('admin.department');
   //Admin Add Department
   Route::post('/add-department', 'AdminDepartment@addDepartment')->name('admin.add_department');
   //Admin Edit Department
   Route::post('/edit-department', 'AdminDepartment@editDepartment')->name('admin.edit_department');
   //Admin Delete Department
   Route::post('/delete-department', 'AdminDepartment@deleteDepartment')->name('admin.delete_department');

   ////////////////////////////////////AdminLateworkingController/////////////////////////////////////////////////////

    //Admin Late Working Employee List
   Route::get('/lateworking', 'AdminLateworkingController@lateworking')->name('admin.lateworking');   


   ///////////////////////////////////////////AdminOutOfStation////////////////////////////////////////////////////

   //User Out Of Station
   Route::get('/admin-out-of-station', 'AdminOutOfStation@outofstation')->name('admin.out_of_station');
   //User Update Out Of Station
   Route::post('/admin-update-out-of-station','AdminOutOfStation@update_outofstation')->name('admin.update_out_of_station');

   /////////////////////////////////////AdminVPmeetingController/////////////////////////////////////////////////

    //Admin Vendor Meeting Employee List
   Route::get('/vendormeeting', 'AdminVPmeetingController@vendormeeting')->name('admin.vendormeeting'); 
   //Admin Pre Events Meeting Employee List
   Route::get('/preeventmeeting', 'AdminVPmeetingController@preeventmeeting')->name('admin.preeventmeeting');    

   ///////////////////////////////////////////AdminEventsController//////////////////////////////////////////

   //Admin Recce Employee List
   Route::get('/recce', 'AdminEventsController@recce')->name('admin.recce');
   //Admin Event Setup Employee List
   Route::get('/eventsetup', 'AdminEventsController@eventsetup')->name('admin.eventsetup');
   //Admin Event Employee List
   Route::get('/event', 'AdminEventsController@event')->name('admin.event'); 

   ////////////////////////////////////AdminDeliveryDismantaleController//////////////////////////////////////
   
   //Admin Delivery Employee List
   Route::get('/delivery', 'AdminDeliveryDismantaleController@delivery')->name('admin.delivery');
   //Admin Dismantle Employee List
   Route::get('/dismantle', 'AdminDeliveryDismantaleController@dismantle')->name('admin.dismantle');   

   ///////////////////////////////////////AdminLeaveController///////////////////////////////////////////////

   //To Show User Leave List to Admin
   Route::get('leaves-list','AdminLeaveController@leavelist')->name('admin.leaves_list');

   Route::post('update-user-leave','AdminLeaveController@updateuserleave')->name('admin.update_user_leave');
   
   ///////////////////////////////////////AdminAttendenceController///////////////////////////////////////////////

   // To View Attendence List
   Route::get('bangalore-attendence-list','AdminAttendenceController@bangaloreattendencelist')->name('admin.bangalore_attendence_list');
   // To View Attendence List
   Route::get('mumbai-attendence-list','AdminAttendenceController@mumbaiattendencelist')->name('admin.mumbai_attendence_list');
   // To View Attendence List
   Route::get('delhi-attendence-list','AdminAttendenceController@delhiattendencelist')->name('admin.delhi_attendence_list');
   // To View Previous Bangalore Attendence List
   Route::get('previous-bangalore-attendence-list','AdminAttendenceController@previousbangaloreattendencelist')->name('admin.previous_bangalore_attendence_list');
   // To View Previous Mumbai Attendence List
   Route::get('previous-mumbai-attendence-list','AdminAttendenceController@previousmumbaiattendencelist')->name('admin.previous_mumbai_attendence_list');
   // To View Previous Delhi Attendence List
   Route::get('previous-delhi-attendence-list','AdminAttendenceController@previousdelhiattendencelist')->name('admin.previous_delhi_attendence_list');
   // To Download Bangalore Attendence Sheet
   Route::get('/admin-bangalore-download-attendence', 'AdminAttendenceController@bangalore_download_attendence')->name('admin.bangalore_download_excel');
   // To Download Delhi Attendence Sheet
   Route::get('/admin-delhi-download-attendence', 'AdminAttendenceController@delhi_download_attendence')->name('admin.delhi_download_excel');
   // To Download Mumbai Attendence Sheet
   Route::get('/admin-mumbai-download-attendence', 'AdminAttendenceController@mumbai_download_attendence')->name('admin.mumbai_download_excel');
   
   ////////////////////////////////////////AdminEventsBilling//////////////////////////////////////////////////
  
   //To View Event FE Amount Report
   Route::get('event-fe-amount','AdminEventsBilling@eventfe_report')->name('admin.eventfeamount');
   //To Submit Billing Report Form 
   Route::post('createbilling','AdminEventsBilling@createbilling')->name('admin.createbilling');
   //To Submit FE Amount Form 
   Route::post('create-fe-amount','AdminEventsBilling@createfeamount')->name('admin.createfeamount');
   //To Download FE Sheet
   Route::get('/admin-fe-sheet/sheet/{year}/{month}/', 'AdminEventsBilling@fe_download')->name('admin.fe_sheet');
   //To Submit FE Amount Status
   Route::post('create-fe-status','AdminEventsBilling@approvefe_sheet')->name('admin.approve_fesheet');
   //To Update Edit FE Amount Status
   Route::post('edit-fe-amount','AdminEventsBilling@editfeamount')->name('admin.editfeamount');
   
    ////////////////////////////////////AdminBusinessController///////////////////////////////////////////////////
    
    //To View Business List
   Route::get('view-business','AdminBusinessController@viewbusinesslist')->name('admin.view_business');
   // Ajax Call For Admin View Meeting Completed
   Route::post('/admin-view-signup', 'AdminBusinessController@viewsignup')->name('admin.view_signup');
   //User Download Documents
   Route::get('/admin-signup-document/{EncryptedId}/{EncryptedProof}', 'AdminBusinessController@signup_download')->name('admin.signup_download');
   //To Approve Signup 
   Route::post('admin-approve-signup','AdminBusinessController@approvesignup')->name('admin.approve_signup');
   //To Redo or Reject Signup
   Route::post('admin-reject-signup','AdminBusinessController@rejectsignup')->name('admin.reject_signup');
   //To Cancel Signup
   Route::post('admin-cancel-signup','AdminBusinessController@cancelsignup')->name('admin.cancel_signup');
   
   ///////////////////////////////////AdminBusinessBillingController///////////////////////////////////////////////////

    //To View Billing List
   Route::get('view-billing','AdminBusinessBillingController@viewbillinglist')->name('admin.view_billing');  
    // Ajax Call For Admin View Meeting Completed
   Route::post('/admin-view-billing', 'AdminBusinessBillingController@viewbilling')->name('admin.view_billing_list');
    //To Approve Billing
   Route::post('admin-approve-billing','AdminBusinessBillingController@approvebilling')->name('admin.approve_billing');
    //To Redo Billing
   Route::post('admin-reject-billing','AdminBusinessBillingController@rejectbilling')->name('admin.reject_billing');
   //To Cancel Signup
   Route::post('admin-cancel-billing','AdminBusinessBillingController@cancelbilling')->name('admin.cancel_billing');
    //To Download Billing Documents
   Route::get('/admin-billing-document/{EncryptedId}/{EncryptedProof}', 'AdminBusinessBillingController@billing_download')->name('admin.billing_download');

   ///////////////////////////////////AdminBusinessRevionController///////////////////////////////////////////////////

    ///To View Business Revision List
   Route::get('view-businessrevision','AdminBusinessRevionController@viewbusinessrevionlist')->name('admin.view-businessrevision');
   //To Approve Business Revision 
   Route::post('admin-businessrevision','AdminBusinessRevionController@businessrevionapproval')->name('admin.businessrevision');
   //To Redo or Reject Signup
   Route::post('admin-reject-businessrevision','AdminBusinessRevionController@businessrevionreject')->name('admin.reject_businessrevision');
   
}) ;


////////////////////////////////////////// End of Admin //////////////////////////////////////////////////////////////////


////////////////////////////////////////// User /////////////////////////////////////////////////////////////////////////


////////////////////////////////////////// UserController ////////////////////////////////////////////////////////////////

//User Dashboard
Route::get('/dashboard', 'UserController@dashboard')->name('dashboard');
//User Profile
Route::get('/profile', 'UserController@profile')->name('profile');
//Update User Basic Details
Route::post('/update-basic', 'UserController@update_basic_details')->name('update_basic_details');
//Update User Passport Details
Route::post('/update-passport','UserController@update_passport_details')->name('update_passport_details');
//Update User Bank Account Details
Route::post('/update-bank-account','UserController@update_bank_details')->name('update_bank_details');
//Update User PF Form Details
Route::post('/update-pf-form','UserController@update_pf_form')->name('update_pf_form');
//Ajax Call For Academics Data
Route::get('/academics-data', 'UserController@academics_data');
Route::post('/add-academic-data', 'UserController@add_academic_data')->name('add_academic_data');
Route::post('/update-academic-data', 'UserController@update_academic_data')->name('update_academic_data');
Route::post('/delete-academic-data', 'UserController@delete_academic_data')->name('delete_academic_data');
//Ajax Call For Employment Data
Route::get('/employment-data', 'UserController@employment_data');
Route::post('/add-employment-data', 'UserController@add_employment_data')->name('add_employment_data');
Route::post('/update-employment-data', 'UserController@update_employment_data')->name('update_employment_data');
Route::post('/delete-employment-data', 'UserController@delete_employment_data')->name('delete_employment_data');
//Ajax Call For Family Background Data
Route::get('/family-data', 'UserController@family_data');
Route::post('/add-family-data', 'UserController@add_family_data')->name('add_family_data');
Route::post('/update-family-data', 'UserController@update_family_data')->name('update_family_data');
Route::post('/delete-family-data', 'UserController@delete_family_data')->name('delete_family_data');
//User Upload Personal Documents
Route::post('/upload-personal-document', 'UserController@upload_personal_documents')->name('upload_personal_documents');
//User Upload Academic Documents
Route::post('/upload-academic-document', 'UserController@upload_academic_documents')->name('upload_academic_documents');
//User Upload Personal Documents
Route::post('/career-objective', 'UserController@career_objective')->name('career_objective');
//User Upload Personal Documents
Route::post('/user-other-activity', 'UserController@user_other_activity')->name('user_other_activity');
//User Upload Personal Documents
Route::post('/user-references', 'UserController@user_references')->name('user_references');
//User To View Official Document
Route::get('/official-document', 'UserController@official_document')->name('official_document');
//User Download Documents
Route::get('/document/{EncryptedId}/{EncryptedProof}', 'UserController@document_download')->name('download');


//////////////////////////////////////////////UserMeetingController//////////////////////////////////////////////////////

//To Show User Meeting Page
Route::get('meeting','UserMeetingController@meeting')->name('meeting');
//Ajax Call For fetching Existing Company List
Route::post('/companylist','UserMeetingController@companylist')->name('company_list');
//To Submit New Meeting
Route::post('add-meeting','UserMeetingController@addmeeting')->name('add_meeting');
//To Show User Meeting List Page
Route::get('meeting-list','UserMeetingController@meetinglist')->name('meeting_list');
//To View Upload User Meeting 
Route::get('/upload-meeting/{EncryptedID}','UserMeetingController@uploadmeeting')->name('upload_meeting');
//To Submit Meeting Details
Route::post('submit-meeting','UserMeetingController@submitmeetingdetails')->name('submit_meeting');


//////////////////////////////////////////////UserFollowUpController//////////////////////////////////////////////////////

//To View Upload User Meeting 
Route::get('/follow-up-meeting/{EncryptedID}','UserFollowUpController@followupmeeting')->name('follow_up_meeting');
//To Submit Follow Up Meeting Details
Route::post('follow-up-meeting','UserFollowUpController@submitfollowupmeeting')->name('add_followup_meeting');
//To Show User Follow Up Meeting List Page
Route::get('follow-up-meeting-list','UserFollowUpController@followup_meetinglist')->name('followup_meeting_list');

///////////////////////////////////////////////UserLeaveController//////////////////////////////////////////////////////

//User Leave Page
Route::get('/leave', 'UserLeaveController@index')->name('leave');
//User Apply For Leave
Route::post('/add-leave','UserLeaveController@addleave')->name('add_leave');
//To Show User Leave List Page
Route::get('leave-list','UserLeaveController@leavelist')->name('leave_list');
//User Superior's Update Status For Leave
Route::post('/update-leave','UserLeaveController@updateleave')->name('update_leave');

//////////////////////////////////////////////UserLateworkingController///////////////////////////////////////////////////

//User Lateworking
Route::get('/lateworking', 'UserLateworkingController@lateworking')->name('lateworking');
//User Store Lateworking
Route::post('/storelateworking', 'UserLateworkingController@storelateworking')->name('storelateworking');

///////////////////////////////////////////UserOutOfStationController////////////////////////////////////////////////////

//User Out Of Station
Route::get('/out-of-station', 'UserOutOfStationController@outofstation')->name('out_of_station');
//User Add Out Of Station
Route::post('/add-out-of-station', 'UserOutOfStationController@add_outofstation')->name('add_out_of_station');
//User Update Out Of Station
Route::post('/update-out-of-station','UserOutOfStationController@update_outofstation')->name('update_out_of_station');

///////////////////////////////////////////UserNoticeController//////////////////////////////////////////////////////////
//User Notice List
Route::get('/notice-list', 'UserNoticeController@noticelist')->name('notice_list');
//User View Notice
Route::get('/view-notice/{EncryptedID}','UserNoticeController@viewnotice')->name('view_notice');
//User Appriciation mail
Route::get('/newappriciation','UserNoticeController@newappriciationmail')->name('newappriciation');
//User View Appreciation Mail 
Route::get('/view-appriciation/{EncryptedId}','UserNoticeController@viewappriciation')->name('view_appriciation');
//User Submit Wishes Form
Route::post('/appwish', 'UserNoticeController@userappriciationwish')->name('appriciation_wish');
//User Holiday List
Route::get('/holidayslist', 'UserNoticeController@holidaysfileview')->name('wings_holidayslist');
//User HR Policy
Route::get('/hr_policy', 'UserNoticeController@hrpolicies')->name('hr_policy');
//User Company Policy(ACCEPTABLE USAGE POLICY - AUP)
Route::get('/aup', 'UserNoticeController@aup')->name('aup');

///////////////////////////////////////////UserVPmeetingController////////////////////////////////////////////

//User WorkSchedule Vendor Meeting
Route::get('/vendormeeting','UserVPmeetingController@vendormeeting')->name('vendormeeting');
Route::post('/vendormeetingcreate','UserVPmeetingController@vendormeetingcreate')->name('vendormeetingcreate');
//User WorkSchedule Pre- Event Meeting
Route::get('/preeventmeeting','UserVPmeetingController@preeventmeeting')->name('preeventmeeting');
Route::post('/preeventmeetingcreate','UserVPmeetingController@preeventmeetingcreate')->name('preeventmeetingcreate');

////////////////////////////////////////////UserEventsController//////////////////////////////////////////
//User WorkSchedule Recce
Route::get('/recce','UserEventsController@recce')->name('recce');
Route::post('/reccecreate','UserEventsController@reccecreate')->name('reccecreate');
//User WorkSchedule Event Setup
Route::get('/eventsetup','UserEventsController@eventsetup')->name('eventsetup');
Route::post('/eventsetupcreate','UserEventsController@eventsetupcreate')->name('eventsetupcreate');
//User WorkSchedule Event
Route::get('/event','UserEventsController@event')->name('event');
Route::post('/eventcreate','UserEventsController@eventcreate')->name('eventcreate');

////////////////////////////////////UserDeliveryDismantaleController////////////////////////////////////
//User WorkSchedule Delivery
Route::get('/delivery','UserDeliveryDismantaleController@delivery')->name('delivery');
Route::post('/deliverycreate','UserDeliveryDismantaleController@deliverycreate')->name('deliverycreate');
//User WorkSchedule Dismantle
Route::get('/dismantle','UserDeliveryDismantaleController@dismantle')->name('dismantle');
Route::post('/dismantlecreate','UserDeliveryDismantaleController@dismantlecreate')->name('dismantlecreate');

//////////////////////////////////////UserAttendenceController//////////////////////////////////////////////
//To View Employee Current Month Attendence
Route::get('/attendence','UserAttendenceController@index')->name('own_attendence');
//To View Employee Previous Month Attendence
Route::get('/previous-attendence','UserAttendenceController@previousmonth')->name('previous_attendence');

////////////////////////////////////////UserEventBillingController//////////////////////////////////////////////////

//To View Event Billing Report
Route::get('eventbilling','UserEventBillingController@eventbilling')->name('eventbilling');
//To Submit Billing Report Form 
Route::post('create-billing','UserEventBillingController@createbilling')->name('createbilling');
//To Submit FE Amount Form 
Route::post('create-fe-amount','UserEventBillingController@createfeamount')->name('createfeamount');

///////////////////////////////////////////Only Particular User Has Privilege/////////////////////////////////

//////////////////////////////////////////////////Bangalore Attendence /////////////////////////////////////////////  
// To Send Mail
Route::get('bang-attendence','AttendenceBangaloreController@attendence')->name('attendence');
// To Upload Excel File Sheet
Route::post('/bang-punch-in','AttendenceBangaloreController@uploadpunchindetails')->name('upload_punch_in_details');
 // To Send Mail
Route::get('bang-attendence-list','AttendenceBangaloreController@attendencelist')->name('attendence_list');
//Ajax Call For Attendence Update Data
Route::post('/bang-update-attendence', 'AttendenceBangaloreController@update_attendence')->name('update_attendence');
// To Download Bangalore Attendence Sheet
Route::get('/download-attendence', 'AttendenceBangaloreController@download_attendence')->name('bang_download_excel');
// To View Bangalore Mail Attendence
Route::get('/bang-mail-attendence','AttendenceBangaloreController@mail_attendence')->name('bang_mail_attendence');
// To Update Mail Template For User
Route::post('/bang-send-mail', 'AttendenceBangaloreController@bang_send_mail')->name('bang_send_mail');
// To View Previous Attendence List
Route::get('bang-attendence-previous-list','AttendenceBangaloreController@previousattendencelist')->name('previous_attendence_list');


//////////////////////////////////////////////////Mumbai Attendence /////////////////////////////////////////////  

// To Send Mail
Route::get('mumb-attendence','AttendenceMumbaiController@attendence')->name('mumb_attendence');
// To Upload Excel File Sheet
Route::post('/mumb-punch-in','AttendenceMumbaiController@uploadpunchindetails')->name('mumb_upload_punch_in_details');
// To Send Mail
Route::get('mumb-attendence-list','AttendenceMumbaiController@attendencelist')->name('mumb_attendence_list');
//Ajax Call For Attendence Update Data
Route::post('/mumb-update-attendence', 'AttendenceMumbaiController@update_attendence')->name('mumb_update_attendence');
// To Download Mumbai Attendence Sheet
Route::get('/mumb-download-attendence', 'AttendenceMumbaiController@mumbai_download_attendence')->name('mumb_download_excel');
// To View Bangalore Mumbai Attendence
Route::get('/mumb-mail-attendence','AttendenceMumbaiController@mumbai_mail_attendence')->name('mumb_mail_attendence');
// To Update Mail Template For User
Route::post('/mumb-send-mail', 'AttendenceMumbaiController@mumbai_send_mail')->name('mumb_send_mail');
// To View Previous Attendence List
Route::get('mumb-attendence-previous-list','AttendenceMumbaiController@previousattendencelist')->name('previous_mumb_attendence_list');


//////////////////////////////////////////////////Delhi Attendence /////////////////////////////////////////////  

// To Send Mail
Route::get('delh-attendence','AttendenceDelhiController@attendence')->name('delh_attendence');
// To Upload Excel File Sheet
Route::post('/delh-punch-in','AttendenceDelhiController@uploadpunchindetails')->name('delh_upload_punch_in_details');
 // To Send Mail
Route::get('delh-attendence-list','AttendenceDelhiController@attendencelist')->name('delh_attendence_list');
//Ajax Call For Attendence Update Data
Route::post('/delh-update-attendence', 'AttendenceDelhiController@update_attendence')->name('delh_update_attendence');
// To Download Delhi Attendence Sheet
Route::get('/delh-download-attendence', 'AttendenceDelhiController@delhi_download_attendence')->name('delh_download_excel');
// To View Bangalore Delhi Attendence
Route::get('/delh-mail-attendence','AttendenceDelhiController@delhi_mail_attendence')->name('delh_mail_attendence');
// To Update Mail Template For User
Route::post('/delh-send-mail', 'AttendenceDelhiController@delhi_send_mail')->name('delh_send_mail');
// To View Previous Attendence List
Route::get('delh-attendence-previous-list','AttendenceDelhiController@previousattendencelist')->name('previous_delh_attendence_list');

//////////////////////////////////////////////////ClientBusinessController//////////////////////////////////////////////////

// User Event SignUp
Route::get('/signupclient','ClientBusinessController@signupclient')->name('signupclient');
// User Submit Business Event SignUp
Route::post('/business-signup','ClientBusinessController@businesssignup')->name('business_signup');
// To Calculate Profit Amount and Percentage
Route::post('/budget-amount','ClientBusinessController@budgetamount')->name('budget_amount');
//Ajax Call For fetching Existing Company List
Route::post('/businesscompanylist','ClientBusinessController@businesscompanylist')->name('business_company_list');
//To View Signup List
Route::get('signup-list','ClientBusinessController@businesignuplist')->name('signup_list');
//User Download Documents
Route::get('/signup-document/{EncryptedId}/{EncryptedProof}', 'ClientBusinessController@signup_download')->name('signup_download');
//To Approve Signup By Particular User
Route::post('approve-signup','ClientBusinessController@approvesignup')->name('approve_signup');
//To Redo or Rejected Signup By Particular User
Route::post('reject-signup','ClientBusinessController@rejectsignup')->name('reject_signup');
//To Edit Signup Form
Route::get('/edit-signup/{EncryptedId}','ClientBusinessController@editsignup')->name('edit_signup');

//To Edit Revision Signup Form
Route::get('/edit-revision-signup/{EncryptedId}','ClientBusinessController@editrevisionsignup')->name('edit_revision_signup');

//To Delete Split in Edit Page
Route::post('/delete-split','ClientBusinessController@deletesplit')->name('delete_split_signup');
//To Submit Edit Signup Form
Route::post('/submit-edit-business','ClientBusinessController@submiteditsignup')->name('submit_edit_business');
//To Send Mail From User To Suresh Sir For Reply Comment
Route::post('/reply-comment','ClientBusinessController@replycomment')->name('reply_comment');
///Split Percentage
Route::get('/event-signup-split','ClientBusinessController@eventsignupsplit')->name('split_percentage');
///Test
Route::get('/mailtest','ClientBusinessController@mailtest')->name('mail_test');

///////////////////////////////////////////BillingInformationController//////////////////////////////////////////////// 

//To View Billing List
Route::get('billing-list','BillingInformationController@billinglist')->name('billing_list');
//User Billing Information
Route::get('/billinginfo/{EncryptedId}','BillingInformationController@billinginfo')->name('billinginfo');
//To Create/submit Billing Information
Route::post('/billinginfocreate','BillingInformationController@billinginfocreate')->name('billinginfocreate');
//To Approve Billing
Route::post('approve-billing','BillingInformationController@approvebilling')->name('approve_billing');
//To Redo Billing
Route::post('reject-billing','BillingInformationController@rejectbilling')->name('reject_billing');
//To View Edit Billing Page
Route::get('/edit-billing/{EncryptedId}','BillingInformationController@editbilling')->name('edit_billing');

//To View Edit Revision Billing Page
Route::get('/edit-revision-billing/{EncryptedId}','BillingInformationController@editrevisionbilling')->name('edit_revision_billing');

//To Submit Edit Billing Page
Route::post('/submit-edit-billing','BillingInformationController@submiteditbilling')->name('submit_edit_billing');
//To Download Billing Documents
Route::get('/billing-document/{EncryptedId}/{EncryptedProof}', 'BillingInformationController@billing_download')->name('billing_download');

///////////////////////////////////////////UserAdditionalSignupController////////////////////////////////////////

//To View Additional Signup Page
Route::get('additional-signup','UserAdditionalSignupController@additional_signup')->name('additional_signup');
//Ajax Call For fetching BS Number List
Route::post('/bsnumberlist','UserAdditionalSignupController@bsnumberlist')->name('bsnumber_list');
// To Fetch BS Number Data
Route::post('/bsnumber-data','UserAdditionalSignupController@fetchbsdata')->name('fetch_bs_data');
//To Submit Additional Signup
Route::post('submit-additional-signup','UserAdditionalSignupController@submitadditionalsignup')->name('submit_additional_signup');
//To View Edit Additional Signup Form
Route::get('/edit-additional-signup/{EncryptedId}','UserAdditionalSignupController@editadditionalsignup')->name('edit_additional_signup');

//To View Edit Additional Revision Signup Form
Route::get('/edit-additional-revision-signup/{EncryptedId}','UserAdditionalSignupController@editadditionalrevisionsignup')->name('edit_additional_revision_signup');

//To Submit Edit Additional Signup Form
Route::post('/submit-edit-additional-signup','UserAdditionalSignupController@submiteditadditionalsignup')->name('submit_edit_additional_signup');

///////////////////////////////////////////////////UserNetworkingMeeting////////////////////////////////////////////////////

//To Show User Networking Meeting Page
Route::get('networking-meeting','UserNetworkingMeeting@networkingmeeting')->name('networking_meeting');
//To Submit New Networking Meeting
Route::post('add-networking-meeting','UserNetworkingMeeting@addnetworkingmeeting')->name('add_networking_meeting');
//To Show User Networking Meeting List Page
Route::get('networking-meeting-list','UserNetworkingMeeting@networkingmeetinglist')->name('networking_meeting_list');


////////////////////////////////////////////////WishesController////////////////////////////////////////////////////////

//To Submit Wishes For Birthday and Work Anniversary's
Route::post('wishes','WishesController@birthdaywish')->name('wishes');

Route::get('/test-file','WishesController@viewtest')->name('test_file');

Route::post('submit-file','WishesController@submitfile')->name('submit_file');

Route::get('filedisplay','WishesController@file_display')->name('file_display');

////////////////////////////////////////////////UserBusinessRevionController////////////////////////////////////////////////////////

//Signup Rectification Request
Route::get('/businessrevision','UserBusinessRevionController@businessrevision')->name('businessrevision');

Route::post('/businessrevisioncreate','UserBusinessRevionController@businessrevisioncreate')->name('businessrevisioncreate');

////////////////////////////////////////// End of User //////////////////////////////////////////////////////////////////


///////////////////////////////////////////// HR /////////////////////////////////////////////////////////////////////////

Route::middleware(['hr'])->group(function() {


   ///////////////////////////////////////////////HrUserController/////////////////////////////////////////////////////

   //HR Employee Activation
   Route::get('/employee-activation', 'HrUserController@useractivation')->name('hr.user_activation');
   //HR Send Activation Link
   Route::post('/emp-activate', 'HrUserController@sendEmpActivation')->name('hr.send_activate_link');
   //HR Employee List
   Route::get('/employee-list', 'HrUserController@employeelist')->name('hr.employeelist');
   //HR Ajax Call For Updating Block and Active Status
   Route::post('/block-user', 'HrUserController@blockUser')->name('hr.block_user');
   //HR Ajax Call For Updating Confirm User
   Route::post('/confirm-user', 'HrUserController@confirmUser')->name('hr.confirm_user');
   //HR Newly Joined Employee List
   Route::get('/new-employee-list', 'HrUserController@newemployeelist')->name('hr.new_employee_list');
   //HR Resigned Employee List
   Route::get('/resigned-employee-list', 'HrUserController@resignedemployeelist')->name('hr.resigned_employee_list');
   //HR Submit/Add Resigned Employee List
   Route::post('/add-resigned-employee-list', 'HrUserController@addresignedemployee')->name('hr.add_resigned_emp');


   /////////////////////////////////////////////HrUserProfileController/////////////////////////////////////////////////

   //HR To View User Profile
   Route::get('/hr-user-profile/{EncryptedUserID}','HrUserProfileController@showUserProfile')->name('hr.user-view');
   //Update User Basic Details
   Route::post('/hr-update-basic', 'HrUserProfileController@update_basic_details')->name('hr.update_basic_details');
   //Update User Passport Details
   Route::post('/hr-update-passport','HrUserProfileController@update_passport_details')->name('hr.update_passport_details');
   //Update User Bank Account Details
   Route::post('/hr-update-bank-account','HrUserProfileController@update_bank_details')->name('hr.update_bank_details');
   //Update User PF Form Details
   Route::post('/hr-update-pf-form','HrUserProfileController@update_pf_form')->name('hr.update_pf_form');
   //Ajax Call For Academics Data
   Route::get('/hr-academics-data', 'HrUserProfileController@academics_data');
   Route::post('/hr-add-academic-data', 'HrUserProfileController@add_academic_data')->name('hr.add_academic_data');
   Route::post('/hr-update-academic-data', 'HrUserProfileController@update_academic_data')->name('hr.update_academic_data');
   Route::post('/hr-delete-academic-data', 'HrUserProfileController@delete_academic_data')->name('hr.delete_academic_data');
   //Ajax Call For Employment Data
   Route::get('/hr-employment-data', 'HrUserProfileController@employment_data');
   Route::post('/hr-add-employment-data', 'HrUserProfileController@add_employment_data')->name('hr.add_employment_data');
   Route::post('/hr-update-employment-data', 'HrUserProfileController@update_employment_data')->name('hr.update_employment_data');
   Route::post('/hr-delete-employment-data', 'HrUserProfileController@delete_employment_data')->name('hr.delete_employment_data');
   //Ajax Call For Family Background Data
   Route::get('/hr-family-data', 'HrUserProfileController@family_data');
   Route::post('/hr-add-family-data', 'HrUserProfileController@add_family_data')->name('hr.add_family_data');
   Route::post('/hr-update-family-data', 'HrUserProfileController@update_family_data')->name('hr.update_family_data');
   Route::post('/hr-delete-family-data', 'HrUserProfileController@delete_family_data')->name('hr.delete_family_data');
   //HR Upload Personal Documents
   Route::post('/hr-upload-personal-document', 'HrUserProfileController@upload_personal_documents')->name('hr.upload_personal_documents');
   //HR Upload Academic Documents
   Route::post('/hr-upload-academic-document', 'HrUserProfileController@upload_academic_documents')->name('hr.upload_academic_documents');
   //HR Upload Personal Documents
   Route::post('/hr-career-objective', 'HrUserProfileController@career_objective')->name('hr.career_objective');
   //HR Upload Personal Documents
   Route::post('/hr-user-other-activity', 'HrUserProfileController@user_other_activity')->name('hr.user_other_activity');
   //HR Upload Personal Documents
   Route::post('/hr-user-references', 'HrUserProfileController@user_references')->name('hr.user_references');
   //HR Download Documents
   Route::get('/hr-document/{EncryptedId}/{EncryptedProof}', 'HrUserProfileController@document_download')->name('hr.download');
   // HR Upload Official Documents 
   Route::post('/hr-upload-official-document', 'HrUserProfileController@upload_official_documents')->name('hr.upload_official_documents');

   ///////////////////////////////////////////////HrController/////////////////////////////////////////////////
   //Hr To Send Mail
   Route::get('send-mail','HrController@sendMail')->name('hr.send_mail');
   //HR Notice
   Route::get('/hr-notice', 'HrController@notice')->name('hr.notice');
   //HR Add Notice
   Route::post('/hr-add-notice', 'HrController@addnotice')->name('hr.add_notice');
   //HR Edit Notice
   Route::post('/hr-edit-notice', 'HrController@editnotice')->name('hr.edit_notice');
   //HR Delete Notice
   Route::post('/hr-delete-notice', 'HrController@deletenotice')->name('hr.delete_notice');
   //HR View Notice
   Route::get('/hr-view-notice/{EncryptedID}','HrController@viewnotice')->name('hr.view_notice');
   //HR Appreciation
   Route::get('/hr-appreciation','HrController@indexappriciation')->name('hr.appreciation');
   //HR Submit Appreciation Form
   Route::post('/hr-appriciation-form','HrController@appriciationform')->name('hr.appriciation_form');
   //HR View Appreciation Mail 
   Route::get('/hr-view-appriciation/{EncryptedId}','HrController@viewappriciation')->name('hr.view_appriciation');
   //HR Edit Appreciation Mail
   Route::post('hr-update-appriciation', 'HrController@updateappriciation')->name('hr.update_appriciation');
   //HR Delete Appreciation Mail
   Route::post('hr-appreciation-delete', 'HrController@appreciation_delete')->name('hr.appreciation_delete'); 
     //Admin Submit Wishes Form
   Route::post('/hr-appriciation-wish', 'HrController@appriciationwish')->name('hr.appriciation_wish');
   //HR Holiday List
   Route::get('/hr-holiday', 'HrController@holidaysfile')->name('hr.holiday');
   //HR Upload Holiday List
   Route::post('hr-import-Holiday-File', 'HrController@importfile')->name('hr.import_Holiday_File');

   //////////////////////////////////////////////////HrAttendenceController////////////////////////////////////////////////////////////
   
   //////////////////////////////////////////////////Bangalore Attendence /////////////////////////////////////////////  
   //Hr To Send Mail
   Route::get('ban-attendence','HrAttendenceController@attendence')->name('hr.attendence');
   //Hr To Upload Excel File Sheet
   Route::post('/ban-punch-in','HrAttendenceController@uploadpunchindetails')->name('hr.upload_punch_in_details');
    //Hr To Send Mail
   Route::get('ban-attendence-list','HrAttendenceController@attendencelist')->name('hr.attendence_list');
   //Ajax Call For Attendence Update Data
   Route::post('/ban-hr-update-attendence', 'HrAttendenceController@update_attendence')->name('hr.update_attendence');
   // To Download Bangalore Attendence Sheet
   Route::get('/hr-download-attendence', 'HrAttendenceController@bangalore_download_attendence')->name('hr.bangalore_download_excel');
    // To View Previous Attendence List
   Route::get('hr-bang-attendence-previous-list','HrAttendenceController@previousattendencelist')->name('hr.previous_attendence_list');

   //////////////////////////////////////////////////Mumbai Attendence /////////////////////////////////////////////  

   //Hr To Send Mail
   Route::get('mum-attendence','HrMumbaiAttendenceController@attendence')->name('hr.mum_attendence');
   //Hr To Upload Excel File Sheet
   Route::post('/mum-punch-in','HrMumbaiAttendenceController@uploadpunchindetails')->name('hr.mum_upload_punch_in_details');
    //Hr To Send Mail
   Route::get('mum-attendence-list','HrMumbaiAttendenceController@attendencelist')->name('hr.mum_attendence_list');
   //Ajax Call For Attendence Update Data
   Route::post('/mum-hr-update-attendence', 'HrMumbaiAttendenceController@update_attendence')->name('hr.mum_update_attendence');
   // To Download Mumbai Attendence Sheet
   Route::get('/mum-hr-download-attendence', 'HrMumbaiAttendenceController@mumbai_download_attendence')->name('hr.mumbai_download_excel');
   // To View Previous Attendence List
   Route::get('hr-mum-attendence-previous-list','HrMumbaiAttendenceController@previousattendencelist')->name('hr.mumbai_previous_attendence_list');
   
   //////////////////////////////////////////////////Delhi Attendence /////////////////////////////////////////////  

   //Hr To Send Mail
   Route::get('del-attendence','HrDelhiAttendenceController@attendence')->name('hr.del_attendence');
   //Hr To Upload Excel File Sheet
   Route::post('/del-punch-in','HrDelhiAttendenceController@uploadpunchindetails')->name('hr.del_upload_punch_in_details');
    //Hr To Send Mail
   Route::get('del-attendence-list','HrDelhiAttendenceController@attendencelist')->name('hr.del_attendence_list');
   //Ajax Call For Attendence Update Data
   Route::post('/del-hr-update-attendence', 'HrDelhiAttendenceController@update_attendence')->name('hr.del_update_attendence');
   // To Download Delhi Attendence Sheet
   Route::get('/del-hr-download-attendence', 'HrDelhiAttendenceController@delhi_download_attendence')->name('hr.delhi_download_excel');
   // To View Previous Attendence List
   Route::get('hr-del-attendence-previous-list','HrDelhiAttendenceController@previousattendencelist')->name('hr.delhi_previous_attendence_list');

});


////////////////////////////////////////// End Of HR /////////////////////////////////////////////////////////////////////
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
