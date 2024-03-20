<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SF</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Style -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <div class="row mt-4 d-flex align-items-center" style="margin-left: 10%; margin-right: 10%;">
        <img src="/image/soup.png" alt="" style="width: auto; height: auto;">
        <h1 class="fw-bold col-2 ms-0 mb-0 ps-0 flex-grow-1" style="color: gold;">스프</h1>
        <div class="col-auto justify-content-end">
            <div class="dropdown">
                <button class="btn dropdown-toggle border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(Auth::check())
                    {{ Auth::user()->name }}님
                    @endif
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/calendar">나의 달력</a></li>
                    <li><a class="dropdown-item" href="/user">나의 정보</a></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}">로그아웃</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        @yield('content')
    </div>

    <div class="mb-5"></div>
</body>

</html>

<style>
    .dropdown-item:active {
        color: black;
        background-color: palegoldenrod !important;
    }
</style>