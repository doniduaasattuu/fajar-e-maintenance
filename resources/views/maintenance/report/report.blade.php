@include('utility.prefix')

<div class="py-4">

    <div class="my-4 py-5 position-absolute top-50 start-50 translate-middle" style="min-width: 300px;">

        <form id="/report" method="post">
            @csrf

            <h2 class="mb-3">{{ $title }}</h2>

            <div class="mb-3">
                <label for="table" class="form-label fw-semibold">Equipment</label>
                <select id="table" name="table" class="form-select" aria-label="Default select example">
                    <option @selected(old('table')) value="motors">Motor</option>
                    <option @selected(old('table')) value="trafos">Trafo</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label fw-semibold">Date</label>
                <input value="{{ old('date') }}" type="date" name="date" id="date" class="form-control" aria-describedby="dateHelp">
                @unless ($errors->get('date'))
                <small id="emailHelp" class="form-text text-muted">The default date today.</small>
                @endunless
                @include('utility.error-help', ['column' => 'date'])
            </div>

            <button type="submit" class="btn btn-primary">Generate</button>
        </form>
    </div>

</div>

@include('utility.script.toupper')
@include('utility.suffix')