<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body class="overflow-hidden">

    @include("utility.navbar")

    <div class="container d-flex absolute mt-5 vh-100">
        <div class="my-4 py-5 position-absolute top-50 start-50 translate-middle" style="min-width: 300px;">
            <form id="form-equipment" method="get">

                <div class="mb-3">
                    <h2>Equipment</h2>
                    <div class="form-text">Look for the equipment you want to update.</div>
                </div>

                <div class=" mb-3">
                    <input id="equipment" class="form-control" aria-describedby="listHelp">
                </div>

                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    <script>
        let form_equipment = document.getElementById("form-equipment");
        const emo_input = document.getElementById("equipment");

        form_equipment.onchange = () => {
            form_equipment.setAttribute("action", "/edit-equipment/" + emo_input.value);
        }
    </script>
</body>

</html>