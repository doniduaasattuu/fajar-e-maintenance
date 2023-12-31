<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body>
    @include("utility.navbar")

    <div class="container py-4">
        <h4 class="text-secondary mb-4">{{ $equipment->id }}</h4>
        <form id="edit_form" action="/update-equipment" method="post">
            @csrf

            <!-- TABLE -->
            <input class="d-none" readonly name="table" type="text" class="form-control" value="{{ $equipment->getTable() }}">
            <!-- TABLE -->

            @if ($equipment->getTable() == "emos") <!-- EQUIPMENT FOREACH -->

            <!-- EQUIPMENT EMO START -->
            @foreach ($equipment->toArray() as $key => $value )
            @if ($key != "emo_details")

            @if ($key == "status")
            <!-- IF STATUS_MOTOR -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($key)) }}</label>
                <div class="col-xl-10">
                    <select name="{{ $key }}" id="{{ $key }}" value="{{ $value }}" class="form-select" aria-label="Default select example">
                        <option value="Repaired">Repaired</option>
                        <option value="Installed">Installed</option>
                        <option value="Available">Available</option>
                    </select>
                </div>
            </div>
            @continue
            @endif

            <div class="form-group row mb-3">
                <label for="{{ $key }}" class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($key)) }}</label>
                <div class="col-xl-10">
                    <input name="{{ $key }}" id="{{ $key }}" type="text" class="form-control" value="{{ $value }}">
                </div>
            </div>


            @else

            @foreach ($value as $equipment_details_key => $equipment_details_value ) <!-- EQUIPMENT DETAILS -->

            <!-- ======================================================================== -->
            @if ($equipment_details_key == "power_unit")
            <!-- POWER UNIT -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($equipment_details_key)) }}</label>
                <div class="col-xl-10">
                    <select name="{{ $equipment_details_key }}" id="{{ $equipment_details_key }}" value="{{ $equipment_details_value }}" class="form-select" aria-label="Default select example">
                        <option value="kW">kW</option>
                        <option value="HP">HP</option>
                    </select>
                </div>
            </div>
            @continue
            @endif
            <!-- ======================================================================== -->

            <!-- ======================================================================== -->
            @if ($equipment_details_key == "nipple_grease")
            <!-- NIPPLE GREASE -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($equipment_details_key)) }}</label>
                <div class="col-xl-10">
                    <select name="{{ $equipment_details_key }}" id="{{ $equipment_details_key }}" value="{{ $equipment_details_value }}" class="form-select" aria-label="Default select example">
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                    </select>
                </div>
            </div>
            @continue
            @endif
            <!-- ======================================================================== -->

            <!-- ======================================================================== -->
            @if ($equipment_details_key == "cooling_fan")
            <!-- COOLING FAN -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($equipment_details_key)) }}</label>
                <div class="col-xl-10">
                    <select name="{{ $equipment_details_key }}" id="{{ $equipment_details_key }}" value="{{ $equipment_details_value }}" class="form-select" aria-label="Default select example">
                        <option value="Internal">Internal</option>
                        <option value="External">External</option>
                        <option value="Not Available">Not Available</option>
                    </select>
                </div>
            </div>
            @continue
            @endif
            <!-- ======================================================================== -->

            <!-- ======================================================================== -->
            @if ($equipment_details_key == "mounting")
            <!-- MOUNTING -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($equipment_details_key)) }}</label>
                <div class="col-xl-10">
                    <select name="{{ $equipment_details_key }}" id="{{ $equipment_details_key }}" value="{{ $equipment_details_value }}" list="mounting_list" class="form-select" aria-label="Default select example">
                        <option value="Horizontal">Horizontal</option>
                        <option value="Vertical">Vertical</option>
                        <option value="V/H">V/H</option>
                        <option value="MGM">MGM</option>
                    </select>
                </div>
            </div>
            @continue
            @endif
            <!-- ======================================================================== -->

            <!-- NOT ENUM TYPE -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($equipment_details_key)) }}</label>
                <div class="col-xl-10">
                    <input name="{{ $equipment_details_key }}" id="{{ $equipment_details_key }}" type="text" class="form-control" value="{{ $equipment_details_value }}">
                </div>
            </div>
            <!-- NOT ENUM TYPE -->
            @endforeach

            @endif

            @endforeach <!-- EQUIPMENT DETAILS -->
            <!-- EQUIPMENT EMO END -->

            @elseif ($equipment->getTable() == "transformers") <!-- EQUIPMENT FOREACH -->

            <!-- EQUIPMENT TRANSFORMER START -->
            @foreach ($equipment->toArray() as $key => $value )
            @if ($key != "transformer_details")

            @if ($key == "status")
            <!-- IF STATUS_TRAFO -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($key)) }}</label>
                <div class="col-xl-10">
                    <select name="{{ $key }}" id="{{ $key }}" value="{{ $value }}" class="form-select" aria-label="Default select example">
                        <option value="Repaired">Repaired</option>
                        <option value="Installed">Installed</option>
                        <option value="Available">Available</option>
                    </select>
                </div>
            </div>
            @continue
            @endif

            <div class="form-group row mb-3">
                <label for="{{ $key }}" class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($key)) }}</label>
                <div class="col-xl-10">
                    <input name="{{ $key }}" id="{{ $key }}" type="text" class="form-control" value="{{ $value }}">
                </div>
            </div>


            @else

            @foreach ($value as $equipment_details_key => $equipment_details_value ) <!-- EQUIPMENT DETAILS -->

            <!-- ======================================================================== -->
            @if ($equipment_details_key == "type")
            <!-- TRANSFORMER TYPE -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($equipment_details_key)) }}</label>
                <div class="col-xl-10">
                    <select name="{{ $equipment_details_key }}" id="{{ $equipment_details_key }}" value="{{ $equipment_details_value }}" class="form-select" aria-label="Default select example">
                        <option value="Step Up">Step Up</option>
                        <option value="Step Down">Step Down</option>
                    </select>
                </div>
            </div>
            @continue
            @endif
            <!-- ======================================================================== -->

            <!-- NOT ENUM TYPE -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($equipment_details_key)) }}</label>
                <div class="col-xl-10">
                    <input name="{{ $equipment_details_key }}" id="{{ $equipment_details_key }}" type="text" class="form-control" value="{{ $equipment_details_value }}">
                </div>
            </div>
            <!-- NOT ENUM TYPE -->
            @endforeach

            @endif

            @endforeach <!-- EQUIPMENT DETAILS -->
            <!-- EQUIPMENT TRANSFORMER END -->
            @endif <!-- EQUIPMENT FOREACH -->

            <div>
                <button type="submit" class="mt-2 mb-4 btn btn-primary">
                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2V2Z" />
                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z" />
                    </svg>
                    Save
                </button>
            </div>

        </form>
    </div>

    <script>
        let emo_id = document.getElementById("id");
        emo_id.parentElement.parentElement.style.display = "none";

        // CHANGE VALUE OF SELECT INPUT START
        let selects = document.getElementsByTagName("select");
        for (let i = 0; i < selects.length; i++) {
            let select_value = selects[i].getAttribute("value");
            let options = selects[i].children;

            for (let j = 0; j < options.length; j++) {
                if (options[j].hasAttribute("value") && options[j].getAttribute("value") == select_value) {
                    options[j].setAttribute("selected", true);
                }
            }
        }
        // CHANGE VALUE OF SELECT INPUT END

        // HIDE UPDATED_AT COLUMN
        const updated_at = document.getElementById("updated_at");
        updated_at.parentElement.parentElement.classList.add("d-none");
        // HIDE UPDATED_AT COLUMN

        // DELETE FUNCLOC AND SORTFIELD WHEN NOT INSTALLED
        const status = document.getElementById("status");
        const funcloc = document.getElementById("funcloc");
        const sort_field = document.getElementById("sort_field");

        funcloc_value_temp = "";
        sort_field_value_temp = "";

        status.onchange = () => {
            if (status.value != "Installed") {

                if (funcloc.value != "" && sort_field.value != "") {
                    funcloc_value_temp = funcloc.value;
                    sort_field_value_temp = sort_field.value;
                }

                funcloc.value = "";
                sort_field.value = "";
            } else {
                funcloc.value = funcloc_value_temp;
                sort_field.value = sort_field_value_temp;
            }
        }
    </script>
</body>

</html>