<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\User;
use App\UserDetails;
use App\PassportDetails;
use App\UserBankDetails;
use App\UserPfForm;
use App\UserDocument;
use App\UserOtherDetails;
use App\BangaloreAttendence;
use App\MumbaiAttendence;
use App\DelhiAttendence;
use App\Custom\ConvertNumber;
use App\UserOfficialDocument;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Toastr;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $messages = [
            'f_name.required' => 'First Name Is Required.',
            'l_name.required' => 'Last Name Is Required',
            'gender.required' => 'Select Your Gender',
            'branch.required' => 'Select Your Branch',
            'remember_me.required' => 'Please Agree For Terms & Conditions'
        ];

        return Validator::make($data, [
            'f_name' => ['required', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'phone' => 'required|digits_between:8,15',
            'branch' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'remember_me' => ['required'],
        ],$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $confirmation_code = str_random(30);
        
        $User =  User::create([
            'first_name' => $data['f_name'],
            'last_name' => $data['l_name'],
            'gender' => $data['gender'],
            'branch' => $data['branch'],
            'phone' =>  $data['phone'],
            'email' =>  $data['email'],
            'confirmation_code' => $confirmation_code,
            'password' => Hash::make($data['password']),
        ]);

        return $User;
    }

    public function verifyRegister($confirmationCode)
    {
        try {
            if (!$confirmationCode) {
                throw new InvalidConfirmationCodeException();
            }
            $User = User::where('confirmation_code', $confirmationCode)->first();

            if (!$User) {
                throw new InvalidConfirmationCodeException;
            }

            $date = Carbon::today();

            $User->email_verify = 1;
            $User->confirmation_code = NULL;
            $User->status = 'active';
            $User->save();  

            $Details = UserDetails::create([
                'user_id' => $User->id 
            ]);   

            $Passport = PassportDetails::create([
                'user_id' => $User->id ,
                'user_details_id' => $Details->id
            ]);

            $Bank = UserBankDetails::create([
                'user_id' => $User->id ,
                'user_details_id' => $Details->id,
                'passport_details_id' =>  $Passport->id
            ]);  

            $Pf_details =  UserPfForm::create([
                'user_id' => $User->id ,
                'user_details_id' => $Details->id,
                'passport_details_id' =>  $Passport->id,
                'bank_details_id' => $Bank->id
            ]);  

            UserDocument::create([
                'user_id' => $User->id,
            ]);

            UserOtherDetails::create([
                'user_id' => $User->id,
            ]);
            
            UserOfficialDocument::create([
                'user_id' => $User->id,
            ]);
            
            $month  = date('m');
            $year  = date('Y');
            $days = date('t', mktime(0, 0, 0, $month, 1, $year));
            $number = new ConvertNumber(); 
            for($i = 1; $i<= $days; $i++){
               $day  = date('Y-m-'.$i);
               $result = date("l", strtotime($day));
               if($result == "Sunday"){
                    $day = date("d", strtotime($day));
                    $num_word = $number->numberTowords($day);
                    $data[$i] = $num_word;
               }
            }

            if($User->branch == 1 || $User->branch == 6 || $User->branch == 7 || $User->branch == 4)
            {               
                $latest = BangaloreAttendence::create([
                    'user_id' => $User->id,
                    'emp_id' => $Details->emp_id,
                    'emp_name' => $User->first_name.' '.$User->last_name,
                    'year' => $date->year,
                    'month' => $date->month
                ]);

                foreach ($data as $key => $value) {
                    $latest->$value = "SUN";
                    $latest->save();
                }
            }
            elseif($User->branch == 2 || $User->branch == 5)
            {
                $latest = MumbaiAttendence::create([
                    'user_id' => $User->id,
                    'emp_id' => $Details->emp_id,
                    'emp_name' => $User->first_name.' '.$User->last_name,
                    'year' => $date->year,
                    'month' => $date->month
                ]);

                foreach ($data as $key => $value) {
                    $latest->$value = "SUN";
                    $latest->save();
                }
            }
            elseif($User->branch == 3)
            {               
                $latest = DelhiAttendence::create([
                    'user_id' => $User->id,
                    'emp_id' => $Details->emp_id,
                    'emp_name' => $User->first_name.' '.$User->last_name,
                    'year' => $date->year,
                    'month' => $date->month
                ]);

                foreach ($data as $key => $value) {
                    $latest->$value = "SUN";
                    $latest->save();
                }
            }           


            $this->guard()->login($User);

            Toastr::success('You Have Successfully Verified Your Email ID',$title = null, $options = ["positionClass" => "toast-top-center"]);

            return redirect('/dashboard');
        }
        catch (InvalidConfirmationCodeException $e)
        {
            Log::info("Invalid Confirmation Code by IP : ". $_SERVER['REMOTE_ADDR']);
            return response()->redirectTo('/login');
        }
    }
}
