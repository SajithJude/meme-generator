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
                                    <b style="font-size:19px; color: #ffffbd; font-family:Arial; line-height: 23px;">Forgot your password? No problem, I got you!</b>
                                </div>
                                <div style="border:1px #ffffbd  solid;"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 0px 36px 0px 36px; color: white;" class="main-body">
                                Hi there,&#128578;<br><br>
                                Reset your password and continue on your journey towards becoming a rockstart communicator.<br><br>
                                <a href="{{ $resetLink }}" style="cursor: pointer !important; margin-left: center; margin-right: auto;">
                                    <button style=" background-color: #ffffbd; color: black; text-align: center; height: 30px; width:112px; font-size: 13px; border: none; border-radius:20px;" role="button">
                                        <b>Login</b>
                                    </button>
                                </a><br><br>
                                If you are facing problems with the button, copy and paste the following link in your browser:<br><br>
                                <a href="{{ $resetLink }}">{{ $resetLink }}</a><br><br>
                                Just a note, this link is valid for 60 minutes. If you don’t get around to it within that time, request a new one.<br><br>
                                If you didn’t request to reset your password, let us know at <a href="mailto:academy@susieashfield.com">academy@susieashfield.com</a> so we can get John Wick to find who’s trying to login to your account. &#128373; &#65039; &#8205;<br><br>
                                Best,<br>
                                Susie<br><br>
                                <span style="font-size: 19px;">Susie Ashfield</span><br>
                                T: 077 7167 0623<br>
                                E: <a href="mailto:hello@susieashfield.com">hello@susieashfield.com</a><br>
                                W: <a href="https://www.susieashfield.com">www.susieashfield.com</a><br><br>
                                <span style="font-size: 19px;"><b>“Speak2Impact Academy has turned even the stuffiest of executives and business VIPs into TED Talk–style rockstars”</b></span><span style="font-style: italic;">Forbes Magazine</span><br><br>
                                <a href="https://www.forbes.com/sites/carriekerpen/2021/03/09/the-public-speaking-advice-youve-never-heard-before-from-the-anti-speech-writer/" target="_blank">https://www.forbes.com/sites/carriekerpen/2021/03/09/the-public-speaking-advice-youve-never-heard-before-from-the-anti-speech-writer/</a><br>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
