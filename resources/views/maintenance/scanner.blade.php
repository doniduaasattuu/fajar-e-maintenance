<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .container {
        display: flex;
        justify-content: center;
    }

    #reader {
        width: 600px;
        height: 600px;
    }
</style>

<body>
    <div class="container">
        <div id="reader"></div>
    </div>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script type="text/javascript">
        function onScanSuccess(decodedText, decodedResult) {

            $motorList = decodedText.substring(37, decodedText.length);
            window.location = `/checking-form/${$motorList}`;

            html5QrcodeScanner.clear();
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },

            false);
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>

</html>