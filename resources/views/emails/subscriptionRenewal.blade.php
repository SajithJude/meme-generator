<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Speak2Impact') }}</title>
    <style>
        tr {
            height: 72px !important;
        }

        @media (max-width: 700px) {
            .footer {
                flex-direction: column;
                padding: 5px !important;
            }

            .col-sml {
                margin: auto;
                padding-left: 0px !important;
            }
        }

        .main-body a, .main-body a:visited {
            color: white;
            text-decoration: underline;
        }

        .main-body a:hover {
            color: #ffffbd;
            text-decoration: underline;
        }

        @media (max-width: 460px) {
            td {
                word-break: break-word;
            }

            .main-body a {
                display: block;
                word-break: break-word;
            }
        }
    </style>
</head>

<body>
    <div class="col-lge" style="background-color:#F5F5F5; max-width:864px; margin: auto; border-bottom: solid #f5f5f5;">
        <div style="text-align:center;">
            <img alt="Logo" src="{{ asset('images/Mic_Icon_Yellow1_Bg.jpg') }}" style="height:70px; width: 70px; padding-top: 29px; padding-bottom: 10px;" class="logo">
        </div>
        <div style="background-color:#000000; padding: 2px 0 2px 0; margin:0px auto 25px; max-width: 650px;">
            <table width="100%">
                <tbody>
                    <tr>
                        <td valign="center">
                            <div style="margin: 0px 36px 0px 36px;">
                                <div style=" text-align:center; margin:23px;">
                                    <b style="font-size:19px; color: #ffffbd; font-family:Arial; line-height: 23px;">Subscription Renewal Notification</b>
                                </div>
                                <div style="border:1px #ffffbd  solid;"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @if ($payload['role'] == 'admin')
                              <p style="margin: 0px 36px 0px 36px; color: white;" class="main-body">
                                  A new  customer {{ $payload['customer']->name }} ({{ $payload['customer']->email }}) has either subscribed or their membership has been renewed. Please refer to Stripe for further information.<br /><br />
                              </p>
                            @else
                              <p style="margin: 0px 36px 0px 36px; color: white;" class="main-body">
                                  Hi there,&#128578;<br><br>
                                  Your subscription to Speak2Impact Academy has been activated. You will receive the receipt automatically from Stripe. In case you haven't received it, please send an email to me at academy@susieashfieldd.com and I will send it to you again.<br /><br />

                                  If this is your first time in the academy, watch this short video here where I explain the academy and how to use it:
                                  https://vimeo.com/user179511897/academyonboarding?share=copy<br /><br />

                                  Thank you for joining us.<br /><br />

                                  <span style="font-size: 19px;">Susie Ashfield</span><br />
                                  T: 077 7167 0623<br>
                                  E: <a href="mailto:hello@susieashfield.com">hello@susieashfield.com</a><br>
                                  W: <a href="https://www.susieashfield.com">www.susieashfield.com</a><br><br>
                                  <span style="font-size: 19px;"><b>“Speak2Impact Academy has turned even the stuffiest of executives and business VIPs into TED Talk–style rockstars”</b></span><span style="font-style: italic;">Forbes Magazine</span><br><br>
                                  <a href="https://www.forbes.com/sites/carriekerpen/2021/03/09/the-public-speaking-advice-youve-never-heard-before-from-the-anti-speech-writer/" target="_blank">https://www.forbes.com/sites/carriekerpen/2021/03/09/the-public-speaking-advice-youve-never-heard-before-from-the-anti-speech-writer/</a><br>
                              </p>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
