<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Account Deletion Notification</title>

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
            <div style="margin: 0; margin-top: 70px; padding: 92px 30px 115px; background: #ffffff; border-radius: 30px; text-align: center;">
                <div style="width: 100%; max-width: 530px; margin: 0 auto;">
                    <img src="{{ asset('dashboard/images/patient-email.png') }}" style="width: 100%;" />
                    <h1 style="margin: 0; font-size: 24px; font-weight: 500; color: #1f1f1f;">Come back anytime</h1>

                    <p style="margin-top: 20px; font-size: 16px; font-weight: 500; text-align: left;">
                        Hi {{ $name }},
                    </p>

                    <p style="margin-top: 15px; text-align: justify; font-weight: 500;">
                        We saw you started creating your account with <strong>Deluxe Hospital</strong>, but didn’t get a chance to verify your email in time.
                        We’re here when you’re ready—your health journey can start in just a few clicks.
                    </p>

                    <p style="margin-top: 20px; font-weight: 500; text-align: left;">
                        With Deluxe Hospital, you can:
                    </p>

                    <ul style="text-align: left; font-weight: 500; padding-left: 20px; margin-top: 10px;">
                        <li>👩‍⚕️ Talk to licensed doctors anytime, anywhere</li>
                        <li>⏱ Skip waiting rooms—get care when you need it</li>
                        <li>🔒 Enjoy private, secure telemedicine visits</li>
                    </ul>

                    <p style="margin-top: 20px; text-align: justify; font-weight: 500;">
                        Kindly open the <strong>Deluxe Hospital app</strong> to restart your registration—it only takes a few minutes.
                    </p>

                    <p style="margin-top: 20px; text-align: justify; font-weight: 500;">
                        Need help or have questions? Our support team is just a message away. Chat with one of our Customer Service Nurses via the app.
                    </p>

                    <p style="margin-top: 30px; font-weight: 500; text-align: justify;">
                        Your health, your schedule—Deluxe Hospital makes it easy.
                        <br><br>
                        With caring thoughts,<br>
                        <strong>The Team that Cares</strong><br>
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