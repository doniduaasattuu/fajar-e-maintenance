 <!-- ======================= FOR MOTOR REGISTRATION PAGE START ====================== -->
 <form action="/{{ $action }}" method="post" id="forms">
     @csrf
     <div>
         @foreach ($motorService->getColumns('motors', ['updated_at']) as $column) <!-- FORM MOTOR -->
         <div class="mb-3">
             <label for="{{ $column }}" class="form-label fw-semibold">{{ $column == 'id' ? 'Motor' : ucfirst(str_replace("_", " ", $column)) }}</label>
             @switch($column)

             {{-- ID --}}
             @case('id')
             <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="9" class="form-control" oninput="toupper(this)" onkeypress="return /[a-zA-Z0-9]/i.test(event.key)">
             @break

             {{-- STATUS --}}
             @case('status')
             <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
                 @foreach ($motorService->statusEnum() as $option )
                 <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
                 @endforeach
             </select>
             @break

             {{-- FUNCLOC --}}
             @case('funcloc')
             <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control" oninput="toupper(this)" onkeypress="return /[a-zA-Z0-9-]/i.test(event.key)">
             @break

             {{-- MATERIAL NUMBER --}}
             @case('material_number')
             <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="8" class="form-control" onkeypress="return onlynumber(event, 48, 57)">
             @break

             {{-- UNIQUE ID --}}
             @case('unique_id')
             <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="6" class="form-control" onkeypress="return onlynumber(event, 48, 57)">
             @break

             {{-- QR CODE LINK --}}
             @case('qr_code_link')
             <input readonly value="{{ (null != old($column)) ? old($column) : 'https://www.safesave.info/MIC.php?id=Fajar-MotorList' }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="100" class="form-control">
             @break

             {{-- CREATED AT --}}
             @case('created_at')
             <input readonly value="{{ Carbon\Carbon::now() }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="19" class="form-control">
             @break

             {{-- SORT FIELD, DESCRIPTION --}}
             @default
             <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control" oninput="toupper(this)">
             @endswitch
             @include('utility.error-help')
         </div>
         @endforeach <!-- FORM MOTOR -->
     </div>

     <div class="alert alert-info alert-dismissible mt-4 shadow-md shadow" role=" alert">
         All fields below can be blank.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>

     <div>
         @foreach ($motorService->getColumns('motor_details', ['id', 'motor_detail', 'created_at', 'updated_at']) as $column) <!-- FORM MOTOR DETAILS -->
         <div class="mb-3">
             <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
             @switch($column)

             {{-- NUMERIC TYPE --}}
             @case('power_rate')
             <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" oninput="toupper(this)" onkeypress="return onlynumber(event, 46, 57)">
             @break
             {{-- NUMERIC TYPE --}}

             {{-- MAX: 10 --}}
             @case('voltage')
             @case('current_nominal')
             @case('frequency')
             @case('pole')
             @case('rpm')
             @case('shaft_diameter')
             @case('cos_phi')
             @case('efficiency')
             @case('ip_rating')
             @case('insulation_class')
             @case('duty')
             @case('greasing_qty_de')
             @case('greasing_qty_nde')
             @case('length')
             @case('width')
             @case('height')
             @case('weight')
             <input maxlength="10" value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" oninput="toupper(this)">
             @break
             {{-- MAX: 10 --}}

             {{-- MAX: 25 --}}
             @case('bearing_de')
             @case('bearing_nde')
             @case('frame_type')
             @case('connection_type')
             @case('greasing_type')
             <input maxlength="25" value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" oninput="toupper(this)">
             @break
             {{-- MAX: 25 --}}

             {{-- ENUM TYPE --}}
             @case('power_unit')
             @case('electrical_current')
             @case('nipple_grease')
             @case('cooling_fan')
             @case('mounting')
             <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
                 @if ($column == 'power_unit')
                 @foreach ($motorService->powerUnitEnum() as $option )
                 <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
                 @endforeach

                 @elseif ($column == 'electrical_current')
                 @foreach ($motorService->electricalCurrentEnum() as $option )
                 <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
                 @endforeach

                 @elseif ($column == 'nipple_grease')
                 @foreach ($motorService->nippleGreaseEnum() as $option )
                 <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
                 @endforeach

                 @elseif ($column == 'cooling_fan')
                 @foreach ($motorService->coolingFanEnum() as $option )
                 <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
                 @endforeach

                 @elseif ($column == 'mounting')
                 @foreach ($motorService->mountingEnum() as $option )
                 <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
                 @endforeach

                 @endif
             </select>
             @break
             {{-- ENUM TYPE --}}

             @default
             <input maxlength="50" value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" oninput="toupper(this)">
             @endswitch
             @include('utility.error-help')
         </div>
         @endforeach <!-- FORM MOTOR DETAILS -->
     </div>

     <button type="submit" class="btn btn-primary">{{ isset($motor) ? 'Update' : 'Submit' }}</button>
 </form>
 <!-- ======================== FOR MOTOR REGISTRATION PAGE END ======================= -->