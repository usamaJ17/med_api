<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Account Deletion Notification</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
</head>

<body
    style="
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #ffffff;
      font-size: 14px;
    ">
    <div
        style="
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
                        <td></td>
                        <td style="text-align: right;">
                            <span style="font-size: 16px; line-height: 30px; color: #ffffff;">
                                {{ date('Y-m-d') }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </header>

        <main>
            <div
                style="margin: 0; margin-top: 70px; padding: 92px 30px 115px; background: #ffffff;
                  border-radius: 30px; text-align: center;">
                <div style="width: 100%; max-width: 530px; margin: 0 auto;">
                    <img src="{{ asset('dashboard/images/patient-email.png') }}" style="width: 100%;" />
                    <h1 style="margin: 0; font-size: 24px; font-weight: 500; color: #1f1f1f;">Account Deleted</h1>
                    <p style="margin-top: 20px; font-size: 16px; font-weight: 500; text-align: left;">
                        Dear {{ $name }},
                    </p>
                    <p style="margin-top: 15px; text-align: justify; font-weight: 500;">
                        We noticed that you had started the on-boarding (sign up) process but were unable to complete it
                        within 24 hours.
                        Unfortunately, your OTP has now expired, and your account has been deleted from our system.
                    </p>
                    <p style="margin-top: 15px; text-align: justify; font-weight: 500;">
                        If you still wish to join the Deluxe Hospital platform, you can simply start the sign up process
                        again.
                        We would love to welcome you onboard.
                    </p>
                    <p style="margin-top: 15px; text-align: justify; font-weight: 500;">
                        If you need any assistance, feel free to reach out. You can chat with us using the in-app
                        customer service button
                        on the Home Screen of the app or email us at <a
                            href="mailto:care@deluxehospital.com">care@deluxehospital.com</a>.
                    </p>
                    <p style="margin-top: 30px; font-weight: 500; text-align: justify;">
                        With Caring Thoughts,<br>
                        <strong>The Team That Cares</strong><br>
                        ❤️‍🩹<br>
                        <strong>Deluxe Hospital</strong>
                    </p>
                </div>
            </div>
        </main>
        <footer style="margin-top: 20px; text-align: center; padding-top: 20px; border-top: 1px solid #dddddd;">
            <img src="{{ asset('dashboard/images/logo-letter.png') }}" alt="Deluxe Hospital Logo"
                style="width: 100px; margin-bottom: 15px;" />
            <div style="margin-bottom: 10px;">
                <a href="https://www.tiktok.com/@deluxehospital?_t=8sMSBOZEAgo&_r=1" target="_blank">
                    <img src="{{ asset('dashboard/images/social-icons/tiktok.png') }}" alt="TikTok"
                        style="width: 24px; margin: 0 5px;" />
                </a>
                <a href="https://x.com/deluxe_hospital" target="_blank">
                    <img src="{{ asset('dashboard/images/social-icons/twitter.png') }}" alt="Twitter"
                        style="width: 24px; margin: 0 5px;" />
                </a>
                <a href="https://www.instagram.com/deluxe_hospital?igsh=amgxODE2dm1samkw&utm_source=qr" target="_blank">
                    <img src="{{ asset('dashboard/images/social-icons/instagram.png') }}" alt="Instagram"
                        style="width: 24px; margin: 0 5px;" />
                </a>
                <a href="https://t.me/deluxe_hospital" target="_blank">
                    <img src="{{ asset('dashboard/images/social-icons/telegram.png') }}" alt="Telegram"
                        style="width: 24px; margin: 0 5px;" />
                </a>
                <a href="https://youtu.be/ZZhXcvqeYsQ?si=Wz6mUKZBAW6ayDD5" target="_blank">
                    <img src="{{ asset('dashboard/images/social-icons/youtube.png') }}" alt="YouTube"
                        style="width: 24px; margin: 0 5px;" />
                </a>
            </div>
            <p style="font-size: 12px; color: #666666; margin: 0; margin-top: 10px;">
                Visit us at <a href="https://deluxehospital.com" target="_blank">deluxehospital.com</a>
            </p>
            <p style="font-size: 12px; color: #999999; margin-top: 10px;">
                If you do not wish to receive further emails, you may <a
                    href="{{ url('/unsubscribe?email=' . urlencode($email)) }}" target="_blank">unsubscribe
                    here</a>.
            </p>
        </footer>
    </div>
</body>

</html>
