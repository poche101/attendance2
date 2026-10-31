@php
$ic=['home'=>'<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>','users'=>'<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>','chk'=>'<polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>','doc'=>'<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>','sr'=>'<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>','out'=>'<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>','menu'=>'<line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="14" y2="17"/>','x'=>'<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>'];
$menu=[['admin','Overview','home'],['admin.members','Members','users'],['admin.attendance','Attendance','chk'],['admin.report','Reports','doc'],['admin.search','Semantic Search','sr']];
@endphp
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><title>@yield('title') · {{ $church->name }}</title>@include('partials.css')

<style>
/* ===== Mobile menu + responsive shell (self-contained) ===== */
.main{min-width:0}
.mbar,.scrim,.sclose{display:none}
.tw{-webkit-overflow-scrolling:touch}
@media(max-width:1100px) and (min-width:861px){
 .shell{grid-template-columns:232px 1fr}
 .main{padding:24px 24px 56px}
}
@media(max-width:860px){
 .shell{display:block}
 .mbar{display:flex;align-items:center;gap:12px;position:sticky;top:0;z-index:40;height:calc(58px + env(safe-area-inset-top));padding:env(safe-area-inset-top) 14px 0;background:rgba(255,255,255,.94);-webkit-backdrop-filter:blur(10px);backdrop-filter:blur(10px);border-bottom:1px solid #e7eaf3}
 .burger{all:unset;display:grid;place-items:center;width:40px;height:40px;border-radius:11px;cursor:pointer;color:#0f172a;border:1px solid #e7eaf3;background:#fff;flex:none}
 .burger:hover{background:#f6f7fb}
 .burger svg,.sclose svg{width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
 .mbrand{display:flex;align-items:center;gap:10px;min-width:0}
 .mbrand i{width:32px;height:32px;border-radius:10px;background:linear-gradient(135deg,#4f46e5,#7c3aed);display:grid;place-items:center;color:#fff;font-style:normal;flex:none}
 .mbrand b{font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
 .side{position:fixed;top:0;left:0;bottom:0;width:284px;max-width:86vw;height:100vh;height:100dvh;z-index:60;display:flex;flex-direction:column;flex-wrap:nowrap;align-items:stretch;gap:0;padding:22px 16px;padding-top:max(22px,env(safe-area-inset-top));overflow-y:auto;transform:translateX(-104%);transition:transform .3s cubic-bezier(.22,.61,.36,1);background:#fff}
 .brand{padding:4px 40px 22px 8px}
 .nav{display:block;overflow:visible;flex:initial}
 .nav .lbl{display:block}
 .nav a{white-space:normal;padding:13px 12px}
 .foot{margin-top:auto;padding-top:14px;border-top:1px solid #e7eaf3}
 .sclose{all:unset;display:grid;place-items:center;position:absolute;top:16px;right:14px;width:36px;height:36px;border-radius:10px;cursor:pointer;color:#475569}
 .sclose:hover{background:#f6f7fb}
 body.nav-open .side{transform:none;box-shadow:0 20px 60px rgba(15,23,42,.3)}
 .scrim{display:block;position:fixed;inset:0;z-index:50;background:rgba(15,23,42,.45);-webkit-backdrop-filter:blur(2px);backdrop-filter:blur(2px);opacity:0;pointer-events:none;transition:opacity .25s}
 body.nav-open .scrim{opacity:1;pointer-events:auto}
 body.nav-open{overflow:hidden}
 .main{padding:20px 18px 56px}
}
@media(max-width:560px){
 .main{padding:16px 14px 48px}
 .bar-t{margin-bottom:18px}
 .bar-t h1{font-size:23px}
 .bar-t>.tools,.bar-t>.chip,.bar-t>.btn{width:100%}
 .tools{width:100%}
 .tools input,.tools select,.tools .btn,.bar-t form,.bar-t select{width:100%;min-width:0}
 .tools .sp{display:none}
 .card{padding:16px;border-radius:14px}
 .tabs{display:flex;width:100%}.tabs a{flex:1;text-align:center;padding:8px 10px}
}
@media print{.mbar,.scrim{display:none!important}}
</style>
</head><body>

{{-- Mobile top bar (shown at 860px and below) --}}
<header class="mbar">
    <button class="burger" type="button" aria-label="Open menu" aria-controls="side" aria-expanded="false"><svg viewBox="0 0 24 24">{!! $ic['menu'] !!}</svg></button>
    <div class="mbrand"><i>⛪</i><b>{{ $church->name }}</b></div>
</header>
<div class="scrim"></div>

<div class="shell"><aside class="side" id="side">
<button class="sclose" type="button" aria-label="Close menu"><svg viewBox="0 0 24 24">{!! $ic['x'] !!}</svg></button>
<div class="brand"><i>⛪</i><div><b>{{ $church->name }}</b><small>Admin Console</small></div></div>
<nav class="nav"><div class="lbl">Menu</div>@foreach($menu as [$r,$l,$i])<a href="{{ route($r,$church) }}" class="{{ request()->routeIs($r.'*')&&($r!='admin'||request()->routeIs('admin'))?'on':'' }}"><svg viewBox="0 0 24 24">{!! $ic[$i] !!}</svg>{{ $l }}</a>@endforeach</nav>
<div class="foot"><form method="post" action="{{ route('admin.logout',$church) }}">@csrf<button><svg viewBox="0 0 24 24">{!! $ic['out'] !!}</svg>Log out</button></form></div></aside>
<main class="main">@if(session('ok'))<div class="msg ok">{{ session('ok') }}</div>@endif @if($errors->any())<div class="msg bad">{{ $errors->first() }}</div>@endif
<div class="bar-t"><div><h1>@yield('title')</h1><div class="mut">@yield('sub')</div></div>@yield('actions')</div>@yield('c')</main></div>

<script>
(function () {
    var b = document.body, t = document.querySelector('.burger');
    function set(open) { b.classList.toggle('nav-open', open); t.setAttribute('aria-expanded', open); }
    t.addEventListener('click', function () { set(!b.classList.contains('nav-open')); });
    document.querySelectorAll('.scrim, .sclose, .nav a').forEach(function (e) { e.addEventListener('click', function () { set(false); }); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') set(false); });
    window.matchMedia('(min-width:861px)').addEventListener('change', function (e) { if (e.matches) set(false); });
})();
</script>
</body></html>
