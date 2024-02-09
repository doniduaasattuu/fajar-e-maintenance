@include('utility.prefix', ['container' => 'container-fluid'])

<div class="py-4">

    <table class="rounded table table-light table-hover mb-0 border border-1 shadow-sm table-responsive-md">
        <tr>
            <thead>
                @foreach ($selected_columns as $column)

                @switch($column)

                {{-- MOTOR STATUS --}}
                @case('motor_status')
                <th>Status</th>
                @break

                {{-- NUMBER OF GREASING --}}
                @case('number_of_greasing')
                <th>Greasing</th>
                @break

                {{-- TEMPERATURE --}}
                @case('temperature_de')
                @case('temperature_body')
                @case('temperature_nde')
                <th>{{ strlen(explode('_', $column)[1]) > 3 ? ucfirst(explode('_', $column)[1]) : strtoupper(explode('_', $column)[1]) }}</th>
                @break

                {{-- VIBRATION DE --}}
                @case('vibration_de_vertical_value')
                @case('vibration_de_horizontal_value')
                @case('vibration_de_axial_value')
                @case('vibration_de_frame_value')
                <th>{{ 'Vib ' . strtoupper(explode('_', $column)[1]) . ' ' . ucfirst(explode('_', $column)[2]) }}</th>
                @break

                {{-- VIBRATION NDE --}}
                @case('vibration_nde_vertical_value')
                @case('vibration_nde_horizontal_value')
                @case('vibration_nde_frame_value')
                <th>{{ 'Vib ' . strtoupper(explode('_', $column)[1]) . ' ' . ucfirst(explode('_', $column)[2]) }}</th>
                @break

                {{-- NOISE --}}
                @case('noise_de')
                @case('noise_nde')
                <th>{{ 'Noise ' . strtoupper(explode('_', $column)[1]) }}</th>
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

                {{-- GREASING --}}
                @case('number_of_greasing')
                <td>{{ $record->$column . 'x' }}</td>
                @break

                {{-- TEMPERATURE --}}
                @case('temperature_de')
                @case('temperature_body')
                @case('temperature_nde')
                <td>{{ $record->$column . ' °C' }}</td>
                @break

                {{-- VIBRATION --}}
                @case('vibration_de_vertical_value')
                @case('vibration_de_horizontal_value')
                @case('vibration_de_axial_value')
                @case('vibration_de_frame_value')
                @case('vibration_nde_vertical_value')
                @case('vibration_nde_horizontal_value')
                @case('vibration_nde_frame_value')
                <td>{{ $record->$column . ' mm/s' }}</td>
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