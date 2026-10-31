@extends('layout')@section('h','Christ Embassy Ajah')@section('sub','Create your account once. Next time, just type your email or phone.')
@section('c')
<h2>Create your account</h2>
<p class="mut">It takes less than a minute.</p>
<form method="post" action="{{ route('portal.register.store') }}">@csrf
    <div class="fgrid">
        <div class="sec">Personal details</div>
        <label>Full name</label>
        <input name="full_name" value="{{ old('full_name') }}" placeholder="e.g. Grace Adeyemi" required>
        <div class="two">
            <div><label>Email</label><input type="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" required></div>
            <div><label>Phone</label><input name="phone" value="{{ old('phone') }}" placeholder="0803 000 0000" required></div>
        </div>

        <div class="sec" style="margin-top:14px">Church details</div>
        <label>Church</label>
        <select name="church" id="ch" required>
            <option value="">Select your church</option>
            @foreach($churches as $c)<option value="{{ $c->slug }}" @selected(old('church')==$c->slug)>{{ $c->name }}</option>@endforeach
        </select>
        <div id="dyn"></div>

        <label>Children with you today (if any)</label>
        <input type="number" name="children" min="0" value="{{ old('children',0) }}">
    </div>
    <button class="btn">Create account &amp; mark attendance</button>
</form>
<a class="link" href="{{ route('portal.checkin') }}">Already registered? Check in</a>

<script>
(function () {
    var CFG = @json($configs);
    var old = { group: @json(old('group_name')), cell: @json(old('cell_name')) };
    var ch = document.getElementById('ch'), box = document.getElementById('dyn');
    function esc(s) { return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;'); }
    function build() {
        var c = CFG[ch.value];
        if (!c) { box.innerHTML = ''; return; }
        if (!c.groups) {
            box.innerHTML = '<div class="two"><div><label>' + c.group_label + '</label><input name="group_name" value="' + esc(old.group || '') + '" required></div>' +
                            '<div><label>' + c.cell_label + '</label><input name="cell_name" value="' + esc(old.cell || '') + '" required></div></div>';
            return;
        }
        box.innerHTML = '<div class="two"><div><label>' + c.group_label + '</label><select name="group_name" id="g" required><option value="">Select group</option>' +
            Object.keys(c.groups).map(function (g) { return '<option' + (g == old.group ? ' selected' : '') + '>' + esc(g) + '</option>'; }).join('') +
            '</select></div><div><label>' + c.cell_label + '</label><select name="cell_name" id="c" required></select></div></div>';
        var g = document.getElementById('g'), cc = document.getElementById('c');
        function fill() {
            cc.innerHTML = '<option value="">Select ' + c.cell_label.toLowerCase() + '</option>' +
                (c.groups[g.value] || []).map(function (x) { return '<option' + (x == old.cell ? ' selected' : '') + '>' + esc(x) + '</option>'; }).join('');
        }
        g.onchange = function () { old.cell = ''; fill(); };
        fill();
    }
    ch.onchange = function () { old.group = ''; old.cell = ''; build(); };
    build();
})();
</script>
@endsection
