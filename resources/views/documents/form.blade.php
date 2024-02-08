@php
$skipped = ['id', 'uploaded_by', 'created_at', 'updated_at'];
@endphp

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
            <input type="hidden" id="uploaded_by" name="uploaded_by" value="{{ $document->uploaded_by }}">
            @include('utility.error-help', ['column' => 'uploaded_by'])
            @endisset

            @foreach ($documentService->getColumns('documents', $skipped) as $column) {{-- DOCUMENT COLUMN --}}
            <div class="mb-3">
                <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst($column) }}</label>

                @switch($column)

                {{-- AREA --}}
                @case('area')
                <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
                    <option value="">-- Choose --</option>
                    @foreach ($documentService->areas() as $option )
                    <option @selected( isset($document) ? ($document->$column==$option) : old($column)==$option) value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
                @break

                {{-- ATTACHMENT --}}
                @case('attachment')
                <div class="input-group">
                    <input class="form-control" type="file" id="attachment" aria-label="Upload" name="attachment">
                    @if( isset($document) && $document->attachment !== null)
                    <button class="btn btn-outline-secondary" type="button" id="image"><a target="_blank" class="text-reset text-decoration-none" href="/storage/documents/{{ $document->$column }}">Existing</a></button>
                    @endif
                </div>
                @unless ($errors->any())
                <div class="form-text text-secondary">Maximum upload file size: 25 MB.</div>
                @endunless
                @break

                @default
                <input value="{{ null != old($column) ? old($column) : (isset($document) ? $document->$column : '' ) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" @if ($column !='title' ) oninput="return toupper(this)" @endif maxlength="{{ $column == 'equipment' ? 9 : 50 }}" placeholder="{{ $column == 'title' ? 'Min 15 character' : 'This field can be empty' }}">
                @endswitch

                @include('utility.error-help')
            </div>
            @endforeach {{-- document COLUMN --}}
        </div>

        {{-- BUTTON SUBMIT --}}
        <button type="submit" class="btn btn-primary">{{ isset($document) ? 'Update' : 'Submit' }}</button>
    </form>

</div>

@include('utility.suffix')