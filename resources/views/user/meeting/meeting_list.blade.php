@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>HRM | Meeting List</title>

@include('user.layouts.css')

 <!-- JQuery DataTable Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
  <!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('user/plugins/summernote/dist/summernote.css')}}"/>
  <style type="text/css">
    .text-center-row>th, .text-center-row>td 
    {
      text-align: center;
      vertical-align:middle;
    } 
    .card-inside-title, h6{
      text-transform: none !important;
    }
     .invalid-feedback {  
        display: block;  
        width: 100%;
        margin-top: .25rem;
        font-size: 95%;
        color: #dc3545;
    }
    .theme-blush .nav-tabs .nav-link.active {
        border: 1px solid #00bcd4;
        color: #00bcd4;
        }
        .table-bordered{
            border: 1px solid #00BCD4;
        }
        thead{
            background: #00BCD4;
            color: #fff;
        }
</style>
</head>

<body class="theme-blush">

@include('user.layouts.page_loader')

@include('user.layouts.search')

@include('user.layouts.menu_sidebar')

@include('user.layouts.left_sidebar')

@include('user.layouts.right_sidebar')

<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Meeting List</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Meeting</li>
                        <li class="breadcrumb-item active">Recent Meetings</li>
                    </ul>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                                
                </div>
            </div>
        </div>      
        <div class="container-fluid">          
             <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Export</strong> Meeting List </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Sl.no</th>
                                            <th>Date Of Meeting</th>
                                            <th>Employee Name</th>
                                            <th>Company Name</th>                                  
                                            <th>Client Name</th>
                                            <th>Time Of Meeting</th>
                                            <th>Duration Of Meeting</th>
                                            <th>Location Of Meeting</th>
                                            <th>Purpose of Meeting</th>
                                            <th>Meeting Status</th>
                                            <th>Send MOM</th>
                                            <th>Follow Up</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                     
                                        @foreach($meetings as $key => $data)
                                            @php
                                            $EncryptedID = \Illuminate\Support\Facades\Crypt::encrypt($data->id); 

                                            $user = \App\User::find($data->user_id);   

                                            $current = \Carbon\Carbon::now();

                                            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$data->date.' '.$data->time.':00');

                                            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current);

                                            $diff_in_Mins = $to->diffInMinutes($from);   
                                            @endphp
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{$data->date}}</td>
                                                <td>{{$user->first_name }} {{$user->last_name }}</td>                                           
                                                <td>{{$data->company_name}}</td>
                                                <td>{{$data->client_name}}</td>
                                                <td>{{$data->time}}</td>
                                                <td>{{$data->duration}}</td>
                                                <td>{{$data->location}}</td>
                                                <td>{{$data->purpose_of_meeting}}</td>
                                                <td>
                                                    @if(is_null($data->meeting_status))
                                                        <span class="btn btn-round btn-warning">Pending</span>
                                                    @elseif($data->meeting_status == "Completed")
                                                        <span class="btn btn-round btn-success">Completed</span> 
                                                    @elseif($data->meeting_status == "Postponed")
                                                        <span class="btn btn-round btn-primary">Postponed</span> 
                                                    @elseif($data->meeting_status == "Canceled")
                                                        <span class="btn btn-round btn-danger">Canceled</span> 
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($data->meeting_status == NULL)
                                                        @if($data->user_id == Auth::user()->id)
                                                            @if($diff_in_Mins < (2880))
                                                                <a href="{{route('upload_meeting',[ 'EncryptedID' => $EncryptedID ])}}"><span class="btn btn-round btn-danger">SendMOM</span></a>
                                                            @else
                                                                <button class="btn btn-round btn-danger" disabled>Timeout</button>       
                                                            @endif   
                                                        @else
                                                            <button class="btn btn-round btn-danger" disabled>Pending</button>   
                                                        @endif   
                                                    @elseif($data->meeting_status == 'Completed')                             
                                                        <a data-toggle="modal" data-target="#viewCompleted{{$data->id}}"><button class="btn btn-round btn-danger">View</button></a>                    
                                                    @elseif($data->meeting_status == 'Postponed')   
                                                        <a data-toggle="modal" data-target="#viewPostponed{{$data->id}}"><button class="btn btn-round btn-danger">View</button></a>  
                                                    @elseif($data->meeting_status == 'Canceled')   
                                                        <a data-toggle="modal" data-target="#viewCanceled{{$data->id}}"><button class="btn btn-round btn-danger">View</button></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($data->meeting_status == 'Completed')  
                                                        <a href="{{route('follow_up_meeting',[ 'EncryptedID' => $EncryptedID ])}}"><span class="btn btn-round btn-primary">FollowUp</span></a>
                                                    @endif  
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
</section>

@foreach($meetings as $key => $data)

<?php
$Details = App\UserMeeting::find($data->id);

if(is_null($Details->referred_id)){
    $parent_id = $Details->id;
}else{
    $parent_id = $Details->referred_id;
}  

$details = App\Clients::where('parent_mom_id','=',$parent_id)->first(); 
$add_client_email = explode(",",$details['extra_email']); 
?>

<!-- Large Size -->
<div class="modal fade" id="viewCompleted{{$data->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h4 class="title" id="largeModalLabel">Meeting - {{$data->company_name}}</h4>
            </div>
            <div class="modal-body"> 
                <div class="row">                                                       
                    <div class="col-lg-6 col-md-6 col-sm-12 ">
                        <label>Company Name</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-balance"></i></span>
                            </div>
                            <input type="text" class="form-control" name="company_name" placeholder="Enter Company Name" value="{{$data->company_name}}">                      
                        </div>                                               
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 ">
                        <label for="email_address">Client Status</label>
                        <div class="form-group gender-bottom"> 
                            <div class="radio inlineblock m-r-20">      
                            @if(is_null($details['alternate_client_email']))                                                              
                                <input type="radio" class="with-gap" value="exist"  checked>
                                <label ><i class="zmdi zmdi-star-circle"></i> Exist</label>
                            @else
                                <input type="radio" class="with-gap" value="new" checked>
                                <label ><i class="zmdi zmdi-plus-circle"></i> New</label>  
                            @endif                         
                            </div>   
                        </div>  
                    </div>
                </div>
                @if(is_null($details['alternate_client_email']))
                <div class="row exist">
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                            <label>Client Name</label>
                            <div class="input-group masked-input">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-box"></i></span>
                                </div>
                                <input type="text" class="form-control" name="exist_company_name" id="exist_company_name" placeholder="Client Name" value="{{$details['client_name']}}">    
                            </div>                                               
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                            <label>Client Email</label>
                            <div class="input-group masked-input">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                </div>
                                <input type="text" class="form-control" name="exist_company_email" id="exist_company_email" placeholder="Client Email" value="{{$details['client_email']}}">
                            </div>                                               
                        </div>
                </div>
                @else
                <div class="row alternate">
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                            <label>Alternate Name</label>
                            <div class="input-group masked-input">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-box"></i></span>
                                </div>
                                <input type="text" class="form-control" name="alt_company_name" id="alt_company_name" placeholder="Alternate Name" value="{{$details['alternate_client_name']}}">       
                            </div>                                               
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                            <label>Alternate Email</label>
                            <div class="input-group masked-input">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                </div>
                                <input type="text" class="form-control" name="alt_company_email" id="alt_company_email" placeholder="Alternate Email" value="{{$details['alternate_client_email']}}">                
                            </div>                                               
                        </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label>Date Of Meeting</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                            </div>
                            <input type="text" class="form-control" name="date" placeholder="Date Of Meeting" value="{{$data->date}}" >                             
                        </div>                                               
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label>Time Of Meeting</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-time"></i></span>
                            </div>
                            <input type="text" class="form-control" name="time" placeholder="Time Of Meeting" value="{{$data->time}}" >                                
                        </div>                                               
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label>Location Of Meeting</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                            </div>
                            <input type="text" class="form-control" name="location" placeholder="Location Of Meeting" value="{{$data->location}}" >                            
                        </div>                                               
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label>Total No Of Persons Involved In Meeting</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-accounts-add"></i></span>
                            </div>
                            <input type="number" class="form-control" name="person_involved" placeholder="Persons Involved In Meeting" value="{{$details['person_involved']}}">                                       
                        </div>                                               
                    </div>
                    
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12  field_wrapper">
                                    <label>Additional Client Email</label>
                                    @foreach($add_client_email as $email)
                                    <div class="input-group masked-input mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>
                                        </div>
                                       <input type="text" class="form-control" name="additional_email[]" placeholder="Additional Client Email" value="{{$email}}">                   
                                    </div> 
                                    @endforeach
                                </div>                            
                            </div>                                         
                        </div>
                   
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label>From The Client</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-accounts"></i></span>
                            </div>
                            <input type="text" class="form-control" name="from_client" placeholder="From The Client" value="{{$details['from_client']}}">                          
                        </div>                                               
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label>From The Agency</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-airline-seat-recline-normal"></i></span>
                            </div>
                            <input type="text" class="form-control" name="from_agency" placeholder="From The Agency" value="{{$details['from_agency']}}">                              
                        </div>                                               
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <label>Key Points</label>
                        <div class="input-group masked-input">
                            <textarea class="form-control summernote"  name="key_points" rows="3" placeholder="Key Points">{!! $details['key_points'] !!}</textarea>                    
                        </div>                                               
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label>Mobile Number</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-smartphone-iphone"></i></span>
                            </div>
                            <input type="text" class="form-control" name="mobile" placeholder="Mobile Number" value="{{$details['mobile']}}">          
                        </div>                                               
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label>Landline Number</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-phone-ring"></i></span>
                            </div>
                            <input type="text" class="form-control" name="landline" placeholder="Landline Number" value="{{$details['landline']}}">  
                        </div>                                               
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                        <label>Address Line 1</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                            </div>
                            <input type="text" class="form-control" name="address_1" placeholder="Address Line 1" value="{{$details['address_1']}}">  
                        </div>                                               
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                        <label>Address Line 2</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                            </div>
                            <input type="text" class="form-control" name="address_2" placeholder="Address Line 2" value="{{$details['address_2']}}">                                         
                        </div>                                               
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                        <label>Address Line 3</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                            </div>
                            <input type="text" class="form-control" name="address_3" placeholder="Address Line 3" value="{{$details['address_3']}}">                                            
                        </div>                                               
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                        <label>State</label>
                        <div class="input-group masked-input">
                            <select class="form-control" name="state">
                                <option value="">Please Select State</option>                                        
                                @foreach($States as $state)                                      
                                    @if($details['state'] == $state->id)
                                        <option value="{{$state->id}}" selected>{{$state->state_name}}</option>                                                
                                    @endif                                                                                        
                                @endforeach
                            </select>                     
                        </div>                                               
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                        <label>City</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-city"></i></span>
                            </div>
                            <input type="text" class="form-control" name="city" placeholder="City"  value="{{$details['city']}}">                         
                        </div>                                               
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                        <label>Zip Code</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-home"></i></span>
                            </div> 
                            <input type="text" class="form-control" name="zip_code" placeholder="Zip Code"  value="{{$details['zipcode']}}">              
                        </div>                                               
                    </div>
                </div>
            </div>
            <div class="modal-footer">               
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>


<!-- Large Size -->
<div class="modal fade" id="viewPostponed{{$data->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h4 class="title" id="largeModalLabel">Postponed - {{$data->company_name}}</h4>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <label>Reason For Postponed</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-comment-list"></i></span>
                            </div>
                            <textarea class="form-control" rows="3" name="postpone" placeholder="Reason For Postponed">{{$Details->reason}}</textarea>                                       
                        </div>                                               
                    </div>
                </div>
            </div>
            <div class="modal-footer">              
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Large Size -->
<div class="modal fade" id="viewCanceled{{$data->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h4 class="title" id="largeModalLabel">Canceled - {{$data->company_name}}</h4>
            </div>
            <div class="modal-body"> 
                 <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <label>Reason For Canceled</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-comment-list"></i></span>
                            </div>
                            <textarea class="form-control" rows="3" name="cancel" placeholder="Reason For Canceled">{{$Details->reason}}</textarea>                                  
                        </div>                                               
                    </div>
                </div>
            </div>
            <div class="modal-footer">               
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
@endforeach


@include('user.layouts.js')
<script src="{{asset('user/plugins/summernote/dist/summernote.js')}}"></script>
<!-- Jquery DataTable Plugin Js --> 
<script src="{{asset('user/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('user/js/pages/tables/jquery-datatable.js')}}"></script>

<script type="text/javascript">
    $('.summernote').summernote({
        height: 120,   
        width:1500,
        toolbar: [   
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ],
        placeholder: 'Key Points / Discussion Details',    
    });
</script>
{!! Toastr::message() !!}
</body>

@endsection