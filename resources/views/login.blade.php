@extends('layout')@section('h',$church->name)@section('sub','Administrators only. Your dashboard is private to this church.')
@section('c')
<h2>Admin sign in</h2>
<p class="mut">{{ $church->name }}</p>
<form method="post" class="login">
    @csrf
    <div class="fgrid">
        <div class="sec">Administrator access</div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@yourchurch.org" required autofocus>
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>
    </div>
    <button class="btn">Sign in</button>
</form>
<a class="link" href="{{ route('checkin',$church) }}">← Back to check‑in</a>
@endsection
