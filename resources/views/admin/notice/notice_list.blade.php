@extends('admin.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title> HRM | Notice Board</title>

@include('admin.layouts.css')

<link rel="stylesheet" href="{{asset('admin/plugins/footable-bootstrap/css/footable.bootstrap.min.css')}}">
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('admin/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<!-- Bootstrap Tagsinput Css -->
<link rel="stylesheet" href="{{asset('admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">

<link rel="stylesheet" href="{{asset('admin/plugins/footable-bootstrap/css/footable.standalone.min.css')}}">

<link rel="stylesheet" href="{{asset('admin/plugins/summernote/dist/summernote.css')}}">

<!-- Select2 -->
<link rel="stylesheet" href="{{asset('admin/plugins/select2/select2.css')}}" />
 
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
    .select2-container-multi .select2-choices{
        background-image: none!important; 
    }
    .select2-container-multi .select2-choices .select2-search-field input{
        padding:0px !important;
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
                    <h2>Notice</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Notice Baord</li>
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
                                    <h2>Add<strong> Notice </strong></h2>
                                </div>   
                                <form method="post" action="{{route('admin.add_notice')}}">
                                @csrf 
                                    <div class="body">                       
                                        <label for="email_address">Title</label>
                                        <div class="form-group">                                
                                           <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Notice Title" name="title">
                                            </div>
                                             @if ($errors->has('title'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                            @endif  
                                        </div>

                                        <label for="email_address">Branch</label>
                                        <div class="form-group">                                
                                             <select  class="form-control show-tick ms select2" multiple data-placeholder="Select Branch" name="branch[]">
                                                    <option value="">Branch Name</option>       
                                                @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}">{{$branch->name}}</option>                                   
                                                @endforeach
                                            </select>                                            
                                            @if ($errors->has('branch'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('branch') }}</strong>
                                                </span>
                                            @endif  
                                        </div> 

                                        <label for="email_address">Description </label>
                                        <div class="form-group">
                                            <textarea class="summernote form-control" name="description"></textarea>     
                                            @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
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
                                    <h2><strong> Notice </strong>List</h2>
                                </div>                         
                                <div class="body">
                                    <div class="table-responsive">
                                        <table class="table table-striped m-b-0" id="notice_delete">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-breakpoints="xs">Notice Title</th>                                                                          
                                                <th>Edit</th>
                                                <th>Delete</th>
                                                <th>View</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($notices as $key => $notice)      
                                                @php
                                                $EncryptedID = \Illuminate\Support\Facades\Crypt::encrypt($notice->id); 
                                                @endphp                                         
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$notice->title}}</td>                                                   
                                                    <td>
                                                       <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#editModal{{$notice->id}}"><i class="zmdi zmdi-edit"></i></button>
                                                    </td> 
                                                    <td>
                                                        <button class="btn btn-danger btn-round delete" data-id="{{$notice->id}}"><i class="zmdi zmdi-delete"></i></button>
                                                    </td>     
                                                    <td>
                                                       <a href="{{route('admin.view_notice',[ 'EncryptedID' => $EncryptedID ])}}"> <button class="btn btn-success btn-round"><i class="zmdi zmdi-eye"></i></button></a>
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

@foreach($notices as $notice)
<!--Modal -->
 <?php
    $data = explode('|',$notice->branch);
    $res=array();

    foreach($data as $p)
    {
        $nt = \App\Branch::find($p);
        array_push($res,$nt->name);   
    }
    $r = $res;   
?>
    <div class="modal fade" id="editModal{{$notice->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit Notice   </h4>
                </div>
               <form method="post" action="{{route('admin.edit_notice')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="notice_id" value="{{$notice->id}}">
                    <div class="modal-body">     

                        <label for="email_address">Title</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                </div>
                               <input type="text" class="form-control" placeholder="Title" name="edit_title" value="{{$notice->title}}">
                            </div>
                        </div>         
                    
                        <label for="email_address">Branch </label><input type="text" data-role="tagsinput" value="{{implode(',',$r)}}">
                        <div class="form-group">                                                                                                                  
                           <select  class="form-control show-tick ms select2" multiple data-placeholder="{{implode(',',$r)}}" name="edit_branch[]">
                                    <option value="">Branch Name</option>       
                                @foreach($branches as $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>                                   
                                @endforeach                               
                            </select>                         
                        </div>                           
                   
                        <label for="email_address">Description</label>
                        <div class="form-group">
                             <textarea class="summernote form-control" name="edit_description">{!! $notice->description !!}</textarea> 
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

<script src="{{asset('admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script> <!-- Bootstrap Tags Input Plugin Js --> 

<script src="{{asset('admin/plugins/select2/select2.min.js')}}"></script> <!-- Select2 Js -->

<script src="{{asset('admin/js/pages/forms/advanced-form-elements.js')}}"></script> 

<script src="{{asset('admin/plugins/summernote/dist/summernote.js')}}"></script>

<script type="application/javascript">    
    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        swal({
                title: "Are you sure!",
                type: "warning",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes Delete it!",
                text: "You Will Be Deleting Notice Details!",
                showCancelButton: true,
            },
            function() {
                $.ajax({
                    url: '{{ route('admin.delete_notice') }}',
                    type: "POST",
                    dataType: "json",
                    data: {"_token": "{{ csrf_token() }}","id" : id},
                    success: function (data) {
                                    $("#notice_delete").load(" #notice_delete");
                                    if(data == "Success"){
                                    swal({
                                        title: "Success!",
                                        text: "You Have Successfully Deleted Notice Details!.",
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
   