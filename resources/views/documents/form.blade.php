@include('utility.prefix')

<div class="py-4">

    <div class="mb-3">
        <h3 class="mb-1">{{ $title }}</h3>
        <nav aria-label=" breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/documents">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ isset($document) != null ? $document->id : $title }}</li>
            </ol>
        </nav>
    </div>

    @include('utility.alert')

    <form action="/{{ $action }}" id="forms" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            @isset($document)
            <input type="hidden" id="id" name="id" value="{{ $document->id }}">
            @include('utility.error-help', ['column' => 'id'])
            <input type="hidden" id="reporter" name="reporter" value="{{ $document->reporter }}">
            @include('utility.error-help', ['column' => 'reporter'])
            @endisset

            @foreach ($documentService->getColumns('documents') as $column) {{-- DOCUMENT COLUMN --}}
            <div class="mb-3">
                <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst($column) }}</label>
                <input value="{{ null != old($column) ? old($column) : (isset($document) ? $document->$column : '' ) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" oninput="return toupper(this)" maxlength="25">
                @include('utility.error-help')
            </div>
            @endforeach {{-- document COLUMN --}}
        </div>

        {{-- BUTTON SUBMIT --}}
        <button type="submit" class="btn btn-primary">{{ isset($document) ? 'Update' : 'Submit' }}</button>
    </form>

</div>

@include('utility.suffix')