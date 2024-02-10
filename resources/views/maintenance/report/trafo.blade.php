<!DOCTYPE html>
<html lang="en">
@include('utility.head')

@include('utility.navbar')

<body>
    <table style="font-size: 10px;" class="rounded table table-light table-sm table-hover mb-0 border border-1 shadow-sm table-responsive-md">
        <tr>
            <thead>
                @foreach ($selected_columns as $column)

                @switch($column)

                {{-- TRAFO STATUS --}}
                @case('trafo_status')
                <th style="line-height: 30px;" class="text-center px-2">Status</th>
                @break

                {{-- PRIMARY CURRENT --}}
                @case('primary_current_phase_r')
                @case('primary_current_phase_s')
                @case('primary_current_phase_t')
                <th style="line-height: 30px;" class="text-center px-2">{{ 'Prim ' . strtoupper(explode('_', $column)[3]) }}</th>
                @break

                {{-- SECONDARY CURRENT --}}
                @case('secondary_current_phase_r')
                @case('secondary_current_phase_s')
                @case('secondary_current_phase_t')
                <th style="line-height: 30px;" class="text-center px-2">{{ 'Sec ' . strtoupper(explode('_', $column)[3]) }}</th>
                @break

                {{-- PRIMARY VOLTAGE --}}
                @case('primary_voltage')
                <th style="line-height: 30px;" class="text-center px-2">{{ 'Prim V' }}</th>
                @break

                {{-- SECONDARY VOLTAGE --}}
                @case('secondary_voltage')
                <th style="line-height: 30px;" class="text-center px-2">{{ 'Sec V' }}</th>
                @break

                {{-- TEMPERATURE --}}
                @case('oil_temperature')
                @case('winding_temperature')
                <th style="line-height: 30px;" class="text-center px-2">{{ ucfirst(explode('_', $column)[0]) }} temp</th>
                @break

                {{-- CLEANLINESS --}}
                @case('cleanliness')
                <th style="line-height: 30px;" class="text-center px-2">{{ 'Cleanness' }}</th>
                @break

                {{-- OIL LEAKAGE --}}
                {{-- OIL LEVEL --}}
                @case('oil_leakage')
                {{-- @case('oil_level') --}}
                <th style="line-height: 30px;" class="text-center px-2">{{ ucfirst(explode('_', $column)[1]) }}</th>
                @break

                {{-- BLOWER CONDITION --}}
                @case('blower_condition')
                <th style="line-height: 30px;" class="text-center px-2">{{ ucfirst(explode('_', $column)[0]) }}</th>
                @break

                {{-- CREATED_AT --}}
                @case('created_at')
                <th style="line-height: 30px;" class="text-center px-2">Date</th>
                @break

                @default
                <th style="line-height: 30px;" class="text-center px-2">{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                @endswitch

                @endforeach
            </thead>
        </tr>
        @foreach ($records as $record)

        <tr>
            <tbody>
                @foreach ($selected_columns as $column)

                @switch($column)

                {{-- TRAFO --}}
                @case('trafo')
                <td class="text-center px-2" style="font-family: 'Roboto Mono';">{{ $record->$column }}</td>
                @break

                {{-- PRIMARY CURRENT --}}
                @case('primary_current_phase_r')
                @case('primary_current_phase_s')
                @case('primary_current_phase_t')
                {{-- SECONDARY CURRENT --}}
                @case('secondary_current_phase_r')
                @case('secondary_current_phase_s')
                @case('secondary_current_phase_t')
                <td class="text-center px-2">{{ $record->$column . 'A' }}</td>
                @break

                {{-- VOLTAGE --}}
                @case('primary_voltage')
                @case('secondary_voltage')
                <td class="text-center px-2">{{ $record->$column . 'V' }}</td>
                @break

                {{-- TEMPERATURE --}}
                @case('oil_temperature')
                @case('winding_temperature')
                <td class="text-center px-2">{{ $record->$column . '°C' }}</td>
                @break

                {{-- OIL LEVEL --}}
                @case('oil_level')
                <td class="text-center px-2">{{ $record->$column . '%' }}</td>
                @break

                {{-- CREATED AT --}}
                @case('created_at')
                <td class="text-center px-2">{{ Carbon\Carbon::create($record->$column)->format('d M Y') }}</td>
                @break

                @default
                <td class="text-center px-2">{{ ucfirst(str_replace('_', ' ', $record->$column)) }}</td>
                @endswitch


                @endforeach
            </tbody>
        </tr>

        @endforeach
    </table>
</body>

</html>