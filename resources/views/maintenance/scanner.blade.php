<!DOCTYPE html>
<html lang="en">

@include("utility.head")

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
    @include("utility.navbar")

    <div class="container mt-5">
        <div id="reader"></div>
        <!-- d-flex justify-content-center align-item-center -->
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
    <script>
        let buttonRequest = document.getElementById("html5-qrcode-button-camera-permission");
        let fromFile = document.getElementById("html5-qrcode-anchor-scan-type-change");
        let reader = document.getElementById("reader");

        buttonRequest.classList.add("btn");
        buttonRequest.classList.add("btn-primary");

        fromFile.classList.add("btn");
        fromFile.classList.add("btn-secondary");
        fromFile.classList.add("mt-3");

        reader.style.border = "none";
    </script>
</body>

</html>