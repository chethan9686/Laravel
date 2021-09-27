<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Wings</title>
    <style type="text/css">
        @media only screen and (max-width: 795px) {
            img {
                max-width: 100% !important;
                height: auto !important;
            }

            *[class="mobile-column"], .mobile-column {
                display: block;
            }

            *[class="mob-column"], .mob-column {
                float: none !important;
                width: 100% !important;
            }

            *[class="hide"], .hide {
                display: none !important;
            }

            *[class="condensed"], .condensed {
                padding-bottom: 40px !important;
                display: block;
            }

            *[class="center"], .center {
                text-align: center !important;
                width: 100% !important;
                height: auto !important;
            }

            *[class="100pad"] {
                width: 100% !important;
                padding: 20px;
            }

            *[class="100padleftright"] {
                width: 100% !important;
                padding: 0 20px 0 20px;
            }

            *[class="100padtopbottom"] {
                width: 100% !important;
                padding: 20px 0 20px 0;
            }

            *[class="hr"], .hr {
                width: 100% !important;
            }

            *[class="p10"], .p10 {
                width: 10% !important;
                height: auto !important;
            }
            *[class="p20"], .p20 {
                width: 20% !important;
                height: auto !important;
            }
            *[class="p30"], .p30 {
                width: 30% !important;
                height: auto !important;
            }
            *[class="p40"], .p40 {
                width: 40% !important;
                height: auto !important;
            }
            *[class="p50"], .p50 {
                width: 50% !important;
                height: auto !important;
            }
            *[class="p60"], .p60 {
                width: 60% !important;
                height: auto !important;
            }
            *[class="p70"], .p70 {
                width: 70% !important;
                height: auto !important;
            }
            *[class="p80"], .p80 {
                width: 80% !important;
                height: auto !important;
            }
            *[class="p90"], .p90 {
                width: 90% !important;
                height: auto !important;
            }
            *[class="p100"], .p100 {
                width: 100% !important;
                height: auto !important;
            }
            *[class="p15"], .p15 {
                width: 15% !important;
                height: auto !important;
            }
            *[class="p25"], .p25 {
                width: 25% !important;
                height: auto !important;
            }
            *[class="p33"], .p33 {
                width: 33% !important;
                height: auto !important;
            }
            *[class="p35"], .p35 {
                width: 35% !important;
                height: auto !important;
            }
            *[class="p45"], .p45 {
                width: 45% !important;
                height: auto !important;
            }
            *[class="p55"], .p55 {
                width: 55% !important;
                height: auto !important;
            }
            *[class="p65"], .p65 {
                width: 65% !important;
                height: auto !important;
            }
            *[class="p75"], .p75 {
                width: 75% !important;
                height: auto !important;
            }
            *[class="p85"], .p85 {
                width: 85% !important;
                height: auto !important;
            }
            *[class="p95"], .p95 {
                width: 95% !important;
                height: auto !important;
            }
            *[class="alignleft"] {
                text-align: left !important;
            }
            *[class="100button"] {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 450px) {
            *[class="xs-no-pad"], .xs-no-pad {
                padding: 0 !important;
            }

            *[class="xs-p25"], .xs-p25 {
                width: 25% !important;
                height: auto !important;
            }
            *[class="xs-p50"], .xs-p50 {
                width: 50% !important;
                height: auto !important;
            }
            *[class="xs-p75"], .xs-p75 {
                width: 75% !important;
                height: auto !important;
            }
            *[class="xs-p100"], .xs-p100 {
                width: 100% !important;
                height: auto !important;
            }

            *[class="xs-hide"], .xs-hide {
                display: none !important;
            }
        }
        p{
            color:#222 !important;
            font-family: arial, sans-serif !important;
            font-size:16px !important;
        }
        td{
            color:#222 !important;
            font-family: arial, sans-serif !important;
            font-size:16px !important;
        }
        body{
            font-family: arial, sans-serif !important;
        }
            
    </style>
</head>

<body style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #fff;margin: 0;padding: 0;width: 100% !important;">
@php
    $User = App\User::find($Meeting->user_id);
    $today = \Carbon\Carbon::today();
@endphp
<!--Banner Start-->
<table style="background-color: #fff;margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 100%;border-collapse: collapse;color: inherit;font-size: 16px; font-family: arial, sans-serif;" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" width="100%" mc:repeatable="section" mc:variant="section 2 - Banner">
    <tr>
        <td align="center" valign="top" style="border-collapse: collapse;">
            <table background="{{ url(asset('user-asset/images/bg.jpg')) }}" class="p100" style="background-color: white;background-position: center center;background-size: cover;margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 800px;border-collapse: collapse;color: inherit;font-size: 16px; font-family: arial, sans-serif;" width="800" cellspacing="0" cellpadding="0" border="0" align="center">
                <tr>
                    <td style="background-color: rgba(0, 0, 0, 0);border-collapse: collapse;" align="center" valign="top" bgcolor="#3F3E46">
                        <table class="p90" style="margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 600px;border-collapse: collapse;color: inherit;font-size: 16px; font-family: arial, sans-serif;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse;">
                                    <table class="p100" style="border-bottom: 1px solid #6F6E76;margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 600px;border-collapse: collapse;color: inherit;font-size: 16px; font-family: arial, sans-serif;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                                        <tr>
                                            <td valign="top" align="left" style="border-collapse: collapse;">
                                              <table cellpadding="0" cellspacing="0" border="0" class="m_8326558966892935426message_footer_table" align="center" style="border-collapse:collapse;color:#545454;font-family: arial, sans-serif;font-size:16px;line-height:20px;margin:0 auto;max-width:100%;width:100%">
                                                <tbody>
                                                  <tr>
                                                    <td style="padding:0 20px;text-align:center;height:90px">
                                                      <img src="{{asset('logo_wingsevents.png')}}" style="vertical-align:middle" class="CToWUd">
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td valign="top">
                                                    <table class="p100" style="background-color: #150f13; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#150f13">
                                                      <tbody><tr>
                                                      <td style="font-size: 1px; height: 9px; line-height: 9px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                                      </tr>
                                                      <tr>
                                                          <td style="font-weight: 700; letter-spacing: 0.03em; line-height: 23px; cursor: pointer;width: 600px;" align="center" valign="top" class="editable_text header3"><span style="color:#fff !important;font-family: arial, sans-serif;font-size:16px;">Meeting - {{$Meeting->meeting_status}}</span>
                                                          </td>
                                                        </tr>
                                                      <tr>
                                                      <td style="font-size: 1px; height: 9px; line-height: 9px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                                      </tr>
                                                    </tbody></table>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!--Banner End-->

<!--Table Start-->
<table style="background-color: #fff;margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 100%;border-collapse: collapse;color: inherit;font-size: 16px; font-family: arial, sans-serif;" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" width="100%" mc:repeatable="section" mc:variant="section 3 - Table">
    <tr>
        <td align="center" valign="top" style="border-collapse: collapse;">
            <table class="p100" style="background-color: #fff;margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 800px;border-collapse: collapse;color: inherit;font-size: 16px; font-family: arial, sans-serif;" width="800" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff">
                <tr>
                    <td style="width: 30px;font-size: 1px;border-collapse: collapse;" width="30" valign="top" align="left">&nbsp;</td>
                    <td align="center" valign="top" style="border-collapse: collapse;">
                        <table class="p100" style="margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 600px;border-collapse: collapse;color: inherit;font-size: 16px; font-family: arial, sans-serif;" width="600" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse;">
                                    <table class="p100" style="margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 500px;border-collapse: collapse;color: inherit;font-size: 16px;font-family: arial, sans-serif;" width="400" cellspacing="0" cellpadding="0" border="0" align="center">
                                        <tr>
                                            <td style="font-size: 1px;height: 10px;line-height: 10px;mso-line-height-rule: exactly;border-collapse: collapse;" valign="top" align="left">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td style="font-size: 1px; height: 30px; line-height: 30px; mso-line-height-rule: exactly;" valign="top" align="center">&nbsp;</td>
                                        </tr>
                                        <tr>
                                        <div style="font-size: 16px;height:13px;float:right;"><b>Date :</b> {{$today->format('d-m-Y')}}</div>
                                        <tr>
                                          <td style="font-size: 1px; height: 30px; line-height: 30px; mso-line-height-rule: exactly;" valign="top" align="center">&nbsp;</td>
                                        </tr>
                                        <p style="font-size: 16px;text-align:justify;color: #222;font-family: arial, sans-serif;"><span style="font-weight:bold">Dear Sir/Madam,</span></p><span class="im">
                                        <p style="font-size: 16px;text-align:justify;font-family: arial, sans-serif;">Please find below meeting status!</p>
                                        </tr>
                                        <tr>
                                            <td style="width: 500px;border-collapse: collapse;" width="500" align="center" valign="top">
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="500" style="font-family: arial, sans-serif;border-collapse: collapse;width: 100%;color: inherit;font-size: 18px;">
                                                    <tr>
                                                        <td style="border: 1px solid #bbb8b8;color:#222;width: 200px;padding: 10px 20px 10px 20px;border-collapse: collapse;">Company Name</td>
                                                        <td style="color:#222;border: 1px solid #bbb8b8;padding: 10px 20px 10px 20px;border-collapse: collapse;">{{$Meeting->company_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #bbb8b8;color:#222;width: 200px;padding: 10px 20px 10px 20px;border-collapse: collapse;">Client Name</td>
                                                        <td style="color:#222;border: 1px solid #bbb8b8;padding: 10px 20px 10px 20px;border-collapse: collapse;">{{$Meeting->client_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 10px 20px 10px 20px;border: 1px solid #bbb8b8;color:#222;width: 200px;border-collapse: collapse;">Date of Meeting</td>
                                                        <td style="padding: 10px 20px 10px 20px;border: 1px solid #bbb8b8;color:#222;border-collapse: collapse;"><?php echo date("d-m-Y",strtotime($Meeting->date)) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 10px 20px 10px 20px;border: 1px solid #bbb8b8;color:#222;width: 200px;border-collapse: collapse;">Time of Meeting</td>
                                                        <td style="padding: 10px 20px 10px 20px;border: 1px solid #bbb8b8;color:#222;border-collapse: collapse;"><?php echo date("h:i a",strtotime($Meeting->time)) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #bbb8b8;color:#222;width: 200px;padding: 10px 20px 10px 20px;border-collapse: collapse;">Meeting Status</td>
                                                        <td style="color: #0c7ce6;border: 1px solid #bbb8b8;padding: 10px 20px 10px 20px;border-collapse: collapse;"><b>{{$Meeting->meeting_status}}<b></td>
                                                    </tr> 
                                                    <tr>
                                                        <td style="border: 1px solid #bbb8b8;color:#222;width: 200px;padding: 10px 20px 10px 20px;border-collapse: collapse;">Reason</td>
                                                        <td style="color:#222;border: 1px solid #bbb8b8;padding: 10px 20px 10px 20px;border-collapse: collapse;">{{$Meeting->reason}}</td>
                                                    </tr>                                                
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 30px;font-size: 1px;border-collapse: collapse;" width="30" valign="top" align="left">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="font-size: 1px;height: 30px;line-height: 30px;mso-line-height-rule: exactly;border-collapse: collapse;" valign="top" align="left">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!--Table End-->


               
<!--Footer Start-->
<table style="background-color: #fff;margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 100%;border-collapse: collapse;color: inherit;font-size: 16px; font-family: arial, sans-serif;border-to:2px solid red;;" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" width="100%" mc:repeatable="section" mc:variant="section 26 - footer">
    <tr>
        <td align="center" valign="top" style="border-collapse: collapse;">
            <table class="p100" style="background-color: #fff;margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 800px;border-collapse: collapse;color: inherit;font-size: 16px; font-family: arial, sans-serif;" width="800" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff">
                <tr>
                    <td align="center" valign="top" style="border-collapse: collapse;">
                        <table class="p100" style="margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 600px;border-collapse: collapse;color: inherit;font-size: 16px; font-family: arial, sans-serif;" width="600" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td style="width: 30px;font-size: 1px;border-collapse: collapse;" width="30" valign="top" align="left">&nbsp;</td>
                                <td align="center" valign="top" style="border-collapse: collapse;">                                   
                                    <table style="margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;border-collapse: collapse;color: inherit;font-size: 16px; font-family: arial, sans-serif;" cellspacing="0" cellpadding="0" border="0" align="center">
                                         <p style="font-size: 16px;text-align:justify;color: #222222;"><b>Regards,<br></b></p>
                                            <hr style="border:1px solid #dddddd;">
                                            <tr>
                                            <td align="left" valign="top" style="border-collapse: collapse;">
                                                <table style="margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;border-collapse: collapse;color: inherit;font-size: 16px; font-family: arial, sans-serif;" cellspacing="0" cellpadding="0" border="0" align="center">
                                                    <tr>
                                                        @if($UserDetails->signature == "user/signature/default.jpg")
                                                        <td>
                                                            <p style="font-size: 16px;text-align:justify;"><font face="'Open Sans', sans-serif"><b style="color:#222">{{$User->first_name}} {{$User->last_name}}</b></font></p>
                                                        </td>
                                                        @else
                                                         <td>
                                                           <img src="{{asset('public/'.$UserDetails->signature)}}">
                                                        </td>
                                                        @endif
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 1px;height: 10px;line-height: 10px;mso-line-height-rule: exactly;border-collapse: collapse;" valign="top" align="left">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #222;font-size: 15px;text-align: center;border-collapse: collapse;" valign="top" align="left" mc:edit="s26 text2_1">
                                                <multiline><span style="font-family: arial, sans-serif;font-size:16px !important;">© {{$today->format('Y')}} Wings Events. All Rights Reserved | Powered by <a href="https://wingsevents.com/" target="_blank">Wings Events</a></span>
                                                </multiline>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 1px;height: 30px;line-height: 30px;mso-line-height-rule: exactly;border-collapse: collapse;" valign="top" align="left">&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 20px;font-size: 1px;border-collapse: collapse;" width="20" valign="top" align="left">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!--Footer End-->


</body>

</html>