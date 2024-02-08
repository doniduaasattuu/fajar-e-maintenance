<!-- NAVBAR -->
<nav class="sticky-top navbar absolute navbar-expand-xl bg-dark text-white zindex-fixed shadow-sm" style="min-width: 330px;">
    <div class="container-lg">
        <a class="text-white fw-medium me-xl-4 me-lg-3 navbar-brand" href="/">Fajar E-Maintenance</a>
        <button class="navbar-dark navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form action="/search" method="post" class="my-4 mb-xl-0 my-xl-0 d-flex" role="search">
                @csrf
                <input id="search_equipment" name="search_equipment" oninput="return toupper(this)" class="search_input form-control me-2" type="texy" maxlength="9" placeholder="Search by Equipment" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                {{-- SCANNER --}}
                <li class="nav-item me-2 me-md-3">
                    <a class="text-white nav-link" aria-current="page" href="/scanner">
                        <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-qr-code" viewBox="0 0 16 16">
                            <path d="M2 2h2v2H2V2Z" />
                            <path d="M6 0v6H0V0h6ZM5 1H1v4h4V1ZM4 12H2v2h2v-2Z" />
                            <path d="M6 10v6H0v-6h6Zm-5 1v4h4v-4H1Zm11-9h2v2h-2V2Z" />
                            <path d="M10 0v6h6V0h-6Zm5 1v4h-4V1h4ZM8 1V0h1v2H8v2H7V1h1Zm0 5V4h1v2H8ZM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8H6Zm0 0v1H2V8H1v1H0V7h3v1h3Zm10 1h-1V7h1v2Zm-1 0h-1v2h2v-1h-1V9Zm-4 0h2v1h-1v1h-1V9Zm2 3v-1h-1v1h-1v1H9v1h3v-2h1Zm0 0h3v1h-2v1h-1v-2Zm-4-1v1h1v-2H7v1h2Z" />
                            <path d="M7 12h1v3h4v1H7v-4Zm9 2v2h-3v-1h2v-1h1Z" />
                        </svg>
                        Scanner</a>
                </li>

                {{-- TRENDS --}}
                <li class="nav-item me-2 me-md-3">
                    <a id="navbar_trends" class="text-white nav-link" href="/trends">
                        <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z" />
                        </svg>
                        Trends</a>
                </li>

                {{-- TABLES --}}
                <li class="nav-item dropdown me-2 me-md-3">
                    <a class="text-white nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-fill-check" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514ZM8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1Z" />
                            <path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12.31 12.31 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7Zm6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.552 4.552 0 0 1 .23-2.002Zm-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.507 4.507 0 0 1-1.3-1.905Z" />
                        </svg>
                        Tables
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="border-bottom border-top dropdown-item" href="/findings">Finding</a></li>
                        <li><a class="border-bottom dropdown-item" href="/motors">Motor</a></li>
                        <li><a class="border-bottom dropdown-item" href="/trafos">Trafo</a></li>
                        <li><a class="border-bottom dropdown-item" href="/funclocs">Funcloc</a></li>
                        <li><a class="border-bottom dropdown-item" href="/documents">Document</a></li>
                        @inject('userService', 'App\Services\UserService')
                        @if (isset($userService) && (session('nik') != null) && $userService->isAdmin(session('nik')))
                        <li><a class="border-bottom dropdown-item" href="/users">User</a></li>
                        @endif
                    </ul>
                </li>

                {{-- USER --}}
                <li class="nav-item dropdown">
                    <a class="text-white nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-square" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                        </svg>
                        {{ explode(' ', session('user'))[0] }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="border-bottom border-top dropdown-item" href="/profile">My profile</a></li>
                        <li><a class="border-bottom text-light bg-danger dropdown-item" href="/logout">Logout</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>

@include('utility.script.toupper')