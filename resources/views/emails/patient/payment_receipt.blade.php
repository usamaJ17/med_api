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
          <div style="width: 100%; max-width: 530px; margin: 0 auto;">
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
            Great news! Your appointment with {{$professional}} is confirmed, and we've successfully received your payment. In order to protect you, we keep this money in our escrow account until after your appointment. We're excited to assist you with your healthcare needs.<br>
            <br><strong>Payment Receipt:</strong><br>
            - <strong>Patient Name:</strong> {{$name}}<br>
            - <strong>Health Professional:</strong> {{$professional}}<br>
            - <strong>Appointment Date:</strong> {{$appointment_date}}<br>
            - <strong>Appointment Time:</strong> {{$appointment_time}}<br>
            - <strong>Amount Paid</strong> {{$amount}}<br>
            - <strong>Transaction ID</strong> {{$transaction_id}}<br>
            - <strong>Payment Date:</strong> {{$payment_date}}<br><br>

            <br><strong>Appointment Details:</strong><br>
            - <strong>Date:</strong> {{$appointment_date}}<br>
            - <strong>Time:</strong> {{$appointment_time}}<br>
            - <strong>Type of Consultation:</strong> {{$consultation_type}}<br>
            - <strong>Health Professional:</strong> {{$professional}}<br>
          
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
            When your appointment is due, please open the Deluxe Hospital app and navigate to the "Chat" section; {{$professional}} will be there<br>
            If you have any questions or need assistance, please reach out to us via the app.<br>
            Thank you for choosing the <strong>Deluxe Hospital app</strong>. We look forward to supporting your health journey.<br>
            See you soon!<br>
            <br>With caring thoughts,<br>
            <strong>The Team that Cares</strong><br>
            <span style="margin-left: 38px;"></span>❤️‍🩹<br>
            <strong>Deluxe Hospital</strong><br>
            
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
          Visit us at <a href="https://deluxehospital.com" target="_blank">deluxehospital.com</a>
        </p>
      </footer>
    </div>
  </body>
</html>
