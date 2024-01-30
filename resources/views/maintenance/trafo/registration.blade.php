 <!-- ======================= FOR TRAFO REGISTRATION PAGE START ====================== -->
 <form action="/{{ $action }}" method="post" id="forms">
     @csrf
     <div>
         @foreach ($trafoService->getColumns('trafos', ['updated_at']) as $column) <!-- FORM TRAFO -->
         <div class="mb-3">
             <label for="{{ $column }}" class="form-label fw-semibold">{{ $column == 'id' ? 'Trafo' : ucfirst(str_replace("_", " ", $column)) }}</label>
             @switch($column)

             {{-- ID --}}
             @case('id')
             <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="9" class="form-control" oninput="toupper(this)" onkeypress="return /[a-zA-Z0-9]/i.test(event.key)">
             @break

             {{-- STATUS --}}
             @case('status')
             <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
                 @foreach ($trafoService->equipmentStatus as $option )
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
             <input readonly value="{{ (null != old($column)) ? old($column) : 'id=Fajar-TrafoList' }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="100" class="form-control">
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
         @endforeach <!-- FORM trafo -->
     </div>

     <div class="alert alert-info alert-dismissible mt-4 shadow-md shadow" role=" alert">
         All fields below can be blank.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>

     <div>
         @foreach ($trafoService->getColumns('trafo_details', ['id', 'trafo_detail', 'created_at', 'updated_at']) as $column) <!-- FORM TRAFO DETAILS -->
         <div class="mb-3">
             <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
             @switch($column)

             {{-- NUMERIC TYPE --}}
             @case('power_rate')
             <input value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" oninput="toupper(this)" onkeypress="return onlynumber(event, 46, 57)">
             @break
             {{-- NUMERIC TYPE --}}

             {{-- ENUM TYPE --}}
             @case('power_unit')
             @case('type')
             <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">

                 @if ($column == 'power_unit')
                 @foreach ($trafoService->powerUnitEnum as $option )
                 <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
                 @endforeach

                 @elseif ($column == 'type')
                 @foreach ($trafoService->typeEnum as $option )
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
         @endforeach <!-- FORM trafo DETAILS -->
     </div>

     <button type="submit" class="btn btn-primary">{{ isset($trafo) ? 'Update' : 'Submit' }}</button>
 </form>
 <!-- ======================== FOR trafo REGISTRATION PAGE END ======================= -->