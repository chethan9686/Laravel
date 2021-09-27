@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HRM | Appreciation</title>
@include('user.layouts.css')
  
<link rel="stylesheet" href="{{asset('user/plugins/dropify/css/dropify.min.css')}}">
<link rel="stylesheet" href="{{asset('user/plugins/summernote/dist/summernote.css')}}">
<link rel="stylesheet" href="{{asset('user/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"  />
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<!-- Begin emoji-picker Stylesheets -->
<link  rel="stylesheet" href="{{asset('user/lib/css/emoji.css')}}"/>
<link rel="stylesheet" href="{{asset('user/css/font-awesome.min.css')}}" >
<style type="text/css">  
    .chat_window {
      margin-left: 0px !important;
    }
    .blockquote{
      background: #fff;
      font-size: 15px !important;
    }
    .form-group{
      margin-bottom: 0px !important;
    }
    .alert{
      margin-bottom: 0px !important;
    }
    .emoji-picker-icon{
      right: 67px !important;
      top: 9px !important;
    }
    .emoji-picker-containerapp .emoji-picker-icon{display: none !important;}
    .form-control1{
      border: 0px solid #fff !important;
    }
    .chat_window .chat-history .other-message{
      margin-right: 15px;
    }
    .chat_window .chat-history .message-data{
      margin-right: 15px;
    }   
    .emojiii .emoji-picker-icon{display: none !important;}
    .form-control1{
      pointer-events: none; !important;
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
                    <h2>Appreciation Mail</h2>
                    <ul class="breadcrumb">
                       <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active">Appreciation Mail</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div> 
        
        <div class="container-fluid">   
            @if(empty($latest))
              <div class="row">
                <div class="col-lg-12 col-md-12">
                  <div class="card">  
                    <div class="header">
                       <h2 style="text-align: center"><strong>Appreciation Mailer's Will Be Display Soon</strong></h2>
                    </div>
                  </div>
                </div>
              </div>
            @else
              @php
                $appriciationdata = \App\Appriciation::orderBy('id', 'DESC')->where('id','!=',$latest->id)->get();
              @endphp
              <div class="row">
                  <div class="col-lg-8 col-md-12">
                      <div class="card">                    
                        <div class="header">
                            <?php
                              $eventdate = \Carbon\Carbon::parse($latest->eventdate);    
                              $eventdate = $eventdate->format('l jS F Y'); 
                              ?>
                              <h2><strong>{{ $latest->eventname }}</strong></h2> 
                              <span class="blogitem-date">{{ $eventdate}}</span>                       
                          </div>
                          <blockquote class="blockquote">
                              {!! $latest->clientmail !!}
                              <footer>by <a href="blog.html">{{ $latest->clientname }}</a></footer>
                          </blockquote>
                       
                         <div class="chat_window body">
                              <div class="chat-header">
                                  <div class="user">
                                      <div class="chat-about">
                                          <div class="chat-with">{{ $latest->eventname }}</div>                                  
                                      </div>
                                  </div>
                                  <a href="javascript:void(0);" class="list_btn btn btn-info btn-round float-md-right"><i class="zmdi zmdi-comments"></i></a>
                              </div>
                              <hr>
                              
                          <ul class="chat-history">
                            @php
                              $latestwish = \App\Appriciationwish::where('appriciationmail_id','=',$latest->id)->get();                      
                            @endphp
                            <div style="overflow-y: scroll; max-height:400px;">
                            @foreach($latestwish as $appwish)
                              <li class="clearfix">
                                  <div class="status online message-data text-right">
                                      <span class="time">{{\Carbon\Carbon::parse($appwish->created_at)->diffForHumans()}}</span>
                                      <span class="name">{{$appwish->name}}</span>
                                      <i class="zmdi zmdi-circle me"></i>
                                  </div>
                                  <div class="message other-message float-right">
                                      <div class="emoji-picker-containerapp">
                                        <input type="text" name="" class="form-control1 disabled" value="{{ $appwish->appriciation_whishes }}" data-emojiable="true" style="border: 2px solid red;">
                                      </div>
                                  </div>
                              </li>
                            @endforeach
                          </div>
                          </ul>
                          <form method="POST" action="{{ route('appriciation_wish') }}" id="appriciationwishesh">
                            {{ csrf_field() }}                       
                            <input type="hidden" name="appriciationmail_id" value="{{$latest->id}}">
                            <div class="text-left">
                              <div class="lead emoji-picker-container">
                                <div class="chat-box">
                                  <div class="input-group sendbutton">
                                      <input type="text" name="appriciation_whishes" class="form-control" placeholder="Enter text here..." data-emojiable="true" style="margin-top: 20px !important;height: 38px;" required>
                                    <div class="input-group-prepend" style="margin-left: 0px !important;">
                                      <span class="input-group-text" style="line-height: 0.5px !important;"><button><i class="zmdi zmdi-mail-send"></i></button></span>
                                    </div>
                                  </div>                                                            
                                </div>
                              </div>
                            </div>
                          </form>
                          </div>
                      </div>
                    </div>
                     <div class="col-lg-4 col-md-12">                  
                      <div class="card">
                          <div class="header">
                              <h2><strong>Latest Appreciation Mailers</strong></h2>                        
                          </div>
                          <div class="body">
                              <ul class="list-unstyled mb-0 widget-categories">
                              @foreach($appriciationdata as $data)
                                @php
                                  $EncryptedId = \Illuminate\Support\Facades\Crypt::encrypt($data->id);
                                @endphp
                                  <li><a href="{{ route('view_appriciation',[ 'EncryptedId' => $EncryptedId ])}}">{{ $data->eventname}}</a></li>
                              @endforeach
                              </ul>
                          </div>
                      </div>
                  </div> 
              </div>
            @endif
          </div>
    </div>

</section>


@include('user.layouts.js')

<script src="{{asset('user/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('user/js/pages/forms/dropify.js')}}"></script>
<script src="{{asset('user/plugins/summernote/dist/summernote.js')}}"></script>
<script src="{{asset('user/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js -->
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>
<!-- Begin emoji-picker JavaScript -->
<script src="{{asset('user/lib/js/config.js')}}"></script>
<script src="{{asset('user/lib/js/util.js')}}"></script>
<script src="{{asset('user/lib/js/jquery.emojiarea.js')}}"></script>
<script src="{{asset('user/lib/js/emoji-picker.js')}}"></script>
  <script>
      $(function() {

        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: '/user/lib/img/',
          popupButtonClasses: 'fa fa-smile-o'
        });
        window.emojiPicker.discover();
      });
    </script>
{!! Toastr::message() !!}
</body>

@endsection