@extends('admin.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | Appriciation</title>

@include('admin.layouts.css')
  
<link rel="stylesheet" href="{{asset('admin/plugins/dropify/css/dropify.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/plugins/summernote/dist/summernote.css')}}">
<link rel="stylesheet" href="{{asset('admin/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"  />
  <!-- Bootstrap Select Css -->
  <link  rel="stylesheet" href="{{asset('admin/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
  <!-- JQuery DataTable Css -->
  <link  rel="stylesheet" href="{{asset('admin/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
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
    .img-responsive{
    display: block;
    height: 100;
    max-width: 100%;
    margin:0 auto;
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
                  <h2>Appreciation</h2>
                  <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active"> Create New Appreciation</li>
                  </ul> 
                  <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
              </div>               
          </div>
      </div>
      <div class="container-fluid">
          <form method="POST" action="{{ route('admin.appriciation_form') }}" class="form-horizontal" role="form" enctype="multipart/form-data">
           {{ csrf_field() }}
            <input type="hidden" class="form-control" name="user_id" />
            <div class="row clearfix">
                <div class="col-md-4">                   
                    <label for="email_address">Company/Organization Name</label>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                            </div>
                           <input type="text" class="form-control" name="companyname" placeholder="Company Name" />
                        </div>
                        @if ($errors->has('companyname'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('companyname') }}</strong>
                        </span>
                        @endif  
                    </div>                    
                </div>
                <div class="col-md-4">                
                  <label for="email_address">Client Name</label>
                  <div class="form-group">
                      <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
                          </div>
                        <input type="text" class="form-control" name="clientname" placeholder="Client Name" />
                      </div>
                      @if ($errors->has('clientname'))
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('clientname') }}</strong>
                      </span>
                      @endif 
                  </div>                     
                </div>
                <div class="col-md-4">                   
                  <label for="email_address">Event Name</label>
                  <div class="form-group">
                      <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>
                          </div>
                       <input type="text" class="form-control" name="eventname" placeholder="Event Name" />
                      </div>
                      @if ($errors->has('eventname'))
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('eventname') }}</strong>
                      </span>
                      @endif  
                  </div>                  
                </div>
                <div class="col-md-4">                  
                  <label for="email_address">Event Date</label>
                  <div class="form-group">
                      <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                          </div>
                          <input type="text" class="form-control datepicker" name="eventdate" placeholder="Event Date" />   
                      </div>
                      @if ($errors->has('eventdate'))
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('eventdate') }}</strong>
                      </span>
                      @endif
                  </div>                   
                </div>
                <div class="col-md-4">                  
                  <label for="email_address">Event Location</label>
                  <div class="form-group">
                      <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                          </div>
                         <input type="text" class="form-control" name="location" placeholder="Location" />
                      </div>
                      @if ($errors->has('location'))
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('location') }}</strong>
                      </span>
                      @endif 
                  </div>                      
                </div>
                <div class="col-md-12">          
                  <label for="email_address">Client Mail</label>
                  <div class="form-group">                      
                        <textarea class="summernote form-control" name="clientmail"></textarea>     
                        @if ($errors->has('clientmail'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('clientmail') }}</strong>
                        </span>
                        @endif                  
                  </div>                      
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                  <button type="submit" class="btn btn-primary btn-round waves-effect btn-block">Submit</button>
                </div>
                <div class="col-md-4">
                </div>
            </div>
          </form>
          <div class="row clearfix">
            <div class="col-lg-12">
               <div class="card">
                  <div class="header">
                <h2><strong>Appriciation</strong> Mails Table</h2>             
              </div>
              <div class="body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                    <thead>
                      <tr class="text-center-row">
                          <th>Sl.No</th>
                          <th>Company Name</th>
                          <th>Client Name</th>
                          <th>Event Name</th>
                          <th>Event date</th>
                          <th>Event Location</th>
                          <th>Action</th> 
                          <th>Delete</th> 
                      </tr>
                    </thead>
                    <tbody>                      
                      @foreach($appmailsall as $key => $mails)
                      @php
                        $EncryptedId = \Illuminate\Support\Facades\Crypt::encrypt($mails->id);
                        $eventdate = \Carbon\Carbon::parse($mails->eventdate);    
                        $eventdate = $eventdate->format('l jS F Y'); 
                      @endphp
                        <tr class="text-center-row">
                          <td>{{ $key+1 }}</td>
                          <td>{{ $mails->companyname }}</td>
                          <td>{{ $mails->clientname }}</td>
                          <td>{{ $mails->eventname }}</td>
                          <td>{{ $mails->eventdate }}</td>
                          <td>{{ $mails->location }}</td>
                          <td>
                            <a href="{{ route('admin.view_appriciation',[ 'EncryptedId' => $EncryptedId ])}}">
                              <button type="button" class="btn btn-raised m-b-10 btn-info waves-effect" data-placement-from="bottom" data-placement-align="left" data-animate-enter="" data-animate-exit="" data-color-name="alert-info"><i class="zmdi zmdi-eye"></i></button>
                            </a>
                              <button type="button" class="btn btn-raised m-b-10 bg-teal waves-effect" data-toggle="modal" data-target="#largeModal{{$mails->id}}" data-placement-from="bottom" data-placement-align="right" data-animate-enter="" data-animate-exit="" data-color-name="bg-teal"><i class="zmdi zmdi-edit"></i></button>
                          </td>
                          <td>
                            <button type="button" class="btn btn-raised m-b-10 bg-red waves-effect" data-id="{{ $mails->id }}" data-toggle="modal" data-target="#deleteapp" data-placement-from="bottom" data-placement-align="left" data-animate-enter="" data-animate-exit="" data-color-name="bg-red"><i class="zmdi zmdi-delete"></i></button>
                          </td>
                        </tr>  


                        <!--Modal -->
                          <div class="modal fade" id="largeModal{{$mails->id}}" tabindex="-1" role="dialog">
                              <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header" style="background: #00bcd4;justify-content: center;">
                                         <strong style="font-size: 20px;text-transform: none;color: white">Post New Apprication Mail</strong>                     
                                      </div>
                                      <form method="POST" action="{{ route('admin.update_appriciation') }}" class="form-horizontal" role="form" enctype="multipart/form-data">
                                      @csrf
                                        <div class="modal-body">                                        
                                          <input type="hidden" class="form-control" name="id" value="{{ $mails->id }}" />
                                          <div class="row clearfix">
                                              <div class="col-lg-12 col-md-12 col-sm-12">
                                                  <label for="email_address">Company/Organization Name</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <div class="input-group-prepend">
                                                              <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                          </div>
                                                        <input type="text" class="form-control" name="edit_companyname" value="{{ $mails->companyname }}" placeholder="Company Name" />
                                                      </div>
                                                  </div>                           
                                              </div>
                                              <div class="col-lg-12 col-md-12 col-sm-12">
                                                  <label for="email_address">Client Name</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <div class="input-group-prepend">
                                                              <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
                                                          </div>
                                                         <input type="text" class="form-control" name="edit_clientname" value="{{ $mails->clientname }}" placeholder="Client Name" />
                                                      </div>     
                                                  </div>
                                              </div>      
                                              <div class="col-lg-12 col-md-12 col-sm-12">
                                                  <label for="email_address">Event Name</label>
                                                  <div class="form-group">
                                                     <div class="input-group">
                                                          <div class="input-group-prepend">
                                                              <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>
                                                          </div>
                                                         <input type="text" class="form-control" name="edit_eventname" value="{{ $mails->eventname }}" placeholder="Event Name" />
                                                      </div>   
                                                  </div>
                                              </div>   
                                              <div class="col-lg-12 col-md-12 col-sm-12">
                                                  <label for="email_address">Event Date</label>
                                                  <div class="form-group">
                                                     <div class="input-group">
                                                          <div class="input-group-prepend">
                                                              <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                          </div>
                                                         <input type="text" class="form-control datepicker" name="edit_eventdate" value="{{ $eventdate }}" placeholder="Event Date" />
                                                      </div>   
                                                  </div>
                                              </div>   
                                              <div class="col-lg-12 col-md-12 col-sm-12">
                                                  <label for="email_address">Location</label>
                                                  <div class="form-group">
                                                      <div class="input-group">
                                                          <div class="input-group-prepend">
                                                              <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                                                          </div>
                                                         <input type="text" class="form-control" name="edit_location" value="{{ $mails->location }}" placeholder="Location" />
                                                      </div>    
                                                  </div>
                                              </div>   
                                              <div class="col-lg-12 col-md-12 col-sm-12">
                                                  <label for="email_address">Client Mail</label>
                                                  <div class="form-group">
                                                     <textarea class="summernote form-control" name="edit_clientmail" required>{!! $mails->clientmail !!}</textarea>   
                                                  </div>
                                              </div>        
                                          </div>
                                        </div>
                                        <div class="modal-footer">                                         
                                            <button type="submit" class="btn btn-primary btn-round waves-effect">SUBMIT</button>
                                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                                        </div>
                                     </form>
                                  </div>
                              </div>
                          </div>       
                          <!--End Modal -->             
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
     <!-- Default Size -->
    <div class="modal fade" id="deleteapp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="margin-top: 8px !important;"></h4>
                    <h5 class="modal-title w-100 text-center position-absolute">Delete Appriciation Mail!</h5>
                </div>
                <form action="{{ route('admin.appreciation_delete') }}" method="post">
                  {{csrf_field()}}
                  <div class="modal-body"> 
                     <input type="hidden" name="id" id="id">
                    <div class="Image">
                      <img src="{{asset('admin/images/delete.png')}}" class="img-responsive" height="80" width="80" title="Appriciation mail" alt="Appriciation mail">
                    </div><br>
                    <h6 class="col-12 modal-title text-center" style="font-size: 14px;">Are you sure you want to delete this Appriciation mail?</h6>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button type="submit" class="btn btn-danger waves-effect">Delete Mailer</button>
                      <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Cancel Mailer</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
  </section>


@include('admin.layouts.js')

<script src="{{asset('admin/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('admin/js/pages/forms/dropify.js')}}"></script>
<script src="{{asset('admin/plugins/summernote/dist/summernote.js')}}"></script>
<script src="{{asset('admin/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js -->
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('admin/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('admin/js/pages/forms/basic-form-elements.js')}}"></script>
<!-- Jquery DataTable Plugin Js --> 
<script src="{{asset('admin/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/js/pages/tables/jquery-datatable.js')}}"></script>
<script type="text/javascript">
  $('#deleteapp').on('show.bs.modal', function (event)
  {
        var a = $(event.relatedTarget)
        var id = a.data('id') 
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
  });
</script>
{!! Toastr::message() !!}
</body>

@endsection