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
                                    <b style="font-size:19px; color: #ffffbd; font-family:Arial; line-height: 23px;">Welcome to the Speak2Impact Academy: Onboarding</b>
                                </div>
                                <div style="border:1px #ffffbd  solid;"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 0px 36px 0px 36px; color: white;" class="main-body">
                                Hi there,&#128578;<br><br>
                                Welcome onboard to the Impact Academy! I’m super excited to have you here.<br><br>
                                Login with the following credentials and make sure to update your password after your 1st login.<br><br>
                                Login: {{ $data['email'] }}<br>
                                Password: {{ $data['password'] }}<br><br>
                                Watch this short video here where I explain the academy and how to use it:<br>
                                <a href="https://vimeo.com/user179511897/academyonboarding?share=copy" target="_blank">https://vimeo.com/user179511897/academyonboarding?share=copy</a><br><br>
                                The best way to understand how it works is just to play around and explore, but if there’s anything that doesn’t make
                                sense, just drop an email to:<br><br>
                                <a href="mailto:academy@susieashfield.com">academy@susieashfield.com</a><br><br>
                                We’ll get in touch right away to help you out.<br><br>
                                Here are some simple steps to help get you going:<br><br>
                                1. Click on the ‘practice’ tab, and sign yourself up to start using ‘Yoodli’. Send any videos you want your coach to
                                look at to:<br>
                                <a href="mailto:academy@susieashfield.com">academy@susieashfield.com</a><br><br>
                                2. Check out the dates for the upcoming live webinars with me. There’s a Q&A session as well as a group review session
                                every month, which will be invaluable to your progress. You’ll find them here:<br>
                                <a href="https://academy.susieashfield.com/webinars" target="_blank">https://academy.susieashfield.com/webinars</a><br><br>
                                3. If you’re a member of our ‘Impact Plus’ package, you can book in your monthly session with your coach by going here:<br>
                                <a href="https://academy.susieashfield.com/meeting" target="_blank">https://academy.susieashfield.com/meeting</a><br><br>
                                That’s it! Have fun, and keep me updated on your progress.<br><br>
                                Thank you for joining us. Your journey to being a rockstar communicator starts…. NOW!<br><br>
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
