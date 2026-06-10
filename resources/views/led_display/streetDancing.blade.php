<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">
    <title>Street Dancing</title>
    @php
        use App\Models\Setting;
        $s_watermark = Setting::get('report_watermark');
        $s_logoLeft1 = Setting::get('report_logo_left_1');
        $s_logoLeft2 = Setting::get('report_logo_left_2');
        $s_logoLeft3 = Setting::get('report_logo_left_3');
        $s_logoRight1 = Setting::get('report_logo_right');
        $s_logoRight2 = Setting::get('report_logo_right_2');
        $s_title = Setting::get('report_header_title', 'HIGALAAY FESTIVAL');

        $bg_url = $s_watermark ? asset('storage/report-header/' . $s_watermark) : asset('img/higalaay2025.gif');
    @endphp
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            height: 100vh;
            overflow: hidden;
            background: #0a0a18;
            font-family: 'Anton', sans-serif;
        }

        /* ── background watermark ── */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: url("{{ $bg_url }}") no-repeat center center / cover;
            opacity: 0.18;
            z-index: 0;
        }

        /* ── dark gradient vignette ── */
        body::after {
            content: "";
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse at center, transparent 30%, rgba(0, 0, 0, 0.55) 100%);
            z-index: 0;
        }

        .led-root {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            padding: 2vh 3vw;
        }

        /* ── top bar: logos ── */
        .logo-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2.5vw;
            flex-shrink: 0;
            padding-bottom: 1.5vh;
            border-bottom: 2px solid rgba(255, 255, 255, 0.12);
        }

        .logo-bar img {
            height: clamp(60px, 10vh, 130px);
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.6));
        }

        /* ── event title strip ── */
        .event-title {
            text-align: center;
            color: #fff;
            font-family: 'Bebas Neue', 'Anton', sans-serif;
            font-size: clamp(1.4rem, 3.5vh, 3rem);
            letter-spacing: 0.18em;
            text-transform: uppercase;
            padding: 1.2vh 0 0.2vh;
            opacity: 0.85;
            flex-shrink: 0;
        }

        .competition-label {
            text-align: center;
            font-family: 'Bebas Neue', 'Anton', sans-serif;
            font-size: clamp(1.8rem, 5vh, 4rem);
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #FFD700;
            text-shadow: 0 0 24px rgba(255, 215, 0, 0.45);
            padding-bottom: 1vh;
            flex-shrink: 0;
        }

        /* ── main winner area ── */
        .winner-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2vh;
        }

        /* placement badge */
        .placement-badge {
            font-family: 'Bebas Neue', 'Anton', sans-serif;
            font-size: clamp(2rem, 5vh, 4.5rem);
            letter-spacing: 0.2em;
            text-transform: uppercase;
            padding: 0.4em 1.2em;
            border-radius: 8px;
            border: 3px solid currentColor;
        }

        .placement-1 {
            color: #FFD700;
            text-shadow: 0 0 30px rgba(255, 215, 0, 0.6);
            border-color: #FFD700;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.25);
        }

        .placement-2 {
            color: #C0C0C0;
            text-shadow: 0 0 20px rgba(192, 192, 192, 0.5);
            border-color: #C0C0C0;
        }

        .placement-3 {
            color: #CD7F32;
            border-color: #CD7F32;
        }

        .placement-4 {
            color: #a0c4ff;
            border-color: #a0c4ff;
        }

        /* single winner name */
        .winner-name {
            font-family: 'Anton', sans-serif;
            font-size: clamp(3rem, 11vw, 9rem);
            line-height: 1;
            color: #ffffff;
            text-align: center;
            text-shadow: 0 0 40px rgba(255, 220, 50, 0.6), 6px 6px 0 rgba(0, 0, 0, 0.45);
            word-break: break-word;
            padding: 0 4vw;
        }

        /* all-4 list */
        .winners-list {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.4vh;
            width: 100%;
        }

        .winner-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2vw;
            width: 100%;
        }

        .winner-row .rank-badge {
            font-family: 'Bebas Neue', 'Anton', sans-serif;
            font-size: clamp(1rem, 2.8vh, 2.2rem);
            letter-spacing: 0.1em;
            flex-shrink: 0;
            min-width: 22vw;
            text-align: right;
            padding-right: 1.5vw;
        }

        .winner-row .divider {
            width: 3px;
            height: clamp(28px, 4vh, 56px);
            border-radius: 2px;
            flex-shrink: 0;
        }

        .winner-row .name {
            font-family: 'Anton', sans-serif;
            flex: 1;
            text-align: left;
            line-height: 1;
            padding-left: 1.5vw;
        }

        /* colour palette per rank */
        .rank-1 .rank-badge {
            color: #FFD700;
        }

        .rank-1 .divider {
            background: #FFD700;
            box-shadow: 0 0 12px #FFD700;
        }

        .rank-1 .name {
            color: #FFD700;
            font-size: clamp(2.2rem, 6vw, 5.5rem);
            text-shadow: 0 0 30px rgba(255, 215, 0, 0.5);
        }

        .rank-2 .rank-badge {
            color: #C0C0C0;
        }

        .rank-2 .divider {
            background: #C0C0C0;
            box-shadow: 0 0 10px #C0C0C0;
        }

        .rank-2 .name {
            color: #C0C0C0;
            font-size: clamp(1.8rem, 5vw, 4.8rem);
        }

        .rank-3 .rank-badge {
            color: #CD7F32;
        }

        .rank-3 .divider {
            background: #CD7F32;
        }

        .rank-3 .name {
            color: #CD7F32;
            font-size: clamp(1.5rem, 4.2vw, 4rem);
        }

        .rank-4 .rank-badge {
            color: #a0c4ff;
        }

        .rank-4 .divider {
            background: #a0c4ff;
        }

        .rank-4 .name {
            color: #a0c4ff;
            font-size: clamp(1.3rem, 3.8vw, 3.6rem);
        }

        /* ── animated background layers ── */
        .aurora {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .aurora-band {
            position: absolute;
            width: 160%;
            height: 35vh;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0;
            animation: aurora-drift linear infinite;
            transform-origin: center center;
        }

        .aurora-band:nth-child(1) {
            background: radial-gradient(ellipse, rgba(20, 180, 80, 0.5) 0%, transparent 70%);
            top: -10vh;
            left: -30%;
            animation-duration: 18s;
            animation-delay: 0s;
        }

        .aurora-band:nth-child(2) {
            background: radial-gradient(ellipse, rgba(255, 160, 20, 0.4) 0%, transparent 70%);
            top: 10vh;
            left: 20%;
            animation-duration: 22s;
            animation-delay: -6s;
        }

        .aurora-band:nth-child(3) {
            background: radial-gradient(ellipse, rgba(20, 180, 255, 0.35) 0%, transparent 70%);
            top: 30vh;
            left: -10%;
            animation-duration: 26s;
            animation-delay: -12s;
        }

        .aurora-band:nth-child(4) {
            background: radial-gradient(ellipse, rgba(255, 60, 120, 0.3) 0%, transparent 70%);
            bottom: -5vh;
            left: 10%;
            animation-duration: 20s;
            animation-delay: -4s;
        }

        @keyframes aurora-drift {
            0% {
                opacity: 0;
                transform: translateX(-8%) scaleY(0.8);
            }

            15% {
                opacity: 1;
            }

            50% {
                transform: translateX(8%) scaleY(1.2);
            }

            85% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translateX(-8%) scaleY(0.8);
            }
        }

        .logo-bar.active {
            border-bottom-color: rgba(255, 215, 0, 0.35);
        }

        /* steady glow on winner name */
        .winner-name {
            text-shadow: 0 0 40px rgba(255, 220, 50, 0.55), 6px 6px 0 rgba(0, 0, 0, 0.45);
        }

        /* steady glow on placement badge */
        .placement-badge {
            box-shadow: 0 0 18px currentColor;
        }

        /* steady glow on competition label */
        .competition-label {
            text-shadow: 0 0 24px rgba(255, 215, 0, 0.5);
        }

        /* ── confetti ── */
        .confetti-wrap {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 2;
        }

        .confetti-piece {
            position: absolute;
            top: -10%;
            opacity: 0.85;
            animation: confetti-fall linear infinite;
            border-radius: 2px;
        }

        @keyframes confetti-fall {
            to {
                top: 110%;
                transform: translateX(40px) rotate(900deg);
            }
        }
    </style>
</head>

<body>

    {{-- animated background: aurora --}}
    <div class="aurora">
        <div class="aurora-band"></div>
        <div class="aurora-band"></div>
        <div class="aurora-band"></div>
        <div class="aurora-band"></div>
    </div>

    {{-- confetti only when winners are being shown --}}
    @if ($winners && $winners != '')
        <div class="confetti-wrap">
            @for ($i = 0; $i < 120; $i++)
                <div class="confetti-piece" style="
                    left: {{ rand(0, 100) }}%;
                    width: {{ rand(8, 15) }}px;
                    height: {{ rand(4, 8) }}px;
                    background: {{ collect(['#FFD700', '#FF4560', '#00E396', '#008FFB', '#ffffff'])->random() }};
                    animation-duration: {{ rand(4, 8) }}s;
                    animation-delay: {{ rand(0, 6) }}s;
                "></div>
            @endfor
        </div>
    @endif

    <div class="led-root">

        {{-- Logo bar --}}
        <div class="logo-bar {{ $winners && $winners != '' ? 'active' : '' }}">
            @if ($s_logoLeft1)
                <img src="{{ asset('storage/report-header/' . $s_logoLeft1) }}" alt="Logo">
            @endif
            @if ($s_logoLeft2)
                <img src="{{ asset('storage/report-header/' . $s_logoLeft2) }}" alt="Logo">
            @endif
            @if ($s_logoRight1)
                <img src="{{ asset('storage/report-header/' . $s_logoRight1) }}" alt="Logo">
            @endif
            @if ($s_logoRight2)
                <img src="{{ asset('storage/report-header/' . $s_logoRight2) }}" alt="Logo">
            @endif
        </div>

        {{-- Event title --}}
        <div class="event-title">{{ $s_title }}</div>
        @if ($led->category)
            @php
                $categoryDesc = \App\Models\Category::where('category', $led->category)->value('description');
            @endphp
            <div class="competition-label">{{ $categoryDesc ?? $led->category }}</div>
        @endif

        {{-- Winner display --}}
        <div class="winner-area">

            @php
                $placementLabels = [
                    1 => 'GRAND CHAMPION',
                    2 => '1ST RUNNER-UP',
                    3 => '2ND RUNNER-UP',
                    4 => '3RD RUNNER-UP',
                ];
            @endphp

            @if ($winners && $winners != '')

                @if (isset($position) && $position)

                    {{-- Single winner reveal --}}
                    <div class="placement-badge placement-{{ $position }}">
                        {{ $placementLabels[$position] ?? '3RD RUNNER-UP' }}
                    </div>
                    <div class="winner-name">{!! $winners !!}</div>
                @else
                    {{-- All-4 winners list --}}
                    <div class="winners-list">
                        @php
                            $rankLabels = [
                                1 => 'GRAND CHAMPION',
                                2 => '1ST RUNNER-UP',
                                3 => '2ND RUNNER-UP',
                                4 => '3RD RUNNER-UP',
                            ];
                        @endphp
                        @foreach ($participants as $p)
                            @php $r = $p->current_rank ?? ($loop->index + 1); @endphp
                            <div class="winner-row rank-{{ $r }}">
                                <div class="rank-badge">{{ $rankLabels[$r] ?? '' }}</div>
                                <div class="divider"></div>
                                <div class="name">{{ $p->participant }}</div>
                            </div>
                        @endforeach
                    </div>

                @endif
            @else
                {{-- Idle / standby --}}
                <div style="color: rgba(255,255,255,0.2); font-size: clamp(1.5rem, 4vw, 3.5rem); letter-spacing: 0.3em; text-transform: uppercase; text-align: center;">
                    STANDBY
                </div>

            @endif

        </div>{{-- /winner-area --}}

    </div>{{-- /led-root --}}


</body>

</html>
