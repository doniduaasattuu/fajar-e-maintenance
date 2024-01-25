@include('utility.prefix')

<div class="py-4">

    <div class="mb-3">
        <h3 class="mb-1">{{ $title }}</h3>
        <nav aria-label=" breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/funclocs">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ isset($funcloc) != null ? $funcloc->id : $title }}</li>
            </ol>
        </nav>
    </div>

    @include('utility.alert')

    <form action="/{{ $action }}" method="post">

        @csrf

        @foreach ($funclocService->getTableColumns() as $column )

        <div class="mb-3">
            <label for="{{ $column }}" class="form-label fw-semibold">{{ $column == 'id' ? 'Funcloc' : ucfirst(str_replace("_", " ", $column)) }}</label>

            @if (isset($funcloc))
            <!-- FOR EDIT FUNCLOC -->
            @if ($column == 'description')
            <input @readonly($column !='description' ) value="{{ $column != 'updated_at' ? $funcloc->$column : Carbon\Carbon::now() }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control" oninput="toupper(this)">
            @else
            <input @readonly($column !='description' ) value="{{ $column != 'updated_at' ? $funcloc->$column : Carbon\Carbon::now() }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control">
            @endif
            @include('utility.error-help')

            @else
            <!-- FOR INSERT FUNCLOC -->
            @if ($column == 'id')
            <input value="{{ ($column == 'created_at' || $column == 'updated_at') ? Carbon\Carbon::now() : old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control" onkeypress="return /[a-zA-Z0-9-]/i.test(event.key)" oninput="toupper(this)">
            @else
            <input @readonly(($column=='created_at' || $column=='updated_at' )) value="{{ ($column == 'created_at' || $column == 'updated_at') ? Carbon\Carbon::now() : old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control" oninput="toupper(this)">
            @endif
            @include('utility.error-help')
            @endif

        </div>

        @endforeach

        <button type="submit" class="btn btn-primary">{{ isset($funcloc) ? 'Update' : 'Submit' }}</button>

    </form>
</div>

@include('utility.script.toupper')
@include('utility.suffix')