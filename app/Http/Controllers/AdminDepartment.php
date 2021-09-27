<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\User;
use Toastr;

class AdminDepartment extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function departmentlist()
    {    	
    	$users = User::where('status','=','active')->orderBy('first_name', 'ASC')->get(); 
    	$departments = Department::all();
    	return view('admin.department.department_list',compact('users','departments'));
    }

    public function addDepartment(Request $request)
    {       
        $request->validate([
                'dept_name' => ['required', 'string', 'max:255'],
                'dept_head' => ['required', 'string', 'max:255'],            
        ], [
                'dept_name.required' => 'Department Name Is Required.',
                'dept_head.required' => 'Please Select Department Head',                   
        ]);  

        Department::create([
            'dept_name' => $request->dept_name,
            'dept_head_id' => $request->dept_head
        ]);

        Toastr::success('You Have Successfully Inserted Department Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
        return back();    	
    }

    public function editDepartment(Request $request)
    {
        $Dept = Department::find($request->department_id);
       
        if(isset($request->edit_dept_name) && isset($request->edit_dept_head_id)){

            $Dept->dept_name = $request->edit_dept_name;
            $Dept->dept_head_id = $request->edit_dept_head_id;
            $Dept->save();

            Toastr::success('You Have Successfully Updated Department Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back();

        }else{
            Toastr::error('Please Check Department Details!. Thank You ',$title = null, $options = ["positionClass" => "toast-top-center"]);
            return back(); 
        }
    }

    public function deleteDepartment(Request $request)
    {
        $dept = Department::find($request->id);
        $dept->delete();
        return response()->json("Success");
    }


}
