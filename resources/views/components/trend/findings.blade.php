@props(['findings' => [], 'equipment' => ''])

<div class="mb-3 mt-4">
    <h6 class="text-center text-secondary mb-1">Findings of {{ $equipment }}</h6>
    <div class="text-center text-secondary form-text">The top one is the newest.</div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Desc</th>
                <th class="text-center" style="width: 50px;">Img</th>
                <th>Rptr</th>
                <th class="text-center" style="width: 80px;">Date</th>
            </tr>

            @foreach ($findings as $finding)
            <tr>
                <td> {{ $loop->iteration }}</td>
                <td>{{ $finding->description }}</td>
                @if ($finding->image)
                <td data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Click to see" class="text-center" style="width: 50px;">
                    <a href="/storage/findings/{{ $finding->image }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                            <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                            <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12" />
                        </svg>
                    </a>
                </td>
                @else
                <td></td>
                @endif
                <td data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="{{ $finding->reporter }}">{{ explode(' ', $finding->reporter)[0] }}</td>
                <td data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="{{ $finding->created_at }}">{{ Carbon\Carbon::create($finding->created_at)->toDateString() }}</td>
            </tr>
            @endforeach
        </thead>
    </table>
</div>