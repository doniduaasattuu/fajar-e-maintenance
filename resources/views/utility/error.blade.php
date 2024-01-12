@isset($errors)
@if ($errors->any())
<div class="alert alert-danger">
    <div>{{ $errors->first() }}</div>
</div>
@endif
@endisset