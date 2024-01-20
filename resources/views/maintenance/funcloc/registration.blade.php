@include('utility.prefix')

<div class="py-4">

    <div class="mb-3">
        <h3 class="mb-1">{{ $title }}</h3>
        <nav aria-label=" breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/funcloc">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>

    @include('utility.alert')

    <form action="/funcloc-update" method="post">

        @csrf

        @foreach ($funclocService->getTableColumns() as $column)
        <div class="mb-3">
            <label for="{{ $column }}" class="form-label fw-semibold">{{ $column == 'id' ? 'Funcloc' : ucfirst(str_replace("_", " ", $column)) }}</label>
            @if ($column == 'id')
            <input id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control" aria-describedby="{{ $column }}" onkeypress="return /[a-zA-Z0-9-]/i.test(event.key)" oninput="toupper(this)">
            @else
            <input id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control" aria-describedby="{{ $column }}" oninput="toupper(this)">
            @endif
            @error($column)
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror

        </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Update</button>

    </form>
</div>

@include('utility.script.toupper')
@include('utility.suffix')