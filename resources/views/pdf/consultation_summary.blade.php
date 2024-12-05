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
            background: url("{{ public_path('pdfs/background2.png') }}") no-repeat center center;
            background-size: contain;
            height: 14in;
            width: 8.5in;
            font-size: 16px;
            -webkit-print-color-adjust: exact; 
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
        .form-section {
            margin-top: 3in;
            /* margin-left: 18px; */
            font-size: 14px;
            padding: 18px;
			width:50%;
        }
        .form-section-mid {
            margin-top: 15px;
            /* margin-left: 20px; */
            font-size: 16px;
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
        <table class="form-section">
            <tr>
                <td>
                    <div class="input-line"><span style="margin-left:-2px">04</span><span style="margin-left:7px">12</span><span style="margin-left:10px">2024</span></div>
                                
                </td>
            </tr>
            <tr>
                <td style="padding-top: 8px;">
                    <div class="input-line" style="margin-left: 12px;">454645</div>
                </td>
            </tr>
        </table>

        <!-- Middle Section -->
        <table class="form-section-mid">
            <tr>
                <td style="width: 70%; vertical-align: top; padding-right: 20px;">
                    <table>
                        <tr>
                            <td>
                                <div class="input-line"><span style="margin-left:-2px">04</span><span style="margin-left:6px">12</span><span style="margin-left:10px">2024</span></div>
                                <div class="input-line" style="margin-left: 100px;">123122</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <div class="input-line" style="margin-left: 80px; margin-top: 5px;">John Doe</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <div class="input-line" style="margin-left: 100px; margin-top: 8px;">123 Street, City</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <div class="input-line" style="margin-left: 128px; margin-top: 8px;">0311-1234567</div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 20%; vertical-align: top;">
                    <table>
                        <tr>
                            <td>
                                <div class="input-line" style="margin-left: 38px; margin-top: -3px;">20 y</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-line" style="margin-left:65px; margin-top: 5px;">80 kg</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-line" style="margin-left: 77px; margin-top: 18px;"></div>
                                <div class="input-line" style="margin-left: 45px; margin-top: 18px;"><img src="{{ public_path('pdfs/check.png') }}" alt="F" style="width: 12px; height: 12px;"></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="form-section-mid" style="height:4.4in;margin-top: 0.8in;">
            <tr>
				<td style="width:60%"><div style="margin-left: -30px;">fsdfd</div></td>
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
                                <div class="input-line" style="margin-left: -30px;margin-top: 5px;">Yes</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-line" style="margin-left: 130px; margin-top: 8px;">Dr. Smith</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-line" style="margin-left: 25px; margin-top: 5px;">324534534</div>
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
