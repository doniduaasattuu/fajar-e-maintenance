@props(['equipment', 'utility', 'table', 'qr_code_link'])

{{-- ID --}}
<div class="mb-3">
    <x-input-label for="id" :value="__('Id *')" />
    <x-input-text id="id" name="id" :value='old("id", $equipment->id ?? "")' :readonly='isset($equipment) ? true : false' :disabled='!Auth::user()->isAdmin()' />
    <x-input-error :message="$errors->first('id')" />
</div>

{{-- STATUS --}}
<div class="mb-3">
    <x-input-label for="status" :value="__('Status *')" />
    <x-input-select id="status" name="status" :options="$utility::getEnumValue('equipment', 'status')" :value='old("status", $equipment->status ?? "")' :disabled='!Auth::user()->isAdmin()' />
    <x-input-error :message="$errors->first('status')" />
</div>

{{-- FUNCLOC --}}
<div class="mb-3">
    <x-input-label for="funcloc" :value="__('Funcloc')" />
    <x-input-text id="funcloc" name="funcloc" :value='old("funcloc", $equipment->funcloc ?? "")' :disabled='!Auth::user()->isAdmin()' />
    <x-input-error :message="$errors->first('funcloc')" />
</div>

{{-- SORT FIELD --}}
<div class="mb-3">
    <x-input-label for="sort_field" :value="__('Sort field')" />
    <x-input-text id="sort_field" name="sort_field" :value='old("sort_field", $equipment->sort_field ?? "")' :disabled='!Auth::user()->isAdmin()' />
    <x-input-error :message="$errors->first('sort_field')" />
</div>

{{-- DESCRIPTION --}}
<div class="mb-3">
    <x-input-label for="description" :value="__('Description')" />
    <x-input-text id="description" name="description" :value='old("description", $equipment->description ?? "")' :disabled='!Auth::user()->isAdmin()' />
    <x-input-error :message="$errors->first('description')" />
</div>

{{-- UNIQUE ID --}}
<div class="mb-3">
    <x-input-label for="unique_id" :value="__('Unique id *')" />
    <x-input-text id="unique_id" name="unique_id" :value='old("unique_id", $equipment->unique_id ?? $utility::firstSlotUnique($table))' :readonly='true' :disabled='!Auth::user()->isAdmin()' />
    <x-input-error :message="$errors->first('unique_id')" />
</div>

{{-- QR CODE LINK --}}
<div class="mb-3">
    <x-input-label for="qr_code_link" :value="__('Qr code link *')" />
    <x-input-text id="qr_code_link" name="qr_code_link" :value='old("qr_code_link", $equipment->qr_code_link ?? $qr_code_link . $utility::firstSlotUnique($table) )' :readonly='true' :disabled='!Auth::user()->isAdmin()' />
    <x-input-error :message="$errors->first('qr_code_link')" />
</div>

{{-- CREATED AT --}}
<div class="mb-3">
    <x-input-label for="created_at" :value="__('Created at')" />
    <x-input-text id="created_at" name="created_at" :value='old("created_at", $equipment->created_at ?? Carbon\Carbon::now()->toDateTimeString() )' :readonly='true' :disabled='!Auth::user()->isAdmin()' />
    <x-input-error :message="$errors->first('created_at')" />
</div>

{{-- UPDATED AT --}}
<div class="mb-3">
    <x-input-label for="updated_at" :value="__('Updated at')" />
    <x-input-text id="updated_at" name="updated_at" :value='old("updated_at", $equipment->updated_at ?? Carbon\Carbon::now()->toDateTimeString() )' :readonly='true' :disabled='!Auth::user()->isAdmin()' />
    <x-input-error :message="$errors->first('updated_at')" />
</div>