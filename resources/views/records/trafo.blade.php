@include('utility.prefix', ['container' => 'container-fluid'])

<div class="py-4">

    <table class="rounded table table-light table-hover mb-0 border border-1 shadow-sm table-responsive-md">
        <tr>
            <thead>
                @foreach ($selected_columns as $column)

                @switch($column)

                {{-- TRAFO STATUS --}}
                @case('trafo_status')
                <th>Status</th>
                @break

                {{-- PRIMARY CURRENT --}}
                @case('primary_current_phase_r')
                @case('primary_current_phase_s')
                @case('primary_current_phase_t')
                <th>{{ 'Prim ' . explode('_', $column)[1] . ' ' . strtoupper(explode('_', $column)[3]) }}</th>
                @break

                {{-- SECONDARY CURRENT --}}
                @case('secondary_current_phase_r')
                @case('secondary_current_phase_s')
                @case('secondary_current_phase_t')
                <th>{{ 'Sec ' . explode('_', $column)[1] . ' ' . strtoupper(explode('_', $column)[3]) }}</th>
                @break

                {{-- TEMPERATURE --}}
                @case('oil_temperature')
                @case('winding_temperature')
                <th>{{ ucfirst(explode('_', $column)[0]) }}</th>
                @break

                @default
                <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                @endswitch

                @endforeach
            </thead>
        </tr>
        @foreach ($records as $record)

        <tr>
            <tbody>
                @foreach ($selected_columns as $column)

                @switch($column)

                {{-- PRIMARY CURRENT --}}
                @case('primary_current_phase_r')
                @case('primary_current_phase_s')
                @case('primary_current_phase_t')
                {{-- SECONDARY CURRENT --}}
                @case('secondary_current_phase_r')
                @case('secondary_current_phase_s')
                @case('secondary_current_phase_t')
                <td>{{ $record->$column . ' A' }}</td>
                @break

                {{-- VOLTAGE --}}
                @case('primary_voltage')
                @case('secondary_voltage')
                <td>{{ $record->$column . ' V' }}</td>
                @break

                {{-- TEMPERATURE --}}
                @case('oil_temperature')
                @case('winding_temperature')
                <td>{{ $record->$column . ' °C' }}</td>
                @break

                {{-- OIL LEVEL --}}
                @case('oil_level')
                <td>{{ $record->$column . ' %' }}</td>
                @break

                {{-- CREATED AT --}}
                @case('created_at')
                <td>{{ Carbon\Carbon::create($record->$column)->format('d M Y') }}</td>
                @break

                @default
                <td>{{ ucfirst(str_replace('_', ' ', $record->$column)) }}</td>
                @endswitch


                @endforeach
            </tbody>
        </tr>

        @endforeach
    </table>

</div>

@include('utility.suffix')