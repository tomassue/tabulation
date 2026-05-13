<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Technical Scoring Result</title>
    <style>
        * { font-family: Arial, Helvetica, sans-serif; }

        .table { width: 100%; border-collapse: collapse; }

        table.bordered td { border: 1px solid black; }
        table.bordered th { border: 1px solid black; }

        .text-center { text-align: center; }
        .text-start  { text-align: left; }
        .text-end    { text-align: right; }
        .bold        { font-weight: bold; }
        .p-2         { padding: 5px; }
        .p-3         { padding: 10px; }

        .footer {
            position: fixed;
            bottom: 10px;
            left: 0; right: 0;
            text-align: center;
            height: 70px;
            z-index: -1000;
        }

        #watermark {
            position: fixed;
            top: 1%;
            width: 100%;
            text-align: center;
            transform-origin: 50% 50%;
            opacity: .07;
        }

        #developer {
            position: fixed;
            top: 50%;
            left: -115px;
            font-weight: bold;
            text-align: right;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        table.bordered tbody tr:nth-child(odd)  { background-color: #f2f2f2; }
        table.bordered tbody tr:nth-child(even) { background-color: #ffffff; }

        .winner-1 { background: rgb(255,240,152) !important; color: black; font-weight: bold !important; }
        .winner-2 { background: silver            !important; color: black; font-weight: bold !important; }
        .winner-3 { background: #fcd6b0           !important; color: black; font-weight: bold !important; }

        .cat-header { font-size: 7pt; text-transform: uppercase; text-align: center; }
        .judge-sub  { font-size: 6pt; color: #555; text-align: center; font-style: italic; }

        .score-cell { text-align: center; font-size: 9pt; padding: 3px; }
        .total-cell { text-align: center; font-size: 9pt; font-weight: bold; color: #1a5276; }
        .ded-cell   { text-align: center; font-size: 9pt; color: red; }
        .final-cell { text-align: center; font-size: 10pt; font-weight: bold; color: #1e8449; }
        .rank-cell  { text-align: center; font-size: 10pt; font-weight: bold; }

        .section-title {
            font-size: 20pt;
            text-transform: uppercase;
            color: #266da7;
            font-weight: bold;
            text-align: center;
        }
        .section-sub {
            font-size: 12pt;
            font-style: italic;
            text-align: center;
        }

        .sig-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .sig-cell  { text-align: center; height: 90px; width: 200px; vertical-align: bottom; padding: 5px; }
        .sig-name  { font-weight: bold; text-transform: uppercase; font-size: 9pt; }
        .sig-line  { border-top: 1px solid black; font-size: 8pt; font-style: italic; margin-top: 4px; padding-top: 2px; }
        .sig-role  { font-size: 8pt; color: #555; margin-top: 2px; }

        .deduction-legend {
            font-size: 8pt;
            color: #555;
            margin-top: 8px;
            padding: 4px 6px;
            border: 1px dashed #aaa;
            display: inline-block;
        }
    </style>
</head>
<body>

<div id="developer"><i>CMISID Tabulation System</i></div>

<main>
    @php
        use App\Models\Setting;
        $titlePrefix = Setting::get('report_header_title', '');
    @endphp

    @include('generated_pdf._header', [
        'headerTitle' => $titlePrefix ? $titlePrefix . ': ' . $category->description : $category->description,
    ])

    {{-- ── Report subtitle ── --}}
    <table class="table" style="margin-bottom:6px;">
        <tr>
            <td class="text-center" style="padding-top:8px;padding-bottom:4px;">
                <div class="section-sub"><i>Technical Scoring — Official Result</i></div>
                <div class="section-title">{{ $category->description }}</div>
                <div style="font-size:9pt;color:#555;margin-top:4px;">
                    Maximum possible score: <strong>{{ $technicalCategories->sum('max_score') }} pts</strong>
                    &nbsp;|&nbsp;
                    {{ $technicalCategories->count() }} judging {{ Str::plural('category', $technicalCategories->count()) }}
                </div>
            </td>
        </tr>
    </table>

    {{-- ── Main result table ── --}}
    <table class="table bordered">
        <thead>
            {{-- Row 1: group headers --}}
            <tr>
                <th style="width:3%;"  rowspan="2" class="text-center p-2" style="font-size:9pt;">#</th>
                <th style="width:28%;" rowspan="2" class="p-2" style="font-size:9pt;">CONTINGENT</th>
                @foreach($technicalCategories as $tc)
                    @php $assignedJudge = $tc->judgeAssignments->first()?->judge; @endphp
                    <th class="cat-header p-2" style="width:{{ max(6, floor(42 / $technicalCategories->count())) }}%;">
                        {{ $tc->name }}<br>
                        <span class="judge-sub">
                            Max&nbsp;{{ $tc->max_score }}pts
                            @if($assignedJudge) &nbsp;|&nbsp; {{ $assignedJudge->judge }} @endif
                        </span>
                    </th>
                @endforeach
                <th rowspan="2" class="text-center p-2" style="font-size:8pt;width:6%;color:#1a5276;">GROSS<br>TOTAL</th>
                <th rowspan="2" class="text-center p-2" style="font-size:8pt;width:5%;color:red;">DEDUCTION</th>
                <th rowspan="2" class="text-center p-2" style="font-size:9pt;width:7%;color:#1e8449;">FINAL<br>SCORE</th>
                <th rowspan="2" class="text-center p-2" style="font-size:9pt;width:6%;">FINAL<br>RANK</th>
            </tr>
            {{-- Row 2: max score sub-row (already shown in row 1, so keep empty) --}}
            <tr>
                @foreach($technicalCategories as $tc)
                    <th class="text-center" style="font-size:7pt;color:#888;">
                        Score
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
                @php
                    $winnerClass = $row['rank'] <= $winner ? 'winner-' . min($row['rank'], 3) : '';
                @endphp
                <tr class="{{ $winnerClass }}">
                    <td class="text-center p-2" style="font-size:9pt;">{{ $row['participant']->participant_no }}</td>
                    <td class="p-2" style="font-size:9pt;">{{ $row['participant']->participant }}</td>
                    @foreach($technicalCategories as $tc)
                        <td class="score-cell">
                            {{ number_format($row['categoryScores'][$tc->id] ?? 0, 1) }}
                        </td>
                    @endforeach
                    <td class="total-cell">{{ number_format($row['grandTotal'], 1) }}</td>
                    <td class="ded-cell">
                        {{ $row['totalDeduction'] > 0 ? '-'.number_format($row['totalDeduction'], 1) : '—' }}
                    </td>
                    <td class="final-cell">{{ number_format($row['finalScore'], 1) }}</td>
                    <td class="rank-cell">{{ bong_ordinal($row['rank']) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $technicalCategories->count() + 6 }}" class="text-center p-2">No scores recorded.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ── Deduction legend ── --}}
    <div class="deduction-legend">
        Deduction types: Technical Minor = 1 pt/occurrence &nbsp;|&nbsp; Technical Major = 3 pts/occurrence &nbsp;|&nbsp; Penalty (safety/conduct) = 10 pts/occurrence
    </div>

    {{-- ── Signatures ── --}}
    @if($technicalCategories->isNotEmpty())
        <table class="sig-table" style="margin-top:30px;">
            <tr>
                @foreach($technicalCategories as $i => $tc)
                    @php $j = $tc->judgeAssignments->first()?->judge; @endphp
                    <td class="sig-cell">
                        <div style="font-size:8pt;color:#777;margin-bottom:25px;">
                            Judge — {{ $tc->name }}
                        </div>
                        @if($j)
                            <div class="sig-name">{{ $j->judge }}</div>
                        @else
                            <div class="sig-name" style="color:#aaa;">(No judge assigned)</div>
                        @endif
                        <div class="sig-line">Full Name and Signature</div>
                    </td>
                    @if(($i + 1) % 3 === 0 && !$loop->last)
                        </tr><tr>
                    @endif
                @endforeach
            </tr>
        </table>
    @endif
</main>

</body>
</html>
