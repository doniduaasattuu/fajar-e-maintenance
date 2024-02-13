<!DOCTYPE html>
<html lang="en">
@include('utility.head')

<body>
    <div class="container d-flex vh-100">
        <div class="my-auto align-items-center py-4 mx-auto justify-content-center" style="min-width: 300px;">

            @include('utility.errors')

            <h2 class="mb-4">{{ $title }}</h2>
            @include('user.form-registration')
        </div>

        @include('utility.script.onlynumber')
        @include('utility.suffix')