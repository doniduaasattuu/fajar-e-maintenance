@include('utility.prefix')

<div class="py-4">

    <div class="mb-3">
        <h3 class="mb-1">{{ $title }}</h3>
        <nav aria-label=" breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/motors">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ isset($motor) != null ? $motor->id : $title }}</li>
            </ol>
        </nav>
    </div>

    @include('utility.alert')

    @isset($action)
    <form action="/{{ $action }}" method="post" id="forms">
        @endisset

        @csrf

        @foreach ($motorService->getTableColumns() as $column )

        <div class="mb-3">
            <label for="{{ $column }}" class="form-label fw-semibold">{{ $column == 'id' ? 'Motor' : ucfirst(str_replace("_", " ", $column)) }}</label>

            @if (isset($motor) && !isset($readonly))
            <!-- FOR EDIT MOTOR PAGE -->
            @if (
            $column == 'id' ||
            $column == 'unique_id' ||
            $column == 'qr_code_link' ||
            $column == 'created_at'
            )
            <input readonly value="{{ $motor->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="9" class="form-control">
            @include('utility.error-help')

            @elseif ($column == 'status')
            <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
                @foreach ($motorService->statusEnum() as $status )
                @if ($status == $motor->$column)
                <option selected value="{{ $motor->$column }}">{{ $motor->$column }}</option>
                @else
                <option value="{{ $status }}">{{ $status }}</option>
                @endif
                @endforeach
            </select>
            @include('utility.error-help')

            @elseif ($column == 'updated_at' )
            <input readonly value="{{ Carbon\Carbon::now() }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="19" class="form-control">
            @include('utility.error-help')

            @elseif ($column == 'material_number')
            <input value="{{ $motor->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="8" class="form-control" onkeypress="return onlynumber(event)">
            @include('utility.error-help')

            @else
            <input value="{{ $motor->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control">
            @include('utility.error-help')
            <!-- FOR EDIT MOTOR PAGE -->
            @endif

            <!-- ==================================================== -->

            <!-- FOR MOTOR DETAILS PAGE -->
            @elseif (isset($readonly))
            <input disabled readonly value="{{ $motor->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control">
            <!-- FOR MOTOR DETAILS PAGE -->

            <!-- ==================================================== -->

            @else
            <!-- FOR INSERT MOTOR PAGE -->
            @if ($column == 'created_at' || $column == 'updated_at')
            <input readonly value="{{ Carbon\Carbon::now() }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control">
            @include('utility.error-help')

            @elseif ($column == 'id')
            <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="9" class="form-control">
            @include('utility.error-help')

            @elseif ($column == 'unique_id')
            <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="5" class="form-control" onkeypress="return onlynumber(event)">
            @include('utility.error-help')

            @elseif ($column == 'qr_code_link')
            <input readonly value="https://www.safesave.info/MIC.php?id=Fajar-MotorList" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="57" class="form-control">
            @include('utility.error-help')

            @elseif ($column == 'material_number')
            <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="8" class="form-control" onkeypress="return onlynumber(event)">
            @include('utility.error-help')

            @elseif ($column == 'status')
            <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
                @if (null != old('status'))

                <!-- USING OLD DATA -->
                @foreach ($motorService->statusEnum() as $status )
                @if (old('status') == $column)
                <option selected value="{{ $status }}">{{ $status }}</option>
                @else
                <option value="{{ $status }}">{{ $status }}</option>
                @endif
                @endforeach

                <!-- USING NORMAL LOOPING -->
                @else
                @foreach ($motorService->statusEnum() as $status )
                <option value="{{ $status }}">{{ $status }}</option>
                @endforeach

                @endif
            </select>
            @include('utility.error-help')

            @else
            <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control">
            @include('utility.error-help')

            @endif
            <!-- FOR INSERT MOTOR PAGE -->

            @endif

        </div>

        @endforeach

        <!-- ============================================ MOTOR DETAILS ============================================== -->

        <!-- MOTOR DETAILS START -->
        <!-- FOR MOTOR DETAILS PAGE -->
        @if (isset($motor->MotorDetail))
        @foreach ($motor->MotorDetail->toArray() as $key => $value )

        @if ($key == 'id' || $key == 'motor_detail')
        @continue
        @else
        <div class="mb-3">
            <label for="{{ $key }}" class="form-label fw-semibold">{{ str_replace('_', ' ', ucfirst($key)) }}</label>
            <input disabled readonly value="{{ $value }}" id="{{ $value }}" name="{{ $value }}" type="text" maxlength="50" class="form-control">
        </div>
        @endif
        @endforeach
        <!-- FOR MOTOR DETAILS PAGE -->


        @endif
        <!-- MOTOR DETAILS END -->

        @isset($action)
        <button type="submit" class="btn btn-primary">{{ isset($motor) ? 'Update' : 'Submit' }}</button>
        <form>
            @endisset
</div>

<script>
    let id = document.getElementById('id');
    let unique_id = document.getElementById('unique_id');
    let qr_code_link = document.getElementById('qr_code_link');
    let status = document.getElementById('status');
    let funcloc = document.getElementById('funcloc')
    let sort_field = document.getElementById('sort_field')
    let current_funcloc = '';
    let current_sort_field = '';

    if (<?php echo json_encode(isset($action)) ?>) {
        for (let input of document.getElementById('forms')) {
            if (input.getAttribute('id') == 'id' ||
                input.getAttribute('id') == 'funcloc' ||
                input.getAttribute('id') == 'sort_field' ||
                input.getAttribute('id') == 'description'
            ) {
                input.oninput = () => {
                    input.value = input.value.toUpperCase();
                }
            }
        }
    }

    status.onchange = () => {
        if (status.value == 'Repaired' || status.value == 'Available') {
            // IF STATUS VALUE IS NOT INSTALLED
            if (funcloc.value.length > 0 && sort_field.value.length > 0) {
                current_funcloc = funcloc.value;
                current_sort_field = sort_field.value;
            }

            funcloc.setAttribute('readonly', 'd-none');
            sort_field.setAttribute('readonly', 'd-none');

            funcloc.value = '';
            sort_field.value = '';
        } else {
            // IF STATUS VALUE IS INSTALLED
            funcloc.value = current_funcloc;
            sort_field.value = current_sort_field;

            funcloc.removeAttribute('readonly');
            sort_field.removeAttribute('readonly');
        }
    }

    unique_id.oninput = () => {
        qr_code_link.value = "";
        let link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList";
        qr_code_link.value = link + unique_id.value;
    }
</script>
@include('utility.script.onlynumber')
@include('utility.suffix')