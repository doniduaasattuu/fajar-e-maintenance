<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body class="overflow-hidden">

    @include("utility.navbar")

    <div class="container d-flex absolute mt-5 vh-100">
        <div class="my-4 py-5 position-absolute top-50 start-50 translate-middle" style="min-width: 300px;">
            <!-- my-auto align-items-center mx-auto   -->
            <form id="trends-picker" method="get">

                @isset($error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
                @endisset

                <h2 class="mb-4">{{ $header }}</h2>

                <div class=" mb-3">
                    <label for="start_date" class="form-label -mb-5">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" aria-describedby="dateHelp">
                </div>

                <div class=" mb-3">
                    <label for="end_date" class="form-label -mb-5">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" aria-describedby="dateHelp">
                </div>

                <div class=" mb-3">
                    <label for="emo_input" class="form-label -mb-5">Equipment</label>
                    <input list="emo_datalist" id="emo_input" class="form-control" aria-describedby="listHelp">
                    <datalist id="emo_datalist">
                    </datalist>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <!-- <div id="emailHelp" class="mt-2 form-text">Want to change your name ?, click <a class="text-decoration-none" href="/change-name">here</a></div> -->
            </form>
        </div>
    </div>

    <script>
        const emo_datalist = document.getElementById("emo_datalist");
        const emo_input = document.getElementById("emo_input");
        const ajax = new XMLHttpRequest();

        const end_date = document.getElementById("end_date");

        function addZero(value) {
            if (value < 10) {
                return "0" + value;
            } else {
                return value;
            }
        }

        let date = new Date()
        let tanggal = addZero(date.getDate() + 1)
        let bulan = addZero(date.getMonth() + 1)
        let tahun = date.getFullYear()
        end_date.value = tahun + "-" + bulan + "-" + tanggal

        // GET EMO LIST IN DATA RECORD
        ajax.open("GET", "/emo-datalist")
        ajax.onload = () => {
            if (ajax.readyState == 4) {

                let emo_datalist_length = JSON.parse(ajax.response).length;
                for (let i = 0; i < emo_datalist_length; i++) {
                    emo_value = JSON.parse(ajax.response)[i].emo
                    let emo_option = document.createElement("option");
                    emo_option.value = emo_value;
                    emo_option.textContent = emo_value;
                    emo_datalist.appendChild(emo_option);
                }
            }
        }
        ajax.send();

        let trends_picker = document.getElementById("trends-picker");
        trends_picker.onchange = () => {
            trends_picker.setAttribute("action", "/trends/" + emo_input.value);
        }
    </script>
</body>

</html>