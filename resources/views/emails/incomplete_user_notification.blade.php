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
            <div
                style="margin: 0; margin-top: 70px; padding: 92px 30px 115px; background: #ffffff; border-radius: 30px; text-align: center;">
                <div style="width: 100%; max-width: 530px; margin: 0 auto;">
                    <img src="{{ asset('dashboard/images/doctor-email.png') }}" style="width: 100%;" />
                    <h1 style="margin: 0; font-size: 24px; font-weight: 500; color: #1f1f1f;">We’d love to have you back!</h1>

                    <p style="margin-top: 20px; font-size: 16px; font-weight: 500; text-align: left;">
                        Hi {{ $name }},
                    </p>

                    <p style="margin-top: 15px; text-align: justify; font-weight: 500;">
                        We noticed you started setting up your <strong>Deluxe Hospital</strong> profile but didn’t quite
                        finish. We’d love to help you complete your registration in just a few minutes so you can:
                    </p>

                    <ul style="text-align: left; font-weight: 500; padding-left: 20px; margin-top: 10px;">
                        <li>✅ Reach patients through our secure telemedicine platform on your terms</li>
                        <li>✅ Consult flexibly. You set your fees; you set your availability.</li>
                        <li>✅ Withdraw your money seamlessly via Mobile Money or Bank Transfer</li>
                    </ul>

                    <p style="margin-top: 20px; font-weight: 500; text-align: left;">
                        Why join Deluxe Hospital?
                    </p>

                    <ul style="text-align: left; font-weight: 500; padding-left: 20px; margin-top: 10px;">
                        <li>— We are registered under the Data Protection Act, 2012 (Act 843) with Registration Number:
                            0006039</li>
                        <li>— Free 24/7 technical support for you and your patients</li>
                    </ul>

                    <p style="margin-top: 20px; text-align: justify; font-weight: 500;">
                        <strong>COMPLETE YOUR REGISTRATION NOW</strong><br>
                        Your progress was saved! Log into the app to complete the registration process.
                    </p>

                    <p style="margin-top: 20px; text-align: justify; font-weight: 500;">
                        Need help? Our care team is ready to assist. Chat with us via our in-app live chat.
                    </p>

                    <p style="margin-top: 30px; font-weight: 500; text-align: justify;">
                        We’re excited to empower you with your own Virtual Practice through the Deluxe Hospital
                        Telemedicine Platform.
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