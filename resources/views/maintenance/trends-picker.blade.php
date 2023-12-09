<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body class="overflow-hidden">

    @include("utility.navbar")

    <!-- MESSAGE -->
    @if (session("message"))
    <div class="modal fade" id="message" tabindex="-1" aria-labelledby="messageLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="bg-light modal-header">
                    <h1 class=" modal-title fs-5" id="messageLabel">Message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session("message") }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let message = new bootstrap.Modal(document.getElementById('message'), {});
        message.show();
    </script>
    @endif
    <!-- MESSAGE -->

    <div class="container d-flex absolute mt-5 vh-100">
        <div class="my-4 py-5 position-absolute top-50 start-50 translate-middle" style="min-width: 300px;">
            <!-- my-auto align-items-center mx-auto   -->
            <form id="/trends-picker" method="post">
                @csrf
                @isset($message)
                <div class="alert alert-info" role="alert">
                    {{ $message }}
                </div>
                @endisset

                <h2 class="mb-4">Equipment Trend</h2>

                <div class=" mb-3">
                    <label for="start_date" class="form-label -mb-5">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" aria-describedby="dateHelp">
                </div>

                <div class=" mb-3">
                    <label for="end_date" class="form-label -mb-5">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" aria-describedby="dateHelp">
                </div>

                <div class=" mb-3">
                    <label for="equipment" class="form-label -mb-5">Equipment</label>
                    <input name="equipment" id="equipment" class="form-control" aria-describedby="listHelp">
                    <!-- <input list="emo_datalist" name="equipment" id="equipment" class="form-control" aria-describedby="listHelp"> -->
                    <!-- <datalist id="emo_datalist"> -->
                    </datalist>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <!-- <div id="emailHelp" class="mt-2 form-text">Want to change your name ?, click <a class="text-decoration-none" href="/change-name">here</a></div> -->
            </form>
        </div>
    </div>

    <script>
        // const emo_datalist = document.getElementById("emo_datalist");
        // const emo_input = document.getElementById("emo_input");
        // const end_date = document.getElementById("end_date");

        // function addZero(value) {
        //     if (value < 10) {
        //         return "0" + value;
        //     } else {
        //         return value;
        //     }
        // }

        // let date = new Date()
        // let tanggal = addZero(date.getDate() + 1)
        // let bulan = addZero(date.getMonth() + 1)
        // let tahun = date.getFullYear()
        // end_date.value = tahun + "-" + bulan + "-" + tanggal

        // GET EMO LIST IN DATA RECORD
        // const ajax = new XMLHttpRequest();
        // ajax.open("GET", "/emo-datalist")
        // ajax.onload = () => {
        //     if (ajax.readyState == 4) {

        //         let emo_datalist_length = JSON.parse(ajax.response).length;
        //         for (let i = 0; i < emo_datalist_length; i++) {
        //             emo_value = JSON.parse(ajax.response)[i].emo
        //             let emo_option = document.createElement("option");
        //             emo_option.value = emo_value;
        //             emo_option.textContent = emo_value;
        //             emo_datalist.appendChild(emo_option);
        //         }
        //     }
        // }
        // ajax.send();

        // let trends_picker = document.getElementById("trends-picker");
        // trends_picker.onchange = () => {
        //     trends_picker.setAttribute("action", "/trends-picker/" + emo_input.value);
        // }
    </script>
</body>

</html>