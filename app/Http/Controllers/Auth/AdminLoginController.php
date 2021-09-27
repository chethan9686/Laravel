<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{
	public function _construct()
	{
		$this->middleware('guest:admin')->except('logout');
	}
   
    public function showLoginForm()
    {
   	 return view('admin.auth.login');
    }

    public function login(Request $request)
    {
   		$request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if(Auth::guard('admin')->attempt(['email' => $request->email , 'password' => $request->password]))
        {          
        	if(Auth::guard('admin')->id() == 1 || Auth::guard('admin')->id() == 2 || Auth::guard('admin')->id() == 3){
                return redirect()->intended(route('admin.dashboard'));
            }
            elseif(Auth::guard('admin')->id() == 6){
                return redirect()->intended(route('admin.employeelist'));
            } 
            else{
                return redirect()->intended(route('admin.view_business'));
            } 
        }

        return redirect()->back()->withInput($request->only('email'))->with('error','These credentials do not match our records.');;
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();       

        return redirect('/');
    }
}
