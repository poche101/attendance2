@extends('admin.layout')@section('title','Overview')@section('sub','Service of '.\Carbon\Carbon::parse($date)->format('l, j F Y').' · stays here until '.$saturday->format('l, j M'))
@section('actions')<span class="chip">Live service week</span>@endsection
@section('c')
@php
$icons = [
    'present'  => '<rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/>',
    'absent'   => '<rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m15 11-6 6"/><path d="m9 11 6 6"/>',
    'children' => '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>',
    'members'  => '<path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/>',
];
$tiles = [
    'present'  => 'background:linear-gradient(135deg,#34d399,#059669);box-shadow:0 8px 18px rgba(5,150,105,.3)',
    'absent'   => 'background:linear-gradient(135deg,#fb7185,#e11d48);box-shadow:0 8px 18px rgba(225,29,72,.28)',
    'children' => 'background:linear-gradient(135deg,#fbbf24,#d97706);box-shadow:0 8px 18px rgba(217,119,6,.28)',
    'members'  => 'background:linear-gradient(135deg,#6366f1,#4f46e5);box-shadow:0 8px 18px rgba(79,70,229,.3)',
];
@endphp

<style>
.main{min-width:0}
.ov-stats{display:grid;gap:18px;grid-template-columns:repeat(auto-fit,minmax(min(220px,100%),1fr))}
.ov-stats .stat>div:last-child{min-width:0}
.ov-two{display:grid;gap:18px;grid-template-columns:1.6fr 1fr}
.ov-two-eq{display:grid;gap:18px;grid-template-columns:repeat(auto-fit,minmax(min(340px,100%),1fr))}
.ov-bars .b>div{display:flex;justify-content:space-between;gap:12px}
.ov-bars .b>div span{min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.ov-bars .b>div b{flex:none}
.ov-ci{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:9px 0;border-bottom:1px solid #f0f2f8}
.ov-ci:last-child{border-bottom:0}
.ov-ci>div{display:flex;align-items:center;min-width:0}
.ov-ci .av{flex:none}
.ov-ci .who{display:block;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.ov-ci .who small{display:block;overflow:hidden;text-overflow:ellipsis}
.ov-ci time{flex:none;font-size:12px;color:#64748b}
@media(max-width:1000px){.ov-two{grid-template-columns:1fr}}
@media(max-width:560px){
 .ov-stats,.ov-two,.ov-two-eq{gap:12px}
 .ov-stats{grid-template-columns:1fr 1fr}
 .ov-stats .stat{flex-direction:column;align-items:flex-start;gap:12px;padding:14px}
 .ov-stats .stat b{font-size:24px}
 .donut{width:128px;height:128px}.donut div{width:92px;height:92px;font-size:22px}
}
@media(max-width:340px){.ov-stats{grid-template-columns:1fr}}
</style>

<div class="ov-stats mb">
@foreach([['Present',$present->count(),'present'],['Absent',$absent->count(),'absent'],['Children',$kids,'children'],['Members',$total,'members']] as [$l,$v,$i])
    <div class="card stat">
        <div class="ic" style="width:50px;height:50px;border-radius:15px;color:#fff;display:grid;place-items:center;flex:none;{{ $tiles[$i] }}">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $icons[$i] !!}</svg>
        </div>
        <div><span>{{ $l }}</span><b>{{ number_format($v) }}</b></div>
    </div>
@endforeach
</div>

<div class="ov-two mb">
    <div class="card">
        <h3>Attendance by {{ strtolower($church->config()['group_label']) }}</h3>
        <div class="bars ov-bars">@php($mx=max(1,$byGroup->max()??1))
            @forelse($byGroup->take(8) as $k=>$v)
                <div class="b"><div><span>{{ $k }}</span><b>{{ $v }}</b></div><i><u style="width:{{ $v/$mx*100 }}%"></u></i></div>
            @empty
                <p class="mut">No check-ins yet this week.</p>
            @endforelse
        </div>
    </div>
    <div class="card" style="text-align:center">
        <h3>Attendance rate</h3>
        <div class="donut" style="--p:{{ $rate }}"><div>{{ $rate }}%</div></div>
        <span class="mut">{{ $present->count() }} of {{ $total }} members present</span>
    </div>
</div>

<div class="ov-two-eq">
    <div class="card">
        <h3>Attendance by {{ strtolower($church->config()['cell_label']) }}</h3>
        <div class="bars ov-bars">@php($mx=max(1,$byCell->max()??1))
            @forelse($byCell->take(8) as $k=>$v)
                <div class="b"><div><span>{{ $k }}</span><b>{{ $v }}</b></div><i><u style="width:{{ $v/$mx*100 }}%"></u></i></div>
            @empty
                <p class="mut">No data yet.</p>
            @endforelse
        </div>
    </div>
    <div class="card">
        <h3>Latest check-ins</h3>
        <div style="margin-top:12px">
            @forelse($present->take(7) as $a)
                <div class="ov-ci">
                    <div><span class="av">{{ strtoupper(substr($a->member->full_name,0,1)) }}</span><span class="who">{{ $a->member->full_name }}<small>{{ $a->member->cell_name }}</small></span></div>
                    <time>{{ $a->created_at->format('g:i A') }}</time>
                </div>
            @empty
                <p class="mut">Nobody has checked in yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
