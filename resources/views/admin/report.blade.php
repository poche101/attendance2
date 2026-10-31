@extends('admin.layout')@section('title','Sunday Report')@section('sub',($current?'Active until '.$saturday->format('l, j M').', then it resets for the next Sunday':'Archived report'))
@section('actions')
<div class="tools" style="margin:0">
    <form method="get"><select name="date" onchange="this.form.submit()">@foreach($dates->prepend(\App\Models\Church::serviceDate())->unique() as $d)<option value="{{ $d }}" @selected($d==$date)>{{ \Carbon\Carbon::parse($d)->format('D, j M Y') }}</option>@endforeach</select></form>
    <button class="btn sm" onclick="window.print()">Print / Save PDF</button>
</div>
@endsection

@section('c')
@php($groupLabel = $church->config()['group_label'])
@php($cellLabel = $church->config()['cell_label'])
<article class="rpt">
    <header class="rpt-head">
        <div>
            <span class="rpt-eyebrow">Sunday Service Attendance Report</span>
            <h2>{{ $church->name }}</h2>
            <p>{{ \Carbon\Carbon::parse($date)->format('l, j F Y') }}</p>
        </div>
        <span class="rpt-badge {{ $current ? 'live' : '' }}">{{ $current ? 'Current week' : 'Archived' }}</span>
    </header>

    <div class="rpt-body">
        <p class="rpt-lead">
            @if($present->count())
                <b>{{ $present->count() }}</b> of <b>{{ $total }}</b> registered members attended
                ({{ $rate }}%), with <b>{{ $kids }}</b> {{ \Illuminate\Support\Str::plural('child', $kids) }} in attendance.
                @if($byGroup->count())
                    Strongest {{ strtolower($groupLabel) }}: <b>{{ $byGroup->keys()->first() }}</b> ({{ $byGroup->first() }}).
                @endif
            @else
                No attendance has been recorded for this service yet.
            @endif
        </p>

        <div class="rpt-tiles">
            <div class="rpt-tile"><span>Registered</span><b>{{ number_format($total) }}</b></div>
            <div class="rpt-tile ok"><span>Present</span><b>{{ number_format($present->count()) }}</b></div>
            <div class="rpt-tile bad"><span>Absent</span><b>{{ number_format($absent->count()) }}</b></div>
            <div class="rpt-tile gold"><span>Children</span><b>{{ number_format($kids) }}</b></div>
            <div class="rpt-tile pri"><span>Total souls</span><b>{{ number_format($present->count() + $kids) }}</b></div>
        </div>

        <div class="rpt-cols">
            <section class="rpt-box rpt-rate">
                <h3>Attendance rate</h3>
                <div class="donut" style="--p:{{ $rate }}"><div>{{ $rate }}%</div></div>
                <small>{{ $present->count() }} present · {{ $absent->count() }} absent</small>
            </section>

            <section class="rpt-box">
                <h3>Top {{ strtolower($groupLabel) }}s</h3>
                <div class="bars">
                    @php($mx = max(1, $byGroup->max() ?? 1))
                    @forelse($byGroup->take(5) as $k => $v)
                        <div class="b"><div><span>{{ $k }}</span><b>{{ $v }}</b></div><i><u style="width:{{ $v / $mx * 100 }}%"></u></i></div>
                    @empty
                        <p class="mut">No check-ins recorded.</p>
                    @endforelse
                </div>
            </section>

            <section class="rpt-box">
                <h3>Top {{ strtolower($cellLabel) }}s</h3>
                <div class="bars">
                    @php($mx = max(1, $byCell->max() ?? 1))
                    @forelse($byCell->take(5) as $k => $v)
                        <div class="b"><div><span>{{ $k }}</span><b>{{ $v }}</b></div><i><u style="width:{{ $v / $mx * 100 }}%"></u></i></div>
                    @empty
                        <p class="mut">No check-ins recorded.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

    <footer class="rpt-foot">
        <span>Generated {{ now()->format('j M Y, g:i A') }}</span>
        <span>{{ $church->name }} · Attendance records are kept permanently</span>
    </footer>
</article>
@endsection
