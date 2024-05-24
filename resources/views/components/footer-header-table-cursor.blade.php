@props(['paginator', 'total' => '...'])

<div class="form-text">Showing <span id="display_count">{{ $paginator->count() }}</span> of {{ $total}} entries.</div>