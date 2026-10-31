@extends('admin.layout')@section('title','Semantic Search')@section('sub','Ask questions across every saved service, powered by OpenAI')
@section('c')<div class="card" style="max-width:860px"><h3>Ask about your attendance</h3><p class="mut">Only {{ $church->name }}’s records are analysed.</p>
<div class="chips">@foreach(['Who has missed three Sundays in a row?','Which cells have declining attendance?','Compare the last two Sundays by group','Who attended every service this month?'] as $s)<a onclick="document.getElementById('q').value=this.textContent">{{ $s }}</a>@endforeach</div>
<form method="post" action="{{ route('admin.search.run',$church) }}">@csrf<textarea id="q" name="q" rows="3" placeholder="Ask anything about attendance…" required>{{ session('q') }}</textarea><button class="btn" style="width:auto;padding-inline:30px">Analyse</button></form>
@if(session('answer'))<div class="ans">{{ session('answer') }}</div>@endif</div>@endsection
