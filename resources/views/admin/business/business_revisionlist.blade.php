@extends('admin.layouts.master')

@section('content')

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> HRM | Business Revision List</title>

    @include('admin.layouts.css')
    <!-- JQuery DataTable Css -->
    <link  rel="stylesheet" href="{{asset('admin/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('user/css/font-awesome.min.css')}}">
    <style>   
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
    .btn
    {
        margin:0px 0px;
        padding: 6px 14px;
    }
    .btn-round 
    {
        padding:5px 15px;
    }    
    #DataTables_Table_1{
        width: 100% !important;
    }  
    #DataTables_Table_2{
        width: 100% !important;
    } 
    #DataTables_Table_3{
        width: 100% !important;
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
                    <h2>Business Revision  List</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Business Revision List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                                
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">                       
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs p-0 mb-3">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#ban">BANGALORE</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#mumb">MUMBAI</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#del">DELHI</a></li>     
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#hyd">HYDERABAD</a></li>                            
                            </ul>                        
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane in active" id="ban">
                                   <div class="table-responsive">                                    
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length='250'>
                                            <thead>
                                                <tr>
                                                    <th>Sl.no</th>
                                                    <td>BS Number</td>
                                                    <th>Revision Requested By</th>                                                                                 
                                                    <th>Invoice Number</th>                                                                                 
                                                    <th>Reson For Revision</th>                                                                                 
                                                    <th>Revision Status</th>                                                                                 
                                                    <th>Revision Comment</th>   
                                                    <th>Action</th>                                                                              
                                                </tr>
                                            </thead>                                   
                                            <tbody>
                                                @forelse ($Bang_Signupsrevision as $key=>$List)
                                                    @php
                                                        $user = \App\User::find($List->user_id);                                                                          
                                                    @endphp
                                                    <tr>
                                                       <td>{{ $key+1 }}</td>    
                                                        <td>{{$List->bs_number}}</td>
                                                        <td>{{$user->first_name }} {{$user->last_name }}</td>
                                                        <td>
                                                            @if(is_null($List->invoice_no))
                                                                <p>No Invoice Number</p>
                                                            @else
                                                                <p>{{$List->invoice_no}}</p>
                                                            @endif
                                                        </td>
                                                        <td>{{$List->revision_reason}}</td>
                                                        <td>
                                                            @if($List->status == 1)
                                                                <span class="btn btn-round btn-warning">Pendding</span>
                                                            @elseif($List->status == 0)
                                                                <span class="btn btn-round btn-danger">Rejected</span>
                                                            @else
                                                                <span class="btn btn-round btn-success">Approved</span>
                                                            @endif
                                                        </td>
                                                        <td><p>{{$List->comment}}</p></td>
                                                        <td>
                                                            @if($List->status == 1)
                                                                <a class="btn btn-success " data-toggle="modal" data-target="#approveRevision" data-id="{{$List->id}}"><i class="zmdi zmdi-check" style="color: #fff"></i></a>
                                                                 <a class="btn btn-danger " data-toggle="modal" data-target="#rejectRevision" data-id="{{$List->id}}"><i class="zmdi zmdi-close" style="color: #fff"></i></a>
                                                            @elseif($List->status == 0)
                                                                <span class="btn btn-round btn-danger">Rejected</span>
                                                            @else
                                                                <span class="btn btn-round btn-success">Unlocked</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>   
                                <div role="tabpanel" class="tab-pane" id="mumb">
                                   <div class="table-responsive">                                    
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length='250'>
                                            <thead>
                                                <tr>
                                                    <th>Sl.no</th>
                                                    <td>BS Number</td>
                                                    <th>Revision Requested By</th>                                                                                 
                                                    <th>Invoice Number</th>                                                                                 
                                                    <th>Reson For Revision</th>                                                                                 
                                                    <th>Revision Status</th>                                                                                 
                                                    <th>Revision Comment</th>   
                                                    <th>Action</th>                                                                              
                                                </tr>
                                            </thead>                                   
                                            <tbody>
                                                @forelse ($Mum_Signupsrevision as $key=>$List)
                                                    @php
                                                        $user = \App\User::find($List->user_id);                                                                          
                                                    @endphp
                                                    <tr>
                                                       <td>{{ $key+1 }}</td>    
                                                        <td>{{$List->bs_number}}</td>
                                                        <td>{{$user->first_name }} {{$user->last_name }}</td>
                                                        <td>
                                                            @if(is_null($List->invoice_no))
                                                                <p>No Invoice Number</p>
                                                            @else
                                                                <p>{{$List->invoice_no}}</p>
                                                            @endif
                                                        </td>
                                                        <td>{{$List->revision_reason}}</td>
                                                        <td>
                                                            @if($List->status == 1)
                                                                <span class="btn btn-round btn-warning">Pendding</span>
                                                            @elseif($List->status == 0)
                                                                <span class="btn btn-round btn-danger">Rejected</span>
                                                            @else
                                                                <span class="btn btn-round btn-success">Approved</span>
                                                            @endif
                                                        </td>
                                                        <td><p>{{$List->comment}}</p></td>
                                                        <td>
                                                            @if($List->status == 1)
                                                                <a class="btn btn-success " data-toggle="modal" data-target="#approveRevision" data-id="{{$List->id}}"><i class="zmdi zmdi-check" style="color: #fff"></i></a>
                                                                 <a class="btn btn-danger " data-toggle="modal" data-target="#rejectRevision" data-id="{{$List->id}}"><i class="zmdi zmdi-close" style="color: #fff"></i></a>
                                                            @elseif($List->status == 0)
                                                                <span class="btn btn-round btn-danger">Rejected</span>
                                                            @else
                                                                <span class="btn btn-round btn-success">Unlocked</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>   
                                <div role="tabpanel" class="tab-pane" id="del">
                                   <div class="table-responsive">                                    
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length='250'>
                                            <thead>
                                                <tr>
                                                    <th>Sl.no</th>
                                                    <td>BS Number</td>
                                                    <th>Revision Requested By</th>                                                                                 
                                                    <th>Invoice Number</th>                                                                                 
                                                    <th>Reson For Revision</th>                                                                                 
                                                    <th>Revision Status</th>                                                                                 
                                                    <th>Revision Comment</th>   
                                                    <th>Action</th>                                                                              
                                                </tr>
                                            </thead>                                   
                                            <tbody>
                                                @forelse ($Del_Signupsrevision as $key=>$List)
                                                    @php
                                                        $user = \App\User::find($List->user_id);                                                                          
                                                    @endphp
                                                    <tr>
                                                       <td>{{ $key+1 }}</td>    
                                                        <td>{{$List->bs_number}}</td>
                                                        <td>{{$user->first_name }} {{$user->last_name }}</td>
                                                        <td>
                                                            @if(is_null($List->invoice_no))
                                                                <p>No Invoice Number</p>
                                                            @else
                                                                <p>{{$List->invoice_no}}</p>
                                                            @endif
                                                        </td>
                                                        <td>{{$List->revision_reason}}</td>
                                                        <td>
                                                            @if($List->status == 1)
                                                                <span class="btn btn-round btn-warning">Pendding</span>
                                                            @elseif($List->status == 0)
                                                                <span class="btn btn-round btn-danger">Rejected</span>
                                                            @else
                                                                <span class="btn btn-round btn-success">Approved</span>
                                                            @endif
                                                        </td>
                                                        <td><p>{{$List->comment}}</p></td>
                                                        <td>
                                                            @if($List->status == 1)
                                                                <a class="btn btn-success " data-toggle="modal" data-target="#approveRevision" data-id="{{$List->id}}"><i class="zmdi zmdi-check" style="color: #fff"></i></a>
                                                                 <a class="btn btn-danger " data-toggle="modal" data-target="#rejectRevision" data-id="{{$List->id}}"><i class="zmdi zmdi-close" style="color: #fff"></i></a>
                                                            @elseif($List->status == 0)
                                                                <span class="btn btn-round btn-danger">Rejected</span>
                                                            @else
                                                                <span class="btn btn-round btn-success">Unlocked</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>    
                                <div role="tabpanel" class="tab-pane" id="hyd">
                                   <div class="table-responsive">                                    
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length='250'>
                                            <thead>
                                                <tr>
                                                    <th>Sl.no</th>
                                                    <td>BS Number</td>
                                                    <th>Revision Requested By</th>                                                                                 
                                                    <th>Invoice Number</th>                                                                                 
                                                    <th>Reson For Revision</th>                                                                                 
                                                    <th>Revision Status</th>                                                                                 
                                                    <th>Revision Comment</th>   
                                                    <th>Action</th>                                                                              
                                                </tr>
                                            </thead>                                   
                                            <tbody>
                                                @forelse ($Bang_Signupsrevision as $key=>$List)
                                                    @php
                                                        $user = \App\User::find($List->user_id);                                                                          
                                                    @endphp
                                                    <tr>
                                                       <td>{{ $key+1 }}</td>    
                                                        <td>{{$List->bs_number}}</td>
                                                        <td>{{$user->first_name }} {{$user->last_name }}</td>
                                                        <td>
                                                            @if(is_null($List->invoice_no))
                                                                <p>No Invoice Number</p>
                                                            @else
                                                                <p>{{$List->invoice_no}}</p>
                                                            @endif
                                                        </td>
                                                        <td>{{$List->revision_reason}}</td>
                                                        <td>
                                                            @if($List->status == 1)
                                                                <span class="btn btn-round btn-warning">Pendding</span>
                                                            @elseif($List->status == 0)
                                                                <span class="btn btn-round btn-danger">Rejected</span>
                                                            @else
                                                                <span class="btn btn-round btn-success">Approved</span>
                                                            @endif
                                                        </td>
                                                        <td><p>{{$List->comment}}</p></td>
                                                        <td>
                                                            @if($List->status == 1)
                                                                <a class="btn btn-success " data-toggle="modal" data-target="#approveRevision" data-id="{{$List->id}}"><i class="zmdi zmdi-check" style="color: #fff"></i></a>
                                                                 <a class="btn btn-danger " data-toggle="modal" data-target="#rejectRevision" data-id="{{$List->id}}"><i class="zmdi zmdi-close" style="color: #fff"></i></a>
                                                            @elseif($List->status == 0)
                                                                <span class="btn btn-round btn-danger">Rejected</span>
                                                            @else
                                                                <span class="btn btn-round btn-success">Unlocked</span>
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
        </div>
    </div>
</section>

<div class="modal fade" id="approveRevision" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h4 class="title" id="largeModalLabel">Revision Approve - <span class="heading"></span></h4>
            </div>
           <form method="post" action="{{route('admin.businessrevision')}}"  enctype="multipart/form-data" id="businessrevionapprovalform">
            @csrf
            <input type="hidden" name="revision_id" id="revision_id" value="">
            <input type="hidden" name="user_id" id="user_id" value="">
                <div class="modal-body"> 
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label for="email_address">Comments</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                    </div>
                                   <textarea rows="4" class="form-control no-resize" placeholder="Comments" name="comment"></textarea>
                                </div>
                            </div>                           
                        </div>                                                                                                                 
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger btn-round waves-effect" style="float: left" data-dismiss="modal">CLOSE</button>
                    <button type="submit" class="btn btn-success btn-round waves-effect">SAVE</button>               
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectRevision" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h4 class="title" id="largeModalLabel">Revision Reject - <span class="heading"></span></h4>
            </div>
           <form method="post" action="{{route('admin.reject_businessrevision')}}" enctype="multipart/form-data" id="businessrevionrejectform">
            @csrf
            <input type="hidden" name="revision_id" id="revision_id" value="">
            <input type="hidden" name="user_id" id="user_id" value="">
                <div class="modal-body"> 
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label for="email_address">Comments</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                    </div>
                                   <textarea rows="4" class="form-control no-resize" placeholder="Comments" name="comment"></textarea>
                                </div>
                            </div>                           
                        </div>                                                                                                                 
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger btn-round waves-effect" style="float: left" data-dismiss="modal">CLOSE</button>
                    <button type="submit" class="btn btn-success btn-round waves-effect">SAVE</button>               
                </div>
            </form>
        </div>
    </div>
</div>


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
<script>
    $(document).ready(function () {
        $('#approveRevision').on('show.bs.modal', function (event) {            
           var button = $(event.relatedTarget); 
           var heading = button.data('heading');
           var id = button.data('id');    
           var user_id = button.data('user_id');       
        
           var modal = $(this);
           modal.find('.heading').text(heading);
           modal.find('#revision_id').val(id);  
           modal.find('#user_id').val(user_id);  
        });

        $('#rejectRevision').on('show.bs.modal', function (event) {            
           var button = $(event.relatedTarget); 
           var heading = button.data('heading');
           var id = button.data('id');   
           var user_id = button.data('user_id');         
        
           var modal = $(this);
           modal.find('.heading').text(heading);
           modal.find('#revision_id').val(id);  
           modal.find('#user_id').val(user_id);
        });
    });

     $("#businessrevionapprovalform").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit 
     $("#businessrevionrejectform").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit 
</script>
{!! Toastr::message() !!}
</body>

@endsection