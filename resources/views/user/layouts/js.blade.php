@php
$User = Auth::user();
$Details = App\UserDetails::where('user_id','=',$User->id)->first();
@endphp
<!-- Jquery Core Js --> 
<script src="{{ asset('user/bundles/libscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js --> 
<script src="{{ asset('user/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js --> 
<script src="{{ asset('user/bundles/mainscript.bundle.js')}}"></script><!-- Custom Js -->
<script src="{{ asset('user/js/pages/toastr.min.js')}}"></script>
<script src="{{ asset('user/js/pages/sweetalert.min.js')}}"></script>
  