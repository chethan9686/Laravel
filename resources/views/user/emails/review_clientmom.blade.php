<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8"> 
    <meta charset="UTF-8">
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
            } table {
  table-layout: auto;
}

td {
  overflow: hidden;
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
            table {
  table-layout: auto;
}

td {
  overflow: hidden;
}
        }
        table{
    table-layout:auto; /* same width will be applied to both the tables*/
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
 .note-editable { 
        font-family: arial, sans-serif !important;
        font-size:16px !important;
        color:#222 !important; 
    }
    </style>
</head>

<body style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #fff;margin: 0;padding: 0;width: 100% !important;">
@php
    $User = App\User::find($Client->user_id);
     $today = \Carbon\Carbon::today();
  @endphp
<!--Banner Start-->
<table style="background-color: #fff;margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 100%;border-collapse: collapse;color: inherit;font-size: inherit;font-family: arial, sans-serif !important;" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" width="100%" mc:repeatable="section" mc:variant="section 2 - Banner">
    <tr>
        <td align="center" valign="top" style="border-collapse: collapse;">
            <table background="{{ url(asset('user-asset/images/bg.jpg')) }}" class="p100" style="border:2px solid #f5f5f5;border-bottom: 1px solid #fff;background-color: white;background-position: center center;background-size: cover;margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 800px;border-collapse: collapse;color: inherit;font-size: inherit;font-family: arial, sans-serif !important;" width="800" cellspacing="0" cellpadding="0" border="0" align="center">
                <tr>
                    <td style="background-color: rgba(0, 0, 0, 0);border-collapse: collapse;" align="center" valign="top">
                        <table class="p90" style="margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 800px;border-collapse: collapse;color: inherit;font-size: inherit;font-family: arial, sans-serif !important;" width="800" cellspacing="0" cellpadding="0" border="0" align="center">
                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse;">
                                    <table class="p100" style="border-bottom: 1px solid #6F6E76;margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 800px;border-collapse: collapse;color: inherit;font-size: inherit;font-family: arial, sans-serif !important;" width="800" cellspacing="0" cellpadding="0" border="0" align="center">
                                        <tr>
                                            <td valign="top" align="left" style="border-collapse: collapse;">
                                              <table cellpadding="0" cellspacing="0" border="0" class="m_8326558966892935426message_footer_table" align="center" style="border-collapse:collapse;color:#545454;font-family:'Helvetica Neue',Arial,sans-serif;font-size:13px;line-height:20px;margin:0 auto;max-width:100%;width:100%">
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
                                                      <td style="font-family: arial, sans-serif;font-weight: 700; letter-spacing: 0.03em; line-height: 23px; cursor: pointer;width: 600px;" align="center" valign="top" class="editable_text header3"><span style="color:#fff !important;font-family: arial, sans-serif;font-size:16px;">Minutes Of Meeting (MOM)</span></td>
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
<table style="background-color: #fff;margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 100%;border-collapse: collapse;color: inherit;font-size: inherit;font-family: arial, sans-serif !important;" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" width="100%" mc:repeatable="section" mc:variant="section 3 - Table">
    <tr>
        <td align="center" valign="top" style="border-collapse: collapse;">
            <table class="p100" style="border:2px solid #f5f5f5;background-color: #fff;margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 800px;border-collapse: collapse;color: inherit;font-size: inherit;font-family: arial, sans-serif !important;" width="800" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff">
                <tr>
                    <td style="width: 30px;font-size: 1px;border-collapse: collapse;" width="30" valign="top" align="left">&nbsp;</td>
                    <td align="center" valign="top" style="border-collapse: collapse;">
                        <table class="p100" style="margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 700px;border-collapse: collapse;color: inherit;font-size: inherit;font-family: arial, sans-serif !important;" width="700" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td align="center" valign="top" style="border-collapse: collapse;">
                                    <table class="p100" style="margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;width: 700px;border-collapse: collapse;color: inherit;font-size: inherit;font-family: arial, sans-serif !important;" width="700" cellspacing="0" cellpadding="0" border="0" align="center">
                                        <tr>
                                            <td style="font-size: 1px;height: 10px;line-height: 10px;mso-line-height-rule: exactly;border-collapse: collapse;" valign="top" align="left">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td style="font-size: 1px; height: 30px; line-height: 30px; mso-line-height-rule: exactly;" valign="top" align="center">&nbsp;</td>
                                        </tr>
                                        <tr>
                                        <div style="font-size:16px;height:13px;float:right;color:#222;font-family: arial, sans-serif;font-weight:bold;color:#222;font-family: arial, sans-serif;font-size:16px;padding-bottom:8px;"><b>Date :</b> {{$today->format('d-m-Y')}}</div>
                                          <td style="font-size: 1px; height: 30px; line-height: 30px; mso-line-height-rule: exactly;" valign="top" align="center">&nbsp;</td>
                                        </tr>
                                        <tr>
                                        <p style="font-size:16px;text-align:justify">
                                            @if(is_null($Client->client_name))
                                            Dear {{$Client->alternate_client_name}},
                                            @elseif(is_null($Client->alternate_client_name))
                                            Dear {{$Client->client_name}},
                                            @endif
                                        </p>
                                        <p style="font-size:16px;text-align:justify">Greetings from Wings Events!!</p>
                                        <p style="font-size:16px;">Thank you for meeting us. As per our discussion please find below the points that we have discussed during our meeting:-</p>
                                        </tr>
                                        <p style="font-size:16px;text-align:justify"><u style="font-weight: bold;color: #b84233;font-family: arial, sans-serif !important;">Service Report:</u></p>
                                        <tr>
                                            <td style="width: 700px;border-collapse: collapse;" width="700" align="center" valign="top">
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="700" style="font-family: arial, sans-serif;border-collapse: collapse;width: 100%;color: inherit;font-size: 18px;">
                                                    <tr>
                                                        <td style="border: 1px solid #bbb8b8;color:#222;padding: 10px 20px 10px 20px;border-collapse: collapse;">Meeting Date</td>
                                                        <td style="color:#222;border: 1px solid #bbb8b8;padding: 10px 20px 10px 20px;border-collapse: collapse;"><?php echo date("d-m-Y",strtotime($Client->date)) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #bbb8b8;color:#222;padding: 10px 20px 10px 20px;border-collapse: collapse;">Time of Meeting</td>
                                                        <td style="color:#222;border: 1px solid #bbb8b8;padding: 10px 20px 10px 20px;border-collapse: collapse;"><?php echo date("h:i a",strtotime($Client->time)) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 10px 20px 10px 20px;border: 1px solid #bbb8b8;color:#222;border-collapse: collapse;">Location of Meeting</td>
                                                        <td style="padding: 10px 20px 10px 20px;border: 1px solid #bbb8b8;color:#222;border-collapse: collapse;">{{$Client->location}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 10px 20px 10px 20px;border: 1px solid #bbb8b8;color:#222;border-collapse: collapse;">Company/Organization Name</td>
                                                        <td style="padding: 10px 20px 10px 20px;border: 1px solid #bbb8b8;color:#222;border-collapse: collapse;">{{$Client->company_name}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <br/>
                                        <p style="font-size:16px;text-align:justify"><u style="font-weight: bold;color: #b84233;font-family: arial, sans-serif !important;">Persons Involved:</u></p>
                                        <tr>
                                            <td style="width: 700px;border-collapse: collapse;" width="700" align="center" valign="top">
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="700" style="font-family: arial, sans-serif;border-collapse: collapse;width: 100%;color: inherit;font-size: 18px;width: 100%">
                                                    <tr>
                                                        <td style="border: 1px solid #bbb8b8;color:#222;padding: 10px 20px 10px 20px;border-collapse: collapse;">From the Client</td>
                                                        <td style="color:#222;border: 1px solid #bbb8b8;padding: 10px 20px 10px 20px;border-collapse: collapse;">{{$Client->from_client}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #bbb8b8;color:#222;padding: 10px 20px 10px 20px;border-collapse: collapse;">From the Agency</td>
                                                        <td style="color:#222;border: 1px solid #bbb8b8;padding: 10px 20px 10px 20px;border-collapse: collapse;">{{$Client->from_agency}}</td>
                                                    </tr>
                                                    <tr style="display: none !important;">
                                                        <td style="padding: 10px 20px 10px 20px;border: 1px solid #bbb8b8;color:#222;border-collapse: collapse;">Company/Organization Name</td>
                                                        <td style="padding: 10px 20px 10px 20px;border: 1px solid #bbb8b8;color:#222;border-collapse: collapse;">{{$Client->company_name}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>        
                                            <br/>
                                        <tr> 
                                            <td><p style="font-size:16px;"><u style="font-weight: bold;color: #b84233;font-family: arial, sans-serif !important;">Key Points of discussion Client/Agency:</u></p>
                                        <p style="color:#222;font-family: arial, sans-serif;font-size:16px;">{!! $Client->key_points !!}</p></td>
                                        </tr>
                                        <tr>
                                        <p style="font-size:16px;text-align:justify">Please feel free to add any points if I may have missed. We look forward to partnering with you for your upcoming events.</p>
                                        </tr>
                                        <p style="color:#222;font-family: arial, sans-serif;font-size:16px;">Regards,</p><br>
                                            <hr style="border:1px solid #dddddd;">
                                            <tr>
                                            <td align="left" valign="top" style="border-collapse: collapse;">
                                                <table style="margin: 0;mso-table-lspace: 0;mso-table-rspace: 0;padding: 0;border-collapse: collapse;color: inherit;font-size: inherit;font-family: arial, sans-serif !important;width: 100%" cellspacing="0" cellpadding="0" border="0" align="center"  width="700">
                                                    <tr>
                                                        @if($UserDetails->signature == "user/signature/default.jpg")
                                                        <td>
                                                            <p style="color:#222;font-family: arial, sans-serif;font-size:16px;"><b style="color:#222;">{{$User->first_name}} {{$User->last_name}}</b></p>
                                                        </td>
                                                        @else
                                                         <td>
                                                           <img src="{{asset('public/'.$UserDetails->signature)}}" width="700">
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
</body>

</html>