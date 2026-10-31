@php($m = $m ?? null)
<div class="fgrid">
    <div class="sec">Personal details</div>
    <div>
        <label>Full name</label>
        <input name="full_name" value="{{ old('full_name', $m->full_name ?? '') }}" placeholder="e.g. Grace Adeyemi" required>
    </div>
    <div class="two">
        <div><label>Email</label><input type="email" name="email" value="{{ old('email', $m->email ?? '') }}" placeholder="you@email.com" required></div>
        <div><label>Phone</label><input name="phone" value="{{ old('phone', $m->phone ?? '') }}" placeholder="0803 000 0000" required></div>
    </div>

    <div class="sec" style="margin-top:22px">Church details</div>
    @if ($cfg['groups'])
        <div class="two">
            <div>
                <label>{{ $cfg['group_label'] }}</label>
                <select name="group_name" id="g" required>
                    <option value="">Select {{ strtolower($cfg['group_label']) }}</option>
                    @foreach ($cfg['groups'] as $g => $_)
                        <option @selected(old('group_name', $m->group_name ?? '') == $g)>{{ $g }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>{{ $cfg['cell_label'] }}</label>
                <select name="cell_name" id="c" required>
                    <option value="">Select group first</option>
                </select>
            </div>
        </div>
        <script>
            (function() {
                const D = @json($cfg['groups']),
                    g = document.getElementById('g'),
                    c = document.getElementById('c');
                let keep = @json(old('cell_name', $m->cell_name ?? ''));

                function f() {
                    c.innerHTML = '<option value="">Select {{ strtolower($cfg['cell_label']) }}</option>';
                    (D[g.value] || []).forEach(x => {
                        const o = document.createElement('option');
                        o.textContent = x;
                        o.selected = x == keep;
                        c.appendChild(o)
                    })
                }
                g.onchange = () => { keep = ''; f() };
                f()
            })()
        </script>
    @else
        <div class="two">
            <div><label>{{ $cfg['group_label'] }}</label><input name="group_name" value="{{ old('group_name', $m->group_name ?? '') }}" placeholder="Type your group" required></div>
            <div><label>{{ $cfg['cell_label'] }}</label><input name="cell_name" value="{{ old('cell_name', $m->cell_name ?? '') }}" placeholder="Type your cell" required></div>
        </div>
    @endif
</div>
