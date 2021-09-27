@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | Delhi Attendence</title>

@include('user.layouts.css')

<!-- JQuery DataTable Css -->
<link rel="stylesheet" href="{{ asset('user/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{asset('user/plugins/dropify/css/dropify.min.css')}}">

<style>   
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: .25rem;
        font-size: 90%;
        color: red;
    } 
     td , th{
    width: 1px;
    white-space: nowrap;
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
                    <h2>Delhi Attendence List</h2>
                    <ul class="breadcrumb">
                       <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active">Monthly Attendence</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>            
                </div>
            </div>
        </div>
        <div class="container-fluid" style="padding-right: 0px;padding-left: 0px">
             <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="card">  
                        <div class="header" style="padding-top: 0px;">
                            <button class="btn btn-info justify-content-center"><a style="color: white" onclick="tableToExcel('myTable', 'Delhi Attendance', 'Delhi Attendance.xls')">Download Delhi Attendance </a></button>
                            @if(!is_null($LastMonth))
                                <a href="{{route('previous_delh_attendence_list')}}"><button type="button" class="btn btn-primary" style="float: right;">{{$LastMonth}} Attendence</button></a>
                            @else
                                <a href="{{route('delh_attendence_list')}}"><button type="button" class="btn btn-primary" style="float: right;">{{$Current->format('F')}} Attendence</button></a>
                            @endif
                        </div>  
                        <div class="body">
                             <div class="table-responsive">                                    
                                <table class="table table-bordered table-hover js-exportable dataTable" id="myTable" data-page-length='250'>
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Sl No</th>
                                            <th style="text-align:center;">Employee Name</th>
                                            <th style="text-align:center;min-width:87px;">1</th>
                                            <th style="text-align:center;min-width:87px;">2</th>
                                            <th style="text-align:center;min-width:87px;">3</th>
                                            <th style="text-align:center;min-width:87px;">4</th>
                                            <th style="text-align:center;min-width:87px;">5</th>
                                            <th style="text-align:center;min-width:87px;">6</th>
                                            <th style="text-align:center;min-width:87px;">7</th>
                                            <th style="text-align:center;min-width:87px;">8</th>
                                            <th style="text-align:center;min-width:87px;">9</th>
                                            <th style="text-align:center;min-width:87px;">10</th>
                                            <th style="text-align:center;min-width:87px;">11</th>
                                            <th style="text-align:center;min-width:87px;">12</th>
                                            <th style="text-align:center;min-width:87px;">13</th>
                                            <th style="text-align:center;min-width:87px;">14</th>
                                            <th style="text-align:center;min-width:87px;">15</th>
                                            <th style="text-align:center;min-width:87px;">16</th>
                                            <th style="text-align:center;min-width:87px;">17</th>
                                            <th style="text-align:center;min-width:87px;">18</th>
                                            <th style="text-align:center;min-width:87px;">19</th>
                                            <th style="text-align:center;min-width:87px;">20</th>
                                            <th style="text-align:center;min-width:87px;">21</th>
                                            <th style="text-align:center;min-width:87px;">22</th>
                                            <th style="text-align:center;min-width:87px;">23</th>
                                            <th style="text-align:center;min-width:87px;">24</th>
                                            <th style="text-align:center;min-width:87px;">25</th>
                                            <th <?php if (false !== $key = array_search(26, $calendar)) { }else{?> style="display: none" <?php } ?> style="text-align:center;min-width:87px;">26</th>
                                            <th <?php if (false !== $key = array_search(27, $calendar)) { }else{?> style="display: none" <?php } ?> style="text-align:center;min-width:87px;">27</th>
                                            <th <?php if (false !== $key = array_search(28, $calendar)) { }else{?> style="display: none" <?php } ?> style="text-align:center;min-width:87px;">28</th>
                                            <th <?php if (false !== $key = array_search(29, $calendar)) { }else{?> style="display: none" <?php } ?> style="text-align:center;min-width:87px;">29</th>
                                            <th <?php if (false !== $key = array_search(30, $calendar)) { }else{?> style="display: none" <?php } ?> style="text-align:center;min-width:87px;">30</th>
                                            <th <?php if (false !== $key = array_search(31, $calendar)) { }else{?> style="display: none" <?php } ?> style="text-align:center;min-width:87px;">31</th>
                                            <th style="text-align:center;">Present</th>
                                            <th style="text-align:center;">Meeting</th>
                                            <th style="text-align:center;">Event</th>
                                            <th style="text-align:center;">Outstation</th>
                                            <th style="text-align:center;">Comp Off</th>
                                            <th style="text-align:center;">Paid Leaves</th>
                                            <th style="text-align:center;">Cut Leaves</th>
                                            <th style="text-align:center;">Working Days</th>
                                        </tr>
                                    </thead>                                   
                                    <tbody>
                                        @foreach($users as $key=>$user)                                                                             
                                            <tr>
                                                <td style="text-align:center;">{{$key+1}}</td>
                                                <td>{{$user->emp_name}}</td>
                                                <td class="column_name {{$user->one}}" data-id="{{$user->id}}" data-column_name="one" contenteditable>{{$user->one}}</td>
                                                <td class="column_name {{$user->two}}" data-id="{{$user->id}}" data-column_name="two" contenteditable>{{$user->two}}</td>
                                                <td class="column_name {{$user->three}}" data-id="{{$user->id}}" data-column_name="three" contenteditable>{{$user->three}}</td>
                                                <td class="column_name {{$user->four}}" data-id="{{$user->id}}" data-column_name="four" contenteditable>{{$user->four}}</td>
                                                <td class="column_name {{$user->five}}" data-id="{{$user->id}}" data-column_name="five" contenteditable>{{$user->five}}</td>
                                                <td class="column_name {{$user->six}}" data-id="{{$user->id}}" data-column_name="six" contenteditable>{{$user->six}}</td>
                                                <td class="column_name {{$user->seven}}" data-id="{{$user->id}}" data-column_name="seven" contenteditable>{{$user->seven}}</td>
                                                <td class="column_name {{$user->eight}}" data-id="{{$user->id}}" data-column_name="eight" contenteditable>{{$user->eight}}</td>
                                                <td class="column_name {{$user->nine}}" data-id="{{$user->id}}" data-column_name="nine" contenteditable>{{$user->nine}}</td>
                                                <td class="column_name {{$user->ten}}" data-id="{{$user->id}}" data-column_name="ten" contenteditable>{{$user->ten}}</td>
                                                <td class="column_name {{$user->eleven}}" data-id="{{$user->id}}" data-column_name="eleven" contenteditable>{{$user->eleven}}</td>
                                                <td class="column_name {{$user->twelve}}" data-id="{{$user->id}}" data-column_name="twelve" contenteditable>{{$user->twelve}}</td>
                                                <td class="column_name {{$user->thirteen}}" data-id="{{$user->id}}" data-column_name="thirteen" contenteditable>{{$user->thirteen}}</td>
                                                <td class="column_name {{$user->fourteen}}" data-id="{{$user->id}}" data-column_name="fourteen" contenteditable>{{$user->fourteen}}</td>
                                                <td class="column_name {{$user->fifteen}}" data-id="{{$user->id}}" data-column_name="fifteen" contenteditable>{{$user->fifteen}}</td>
                                                <td class="column_name {{$user->sixteen}}" data-id="{{$user->id}}" data-column_name="sixteen" contenteditable>{{$user->sixteen}}</td>
                                                <td class="column_name {{$user->seventeen}}" data-id="{{$user->id}}" data-column_name="seventeen" contenteditable>{{$user->seventeen}}</td>
                                                <td class="column_name {{$user->eighteen}}" data-id="{{$user->id}}" data-column_name="eighteen" contenteditable>{{$user->eighteen}}</td>
                                                <td class="column_name {{$user->nineteen}}" data-id="{{$user->id}}" data-column_name="nineteen" contenteditable>{{$user->nineteen}}</td>
                                                <td class="column_name {{$user->twenty}}" data-id="{{$user->id}}" data-column_name="twenty" contenteditable>{{$user->twenty}}</td>
                                                <td class="column_name {{$user->twentyone}}" data-id="{{$user->id}}" data-column_name="twentyone" contenteditable>{{$user->twentyone}}</td>
                                                <td class="column_name {{$user->twentytwo}}" data-id="{{$user->id}}" data-column_name="twentytwo" contenteditable>{{$user->twentytwo}}</td>
                                                <td class="column_name {{$user->twentythree}}" data-id="{{$user->id}}" data-column_name="twentythree" contenteditable>{{$user->twentythree}}</td>
                                                <td class="column_name {{$user->twentyfour}}" data-id="{{$user->id}}" data-column_name="twentyfour" contenteditable>{{$user->twentyfour}}</td>
                                                <td class="column_name {{$user->twentyfive}}" data-id="{{$user->id}}" data-column_name="twentyfive" contenteditable>{{$user->twentyfive}}</td>
                                                <td <?php if (false !== $key = array_search(26, $calendar)) { }else{?> style="display: none" <?php } ?> class="column_name {{$user->twentysix}}" data-id="{{$user->id}}" data-column_name="twentysix" contenteditable>{{$user->twentysix}}</td>
                                                <td <?php if (false !== $key = array_search(27, $calendar)) { }else{?> style="display: none" <?php } ?> class="column_name {{$user->twentyseven}}" data-id="{{$user->id}}" data-column_name="twentyseven" contenteditable>{{$user->twentyseven}}</td>
                                                <td <?php if (false !== $key = array_search(28, $calendar)) { }else{?> style="display: none" <?php } ?> class="column_name {{$user->twentyeight}}" data-id="{{$user->id}}" data-column_name="twentyeight" contenteditable>{{$user->twentyeight}}</td>
                                                <td <?php if (false !== $key = array_search(29, $calendar)) { }else{?> style="display: none" <?php } ?> class="column_name {{$user->twentynine}}" data-id="{{$user->id}}" data-column_name="twentynine" contenteditable>{{$user->twentynine}}</td>
                                                <td <?php if (false !== $key = array_search(30, $calendar)) { }else{?> style="display: none" <?php } ?> class="column_name {{$user->thirty}}" data-id="{{$user->id}}" data-column_name="thirty" contenteditable>{{$user->thirty}}</td>
                                                <td  <?php if (false !== $key = array_search(31, $calendar)) { }else{?> style="display: none" <?php } ?> class="column_name {{$user->thirtyone}}" data-id="{{$user->id}}" data-column_name="thirtyone" contenteditable>{{$user->thirtyone}}</td>
                                                <td class="Present" style="text-align:center;">{{$user->present}}</td>
                                                <td class="Meeting" style="text-align:center;">{{$user->meeting}}</td>
                                                <td class="Event" style="text-align:center;">{{$user->event}}</td>
                                                <td class="Outstation" style="text-align:center;">{{$user->outstation}}</td>
                                                <td class="Comp" style="text-align:center;">{{$user->comp}}</td>
                                                <td class="Paid" style="text-align:center;">{{$user->paid_leave}}</td>
                                                <td class="Cut" style="text-align:center;">{{$user->cut_leave}}</td>
                                                <td class="Working" style="text-align:center;">{{$user->working}}</td>
                                            </tr>
                                        @endforeach                                                                                                                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="text-align:center;">Sl No</th>
                                            <th style="text-align:center;">Employee Name</th>
                                            <th style="text-align:center;min-width:87px;">1</th>
                                            <th style="text-align:center;min-width:87px;">2</th>
                                            <th style="text-align:center;min-width:87px;">3</th>
                                            <th style="text-align:center;min-width:87px;">4</th>
                                            <th style="text-align:center;min-width:87px;">5</th>
                                            <th style="text-align:center;min-width:87px;">6</th>
                                            <th style="text-align:center;min-width:87px;">7</th>
                                            <th style="text-align:center;min-width:87px;">8</th>
                                            <th style="text-align:center;min-width:87px;">9</th>
                                            <th style="text-align:center;min-width:87px;">10</th>
                                            <th style="text-align:center;min-width:87px;">11</th>
                                            <th style="text-align:center;min-width:87px;">12</th>
                                            <th style="text-align:center;min-width:87px;">13</th>
                                            <th style="text-align:center;min-width:87px;">14</th>
                                            <th style="text-align:center;min-width:87px;">15</th>
                                            <th style="text-align:center;min-width:87px;">16</th>
                                            <th style="text-align:center;min-width:87px;">17</th>
                                            <th style="text-align:center;min-width:87px;">18</th>
                                            <th style="text-align:center;min-width:87px;">19</th>
                                            <th style="text-align:center;min-width:87px;">20</th>
                                            <th style="text-align:center;min-width:87px;">21</th>
                                            <th style="text-align:center;min-width:87px;">22</th>
                                            <th style="text-align:center;min-width:87px;">23</th>
                                            <th style="text-align:center;min-width:87px;">24</th>
                                            <th style="text-align:center;min-width:87px;">25</th>
                                            <th <?php if (false !== $key = array_search(26, $calendar)) { }else{?> style="display: none" <?php } ?> style="text-align:center;min-width:87px;">26</th>
                                            <th <?php if (false !== $key = array_search(27, $calendar)) { }else{?> style="display: none" <?php } ?> style="text-align:center;min-width:87px;">27</th>
                                            <th <?php if (false !== $key = array_search(28, $calendar)) { }else{?> style="display: none" <?php } ?> style="text-align:center;min-width:87px;">28</th>
                                            <th <?php if (false !== $key = array_search(29, $calendar)) { }else{?> style="display: none" <?php } ?> style="text-align:center;min-width:87px;">29</th>
                                            <th <?php if (false !== $key = array_search(30, $calendar)) { }else{?> style="display: none" <?php } ?> style="text-align:center;min-width:87px;">30</th>
                                            <th <?php if (false !== $key = array_search(31, $calendar)) { }else{?> style="display: none" <?php } ?> style="text-align:center;min-width:87px;">31</th>
                                            <th style="text-align:center;">Present</th>
                                            <th style="text-align:center;">Meeting</th>
                                            <th style="text-align:center;">Event</th>
                                            <th style="text-align:center;">Outstation</th>
                                            <th style="text-align:center;">Comp Off</th>
                                            <th style="text-align:center;">Paid Leaves</th>
                                            <th style="text-align:center;">Cut Leaves</th>
                                            <th style="text-align:center;">Working Days</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</section>


@include('user.layouts.js')
<script src="{{asset('user/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('user/js/pages/forms/dropify.js')}}"></script>
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>
<!-- Jquery DataTable Plugin Js --> 
<script src="{{asset('user/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script>
    $('td.P').css({"background-color":"green","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.AB').css({"background-color":"red","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.L').css({"background-color":"#90ee90","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.LC').css({"background-color":"orange","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.HD').css({"background-color":"#00f","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.FDL').css({"background-color":"#00f","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.NFDL').css({"background-color":"#e47297","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.RFDL').css({"background-color":"#f00","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.OS').css({"background-color":"#795548","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.NOS').css({"background-color":"#e47297","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.ROS').css({"background-color":"#f00","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.M').css({"background-color":"#65c565","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.E').css({"background-color":"#800080","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.FDCO').css({"background-color":"#222","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.NFDCO').css({"background-color":"#e47297","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.RFDCO').css({"background-color":"#f00","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.HDCO').css({"background-color":"#222","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.NHDCO').css({"background-color":"#e47297","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.RHDCO').css({"background-color":"#f00","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.ABM').css({"background-color":"#f00","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.H').css({"background-color":"#ffa500","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.SUN').css({"background-color":"#ffa500","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.HDL').css({"background-color":"#00f","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.NHDL').css({"background-color":"#e47297","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.NHD').css({"background-color":"#f00","color":"#fff","text-align":"center","min-width":"87px"});
    $('td.NJ').css({"background-color":"#189bd8","color":"#fff","text-align":"center","min-width":"87px"});
</script>
<script>
function tableToExcel(table, name, filename) {
        let uri = 'data:application/vnd.ms-excel;base64,', 
        template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><title></title><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>', 
        base64 = function(s) { return window.btoa(decodeURIComponent(encodeURIComponent(s))) },         format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; })}
        
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}

        var link = document.createElement('a');
        link.download = filename;
        link.href = uri + base64(format(template, ctx));
        link.click();
}
</script>
<script type="text/javascript">
    $(function () {
               //Exportable table
        $('.js-exportable').DataTable();
    });

    var _token = $('input[name="_token"]').val();
    $(document).on('blur', '.column_name', function(){
        var column_name = $(this).data("column_name");    
        var column_value = $(this).text();        
        var id = $(this).data("id");
        swal({
                title: "Are you sure!",
                type: "warning",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes Update it!",
                text: "You Will Be Updating Attendence Of An Employee!",
                showCancelButton: true,
            },
            function() {                
            $.ajax({
                url:"{{ route('delh_update_attendence') }}",
                method:"POST",
                dataType: "json",
                data:{column_name:column_name,column_value:column_value,id:id, _token:_token},
                success:function(data)
                {         
                    swal("You Have Successfully Updated For "+data.emp_name,"Attendence of "+data.column+" day","success", {  });
                }
            })
        });
    });
         
     
</script>

{!! Toastr::message() !!}
</body>
@endsection