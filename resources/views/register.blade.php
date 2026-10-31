@extends('layout')@section('h', $church->name)@section('sub', 'Create your account once. Next time, just type your email
    or phone.')
@section('c')<h2>Create your account</h2>
    <p class="mut">It takes less than a minute.</p>
    <form class="register" method="post" action="{{ route('register.store', $church) }}">@csrf @include('partials.member-fields', ['m' => null])
        <label>Children with you today (if any)</label><input type="number" name="children" min="0"
            value="0"><button class="btn">Create account &amp; mark attendance</button>
    </form>
<a class="link" href="{{ route('checkin', $church) }}">Already registered? Check in</a>@endsection
