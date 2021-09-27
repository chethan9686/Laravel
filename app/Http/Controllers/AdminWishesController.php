<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use \Carbon\Carbon;
use App\Appriciationwish;
use App\Appriciation;

class AdminWishesController extends Controller
{
   	public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function appriciationwish(Request $request){
    	
    	$request->validate([
    		'appriciation_whishes' => 'required',
    	]);

    	$appriciationwish = new Appriciationwish();
    	$appriciationwish->name = Auth::user()->name;       
    	$appriciationwish->appriciationmail_id = $request->appriciationmail_id;
    	$appriciationwish->appriciation_whishes = $request->appriciation_whishes;
    	$appriciationwish->save();
    	return back();
    }
}
