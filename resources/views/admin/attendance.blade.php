@extends('admin.layout')@section('title','Attendance')@section('sub','Present and absent members for the selected service')
@section('actions')<form method="get" class="tools" style="margin:0"><input type="hidden" name="tab" value="{{ $tab }}">@if($section)<input type="hidden" name="section" value="{{ $section }}">@endif<select name="date" onchange="this.form.submit()">@foreach($dates->prepend(\App\Models\Church::serviceDate())->unique() as $d)<option value="{{ $d }}" @selected($d==$date)>{{ \Carbon\Carbon::parse($d)->format('D, j M Y') }}</option>@endforeach</select></form>@endsection
@section('c')
@php($sq = $section ? '&section='.$section : '')
@if($sections)
<div class="tools" style="margin-bottom:10px">
    <a class="btn sm {{ $section ? 'ghost' : '' }}" href="?date={{ $date }}&tab={{ $tab }}">All</a>
    @foreach($sections as $key => $sec)
        <a class="btn sm {{ $section === $key ? '' : 'ghost' }}" href="?date={{ $date }}&tab={{ $tab }}&section={{ $key }}">{{ $sec['label'] }} ({{ $counts[$key][$tab] ?? 0 }})</a>
    @endforeach
</div>
@endif
<div class="tools"><div class="tabs"><a class="{{ $tab=='present'?'on':'' }}" href="?date={{ $date }}&tab=present{{ $sq }}">Present ({{ $present->count() }})</a><a class="{{ $tab=='absent'?'on':'' }}" href="?date={{ $date }}&tab=absent{{ $sq }}">Absent ({{ $absent->count() }})</a></div><span class="sp"></span><a class="btn sm" href="{{ route('admin.export',[$church,$tab]).'?date='.$date.$sq }}">⬇ Download CSV</a></div>
<div class="tw"><table><thead><tr><th>Member</th>@if($sections)<th>Church</th>@endif<th>Phone</th><th>{{ $church->config()['group_label'] }}</th><th>{{ $church->config()['cell_label'] }}</th>@if($tab=='present')<th>Children</th>@endif<th>Status</th></tr></thead><tbody>
@php($rows=$tab=='present'?$present->map(fn($a)=>$a->member->setAttribute('kids',$a->children)):$absent)
@forelse($rows as $m)@php($sk = $church->sectionOf($m->group_name))<tr><td><span class="av">{{ strtoupper(substr($m->full_name,0,1)) }}</span><span class="who">{{ $m->full_name }}<small>{{ $m->email }}</small></span></td>
@if($sections)<td>@if($sk)<span class="pill p" style="{{ $sk === 'mega' ? 'background:#fef3c7;color:#92400e' : 'background:#e0e7ff;color:#3730a3' }}">{{ str_replace('Christ Embassy ','',$sections[$sk]['label']) }}</span>@else<span class="mut">—</span>@endif</td>@endif
<td>{{ $m->phone }}</td><td>{{ $m->group_name }}</td><td>{{ $m->cell_name }}</td>@if($tab=='present')<td>{{ $m->kids }}</td>@endif<td><span class="pill {{ $tab=='present'?'p':'a' }}">{{ $tab=='present'?'Present':'Absent' }}</span></td></tr>
@empty<tr><td colspan="{{ ($sections ? 7 : 6) }}" class="mut" style="text-align:center;padding:40px">Nothing to show for this service.</td></tr>@endforelse</tbody></table></div>@endsection
