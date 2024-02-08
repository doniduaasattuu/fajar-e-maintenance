@include('utility.prefix')

<div class="py-4">

    <div class="my-4 py-5 position-absolute top-50 start-50 translate-middle" style="min-width: 300px;">

        <form id="/trends" method="post">
            @csrf

            <h2 class="mb-4">Trends</h2>

            <div class="mb-3">
                <label for="trends_equipment" class="form-label fw-semibold">Equipment</label>
                <input value="{{ old('equipment') }}" type="text" id="trends_equipment" name="equipment" oninput="return toupper(this)" maxlength="9" class="form-control" aria-describedby="equipment">
                @include('utility.error-help', ['column' => 'equipment'])
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label fw-semibold">Start date</label>
                <input value="{{ old('start_date') }}" type="date" name="start_date" id="start_date" class="form-control" aria-describedby="dateHelp">
                @unless ($errors->get('start_date'))
                <small id="emailHelp" class="form-text text-muted">The default date is one year from today.</small>
                @endunless
                @include('utility.error-help', ['column' => 'start_date'])
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label fw-semibold">End date</label>
                <input value="{{ old('end_date') }}" type="date" name="end_date" id="end_date" class="form-control" aria-describedby="dateHelp">
                @unless ($errors->get('end_date'))
                <small id="emailHelp" class="form-text text-muted">The default date is tomorrow.</small>
                @endunless
                @include('utility.error-help', ['column' => 'end_date'])
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</div>

@include('utility.script.toupper')
@include('utility.suffix')