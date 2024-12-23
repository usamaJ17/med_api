<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Appointment Cancellation by patient</title>

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
            We regret to inform you that your upcoming appointment with {{$p_name}}, scheduled for {{$appointment_date}}] at {{$appointment_time}}, has been canceled by the client. We understand that your time is valuable and apologize for any inconvenience this may cause.<br>
            We appreciate your understanding and flexibility in this matter. Please don't hesitate to reach out to our support team at via the app in case you require further assistance. Once again we apologise for the inconvenience this may have caused.<br>
            Thank you for your continued dedication and for being a valued member of the Deluxe Hospital community.<br>
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
            With caring thoughts,<br>
            <strong>The Team that Cares</strong><br>
            ❤️‍🩹<br>
            <strong>Deluxe Hospital</strong><br>
            <a href="{{ url('/') }}" target="_blank">{{ url('/') }}</a>
            </p>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>
