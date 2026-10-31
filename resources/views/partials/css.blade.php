<link rel="preconnect" href="https://fonts.googleapis.com">
<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
    rel="stylesheet">
<style>
    @property --ang {
        syntax: '<angle>';
        inherits: false;
        initial-value: 0deg
    }

    :root {
        --bg: #f6f7fb;
        --sf: #fff;
        --ink: #0f172a;
        --mut: #64748b;
        --line: #e7eaf3;
        --pri: #4f46e5;
        --pri2: #7c3aed;
        --soft: #eef0ff;
        --gold: #d9a441;
        --ok: #059669;
        --okb: #d1fae5;
        --bad: #dc2626;
        --badb: #fee2e2;
        --r: 16px;
        --sh: 0 1px 2px rgba(15, 23, 42, .04), 0 8px 24px rgba(15, 23, 42, .06);
        color-scheme: light
    }

    * {
        box-sizing: border-box
    }

    html {
        scroll-behavior: smooth
    }

    body {
        margin: 0;
        background: var(--bg);
        color: var(--ink);
        font: 14.5px/1.55 Inter, system-ui, sans-serif;
        -webkit-font-smoothing: antialiased
    }

    h1,
    h2,
    h3 {
        margin: 0;
        letter-spacing: -.01em
    }

    .serif {
        font-family: 'Playfair Display', Georgia, serif
    }

    a {
        color: var(--pri);
        text-decoration: none
    }

    label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        margin: 16px 0 6px
    }

    input,
    select,
    textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid var(--line);
        border-radius: 12px;
        background: #fff;
        color: var(--ink);
        font: inherit;
        transition: .18s
    }

    input:hover,
    select:hover,
    textarea:hover {
        border-color: #cdd3e4
    }

    input:focus,
    select:focus,
    textarea:focus {
        outline: 0;
        border-color: var(--pri);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, .12)
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        margin-top: 22px;
        padding: 13px 18px;
        border: 0;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--pri), var(--pri2));
        color: #fff;
        font: 600 14.5px Inter;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(79, 70, 229, .28);
        transition: .2s
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 26px rgba(79, 70, 229, .34)
    }

    .btn:active {
        transform: none
    }

    .btn.sm {
        width: auto;
        margin: 0;
        padding: 9px 15px;
        font-size: 13px;
        box-shadow: none
    }

    .btn.ghost {
        background: #fff;
        color: var(--ink);
        border: 1px solid var(--line);
        box-shadow: none
    }

    .btn.ghost:hover {
        background: var(--bg)
    }

    .btn.danger {
        background: #fff;
        color: var(--bad);
        border: 1px solid #fecaca;
        box-shadow: none
    }

    .mut {
        color: var(--mut)
    }

    .msg {
        padding: 12px 16px;
        border-radius: 12px;
        font-weight: 500;
        margin-bottom: 16px;
        animation: in .3s
    }

    .msg.ok {
        background: var(--okb);
        color: #065f46
    }

    .msg.bad {
        background: var(--badb);
        color: #991b1b
    }

    @keyframes in {
        from {
            opacity: 0;
            transform: translateY(6px)
        }

        to {
            opacity: 1;
            transform: none
        }
    }

    .auth {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1.05fr 1fr
    }

    .hero {
        position: relative;
        overflow: hidden;
        color: #fff;
        padding: 56px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: radial-gradient(900px 500px at 0% 0%, #6d5df5 0, transparent 60%), radial-gradient(700px 500px at 100% 100%, #a855f7 0, transparent 55%), linear-gradient(160deg, #1e1b4b, #312e81)
    }

    .hero:after {
        content: "";
        position: absolute;
        inset: auto -80px -120px auto;
        width: 380px;
        height: 380px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, .15);
        box-shadow: 0 0 0 60px rgba(255, 255, 255, .04), 0 0 0 120px rgba(255, 255, 255, .03)
    }

    .hero .mark {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: rgba(255, 255, 255, .14);
        display: grid;
        place-items: center;
        font-size: 22px;
        backdrop-filter: blur(6px)
    }

    .hero h1 {
        font: 700 40px/1.15 'Playfair Display', serif;
        margin: 22px 0 14px;
        max-width: 440px
    }

    .hero p {
        opacity: .82;
        max-width: 400px
    }

    .hero small {
        opacity: .6
    }

    .panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 24px;
        background: #fff
    }

    .form {
        width: 100%;
        max-width: 410px;
        animation: in .45s
    }

    .form h2 {
        font: 700 28px 'Playfair Display', serif
    }

    .link {
        display: block;
        text-align: center;
        margin-top: 18px;
        font-weight: 500
    }

    .top {
        position: absolute;
        top: 22px;
        right: 26px;
        font-size: 13px
    }

    @media(max-width:860px) {
        .auth {
            grid-template-columns: 1fr
        }

        .hero {
            padding: 30px 24px 34px
        }

        .hero h1 {
            font-size: 28px
        }

        .hero:after {
            display: none
        }
    }

    .shell {
        display: grid;
        grid-template-columns: 262px 1fr;
        min-height: 100vh
    }

    .side {
        background: #fff;
        border-right: 1px solid var(--line);
        padding: 22px 16px;
        position: sticky;
        top: 0;
        height: 100vh;
        display: flex;
        flex-direction: column
    }

    .brand {
        display: flex;
        gap: 12px;
        align-items: center;
        padding: 4px 8px 22px
    }

    .brand i {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--pri), var(--pri2));
        display: grid;
        place-items: center;
        color: #fff;
        font-style: normal
    }

    .brand b {
        display: block;
        font-size: 14px;
        line-height: 1.25
    }

    .brand small {
        color: var(--mut);
        font-size: 12px
    }

    .nav a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 12px;
        margin-bottom: 3px;
        border-radius: 11px;
        color: #475569;
        font-weight: 500;
        transition: .15s
    }

    .nav a svg {
        width: 18px;
        height: 18px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round
    }

    .nav a:hover {
        background: var(--bg);
        color: var(--ink)
    }

    .nav a.on {
        background: var(--soft);
        color: var(--pri)
    }

    .nav .lbl {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #94a3b8;
        padding: 16px 12px 8px
    }

    .foot {
        margin-top: auto;
        border-top: 1px solid var(--line);
        padding-top: 14px
    }

    .foot form {
        margin: 0
    }

    .foot button {
        all: unset;
        display: flex;
        gap: 12px;
        align-items: center;
        width: 100%;
        padding: 11px 12px;
        border-radius: 11px;
        color: #475569;
        cursor: pointer;
        font-weight: 500;
        box-sizing: border-box
    }

    .foot button:hover {
        background: var(--badb);
        color: var(--bad)
    }

    .foot svg {
        width: 18px;
        height: 18px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2
    }

    .main {
        padding: 28px 36px 60px;
        max-width: 1240px;
        width: 100%
    }

    .bar-t {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 24px
    }

    .bar-t h1 {
        font: 700 28px 'Playfair Display', serif
    }

    .chip {
        display: inline-flex;
        gap: 8px;
        align-items: center;
        background: #fff;
        border: 1px solid var(--line);
        padding: 8px 14px;
        border-radius: 99px;
        font-size: 13px;
        font-weight: 500;
        color: #475569
    }

    .chip:before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--ok);
        box-shadow: 0 0 0 4px var(--okb)
    }

    .card {
        background: var(--sf);
        border: 1px solid var(--line);
        border-radius: var(--r);
        padding: 22px;
        box-shadow: var(--sh)
    }

    .card h3 {
        font-size: 15px;
        font-weight: 600
    }

    .grid {
        display: grid;
        gap: 18px
    }

    .g4 {
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr))
    }

    .g2 {
        grid-template-columns: repeat(auto-fit, minmax(340px, 1fr))
    }

    .g3 {
        grid-template-columns: 1.6fr 1fr
    }

    .mb {
        margin-bottom: 18px
    }

    .stat {
        display: flex;
        gap: 14px;
        align-items: center
    }

    .stat .ic {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        font-size: 20px;
        background: var(--soft)
    }

    .stat span {
        color: var(--mut);
        font-size: 13px
    }

    .stat b {
        display: block;
        font-size: 28px;
        line-height: 1.1;
        font-weight: 700
    }

    .ic.g {
        background: var(--okb)
    }

    .ic.r {
        background: var(--badb)
    }

    .ic.y {
        background: #fef3c7
    }

    .donut {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin: 8px auto 14px;
        display: grid;
        place-items: center;
        background: conic-gradient(var(--pri) calc(var(--p)*1%), #e8ebf6 0)
    }

    .donut div {
        width: 108px;
        height: 108px;
        border-radius: 50%;
        background: #fff;
        display: grid;
        place-items: center;
        font: 700 26px Inter
    }

    .bars .b {
        margin: 13px 0
    }

    .bars .b>div {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        margin-bottom: 6px
    }

    .bars i {
        display: block;
        height: 8px;
        border-radius: 9px;
        background: #eef0f7;
        overflow: hidden
    }

    .bars u {
        display: block;
        height: 100%;
        border-radius: 9px;
        background: linear-gradient(90deg, var(--pri), var(--pri2));
        transition: width .8s
    }

    .tools {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
        margin-bottom: 16px
    }

    .tools input,
    .tools select {
        width: auto;
        min-width: 210px;
        padding: 10px 14px
    }

    .sp {
        flex: 1
    }

    .tw {
        overflow-x: auto;
        border: 1px solid var(--line);
        border-radius: 14px
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
        background: #fff
    }

    th {
        position: sticky;
        top: 0;
        text-align: left;
        background: #fafbfe;
        color: #64748b;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: .06em;
        padding: 12px 16px;
        border-bottom: 1px solid var(--line);
        white-space: nowrap
    }

    td {
        padding: 13px 16px;
        border-bottom: 1px solid #f0f2f8;
        white-space: nowrap
    }

    tr:last-child td {
        border: 0
    }

    tbody tr:hover {
        background: #fafbff
    }

    .av {
        display: inline-grid;
        place-items: center;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: var(--soft);
        color: var(--pri);
        font-weight: 700;
        font-size: 12px;
        margin-right: 12px;
        vertical-align: middle
    }

    .who {
        display: inline-block;
        vertical-align: middle;
        line-height: 1.3
    }

    .who small {
        color: var(--mut);
        display: block
    }

    .pill {
        display: inline-block;
        padding: 3px 11px;
        border-radius: 99px;
        font-size: 12px;
        font-weight: 600
    }

    .pill.p {
        background: var(--okb);
        color: #047857
    }

    .pill.a {
        background: var(--badb);
        color: #b91c1c
    }

    .tabs {
        display: inline-flex;
        background: #eceef7;
        padding: 4px;
        border-radius: 12px;
        gap: 2px
    }

    .tabs a {
        padding: 8px 18px;
        border-radius: 9px;
        color: #475569;
        font-weight: 600;
        font-size: 13px
    }

    .tabs a.on {
        background: #fff;
        color: var(--pri);
        box-shadow: 0 1px 3px rgba(15, 23, 42, .1)
    }

    .pg {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 14px;
        color: var(--mut)
    }

    .rep {
        white-space: pre-wrap;
        font: 14px/1.8 Inter;
        background: #fafbfe;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 24px;
        margin: 0
    }

    .chips a {
        display: inline-block;
        margin: 0 8px 8px 0;
        padding: 7px 13px;
        border: 1px solid var(--line);
        border-radius: 99px;
        background: #fff;
        color: #475569;
        font-size: 12.5px;
        cursor: pointer
    }

    .chips a:hover {
        border-color: var(--pri);
        color: var(--pri)
    }

    .ans {
        margin-top: 18px;
        background: linear-gradient(180deg, #f8f9ff, #fff);
        border: 1px solid #dfe3ff;
        border-radius: 14px;
        padding: 20px;
        white-space: pre-wrap;
        line-height: 1.75
    }

    .two {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0 16px
    }

    @media(max-width:1000px) {
        .g3 {
            grid-template-columns: 1fr
        }
    }

    @media(max-width:860px) {
        .shell {
            grid-template-columns: 1fr
        }

        .side {
            position: static;
            height: auto;
            flex-direction: row;
            flex-wrap: wrap;
            align-items: center;
            padding: 12px;
            gap: 8px
        }

        .brand {
            padding: 0
        }

        .nav {
            display: flex;
            gap: 4px;
            overflow-x: auto;
            flex: 1 0 100%
        }

        .nav a {
            white-space: nowrap
        }

        .nav .lbl {
            display: none
        }

        .foot {
            margin: 0;
            border: 0;
            padding: 0
        }

        .main {
            padding: 20px 16px 50px
        }

        .two {
            grid-template-columns: 1fr
        }
    }

    @media print {

        .side,
        .tools,
        .btn {
            display: none !important
        }

        .shell {
            display: block
        }

        .main {
            padding: 0
        }
    }

    /* ===== Forms: animated all-blue gradient border ===== */
    @keyframes spin {
        to {
            --ang: 360deg
        }
    }

    @keyframes glow {

        0%,
        100% {
            box-shadow: 0 4px 12px rgba(37, 99, 235, .14)
        }

        50% {
            box-shadow: 0 6px 20px rgba(37, 99, 235, .38)
        }
    }

    /* Register / admin member form (standard size: 342px wide) */
    form:has(>.fgrid) {
        border: 2px solid transparent;
        border-radius: 12px;
        padding: 17px 13px 19px;
        background: linear-gradient(180deg, #f5f8ff, #fff 45%) padding-box, conic-gradient(from var(--ang), #1d4ed8, #60a5fa, #38bdf8, #1e40af, #1d4ed8) border-box;
        animation: spin 4s linear infinite, glow 3s ease-in-out infinite
    }

    .panel {
        padding: 20px 16px
    }

    .panel .form:has(form>.fgrid) {
        max-width: 342px
    }

    .panel .form:has(form>.fgrid) h2 {
        font-size: 18px
    }

    .panel .form:has(form>.fgrid)>p {
        margin: 2px 0 8px;
        font-size: 12px
    }

    .panel .form:has(form>.fgrid) .link {
        margin-top: 10px;
        font-size: 13px
    }

    .fgrid .sec {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 0;
        font: 700 9px Inter;
        text-transform: uppercase;
        letter-spacing: .09em;
        color: #2563eb
    }

    .fgrid .sec:after {
        content: "";
        flex: 1;
        height: 1px;
        background: #d6e2ff
    }

    .fgrid .sec[style] {
        margin-top: 10px !important
    }

    form:has(>.fgrid) label {
        margin: 6px 0 2px;
        font-size: 11px
    }

    .fgrid input,
    .fgrid select,
    form:has(>.fgrid) input[type=number] {
        padding: 6px 9px;
        font-size: 12px;
        border: 1.5px solid #dbe3f5;
        border-radius: 7px;
        background: #fff
    }

    .fgrid input:focus,
    .fgrid select:focus,
    form:has(>.fgrid) input[type=number]:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .15)
    }

    .fgrid .two {
        gap: 0 10px
    }

    form:has(>.fgrid) .btn {
        margin-top: 10px;
        padding: 8px 12px;
        font-size: 12.5px;
        border-radius: 7px;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        box-shadow: 0 6px 14px rgba(37, 99, 235, .25)
    }

    .card:has(>form>.fgrid) {
        padding: 0;
        border: 0;
        background: none;
        box-shadow: none
    }

    /* Login form (needs class="login" on the <form>): 452px wide */
    form.login:has(>.fgrid) {
        border-radius: 18px;
        padding: 32px 28px 34px
    }

    .panel .form:has(form.login) {
        max-width: 452px
    }

    .panel .form:has(form.login) h2 {
        font-size: 28px
    }

    .panel .form:has(form.login)>p {
        font-size: 14px;
        margin: 4px 0 16px
    }

    form.login .fgrid .sec {
        font-size: 11px
    }

    form.login label {
        margin: 14px 0 6px;
        font-size: 13px
    }

    form.login .fgrid input {
        padding: 12px 14px;
        font-size: 14.5px;
        border-radius: 10px
    }

    form.login .btn {
        margin-top: 20px;
        padding: 13px 16px;
        font-size: 15px;
        border-radius: 10px
    }

    /* Check-in form (needs class="checkin" on the <form>): 572px wide */
    .panel .form:has(form.checkin) {
        max-width: 572px !important;
        width: 100% !important
    }

    form.checkin:has(>.fgrid) {
        border-radius: 22px !important;
        padding: 42px 38px 44px !important
    }

    .panel .form:has(form.checkin) h2 {
        font-size: 36px !important
    }

    .panel .form:has(form.checkin)>p {
        font-size: 16px !important;
        margin: 6px 0 22px !important
    }

    form.checkin .fgrid .sec {
        font-size: 12.5px !important
    }

    form.checkin label {
        margin: 20px 0 8px !important;
        font-size: 15px !important
    }

    form.checkin .fgrid input,
    form.checkin input[type=number] {
        padding: 17px 18px !important;
        font-size: 16.5px !important;
        border-radius: 13px !important
    }

    form.checkin .btn {
        margin-top: 28px !important;
        padding: 18px 22px !important;
        font-size: 17px !important;
        border-radius: 13px !important
    }

    .panel .form:has(form.checkin) .link {
        font-size: 16px !important;
        margin-top: 20px !important
    }

    @media(max-width:560px) {
        form:has(>.fgrid) {
            padding: 17px 11px 19px
        }

        form.login:has(>.fgrid) {
            padding: 24px 18px 26px
        }

        form.checkin:has(>.fgrid) {
            padding: 28px 22px 30px !important
        }
    }

    @media(prefers-reduced-motion:reduce) {
        form:has(>.fgrid) {
            animation: none
        }
    }

    /* Register form (needs class="register" on the <form>): 560px wide, taller */
    .panel .form:has(form.register) {
        max-width: 560px
    }

    form.register:has(>.fgrid) {
        border-radius: 18px;
        padding: 36px 34px 40px
    }

    .panel .form:has(form.register) h2 {
        font-size: 28px
    }

    .panel .form:has(form.register)>p {
        font-size: 14px;
        margin: 4px 0 18px
    }

    form.register .fgrid .sec {
        font-size: 11px
    }

    form.register .fgrid .sec[style] {
        margin-top: 22px !important
    }

    form.register label {
        margin: 16px 0 6px;
        font-size: 13px
    }

    form.register .fgrid input,
    form.register .fgrid select,
    form.register input[type=number] {
        padding: 13px 15px;
        font-size: 14.5px;
        border-radius: 10px
    }

    form.register .fgrid .two {
        gap: 0 16px
    }

    form.register .btn {
        margin-top: 26px;
        padding: 14px 18px;
        font-size: 15px;
        border-radius: 10px
    }

    .panel .form:has(form.register) .link {
        font-size: 14.5px;
        margin-top: 16px
    }

    @media(max-width:560px) {
        form.register:has(>.fgrid) {
            padding: 24px 18px 28px
        }
    }
</style>
