@include('utility.prefix')

<div class="py-4">

    <div class="mb-3">
        <h3 class="mb-1">{{ $title }}</h3>
        <nav aria-label=" breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/findings">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ isset($finding) != null ? $finding->id : $title }}</li>
            </ol>
        </nav>
    </div>

    @include('utility.alert')

    @switch($title)

    {{-- FINDING REGISTRATION --}}
    @case('Finding registration')
    @include('maintenance.finding.registration')
    @break

    {{-- EDIT FINDING --}}
    @default
    @include('maintenance.finding.registration')
    @endswitch

</div>

@include('utility.suffix')