@extends('admin.layout')@section('title','Members')@section('sub',number_format($total).' registered members · this church only')
@section('actions')<a class="btn sm" href="{{ route('admin.members.create',$church) }}">＋ Add member</a>@endsection
@section('c')
@if($sections)
<div class="tools" style="margin-bottom:10px">
    <a class="btn sm {{ $section ? 'ghost' : '' }}" href="{{ route('admin.members',[$church,'q'=>$q ?: null]) }}">All ({{ number_format($total) }})</a>
    @foreach($sections as $key => $sec)
        <a class="btn sm {{ $section === $key ? '' : 'ghost' }}" href="{{ route('admin.members',[$church,'section'=>$key,'q'=>$q ?: null]) }}">{{ $sec['label'] }} ({{ number_format($counts[$key] ?? 0) }})</a>
    @endforeach
</div>
@endif
<form class="tools" method="get">@if($section)<input type="hidden" name="section" value="{{ $section }}">@endif<input name="q" value="{{ $q }}" placeholder="Search name, email, phone or cell…" style="min-width:280px"><select name="group" onchange="this.form.submit()"><option value="">All {{ strtolower($church->config()['group_label']) }}s</option>@foreach($groups as $g)<option @selected($g==$group)>{{ $g }}</option>@endforeach</select><button class="btn sm ghost">Search</button><span class="sp"></span><a class="btn sm ghost" href="{{ route('admin.members.export',$church) }}">⬇ Export all</a></form>
<div class="tw"><table><thead><tr><th>Member</th>@if($sections)<th>Church</th>@endif<th>Phone</th><th>{{ $church->config()['group_label'] }}</th><th>{{ $church->config()['cell_label'] }}</th><th>Services</th><th>Joined</th><th></th></tr></thead><tbody>
@forelse($members as $m)@php($sk = $church->sectionOf($m->group_name))<tr><td><span class="av">{{ strtoupper(substr($m->full_name,0,1)) }}</span><span class="who">{{ $m->full_name }}<small>{{ $m->email }}</small></span></td>
@if($sections)<td>@if($sk)<span class="pill p" style="{{ $sk === 'mega' ? 'background:#fef3c7;color:#92400e' : 'background:#e0e7ff;color:#3730a3' }}">{{ str_replace('Christ Embassy ','',$sections[$sk]['label']) }}</span>@else<span class="mut">—</span>@endif</td>@endif
<td>{{ $m->phone }}</td><td>{{ $m->group_name }}</td><td>{{ $m->cell_name }}</td><td><span class="pill p">{{ $m->attendances_count }}</span></td><td class="mut">{{ $m->created_at->format('j M Y') }}</td>
<td style="text-align:right"><a class="btn sm ghost" href="{{ route('admin.members.edit',[$church,$m->id]) }}">Edit</a> <form method="post" action="{{ route('admin.members.destroy',[$church,$m->id]) }}" style="display:inline" onsubmit="return confirm('Remove {{ e($m->full_name) }} and their attendance history?')">@csrf @method('DELETE')<button class="btn sm danger">Delete</button></form></td></tr>
@empty<tr><td colspan="{{ $sections ? 8 : 7 }}" class="mut" style="text-align:center;padding:40px">No members found.</td></tr>@endforelse</tbody></table></div>
<div class="pg"><span>Page {{ $members->currentPage() }}</span><span>@if($members->previousPageUrl())<a class="btn sm ghost" href="{{ $members->previousPageUrl() }}">← Prev</a>@endif @if($members->nextPageUrl())<a class="btn sm ghost" href="{{ $members->nextPageUrl() }}">Next →</a>@endif</span></div>@endsection
