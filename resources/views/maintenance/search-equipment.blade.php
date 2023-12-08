<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body class="overflow-hidden">

    @include("utility.navbar")

    <div class="container d-flex absolute mt-5 vh-100">
        <div class="my-4 py-5 position-absolute top-50 start-50 translate-middle" style="min-width: 300px;">

            @isset($message)
            <div class="alert alert-info" role="alert">
                {{ $message }}
            </div>
            @endisset

            <form id="form-equipment" action="/edit-equipment" method="post">
                @csrf
                <div class="mb-3">
                    <h2>Equipment</h2>
                    <div class="form-text">Look for the equipment you want to update.</div>
                </div>

                <div class=" mb-3">
                    <div>
                        <input placeholder="Equipment is required" name="equipment" id="equipment" class="form-control" aria-describedby="listHelp">
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" value="true" name="equipment_details" id="equipment_details">
                        <label class="form-check-label" for="equipment_details">
                            With equipment details
                        </label>
                    </div>
                </div>

                <button id="button_submit" disabled type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    <script>
        let form_equipment = document.getElementById("form-equipment");
        const emo_input = document.getElementById("equipment");
        // const emo_details = document.getElementById("emo_details");
        const button_submit = document.getElementById("button_submit");

        form_equipment.oninput = () => {
            if (emo_input.value.length == 9) {
                button_submit.removeAttribute("disabled");
            } else {
                button_submit.setAttribute("disabled", true);
            }
        }

        // let emo_datalist = document.getElementById("emo_datalist");

        // GET EMO LIST IN DATA RECORD
        // const ajax = new XMLHttpRequest();
        // ajax.open("GET", "/emo-datalist")
        // ajax.onload = () => {
        //     if (ajax.readyState == 4) {

        //         let emo_datalist_length = JSON.parse(ajax.response).length;
        //         for (let i = 0; i < emo_datalist_length; i++) {
        //             let emo_value = JSON.parse(ajax.response)[i].emo
        //             let emo_option = document.createElement("option");
        //             emo_option.value = emo_value;
        //             emo_option.textContent = emo_value;
        //             emo_datalist.appendChild(emo_option);
        //         }
        //     }
        // }
        // ajax.send();
    </script>
</body>

</html>