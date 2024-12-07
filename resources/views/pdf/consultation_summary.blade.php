<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deluxe Hospital Prescription</title>
    <style>
        @page {
            size: Legal;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            background: url("{{ $background }}") no-repeat center center;
            background-size: contain;
            height: 14in;
            width: 8.5in;
            font-size: 14px;
            -webkit-print-color-adjust: exact; 
            font-family: "Gill Sans", sans-serif;
        }
        .content {
            padding: 0.7in;
            padding-bottom: 0px;
            box-sizing: border-box;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .form-section-top {
            margin-top: 1.6in;
            font-size: 14px;
            padding: 18px;
            width: 100%;
        }
        .form-section {
            margin-top: 0.19in;
            font-size: 14px;
            padding: 18px;
            width: 50%;
        }
        .form-section-mid {
            margin-top: 15px;
            font-size: 14px;
            padding: 18px;
        }
        .input-line {
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="content">
        <!-- Form Section -->
        <table class="form-section-top">
            <tr>
                <td width="60%"></td>
                <td>
                    <h2 style="background: rgba(255, 255, 255, 0.5); border-radius: 10px; padding: 10px; text-align: center;">{{$note_key}}</h2>
                </td>

            </tr>
        </table>
        <table class="form-section">
            <tr>
                <td>
                    <div class="input-line">
                        <span style="margin-left:-4px">{{ date('d', strtotime($date)) }}</span>
                        <span style="margin-left:5px">{{ date('m', strtotime($date)) }}</span>
                        <span style="margin-left:8px">{{ date('Y', strtotime($date)) }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 6px;">
                    <div class="input-line" style="margin-left: 12px;">{{ $patient_id }}</div>
                </td>
            </tr>
        </table>

        <!-- Middle Section -->
        <table class="form-section-mid">
            <tr>
                <td style="width: 70%; vertical-align: top; padding-right: 22px;">
                    <table>
                        <tr>
                            <td>
                                <div class="input-line">
                                    <span style="margin-left:-2px">{{ date('d', strtotime($date)) }}</span>
                                    <span style="margin-left:6px">{{ date('m', strtotime($date)) }}</span>
                                    <span style="margin-left:8px">{{ date('Y', strtotime($date)) }}</span>
                                </div>
                                <div class="input-line" style="margin-left: 100px;">{{ $patient_id }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <div class="input-line" style="margin-left: 80px; margin-top: 5px;">{{ $patient_name }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <div class="input-line" style="margin-left: 100px; margin-top: 8px;">{{ $patient_address }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <div class="input-line" style="margin-left: 128px; margin-top: 8px;">{{ $patient_phone }}</div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 20%; vertical-align: top;">
                    <table>
                        <tr>
                            <td>
                                <div class="input-line" style="margin-left: 38px; margin-top: -3px;">{{ $patient_age }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-line" style="margin-left:65px; margin-top: 5px;">{{ $patient_weight }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-line" style="margin-left: 77px; margin-top: 21px;">
                                    @if($patient_gender == 'Male')
                                        <img src="{{ public_path('pdfs/check.png') }}" alt="M" style="width: 12px; height: 12px;">
                                    @endif
                                </div>
                                <div class="input-line" style="margin-left: 45px; margin-top: 21px;">
                                    @if($patient_gender == 'Female')
                                        <img src="{{ public_path('pdfs/check.png') }}" alt="F" style="width: 12px; height: 12px;">
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="form-section-mid" style="height:4.6in;margin-top: 0.6in;">
            <tr>
				<td style="width:60%"><div style="margin-left: -30px;">{ !! $note_value !! }</div></td>
				<td></td>
            </tr>
        </table>

        <!-- Lower Section -->
        <table class="form-section-mid" style="margin-top: 0.6in">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <table>
                        <tr>
                            <td>
                                <div class="input-line" style="margin-left: -30px; margin-top: 8px;">{{ $doctor_name }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-line" style="margin-left: 130px;margin-top: 8px;">{{ $doctor_signature }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-line" style="margin-left: 25px; margin-top: 8px;">{{ $doctor_license }}</div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top;"></td>
            </tr>
        </table>
    </div>
</body>
</html>
