@extends('admin.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title> HRM | Departments</title>

@include('admin.layouts.css')

<link rel="stylesheet" href="{{asset('admin/plugins/footable-bootstrap/css/footable.bootstrap.min.css')}}">
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('admin/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

<link rel="stylesheet" href="{{asset('admin/plugins/footable-bootstrap/css/footable.standalone.min.css')}}">
 
<style>
    .card .header{
        padding: 0px 0 10px 0;
    }
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: .25rem;
        font-size: 90%;
        color: red;
    } 

</style>

</head>

<body class="theme-blush">

@include('admin.layouts.page_loader')

@include('admin.layouts.search')

@include('admin.layouts.menu_sidebar')

@include('admin.layouts.left_sidebar')

@include('admin.layouts.right_sidebar')

<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Departments</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Departments</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                    
                </div>
            </div>
        </div> 
        <div class="container-fluid">
            <div class="row clearfix">               
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5">                           
                            <div class="card">    
                                 <div class="header">
                                    <h2>Add<strong> Department </strong></h2>
                                </div>   
                                <form method="post" action="{{route('admin.add_department')}}">
                                @csrf 
                                    <div class="body">                       
                                        <label for="email_address">Department Name</label>
                                        <div class="form-group">                                
                                           <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Department Name" name="dept_name">
                                            </div>
                                             @if ($errors->has('dept_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('dept_name') }}</strong>
                                                </span>
                                            @endif  
                                        </div>

                                        <label for="email_address">Department Head</label>
                                        <div class="form-group">                                
                                             <select class="form-control show-tick" data-placeholder="Select" name="dept_head">
                                                <option value="">Department Head Name</option>       
                                                @foreach($users as $user)
                                                 <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>                                      
                                                @endforeach
                                            </select> 
                                            @if ($errors->has('dept_head'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('dept_head') }}</strong>
                                                </span>
                                            @endif  
                                        </div>                                                           
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">                            
                            <div class="card">       
                                <div class="header">
                                    <h2><strong> Department </strong>List</h2>
                                </div>                         
                                <div class="body">
                                    <div class="table-responsive">
                                        <table class="table table-striped m-b-0" id="dept_delete">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-breakpoints="xs">Department Name</th>
                                                <th data-breakpoints="xs">Department Head</th>                                            
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($departments as $key => $department)
                                                @php
                                                    $head = App\User::find($department->dept_head_id);
                                                @endphp
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$department->dept_name}}</td>
                                                    <td>{{$head->first_name}} {{$head->last_name}}</td>
                                                    <td>
                                                       <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#editModal{{$department->id}}"><i class="zmdi zmdi-edit"></i></button>
                                                    </td> 
                                                    <td>
                                                        <button class="btn btn-danger btn-round delete" data-id="{{$department->id}}"><i class="zmdi zmdi-delete"></i></button>
                                                    </td>                                    
                                                </tr>                                                 
                                                @endforeach                                                           
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>            
            </div>
        </div>
    </div>
</section>
    
@foreach($departments as $key => $department)
<!--Modal -->
    <div class="modal fade" id="editModal{{$department->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit Department</h4>
                </div>
               <form method="post" action="{{route('admin.edit_department')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="department_id" value="{{$department->id}}">
                    <div class="modal-body"> 
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <label for="email_address">Department Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                        </div>
                                       <input type="text" class="form-control" placeholder="Department Name" name="edit_dept_name" value="{{$department->dept_name}}">
                                    </div>
                                </div>                           
                            </div>                                                                             
                       
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <label for="email_address">Department Head</label>
                                <div class="form-group">
                                    <div class="input-group">                                                                                  
                                      <select class="form-control show-tick" data-placeholder="Select" name="edit_dept_head_id">              
                                        <option value=" ">Department Head Name</option>       
                                        @foreach($users as $user)                                                                                    
                                            @if($department->dept_head_id != $user->id)
                                                 <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                            @else
                                                 <option value="{{$user->id}}" selected>{{$user->first_name}} {{$user->last_name}}</option>
                                            @endif                         
                                        @endforeach
                                        </select>  
                                    </div>
                                </div>                           
                            </div>                                                                             
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger btn-round waves-effect" style="float: left" data-dismiss="modal">CLOSE</button>
                        <button type="submit" class="btn btn-success btn-round waves-effect" >SAVE</button>               
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach  

@include('admin.layouts.js')

<script src="{{asset('admin/bundles/footable.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->

<script src="{{asset('admin/js/pages/tables/footable.js')}}"></script><!-- Custom Js --> 

<script type="application/javascript">    
    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        swal({
                title: "Are you sure!",
                type: "warning",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes Delete it!",
                text: "You Will Be Deleting Department Details!",
                showCancelButton: true,
            },
            function() {
                $.ajax({
                    url: '{{ route('admin.delete_department') }}',
                    type: "POST",
                    dataType: "json",
                    data: {"_token": "{{ csrf_token() }}","id" : id},
                    success: function (data) {
                                    $("#dept_delete").load(" #dept_delete");
                                    if(data == "Success"){
                                    swal({
                                        title: "Success!",
                                        text: "You Have Successfully Deleted Department Details!.",
                                    });
                            }
                        }         
                });
        });
    });
</script>

{!! Toastr::message() !!}
</body>

@endsection
   