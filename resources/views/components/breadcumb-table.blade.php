@props(['title', 'table', 'table_item' => null])

<div class="mb-3">
    <x-h3>{{ __($title) }}</x-h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/{{ strtolower($table) }}">{{ $table }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ isset($table_item) != null ? $table_item->id : 'New' }}</li>
        </ol>
    </nav>
</div>