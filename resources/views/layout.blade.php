<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('t', 'Attendance') · Christ Embassy</title>@include('partials.css')
</head>

<body>
    <div class="auth">
        <section class="hero">
            <div>
                <h1>@yield('h', 'Christ Embassy Ajah Mega Church Christ Embassy Ajah')</h1>
                <p>@yield('sub', 'Every soul counts. Mark your attendance in seconds and let us celebrate you.')</p>
            </div><small>Sunday Service Attendance · celz5.org</small>
        </section>
        <section class="panel">
            <div class="form">
                @if (session('ok'))
                    <div class="msg ok">{{ session('ok') }}</div>
                    @endif @if (session('error'))
                        <div class="msg bad">{{ session('error') }}</div>
                        @endif @if ($errors->any())
                            <div class="msg bad">{{ $errors->first() }}</div>
                        @endif @yield('c')
            </div>
        </section>
    </div>
</body>

</html>
