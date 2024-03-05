@props( ['equipmentDetail', 'utility' => 'App\Services\Utility', 'table', 'skipped' => ['id']] )

<div class="accordion mb-4" id="accordionDetails">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="bg-primary text-white accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="false" aria-controls="collapse">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-view-list" viewBox="0 0 16 16">
                    <path d="M3 4.5h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1H3zM1 2a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 2zm0 12a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 14z" />
                </svg>
                <div class="ms-2 d-inline fw-semibold">{{ $slot }}</d>
            </button>
        </h2>
        <div id="collapse" class="accordion-collapse collapse" data-bs-parent="#accordionDetails">
            <div class="accordion-body">
                <table class="table table-hover">
                    <tbody>

                        @isset($equipmentDetail)
                        @foreach ($utility::getColumns($table, $skipped) as $column)
                        <tr>
                            <th>{{ ucfirst(str_replace('_' , ' ', $column)) }}</th>
                            <td>{{ $equipmentDetail->$column }}</td>
                        </tr>
                        @endforeach
                        @endisset

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>