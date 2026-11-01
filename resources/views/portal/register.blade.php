@extends('layout')@section('sub','Create your account once. Next time, just type your email or phone.')
@section('c')
<h2>Create your account</h2>
<p class="mut">It takes less than a minute.</p>
<form class="register" method="post" action="{{ route('portal.register.store') }}">@csrf
    <div class="fgrid">
        <div class="sec">Personal details</div>
        <label>Full name</label>
        <input name="full_name" value="{{ old('full_name') }}" placeholder="e.g. Grace Adeyemi" required>
        <div class="two">
            <div><label>Email</label><input type="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" required></div>
            <div><label>Phone</label><input name="phone" value="{{ old('phone') }}" placeholder="0803 000 0000" required></div>
        </div>

        <div class="sec" style="margin-top:14px">Church details</div>
        <div id="tog" style="display:flex;gap:6px;background:#eef0fb;padding:4px;border-radius:12px;margin-bottom:12px">
            @foreach($sections as $key => $sec)
                <label style="flex:1;margin:0 !important;cursor:pointer">
                    <input type="radio" name="section" value="{{ $key }}" style="display:none" @checked(old('section', 'ajah') == $key) required>
                    <span class="tg">{{ $sec['label'] }}</span>
                </label>
            @endforeach
        </div>
        <style>
            #tog .tg{display:block;text-align:center;padding:14px 8px;border-radius:10px;font-weight:600;font-size:15.5px;color:#555}
            #tog input:checked+.tg{background:linear-gradient(135deg,var(--pri),var(--pri2));color:#fff}
        </style>
        <div id="dyn"></div>

        <label>Children with you today (if any)</label>
        <input type="number" name="children" min="0" value="{{ old('children',0) }}">
    </div>
    <button class="btn">Create account &amp; mark attendance</button>
</form>
<a class="link" href="{{ route('portal.checkin') }}">Already registered? Check in</a>

<script>
(function () {
    var SEC = @json($sections), GL = @json($group_label), CL = @json($cell_label);
    var old = { group: @json(old('group_name')), cell: @json(old('cell_name')) };
    var box = document.getElementById('dyn');
    function esc(s) { return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;'); }
    function section() { var r = document.querySelector('input[name=section]:checked'); return r ? r.value : null; }
    function build() {
        var s = SEC[section()]; if (!s) { box.innerHTML = ''; return; }
        box.innerHTML = '<div class="two"><div><label>' + GL + '</label><select name="group_name" id="g" required><option value="">Select group</option>' +
            Object.keys(s.groups).map(function (g) { return '<option' + (g == old.group ? ' selected' : '') + '>' + esc(g) + '</option>'; }).join('') +
            '</select></div><div><label>' + CL + '</label><select name="cell_name" id="c" required></select></div></div>';
        var g = document.getElementById('g'), c = document.getElementById('c');
        function fill() {
            c.innerHTML = '<option value="">Select ' + CL.toLowerCase() + '</option>' +
                (s.groups[g.value] || []).map(function (x) { return '<option' + (x == old.cell ? ' selected' : '') + '>' + esc(x) + '</option>'; }).join('');
        }
        g.onchange = function () { old.cell = ''; fill(); };
        fill();
    }
    document.querySelectorAll('input[name=section]').forEach(function (r) { r.onchange = function () { old.group = ''; old.cell = ''; build(); }; });
    build();
})();
</script>
@endsection
