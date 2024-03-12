<x-report-layout>
    <div>
        <caption>Fajar E-Maintenance - {{ $title }}</caption>

        <table class="table table-sm mb-0">
            <tr>
                <thead>
                    @foreach ($selected_columns as $column)

                    @switch($column)

                    {{-- MOTOR STATUS --}}
                    @case('motor_status')
                    <th>Status</th>
                    @break

                    {{-- FUNCLOC --}}
                    @case('funcloc')
                    <th>Area</th>
                    @break

                    {{-- NUMBER OF GREASING --}}
                    @case('number_of_greasing')
                    <th>Greasing</th>
                    @break

                    {{-- TEMPERATURE --}}
                    @case('temperature_de')
                    @case('temperature_body')
                    @case('temperature_nde')
                    <th>{{ strlen(explode('_', $column)[1]) > 3 ? ucfirst(explode('_', $column)[1]) : strtoupper(explode('_', $column)[1]) }} temp</th>
                    @break

                    {{-- VIBRATION DE --}}
                    @case('vibration_de_vertical_value')
                    @case('vibration_de_horizontal_value')
                    @case('vibration_de_axial_value')
                    @case('vibration_de_frame_value')
                    <th>{{ 'Vib ' . strtoupper(explode('_', $column)[1]) . ucfirst(explode('_', $column)[2][0]) }}</th>
                    @break

                    {{-- VIBRATION NDE --}}
                    @case('vibration_nde_vertical_value')
                    @case('vibration_nde_horizontal_value')
                    @case('vibration_nde_frame_value')
                    <th>{{ 'Vib ' . strtoupper(explode('_', $column)[1]) . ucfirst(explode('_', $column)[2][0]) }}</th>
                    @break

                    {{-- NOISE --}}
                    @case('noise_de')
                    @case('noise_nde')
                    <th>{{ 'Noise ' . strtoupper(explode('_', $column)[1]) }}</th>
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

                    {{-- STATUS --}}
                    @case('motor_status')
                    <td>{{ $record->$column == 'Not Running' ? 'Stop' : 'Run' }}</td>
                    @break

                    {{-- FUNCLOC --}}
                    @case('funcloc')
                    <td>{{ explode('-', $record->$column)[2] }}</td>
                    @break

                    {{-- GREASING --}}
                    @case('number_of_greasing')
                    <td>{{ null != $record->$column ? $record->$column . 'x' : $record->$column }}</td>
                    @break

                    {{-- TEMPERATURE --}}
                    @case('temperature_de')
                    @case('temperature_body')
                    @case('temperature_nde')
                    <td>{{ null != $record->$column ? $record->$column . '°C' : $record->$column }}</td>
                    @break

                    {{-- VIBRATION --}}
                    @case('vibration_de_vertical_value')
                    @case('vibration_de_horizontal_value')
                    @case('vibration_de_axial_value')
                    @case('vibration_de_frame_value')
                    @case('vibration_nde_vertical_value')
                    @case('vibration_nde_horizontal_value')
                    @case('vibration_nde_frame_value')
                    <td>{{ null != $record->$column ? $record->$column . 'mm/s' : $record->$column }}</td>
                    @break

                    {{-- NIK --}}
                    @case('nik')
                    <td>{{ App\Models\User::find($record->$column)->printed_name ?? ''}}</td>
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
    </div>
    </table>
</x-report-layout>