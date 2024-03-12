@props(['equipment', 'record' => false])

<div class="mb-4">
    <div class="mb-3">
        @if ($equipment->status != 'Installed')
        <h5 class="text-break lh-sm mb-0">{{ $equipment->status }}</h5>
        @endif
        @if ($record)
        <h5 class="text-break lh-sm mb-0">[ EDIT {{ $equipment->sort_field ?? '' }} RECORD ]</h5>
        @else
        <h5 class="text-break lh-sm mb-0">{{ $equipment->sort_field ?? '' }}</h5>
        @endif
        <p class="text-break mb-0 text-secondary">{{ $equipment->description ?? '' }}</p>
        <p class="text-break lh-sm mb-0 text-secondary">{{ $equipment->funcloc ?? '' }}</p>
        <p class="text-break lh-sm mb-0 text-secondary">{{ $equipment->id . " ({$equipment->unique_id})" }}</p>
    </div>
</div>