@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<title>HRM | Meeting Request</title>

@include('user.layouts.css')

<!-- Multi Select Css -->
<link rel="stylesheet" href="{{asset('user/plugins/multi-select/css/multi-select.css')}}">

<link rel="stylesheet" href="{{asset('user/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"  />
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

<link rel="stylesheet" href="{{asset('user/plugins/dropify/css/dropify.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('user/plugins/select2/select2.css')}}" />

<link rel="stylesheet" href="{{asset('user/pastimepicker/css/jquery.datetimepicker.min.css')}}" />
<script src="{{asset('user/pastimepicker/js/jquery.min.js')}}"></script>

<style type="text/css">
    .card {
     margin-bottom: 0px; 
    }
    .card .body {
        font-size: 13px;
    }
    .gender-bottom{
        margin-bottom: 1.55rem;
    }    
    .dropdown-menu {   
        box-shadow: 0px 4px 10px 0px rgba(41,42,51,0.2);
    }
    .invalid-feedback {  
        display: block;  
        width: 100%;
        margin-top: .25rem;
        font-size: 95%;
        color: #dc3545;
    }
    .download{
        float: right;
    }

    .select2-container-multi .select2-choices{
        background-image: none!important; 
    }
    .select2-container-multi .select2-choices .select2-search-field input{
        padding:0px !important;
    }

    .select2-container .select2-choice {
        border-radius: 0px;
        background-image: none;
        border:0px;
    }
    /* Media Query for Mobile Devices */ 
        @media (max-width: 480px) { 
            #companyList{
                    margin-top: -50px;
            }
            .client{
                margin-top: 55px;
            }
        } 
          
        /* Media Query for low resolution  Tablets, Ipads */ 
        @media (min-width: 481px) and (max-width: 767px) { 
            #companyList{
                    margin-top: -50px;
            }
           
        } 
          
        /* Media Query for Tablets Ipads portrait mode */ 
        @media (min-width: 768px) and (max-width: 1024px){ 
            #companyList{
                    margin-top: -50px;
            }
            
        } 
          
        /* Media Query for Laptops and Desktops */ 
        @media (min-width: 1025px) and (max-width: 1280px){ 
            #companyList{
                    margin-top: -50px;
            }
        } 
          
        /* Media Query for Large screens */ 
        @media (min-width: 1281px) { 
            #companyList{
                    margin-top: -50px;
            }
        } 
</style>
</head>

<body class="theme-blush">

<div id="pageloader">
    <img src="{{ asset('loader.gif')}}" alt="processing..." />
</div>

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
                    <h2>Meeting Request</h2>
                    <ul class="breadcrumb">
                       <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Meeting</li>
                        <li class="breadcrumb-item active">New Meeting</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                    
                </div>
            </div>
        </div> 
        <div class="container-fluid">
             <!-- Tabs With Icon Title -->
            <div class="row clearfix">
                <div class="col-sm-2 col-md-2 col-lg-2">
                </div>
                <div class="col-sm-8 col-md-8 col-lg-8">
                    <div class="card">  
                        <div class="header">
                            <h2><strong>Meeting Form</strong></h2>
                        </div>                      
                        <div class="body">  
                            <form method="post" action="{{route('add_meeting')}}" id="add_meeting" autocomplete="off">
                                @csrf
                                <div class="row">                        
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label for="email_address">Company</label>
                                        <div class="form-group gender-bottom"> 
                                            <div class="radio inlineblock m-r-20">                                                                    
                                                <input type="radio" name="company" id="exist" class="with-gap" value="exist" checked >
                                                <label for="exist"><i class="zmdi zmdi-case-check"></i> Exist</label>
                                                <input type="radio" name="company" id="new" class="with-gap" value="new">
                                                <label for="new"><i class="zmdi zmdi-case"></i> New</label>
                                            </div>   
                                        </div>  
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>Company Name</label>
                                        <span id="exist_div">
                                        <div class="input-group masked-input" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-balance"></i></span>
                                            </div>
                                           <input type="text" class="form-control" name="exist_company_name" id="exist_company_name" placeholder="Search Company Name">  
                                        </div>   
                                        <div id="companyList" style="margin-top: -50px;"></div>                                      
                                        </span>
                                        <div class="input-group masked-input" id="new_div" style="display: none">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-balance"></i></span>
                                            </div>
                                           <input type="text" class="form-control" name="new_company_name" placeholder="Enter Company Name">
                                        </div>    
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 client">
                                        <label>Client Name</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="client_name" placeholder="Client Name">
                                            @if ($errors->has('client_name'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('client_name') }}</strong>
                                            </span>
                                            @endif 
                                        </div>                                       
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>Client Email</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="client_email" placeholder="Client Email">
                                            @if ($errors->has('client_email'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('client_email') }}</strong>
                                            </span>
                                            @endif 
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>Date Of Meeting</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                            </div>
                                            <input type="text" class="form-control datepicker" name="date" placeholder="Date Of Meeting">
                                            @if ($errors->has('date'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date') }}</strong>
                                            </span>
                                            @endif 
                                        </div>                                        
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>Time Of Meeting</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-time"></i></span>
                                            </div>
                                            <input type="text" class="form-control time" name="time" placeholder="Time Of Meeting">
                                            @if ($errors->has('time'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('time') }}</strong>
                                            </span>
                                            @endif 
                                        </div>                                        
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>Duration Of Meeting</label>
                                        <div class="input-group masked-input mb-3">                                       
                                            <select class="form-control show-tick" name="duration" placeholder="Duration Of Meeting">
                                                <option value="">Select Duration Of Meeting</option>
                                                <option value="00:30">00:30 </option>
                                                <option value="01:00">01.00 </option>
                                                <option value="01:30">01.30 </option>
                                                <option value="02:00">02.00 </option>
                                                <option value="02:30">02.30 </option>
                                                <option value="03:00">03.00 </option>
                                                <option value="03:30">03.30 </option>
                                                <option value="04:00">04.00 </option>
                                                <option value="04:30">04.30 </option>
                                                <option value="05:00">05.00 </option>
                                                <option value="05:30">05.30 </option>
                                                <option value="06:00">06.00 </option>
                                                <option value="06:30">06.30 </option>
                                                <option value="07:00">07.00 </option>
                                                <option value="07:30">07.30 </option>
                                                <option value="08:00">08.00 </option>
                                                <option value="08:30">08.30 </option>
                                                <option value="09:00">09.00 </option>
                                                <option value="09:30">09.30 </option>
                                                <option value="10:00">10.00 </option>
                                                <option value="10:30">10.30 </option>
                                                <option value="11:00">11.00 </option>
                                                <option value="11:30">11.30 </option>
                                                <option value="12:00">12.00 </option>
                                                <option value="12:30">12.30 </option>
                                            </select>
                                            @if ($errors->has('duration'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('duration') }}</strong>
                                            </span>
                                            @endif 
                                        </div>                                        
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>Location Of Meeting</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="location" placeholder="Location Of Meeting">
                                            @if ($errors->has('location'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('location') }}</strong>
                                            </span>
                                            @endif 
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>Expected Time Of Arrival (ETA)</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-time-interval"></i></span>
                                            </div>
                                            <input type="text" class="form-control timepicker" name="expected_time" placeholder="Expected Time Of Arrival">
                                            @if ($errors->has('expected_time'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('expected_time') }}</strong>
                                            </span>
                                            @endif 
                                        </div>                                       
                                    </div>

                                     <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label>Tag Employee</label>
                                        <div class="input-group masked-input mb-3">
                                            <select class="form-control show-tick ms select2" multiple name="tag_user[]" placeholder="Select Employee For Meeting">
                                                <option value="">Select User</option>
                                                @foreach($Users as $user)
                                                <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <label>Purpose Of Meeting</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-comments"></i></span>
                                            </div>
                                            <textarea class="form-control" name="purpose_of_working" rows="2" placeholder="Purpose Of Meeting"></textarea>   
                                            @if ($errors->has('purpose_of_working'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('purpose_of_working') }}</strong>
                                            </span>
                                            @endif 
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SUBMIT</button>  
                                            </div>    
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                            </div>
                                        </div>                               
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:10px;">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p style="text-align: justify;font-size:15px;font-weight:bold;"><b style="color:red"><u>Please Note</u>:</b><br>The Minutes of Meeting has to be uploaded within 48 hours from the scheduled time and date of this meeting. If the same is not uploaded, then you will be marked <b style="color:red;">absent</b> for the day. In case of postponement or cancellation of the meeting, please update the same in the HR tool immediately. We request you to kindly adhere to the policy.</p>
                                            </div>              
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                </div>
            </div>
        </div>
    </div>
</section>

@include('user.layouts.js')

<script src="{{asset('user/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js --> 
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> 
<script src="{{asset('user/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('user/js/pages/forms/dropify.js')}}"></script>
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>
<script src="{{asset('user/js/pages/forms/advanced-form-elements.js')}}"></script> 
<script src="{{asset('user/plugins/select2/select2.min.js')}}"></script> <!-- Select2 Js -->

<script src="{{asset('user/pastimepicker/js/jquery.datetimepicker.js')}}"></script>
{!! Toastr::message() !!}

@include('user.scripts.scripts')



<script type="text/javascript">   

    $('.datepicker').bootstrapMaterialDatePicker({minDate : new Date(),time: false });

    $("#add_meeting").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit


    $("input[type='radio']").change(function(){
        if($(this).val()=="exist")
        {
          $("#exist_div").show();
          $("#new_div").hide(); 
        }
        else
        {
          $("#new_div").show(); 
          $("#exist_div").hide();
        }
    });

    $(document).ready(function(){
        $('#exist_company_name').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                  url:"{{route('company_list')}}",
                  method:"POST",
                  data:{query:query, _token:_token},
                  success:function(data)
                  {                             
                    $('#companyList').fadeIn();
                    $('#companyList').html(data);
                  }
                })
            }else{
                $('#companyList').hide();          
            }
        });
    });

    $(document).on('click','ul.companylist li', function(){
        $('#exist_company_name').val($(this).text());
        $('#companyList').hide();      
    });

   $(function() {
      $(".time").datetimepicker({
        minTime: 0,
        format:'H:i',
        step: 15,
        forceRoundTime: true,
        datepicker:false,
        minDate:'-1970/01/01', // today is minimum date
        onSelectDate: function(ct, $i) {
        var minTime, now = new Date;
            if(ct.getTime() > now){
                minTime = false;
            }else{
                var d = $i.val().substr(0, 11) + (Number(now.getHours()) + 1).toString() + ':00';
                $i.val(d);
                minTime = 0;
            }
            this.setOptions({
                minTime: minTime
            })
        }
      })
    });
</script>

</body>

@endsection