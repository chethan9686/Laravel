@if ($errors->has('passport_no'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('passport_no') }}</strong>
</span>
@endif
@if ($errors->has('issued_at'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('issued_at') }}</strong>
</span>
@endif
@if ($errors->has('issued_on'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('issued_on') }}</strong>
</span>
@endif
@if ($errors->has('expiry_on'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('expiry_on') }}</strong>
</span>
@endif
@if ($errors->has('acc_name'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('acc_name') }}</strong>
</span>
@endif
@if ($errors->has('acc_no'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('acc_no') }}</strong>
</span>
@endif
@if ($errors->has('bank_name'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('bank_name') }}</strong>
</span>
@endif
@if ($errors->has('bank_ifsc'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('bank_ifsc') }}</strong>
</span>
@endif
@if ($errors->has('bank_branch'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('bank_branch') }}</strong>
</span>
@endif
@if ($errors->has('bank_division'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('bank_division') }}</strong>
</span>
@endif
@if ($errors->has('ref1_name'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('ref1_name') }}</strong>
</span>
@endif
@if ($errors->has('ref1_company'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('ref1_company') }}</strong>
</span>
@endif
@if ($errors->has('ref1_phone'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('ref1_phone') }}</strong>
</span>
@endif
@if ($errors->has('ref1_email'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('ref1_email') }}</strong>
</span>
@endif

@if ($errors->has('ref2_name'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('ref2_name') }}</strong>
</span>
@endif

@if ($errors->has('ref2_company'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('ref2_company') }}</strong>
</span>
@endif

@if ($errors->has('ref2_phone'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('ref2_phone') }}</strong>
</span>
@endif
@if ($errors->has('ref2_email'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('ref2_email') }}</strong>
</span>
@endif