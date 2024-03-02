@extends('app')

@section('content')
<div class="container d-flex vh-100">
    <div class="my-auto align-items-center py-4 mx-auto justify-content-center" style="min-width: 300px;">

        @include('utility.alert')

        @include('utility.error')

        <h2 class="mb-4">{{ $title }}</h2>
        <form action="login" method="POST">
            @csrf

            {{-- NIK --}}
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input value="{{ old('nik') }}" id="nik" name="nik" type="text" onkeypress="return JS.onlynumber(event, 48, 57)" maxlength="8" class="form-control" aria-describedby="nik">
            </div>

            {{-- PASSWORD --}}
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" name="password" type="password" class="form-control">
            </div>

            {{-- BUTTON SUBMIT --}}
            <button type="submit" class="btn btn-primary">Sign In</button>
            <div id="emailHelp" class="form-text">Don&#039;t have an account ?, Register <a class="text-decoration-none" href="/registration">here</a></div>
        </form>
    </div>
</div>
@endsection