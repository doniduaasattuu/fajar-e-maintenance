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

            <form id="form-equipment" method="get">
                <div class="mb-3">
                    <h2>Equipment</h2>
                    <div class="form-text">Look for the equipment you want to update.</div>
                </div>

                <div class=" mb-3">
                    <div>
                        <input placeholder="Equipment is required" id="equipment" class="form-control" aria-describedby="listHelp">
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" value="true" name="emo_details" id="emo_details">
                        <label class="form-check-label" for="emo_details">
                            With Equipment Details
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
        const button_submit = document.getElementById("button_submit");

        form_equipment.onchange = () => {
            form_equipment.setAttribute("action", "/edit-equipment/" + emo_input.value);
            if (emo_input.value.length == 9) {
                button_submit.removeAttribute("disabled");
            } else {
                button_submit.setAttribute("disabled", true);
            }
        }
    </script>
</body>

</html>