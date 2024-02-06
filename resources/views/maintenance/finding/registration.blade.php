<form action="/{{ $action }}" id="forms" method="post" enctype="multipart/form-data">
    @csrf
    <div>

        @foreach ($findingService->getColumns('findings', ['id', 'description', 'image', 'reporter', 'created_at', 'updated_at']) as $column) {{-- FINDING COLUMN --}}
        <div class="mb-3">
            <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst($column) }}</label>

            {{-- STATUS FINDING --}}
            @switch($column)
            @case('status')
            <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
                @foreach ($findingService->findingStatusEnum as $option )
                <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
            @break

            {{-- AREA --}}
            @case('area')
            <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
                <option value="">-- Choose --</option>
                @foreach ($findingService->areas() as $option )
                <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
            @break

            {{-- EQUIPMENT --}}
            @case('equipment')
            <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" oninput="return toupper(this)" maxlength="9">
            @break

            {{-- NOTIFICATION --}}
            @case('notification')
            <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" onkeypress="return onlynumber(event, 48, 57)" maxlength="8">
            @break

            {{-- FUNCLOC --}}
            @default
            <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" oninput="return toupper(this)" maxlength="25">
            @endswitch

            @include('utility.error-help')
        </div>
        @endforeach {{-- FINDING COLUMN --}}

        {{-- DESCRIPTION --}}
        <div class="mb-3">
            <label for="description" class="fw-semibold form-label">Description</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{ isset($finding) ? $finding->description : old('description') }}</textarea>

            @error('description')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- DESCRIPTION --}}

        {{-- IMAGE --}}
        <div class="mb-3">
            <label for="image" class="fw-semibold form-label">Image</label>
            <div class="input-group">
                <input class="form-control" type="file" id="image" aria-label="Upload" name="image" accept="image/png, image/jpeg, image/jpg">
                @if( isset($finding) && $finding->image !== null)
                <button class="btn btn-outline-secondary" type="button" id="image"><a target="_blank" class="text-reset text-decoration-none" href="/storage/findings/{{ $finding->image }}">Existing</a></button>
                @endif
            </div>

            @unless ($errors->any())
            <div class="form-text text-secondary">Maximum upload file size: 5 MB.</div>
            @endunless

            @error('image')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- IMAGE --}}

    </div>

    {{-- BUTTON SUBMIT --}}
    <button type="submit" class="btn btn-primary">{{ isset($motor) ? 'Update' : 'Submit' }}</button>
</form>

@include('utility.script.toupper')
@include('utility.script.onlynumber')