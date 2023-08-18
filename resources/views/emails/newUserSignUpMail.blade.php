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
            word-break: break-word;
        }

        .main-body a, .main-body a:visited {
            color: white;
            text-decoration: underline;
            word-break: break-word;
        }

        .main-body a:hover {
            color: #ffffbd;
            text-decoration: underline;
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
                                    <b style="font-size:19px; color: #ffffbd; font-family:Arial; line-height: 23px;">New User Sign Up</b>
                                </div>
                                <div style="border:1px #ffffbd  solid;"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 0px 36px 0px 36px; color: white;" class="main-body">
                                A new user <b>{{ $data['name'] }}</b> has signed up for <b>{{ $data['plan'] }}</b> at <b>{{ $data['dateTime'] }}</b> on the Speak2Impact Academy.<br>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
