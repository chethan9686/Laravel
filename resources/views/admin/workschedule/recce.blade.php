@extends('admin.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | Event Recce</title>

@include('admin.layouts.css')

<!-- JQuery DataTable Css -->
<link rel="stylesheet" href="{{ asset('admin/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">

<style>   
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
                    <h2>Event Recce</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Work schedule</li>
                        <li class="breadcrumb-item active">Event Recce</li>
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
                <div class="col-sm-12">
                    <div class="card">                       
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs p-0 mb-3">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#ban">BANGALORE</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#mum">MUMBAI</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#del">DELHI</a></li>     
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#hyd">HYDERABAD</a></li>                            
                            </ul>                        
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane in active" id="ban">
                                    <div class="header">
                                        <h2>Export <strong>Bangalore</strong> Event Recces </h2>
                                    </div>  
                                   <div class="table-responsive">                                    
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                            <thead>
                                               <tr>
                                                    <th>Sl.no</th>
                                                    <th>Name</th>
                                                    <th>Branch</th>
                                                    <th>Client Name</th>
                                                    <th>Event Name</th>
                                                    <th>Date Of Recce </th>
                                                    <th>Time Of Recce </th>
                                                    <th>Recce  Location</th>
                                                    <th>Reporting Time to Work</th>
                                                    <th>Tagged Employees</th>
                                                </tr>
                                            </thead>                                   
                                            <tbody> 
                                               @foreach($Bang_Recce as $key=>$data)
                                                    @php
                                                        $user = \App\User::find($data->user_id);
                                                        $branch = \App\Branch::find($data->branch);
                                                    @endphp
                                                    <?php
                                                      if($data->recce_references_id != 0){
                                                        $tag_users = \App\Recce::where('recce_references_id','=',$data->recce_references_id)->where('user_id','!=',$user->id)->orwhere('id','=',$data->recce_references_id)->get();
                                                        foreach($tag_users as $key1=>$tag){
                                                                $users = \App\User::find($tag->user_id);                                               
                                                                $Res[$key1] = $users->first_name;
                                                            }  
                                                        }else{
                                                               $tag_users = \App\Recce::where('recce_references_id','=',$data->id)->get();
                                                        foreach($tag_users as $key1=>$tag){
                                                                $users = \App\User::find($tag->user_id);                                               
                                                                $Res[$key1] = $users->first_name;
                                                            }   
                                                        }
                                                                                            
                                                      ?>
                                                   <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$user->first_name}} {{$user->last_name}}</td>
                                                        <td>{{$branch->name}}</td>
                                                        <td>{{$data->recce_clientname}}</td>
                                                        <td>{{$data->recce_eventname}}</td>
                                                        <td><?php echo date('d-m-Y', strtotime($data->recce_dateofrecce)) ?></td>
                                                        <td><?php echo date("h:i A",strtotime($data->recce_time)) ?></td>
                                                        <td>{{$data->recce_eventlcation}}</td>
                                                        <td><?php echo date("h:i A",strtotime($data->recce_ERTW)) ?></td>
                                                        <td><sapn class="badge badge-success">@if(!empty($Res)){{implode(',',$Res)}} @endif</sapn></td>
                                                        
                                                    </tr>
                                                @endforeach    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="mum">
                                    <div class="header">
                                        <h2>Export <strong>Mumbai</strong> Event Recces </h2>
                                    </div>  
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                            <thead>
                                               <tr>
                                                    <th>Sl.no</th>
                                                    <th>Name</th>
                                                    <th>Branch</th>
                                                    <th>Client Name</th>
                                                    <th>Event Name</th>
                                                    <th>Date Of Recce </th>
                                                    <th>Time Of Recce </th>
                                                    <th>Recce  Location</th>
                                                    <th>Reporting Time to Work</th>
                                                    <th>Tagged Employees</th>
                                                </tr>
                                            </thead>                                   
                                            <tbody> 
                                               @foreach($Mum_Recce as $key=>$data)
                                                    @php
                                                        $user = \App\User::find($data->user_id);
                                                        $branch = \App\Branch::find($data->branch);
                                                    @endphp
                                                    <?php
                                                      if($data->recce_references_id != 0){
                                                        $tag_users = \App\Recce::where('recce_references_id','=',$data->recce_references_id)->where('user_id','!=',$user->id)->orwhere('id','=',$data->recce_references_id)->get();
                                                        foreach($tag_users as $key1=>$tag){
                                                                $users = \App\User::find($tag->user_id);                                               
                                                                $Res[$key1] = $users->first_name;
                                                            }  
                                                        }else{
                                                               $tag_users = \App\Recce::where('recce_references_id','=',$data->id)->get();
                                                        foreach($tag_users as $key1=>$tag){
                                                                $users = \App\User::find($tag->user_id);                                               
                                                                $Res[$key1] = $users->first_name;
                                                            }   
                                                        }
                                                                                            
                                                      ?>
                                                   <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$user->first_name}} {{$user->last_name}}</td>
                                                        <td>{{$branch->name}}</td>
                                                        <td>{{$data->recce_clientname}}</td>
                                                        <td>{{$data->recce_eventname}}</td>
                                                        <td><?php echo date('d-m-Y', strtotime($data->recce_dateofrecce)) ?></td>
                                                        <td><?php echo date("h:i A",strtotime($data->recce_time)) ?></td>
                                                        <td>{{$data->recce_eventlcation}}</td>
                                                        <td><?php echo date("h:i A",strtotime($data->recce_ERTW)) ?></td>
                                                        <td><sapn class="badge badge-success">@if(!empty($Res)){{implode(',',$Res)}} @endif</sapn></td>
                                                        
                                                    </tr>
                                                @endforeach    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="del">
                                    <div class="header">
                                        <h2>Export <strong>Delhi</strong> Event Recces </h2>
                                    </div>   
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                            <thead>
                                               <tr>
                                                    <th>Sl.no</th>
                                                    <th>Name</th>
                                                    <th>Branch</th>
                                                    <th>Client Name</th>
                                                    <th>Event Name</th>
                                                    <th>Date Of Recce </th>
                                                    <th>Time Of Recce </th>
                                                    <th>Recce  Location</th>
                                                    <th>Reporting Time to Work</th>
                                                    <th>Tagged Employees</th>
                                                </tr>
                                            </thead>                                   
                                            <tbody> 
                                               @foreach($Del_Recce as $key=>$data)
                                                    @php
                                                        $user = \App\User::find($data->user_id);
                                                        $branch = \App\Branch::find($data->branch);
                                                    @endphp
                                                    <?php
                                                      if($data->recce_references_id != 0){
                                                        $tag_users = \App\Recce::where('recce_references_id','=',$data->recce_references_id)->where('user_id','!=',$user->id)->orwhere('id','=',$data->recce_references_id)->get();
                                                        foreach($tag_users as $key1=>$tag){
                                                                $users = \App\User::find($tag->user_id);                                               
                                                                $Res[$key1] = $users->first_name;
                                                            }  
                                                        }else{
                                                               $tag_users = \App\Recce::where('recce_references_id','=',$data->id)->get();
                                                        foreach($tag_users as $key1=>$tag){
                                                                $users = \App\User::find($tag->user_id);                                               
                                                                $Res[$key1] = $users->first_name;
                                                            }   
                                                        }
                                                                                            
                                                      ?>
                                                   <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$user->first_name}} {{$user->last_name}}</td>
                                                        <td>{{$branch->name}}</td>
                                                        <td>{{$data->recce_clientname}}</td>
                                                        <td>{{$data->recce_eventname}}</td>
                                                        <td><?php echo date('d-m-Y', strtotime($data->recce_dateofrecce)) ?></td>
                                                        <td><?php echo date("h:i A",strtotime($data->recce_time)) ?></td>
                                                        <td>{{$data->recce_eventlcation}}</td>
                                                        <td><?php echo date("h:i A",strtotime($data->recce_ERTW)) ?></td>
                                                        <td><sapn class="badge badge-success">@if(!empty($Res)){{implode(',',$Res)}} @endif</sapn></td>
                                                        
                                                    </tr>
                                                @endforeach    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>     
                                <div role="tabpanel" class="tab-pane" id="hyd">
                                    <div class="header">
                                        <h2>Export <strong>HYDERABAD</strong> Event Recces </h2>
                                    </div>   
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                            <thead>
                                               <tr>
                                                    <th>Sl.no</th>
                                                    <th>Name</th>
                                                    <th>Branch</th>
                                                    <th>Client Name</th>
                                                    <th>Event Name</th>
                                                    <th>Date Of Recce </th>
                                                    <th>Time Of Recce </th>
                                                    <th>Recce  Location</th>
                                                    <th>Reporting Time to Work</th>
                                                    <th>Tagged Employees</th>
                                                </tr>
                                            </thead>                                   
                                            <tbody> 
                                               @foreach($Hyd_Recce as $key=>$data)
                                                    @php
                                                        $user = \App\User::find($data->user_id);
                                                        $branch = \App\Branch::find($data->branch);
                                                    @endphp
                                                    <?php
                                                      if($data->recce_references_id != 0){
                                                        $tag_users = \App\Recce::where('recce_references_id','=',$data->recce_references_id)->where('user_id','!=',$user->id)->orwhere('id','=',$data->recce_references_id)->get();
                                                        foreach($tag_users as $key1=>$tag){
                                                                $users = \App\User::find($tag->user_id);                                               
                                                                $Res[$key1] = $users->first_name;
                                                            }  
                                                        }else{
                                                               $tag_users = \App\Recce::where('recce_references_id','=',$data->id)->get();
                                                        foreach($tag_users as $key1=>$tag){
                                                                $users = \App\User::find($tag->user_id);                                               
                                                                $Res[$key1] = $users->first_name;
                                                            }   
                                                        }
                                                                                            
                                                      ?>
                                                   <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$user->first_name}} {{$user->last_name}}</td>
                                                        <td>{{$branch->name}}</td>
                                                        <td>{{$data->recce_clientname}}</td>
                                                        <td>{{$data->recce_eventname}}</td>
                                                        <td><?php echo date('d-m-Y', strtotime($data->recce_dateofrecce)) ?></td>
                                                        <td><?php echo date("h:i A",strtotime($data->recce_time)) ?></td>
                                                        <td>{{$data->recce_eventlcation}}</td>
                                                        <td><?php echo date("h:i A",strtotime($data->recce_ERTW)) ?></td>
                                                        <td><sapn class="badge badge-success">@if(!empty($Res)){{implode(',',$Res)}} @endif</sapn></td>
                                                        
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


@include('admin.layouts.js')

<!-- Jquery DataTable Plugin Js --> 
<script src="{{asset('admin/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/js/pages/tables/jquery-datatable.js')}}"></script>

{!! Toastr::message() !!}
</body>
@endsection