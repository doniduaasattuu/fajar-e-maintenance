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
    <form action="/{{ $action }}" method="post">
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
            <input id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control">
            @include('utility.error-help')

            @endif
            <!-- FOR INSERT MOTOR PAGE -->
            @endif

        </div>

        @endforeach

        <!-- MOTOR DETAILS START -->
        <!-- FOREACH -->
        <!-- MOTOR DETAILS END -->

        @isset($action)
        <button type="submit" class="btn btn-primary">{{ isset($motor) ? 'Update' : 'Submit' }}</button>
        <form>
            @endisset
</div>
@include('utility.script.onlynumber')
@include('utility.suffix')