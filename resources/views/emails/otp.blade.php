<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Verify OTP</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
</head>

<body style="
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #ffffff;
      font-size: 14px;
    ">
    <div style="
        max-width: 680px;
        margin: 0 auto;
        padding: 45px 30px 60px;
        background: #f4f7ff;
        background-image: url(https://archisketch-resources.s3.ap-northeast-2.amazonaws.com/vrstyler/1661497957196_595865/email-template-background-banner);
        background-repeat: no-repeat;
        background-size: 800px 452px;
        background-position: top center;
        font-size: 14px;
        color: #434343;
      ">
        <header>
            <table style="width: 100%;">
                <tbody>
                    <tr style="height: 0;">
                        <td>

                        </td>
                        <td style="text-align: right;">
                            <span style="font-size: 16px; line-height: 30px; color: #ffffff;">{{ date('Y-m-d') }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </header>

        <main>
            <div style="
            margin: 0;
            margin-top: 70px;
            padding: 92px 30px 115px;
            background: #ffffff;
            border-radius: 30px;
            text-align: center;
          ">
                <div style="width: 100%; max-width: 530px; margin: 0 auto;">
                    <img src="{{ asset('dashboard/images/patient-email.png') }}" style="width: 100%;" />
                    <p style="
                margin: 0;
                margin-top: 17px;
                font-size: 16px;
                font-weight: 500;
                text-align: left;
              ">
                        Dear {{ $name }},
                    </p>
                    <p style="
                margin: 0;
                margin-top: 17px;
                font-weight: 500;
                /* letter-spacing: 0.56px; */
                text-align: justify;
              ">
                        Thank you for choosing Deluxe Hospital! We are excited to support your health and wellness
                        journey.
                        To ensure we have the correct email address, please confirm your registration by using either of
                        the two options below:
                    </p>

                    <ol style="margin-top: 20px; text-align: left; font-weight: 500;">
                        <li style="margin-bottom: 15px;">
                            Open the Deluxe Hospital app and enter the following OTP:
                            <p
                                style="margin: 10px 0 0; font-size: 32px; font-weight: 600; letter-spacing: 15px; color: #28a745; text-align: center;">
                                {{ $otp }}
                            </p>
                        </li>
                        <li>
                            Or simply click the link below to verify your email address:
                            <p style="margin: 15px 0 0; text-align: center;">
                                <a href="{{  url('/verify-email/'.$verification_url) }}" target="_blank"
                                    style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: #ffffff; text-decoration: none; border-radius: 5px;">
                                    Verify Email Address
                                </a>
                            </p>
                        </li>
                    </ol>

                    <p style="margin-top: 30px; font-weight: 500; text-align: justify;">
                        This OTP and email verification link is valid for the next 24 hours. If you did not sign up for
                        Deluxe Hospital, please
                        disregard this email.
                    </p>
                    <p style="
                margin: 0;
                margin-top: 17px;
                font-weight: 500;
                /* letter-spacing: 0.56px; */
                text-align: justify;
              ">
                        At Deluxe Hospital, we prioritize your comfort and care, providing exceptional telemedicine
                        services right at your fingertips. Should you need any assistance, our dedicated support team is
                        available around the clock via our mobile app.<br>
                        Thank you for choosing the <strong>Deluxe Hospital app</strong>. We look forward to supporting
                        your health journey.<br>
                        <br>With caring thoughts,<br>
                        <strong>The Team that Cares</strong><br>
                        <span style="margin-left: 38px;"></span>❤️‍🩹<br>
                        <strong>Deluxe Hospital</strong><br>

                    </p>
                </div>
            </div>
        </main>
        <footer style="
          margin-top: 20px;
          text-align: center;
          padding-top: 20px;
          border-top: 1px solid #dddddd;
        ">
            <img src="{{ asset('dashboard/images/logo-letter.png') }}" alt="Deluxe Hospital Logo"
                style="width: 100px; margin-bottom: 15px;" />
            <div style="margin-bottom: 10px;">
                <a href="https://www.tiktok.com/@deluxehospital?_t=8sMSBOZEAgo&_r=1" target="_blank"><img
                        src="{{ asset('dashboard/images/social-icons/tiktok.png') }}" alt="TikTok"
                        style="width: 24px; margin: 0 5px;" /></a>
                <a href="https://x.com/deluxe_hospital" target="_blank"><img
                        src="{{ asset('dashboard/images/social-icons/twitter.png') }}" alt="Twitter"
                        style="width: 24px; margin: 0 5px;" /></a>
                <a href="https://www.instagram.com/deluxe_hospital?igsh=amgxODE2dm1samkw&utm_source=qr"
                    target="_blank"><img src="{{ asset('dashboard/images/social-icons/instagram.png') }}"
                        alt="Instagram" style="width: 24px; margin: 0 5px;" /></a>
                <a href="t.me/deluxe_hospital" target="_blank"><img
                        src="{{ asset('dashboard/images/social-icons/telegram.png') }}" alt="Telegram"
                        style="width: 24px; margin: 0 5px;" /></a>
                <a href="https://youtu.be/ZZhXcvqeYsQ?si=Wz6mUKZBAW6ayDD5" target="_blank"><img
                        src="{{ asset('dashboard/images/social-icons/youtube.png') }}" alt="YouTube"
                        style="width: 24px; margin: 0 5px;" /></a>
            </div>
            <p style="
            font-size: 12px;
            color: #666666;
            margin: 0;
            margin-top: 10px;
          ">
                Visit us at <a href="https://deluxehospital.com" target="_blank">deluxehospital.com</a>
            </p>
            <p style="font-size: 11px; color: #888888; margin: 10px auto 0; max-width: 480px;">
                <strong>ENHANCED GLOBAL HEALTH SERVICES</strong> is registered under:<br>
                &mdash; the <strong>Data Protection Act, 2012 (Act 843)</strong> with Registration Number
                <strong>0006039</strong><br>
                &mdash; the <strong>Companies Act, 2019 (Act 992)</strong> with Registration Number
                <strong>CS029400224</strong>
            </p>
        </footer>
    </div>
</body>

</html>