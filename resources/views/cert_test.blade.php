<html>

<head>
    <style type='text/css'>
        body,
        html {
            margin: 0;
            padding: 0;
        }

        body {
            color: black;
            background-color: rgb(255, 255, 255);
            display: table;
            font-family: Georgia, serif;
            font-size: 24px;
            text-align: center;
        }

        .container {
            border: 20px solid tan;
            width: 750px;
            height: 563px;
            display: table-cell;
            vertical-align: middle;
        }

        .logo {
            color: tan;
        }

        .marquee {
            color: tan;
            font-size: 48px;
            margin: 20px;
        }

        .assignment {
            margin: 20px;
        }

        .person {
            border-bottom: 2px solid rgb(0, 0, 0);
            font-size: 32px;
            font-style: italic;
            margin: 20px auto;
            width: 400px;
        }

        .reason {
            margin: 20px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    {{-- https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js --}}
</head>

<body>
    <div class="container" id="html-content-holder">
        <div class="logo">
            An Organization
        </div>

        <div class="marquee">
            Certificate of Completion
        </div>

        <div class="assignment">
            This certificate is presented to
        </div>

        <div class="person">
            Joe Nathan
        </div>

        <div class="reason">
            For deftly defying the laws of gravity<br />
            and flying high
        </div>
    </div>

    <input id="btn-Preview-Image" type="button" value="Preview" />
    <a id="btn-Convert-Html2Image" href="#">Download</a>
    <br />
    <h3>Preview :</h3>
    <div id="previewImage" style="display: none">
    </div>
</body>
<script type="text/javascript">
    $(document).ready(function() {


        var element = $("#html-content-holder"); // global variable
        var getCanvas; // global variable
        html2canvas(element, {
            onrendered: function(canvas) {
                $("#previewImage").append(canvas);
                getCanvas = canvas;
            }
        });

        $("#btn-Convert-Html2Image").on('click', function() {
            html2canvas(element, {
                backgroundColor: 'rgba(0, 200, 0, 1)',
                onrendered: function(canvas) {
                    $("#previewImage").append(canvas);
                    getCanvas = canvas;
                }
            });
            var imgageData = getCanvas.toDataURL("image/jpeg");
            // Now browser starts downloading it instead of just showing it
            var newData = imgageData.replace(/^data:image\/jpeg/, "data:application/octet-stream");
            $("#btn-Convert-Html2Image").attr("download", "your_pic_name.png").attr("href", newData);
        });

    });
</script>

</html>
