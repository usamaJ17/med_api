<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Appointment Details</title>

    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap"
      rel="stylesheet"
    />
  </head>
  <body
    style="
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #ffffff;
      font-size: 14px;
    "
  >
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
      "
    >
      <header>
        <table style="width: 100%;">
          <tbody>
            <tr style="height: 0;">
              <td>
                
              </td>
              <td style="text-align: right;">
                <span
                  style="font-size: 16px; line-height: 30px; color: #ffffff;"
                  >{{ date('Y-m-d') }}</span
                >
              </td>
            </tr>
          </tbody>
        </table>
      </header>

      <main>
        <div
          style="
            margin: 0;
            margin-top: 70px;
            padding: 92px 30px 115px;
            background: #ffffff;
            border-radius: 30px;
            text-align: center;
          "
        >
          <div style="width: 100%; max-width: 489px; margin: 0 auto;">
          <img src="{{asset('dashboard/images/patient-email.png')}}"  style="width: 100%;"/>
            <p
              style="
                margin: 0;
                margin-top: 17px;
                font-size: 16px;
                font-weight: 500;
                text-align: left;
              "
            >
            Dear {{ $name }},
            </p>
            <p
              style="
                margin: 0;
                margin-top: 17px;
                font-weight: 500;
                /* letter-spacing: 0.56px; */
                text-align: justify;
              "
            >
            We hope this message finds you well.<br>
            This email is to confirm that your appointment with <strong>{{$professional}}</strong> has been successfully canceled as per your request. We have also issued a 100% refund. Please allow some time for it to reflect.<br>
            </p>
            <p
              style="
                margin: 0;
                margin-top: 17px;
                font-weight: 500;
                /* letter-spacing: 0.56px; */
                text-align: justify;
              "
            >
            If you have any questions or need further assistance, please feel free to reach out to us via the app. We're here to assist you every step of the way. You can always re-book with any of our experienced health professionals. If you have a medical emergency you can use our Emergency Help service. To do this, please navigate to the Home Screen of the Deluxe Hospital app, and tab on the Emergency Help button on the upper right hand corner.<br>
            Thank you for choosing the <strong>Deluxe Hospital app</strong>. We look forward to supporting your health journey.<br>
            With caring thoughts,<br>
            <strong>The Team that Cares</strong><br>
            ❤️‍🩹<br>
            <strong>Deluxe Hospital</strong><br>
            <a href="{{ url('/') }}" target="_blank">{{ url('/') }}</a>
            </p>
          </div>
        </div>
      </main>
      
      <footer
        style="
          margin-top: 20px;
          text-align: center;
          padding-top: 20px;
          border-top: 1px solid #dddddd;
        ">
        <img
          src="{{asset('dashboard/images/logo-letter.png')}}"
          alt="Deluxe Hospital Logo"
          style="width: 100px; margin-bottom: 15px;"
        />
        <div style="margin-bottom: 10px;">
          <a href="https://www.tiktok.com/@deluxehospital?_t=8sMSBOZEAgo&_r=1" target="_blank"
            ><img
              src="{{asset('dashboard/images/social-icons/tiktok.png')}}"
              alt="TikTok"
              style="width: 24px; margin: 0 5px;"
          /></a>
          <a href="https://x.com/deluxe_hospital" target="_blank"
            ><img
              src="{{asset('dashboard/images/social-icons/twitter.png')}}"
              alt="Twitter"
              style="width: 24px; margin: 0 5px;"
          /></a>
          <a href="https://www.instagram.com/deluxe_hospital?igsh=amgxODE2dm1samkw&utm_source=qr" target="_blank"
            ><img
              src="{{asset('dashboard/images/social-icons/instagram.png')}}"
              alt="Instagram"
              style="width: 24px; margin: 0 5px;"
          /></a>
          <a href="t.me/deluxe_hospital" target="_blank"
            ><img
              src="{{asset('dashboard/images/social-icons/telegram.png')}}"
              alt="Telegram"
              style="width: 24px; margin: 0 5px;"
          /></a>
          <a href="https://youtu.be/ZZhXcvqeYsQ?si=Wz6mUKZBAW6ayDD5" target="_blank"
            ><img
              src="{{asset('dashboard/images/social-icons/youtube.png')}}"
              alt="YouTube"
              style="width: 24px; margin: 0 5px;"
          /></a>
        </div>
        <p
          style="
            font-size: 12px;
            color: #666666;
            margin: 0;
            margin-top: 10px;
          "
        >
          Visit us at <a href="{{ url('/') }}" target="_blank">{{ url('/') }}</a>
        </p>
      </footer>
    </div>
  </body>
</html>
