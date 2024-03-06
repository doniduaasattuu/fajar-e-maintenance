@include('maintenance.report.header')

<tr>
    <thead>
        @foreach ($selected_columns as $column)

        @switch($column)

        {{-- FUNCLOC --}}
        @case('funcloc')
        <th>Area</th>
        @break

        {{-- TRAFO STATUS --}}
        @case('trafo_status')
        <th>Status</th>
        @break

        {{-- PRIMARY CURRENT --}}
        @case('primary_current_phase_r')
        @case('primary_current_phase_s')
        @case('primary_current_phase_t')
        <th>{{ 'Pri ' . strtoupper(explode('_', $column)[3]) }}</th>
        @break

        {{-- SECONDARY CURRENT --}}
        @case('secondary_current_phase_r')
        @case('secondary_current_phase_s')
        @case('secondary_current_phase_t')
        <th>{{ 'Sec ' . strtoupper(explode('_', $column)[3]) }}</th>
        @break

        {{-- PRIMARY VOLTAGE --}}
        @case('primary_voltage')
        <th>{{ 'Prim V' }}</th>
        @break

        {{-- SECONDARY VOLTAGE --}}
        @case('secondary_voltage')
        <th>{{ 'Sec V' }}</th>
        @break

        {{-- TEMPERATURE --}}
        @case('oil_temperature')
        @case('winding_temperature')
        <th>{{ ucfirst(explode('_', substr($column, 0, 4))[0]) . ' temp' }}</th>
        @break

        {{-- OIL LEAKAGE --}}
        {{-- OIL LEVEL --}}
        @case('oil_leakage')
        {{-- @case('oil_level') --}}
        <th>{{ ucfirst(explode('_', $column)[1]) }}</th>
        @break

        {{-- BLOWER CONDITION --}}
        @case('blower_condition')
        <th>{{ ucfirst(explode('_', $column)[0]) }}</th>
        @break

        {{-- CLEANLINESS --}}
        @case('cleanliness')
        <th>Clean</th>
        @break

        {{-- NIK --}}
        @case('nik')
        <th>Checker</th>
        @break

        {{-- CREATED_AT --}}
        @case('created_at')
        <th>Date</th>
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

        {{-- FUNCLOC --}}
        @case('funcloc')
        <td>{{ explode('-', $record->$column)[2] }}</td>
        @break

        {{-- TRAFO --}}
        @case('trafo')
        <td>{{ $record->$column }}</td>
        @break

        {{-- PRIMARY CURRENT --}}
        @case('primary_current_phase_r')
        @case('primary_current_phase_s')
        @case('primary_current_phase_t')
        {{-- SECONDARY CURRENT --}}
        @case('secondary_current_phase_r')
        @case('secondary_current_phase_s')
        @case('secondary_current_phase_t')
        <td>{{ null != $record->$column ? $record->$column . 'A' : $record->$column }}</td>
        @break

        {{-- VOLTAGE --}}
        @case('primary_voltage')
        @case('secondary_voltage')
        <td>{{ null != $record->$column ? $record->$column . 'V' : $record->$column }}</td>
        @break

        {{-- TEMPERATURE --}}
        @case('oil_temperature')
        @case('winding_temperature')
        <td>{{ null != $record->$column ? $record->$column . '°C' : $record->$column }}</td>
        @break

        {{-- OIL LEVEL --}}
        @case('oil_level')
        <td>{{ null != $record->$column ? $record->$column . '%' : $record->$column }}</td>
        @break

        {{-- NIK --}}
        @case('nik')
        @inject('user', 'App\Services\UserService' )
        <td>{{ $user->user($record->$column)->printed_name }}</td>
        @break

        {{-- CREATED AT --}}
        @case('created_at')
        <td>{{ Carbon\Carbon::create($record->$column)->format('d-m-y') }}</td>
        @break

        @default
        <td>{{ ucfirst(str_replace('_', ' ', $record->$column)) }}</td>
        @endswitch


        @endforeach
    </tbody>
</tr>
@endforeach

@include('maintenance.report.footer')