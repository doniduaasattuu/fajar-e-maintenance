@php
$skipped = [
'id',
'funcloc',
'trafo',
'sort_field',
'primary_current_phase_r',
'primary_current_phase_s',
'primary_current_phase_t',
'secondary_current_phase_r',
'secondary_current_phase_s',
'secondary_current_phase_t',
'nik',
'created_at',
'updated_at',
]
@endphp

@include('utility.prefix')

<div class="py-4">

    {{-- HEADER --}}
    @isset($trafo)
    <div class="mb-3">
        @if ($trafo->status != 'Installed')
        <h5 class="text-break lh-sm mb-0">{{ $trafo->status }}</h5>
        @endif
        <h5 class="text-break lh-sm mb-0">{{ ($trafo->sort_field != null) ? $trafo->sort_field : '' }}</h5>
        <p class="text-break mb-0 text-secondary">{{ ($trafo->description != null) ? $trafo->description : '' }}</p>
        <p class="text-break lh-sm mb-0 text-secondary">{{ ($trafo->funcloc != null) ? $trafo->funcloc : '' }}</p>
        <p class="text-break lh-sm mb-0 text-secondary">{{ $trafo->id }}</p>
    </div>
    @endisset

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <!-- The data you submitted is invalid. -->
        {{ $errors->first() }}
    </div>
    @endif

    {{-- TREND --}}
    @isset($trafo)
    <a href="/equipment-trend/{{ isset($trafo) ? $trafo->id : '' }}" title="Year to date">
        <button class="btn btn-success mb-2 text-white">
            <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z" />
            </svg>
            <div class="d-inline fw-semibold">TRENDS</div>
        </button>
    </a>
    @endisset

    {{-- TRAFO DETAIL --}}
    @isset($trafoDetail)
    @include('utility.trafo-detail-accordion')
    @endisset

    <!-- ========================================= -->
    <!-- ========== CHECKING FORM START ========== -->
    <!-- ========================================= -->
    <form id="myform" action="{{ isset($action) ? $action :'/record-trafo' }}" method="post" enctype="multipart/form-data"> <!-- CHECKING FORM -->
        @csrf

        {{-- DATA TRAFO SEND TO RECORD --}}
        @isset($trafo)
        <input type="hidden" name="funcloc" id="funcloc" value="{{ isset($trafo) ? $trafo->funcloc : '' }}">
        <input type="hidden" name="trafo" id="trafo" value="{{ isset($trafo) ? $trafo->id : '' }}">
        <input type="hidden" name="sort_field" id="sort_field" value="{{ isset($trafo) ? $trafo->sort_field : '' }}">
        <input type="hidden" name="nik" id="nik" value="{{ session('nik') }}">
        @endisset

        {{-- DATA RECORD TO UPDATE --}}
        @isset($record)
        <input type="hidden" name="id" id="id" value="{{ isset($record) ? $record->id : '' }}">
        <input type="hidden" name="funcloc" id="funcloc" value="{{ isset($record) ? $record->funcloc : '' }}">
        <input type="hidden" name="trafo" id="trafo" value="{{ isset($record) ? $record->trafo : '' }}">
        <input type="hidden" name="sort_field" id="sort_field" value="{{ isset($record) ? $record->sort_field : '' }}">
        <input type="hidden" name="nik" id="nik" value="{{ session('nik') }}">
        @endisset

        <div> <!-- TRAFO RECORD WRAPPER -->
            @foreach ($trafoService->getColumns('trafo_records', $skipped) as $column) {{-- CHECKING FORM --}}

            {{-- PRIMARY CURRENT --}}
            @if ($loop->iteration == 2)
            <div class="mb-3">
                <label class="fw-semibold form-label">Primary current</label>
                <div class="row">
                    <div class="col">
                        <input type="number" onkeypress="return onlynumber(event)" min="0" class="form-control" placeholder="Phase R" name="primary_current_phase_r" id="primary_current_phase_r">
                        @error('primary_current_phase_r')
                        <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col px-0">
                        <input type="number" onkeypress="return onlynumber(event)" min="0" class="form-control" placeholder="Phase S" name="primary_current_phase_s" id="primary_current_phase_s">
                        @error('primary_current_phase_s')
                        <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <input type="number" onkeypress="return onlynumber(event)" min="0" class="form-control" placeholder="Phase T" name="primary_current_phase_t" id="primary_current_phase_t">
                        @error('primary_current_phase_t')
                        <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            @endif

            {{-- SECONDARY CURRENT --}}
            @if ($loop->iteration == 2)
            <div class="mb-3">
                <label class="fw-semibold form-label">Secondary current</label>
                <div class="row">
                    <div class="col">
                        <input type="number" onkeypress="return onlynumber(event)" min="0" class="form-control" placeholder="Phase R" name="secondary_current_phase_r" id="secondary_current_phase_r">
                        @error('secondary_current_phase_r')
                        <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col px-0">
                        <input type="number" onkeypress="return onlynumber(event)" min="0" class="form-control" placeholder="Phase S" name="secondary_current_phase_s" id="secondary_current_phase_s">
                        @error('secondary_current_phase_s')
                        <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <input type="number" onkeypress="return onlynumber(event)" min="0" class="form-control" placeholder="Phase T" name="secondary_current_phase_t" id="secondary_current_phase_t">
                        @error('secondary_current_phase_t')
                        <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            @endif

            @switch($column)
            {{-- ENUM TYPE --}}
            @case('trafo_status')
            @case('cleanliness')
            @case('noise')
            @case('silica_gel')
            @case('earthing_connection')
            @case('oil_leakage')
            @case('blower_condition')
            <div class="mb-3">
                <label for="{{ $column }}" class="fw-semibold form-label">{{ ucfirst(str_replace('_', ' ', $column)) }}</label>
                <select name="{{ $column }}" id="{{ $column }}" class="form-select" aria-label="Default select example">
                    @switch($column)
                    @case('trafo_status')
                    @include('utility.looping-option', ['array' => $trafoService->trafoStatusEnum])
                    @break

                    @case('cleanliness')
                    @include('utility.looping-option', ['array' => $trafoService->cleanlinessEnum])
                    @break

                    @case('noise')
                    @include('utility.looping-option', ['array' => $trafoService->noiseEnum])
                    @break

                    @case('silica_gel')
                    @include('utility.looping-option', ['array' => $trafoService->silicaGelEnum])
                    @break

                    @case('earthing_connection')
                    @include('utility.looping-option', ['array' => $trafoService->earthingConnectionEnum])
                    @break

                    @case('oil_leakage')
                    @include('utility.looping-option', ['array' => $trafoService->oilLeakageEnum])
                    @break

                    @case('blower_condition')
                    @include('utility.looping-option', ['array' => $trafoService->blowerConditionEnum])
                    @break

                    @default
                    <option value="">null</option>
                    @endswitch <!-- OPTION -->
                </select>
                @include('utility.error-help')
            </div>
            @break

            @default
            <div class="mb-3">
                <label for="{{ $column }}" class="fw-semibold form-label">{{ ucfirst(str_replace('_', ' ', $column)) }}</label>
                <input value="{{ isset($record) ? $record->$column : old($column) }}" inputmode="numeric" class="form-control" name="{{ $column }}" id="{{ $column }}" type="text" step="10" min="0" max="255" onkeypress="return onlynumber(event, 48, 57)" oninput="return preventmax(this.id, 255)" pattern="\d*" maxlength="4">
                @include('utility.error-help')
            </div>
            @endswitch
            @endforeach {{-- CHECKING FORM --}}

            {{-- FINDING FORM --}}
            @include('utility.finding-checking-form')

            {{-- BUTTON SUBMIT --}}
            @isset($trafo)
            @if ($trafo->status == 'Installed')
            <div>
                <input id="buttonSubmit" class="btn btn-primary" type="submit" value="Submit">
            </div>
            @endif
            @endisset

            {{-- BUTTON UPLOAD --}}
            @isset($record)
            <div>
                <input id="buttonSubmit" class="btn btn-primary" type="submit" value="Update">
            </div>
            @endisset

    </form>
</div>
@include('utility.suffix')