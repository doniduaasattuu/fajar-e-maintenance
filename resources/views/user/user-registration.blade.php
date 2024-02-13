@include('utility.prefix')

<div class="py-4">

    <div class="mb-3">
        <h3 class="mb-1">{{ $title }}</h3>
        <nav aria-label=" breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/users">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ isset($user) != null ? $user->id : $title }}</li>
            </ol>
        </nav>
    </div>

    @include('utility.alert')
    @include('utility.errors')

    @include('user.form-registration')

</div>

@include('utility.suffix')