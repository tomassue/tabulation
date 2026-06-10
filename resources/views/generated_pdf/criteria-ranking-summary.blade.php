<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Criteria Score Report</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        .table {
            width: 100%;
        }

        table.bordered td {
            border: 1px solid black;
        }

        table.bordered th {
            border: 1px solid black;
        }

        .table {
            border-collapse: collapse;
        }

        .text-center {
            text-align: center;
        }

        .text-start {
            text-align: left;
        }

        .text-end {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .p-2 {
            padding: 5px;
        }

        .p-3 {
            padding: 10px;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
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

        table.bordered tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        table.bordered tbody tr:nth-child(even) {
            background-color: #ffffff;
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

        .winner-1 {
            background: rgb(255, 240, 152) !important;
            color: black;
            font-weight: bold !important;
        }

        .winner-2 {
            background: silver !important;
            color: black !important;
            font-weight: bold !important;
        }

        .winner-3 {
            background: #fcd6b0 !important;
            color: black;
            font-weight: bold !important;
        }
    </style>
</head>

<body>
    <div id="developer">
        <div><i>CMISID Tabulation System</i></div>
    </div>
    <main>
        @php
            use App\Models\Setting;
            $isBangga = $category->category == 'bangga-sa-daygon';
            $titlePrefix = Setting::get('report_header_title', '');
            $venue = $isBangga ? Setting::get('report_header_venue_alt', 'Cagayan de Oro City Hall Building - Tourism Hall') : Setting::get('report_header_venue', '');
            $time = $isBangga ? Setting::get('report_header_time_alt', '4:00 PM') : Setting::get('report_header_time', '');
            $datetime = $time ? date('F d, Y') . ' | ' . $time : date('F d, Y');
        @endphp
        @include('generated_pdf._header', [
            'headerTitle' => $titlePrefix ? $titlePrefix . ': ' . $category->description : $category->description,
            'headerVenue' => $venue,
            'headerDatetime' => $datetime,
        ])

        {{-- Report title block --}}
        <div style="text-align:center;padding:10px 0 6px;">
            <div style="font-size:18pt;font-weight:bold;">Criteria Score Report</div>
            <div style="font-size:14pt;text-transform:uppercase;color:#266da7;font-weight:bold;">
                {{ $category->description }}
            </div>
            <div style="margin-top:4px;">
                <span style="background:#fef9e7;border:1px solid #f0c040;padding:3px 10px;font-size:11pt;font-weight:bold;text-transform:uppercase;">
                    {{ $criteria->criteria }}
                </span>
                <span style="color:#c0392b;font-size:10pt;margin-left:6px;">max {{ $criteria->perfect_score }} pts</span>
                @if ($criteria->segment)
                    <span style="color:#555;font-size:9pt;margin-left:6px;">— {{ $criteria->segment }} segment</span>
                @endif
            </div>
            <div style="font-size:10pt;color:#888;margin-top:4px;">Scoring Mode: <strong>{{ isset($scoringType) && $scoringType === 'rank' ? 'Ranking' : 'Average' }}</strong></div>
        </div>

        @php $isRank = isset($scoringType) && $scoringType === 'rank'; @endphp

        {{-- Main scores table --}}
        <table class="table bordered" style="margin-top:10px;">
            <thead>
                @if ($isRank)
                <tr>
                    <th width="3%" rowspan="2" style="font-size:9pt;padding:4px;">#</th>
                    <th rowspan="2" style="font-size:9pt;padding:4px;">CONTINGENT</th>
                    @foreach ($judges as $judge)
                        <th style="font-size:8pt;padding:4px;text-align:center;" colspan="2">
                            {{ $judge->judge }}
                        </th>
                    @endforeach
                    <th width="8%" rowspan="2" style="font-size:9pt;padding:4px;text-align:center;">TOTAL RANK</th>
                    <th width="10%" rowspan="2" style="font-size:9pt;padding:4px;text-align:center;color:green;">FINAL RANK</th>
                </tr>
                <tr>
                    @foreach ($judges as $judge)
                        <th style="font-size:8pt;padding:4px;text-align:center;">Score</th>
                        <th style="font-size:8pt;padding:4px;text-align:center;">Rank</th>
                    @endforeach
                </tr>
                @else
                <tr style="background:#2c3e50;color:#fff;">
                    <th width="3%" style="font-size:9pt;padding:4px;">#</th>
                    <th style="font-size:9pt;padding:4px;">CONTINGENT</th>
                    @foreach ($judges as $judge)
                        <th width="12%" style="font-size:8pt;padding:4px;text-align:center;">
                            {{ $judge->judge }}<br />
                            <span style="font-weight:normal;font-size:7pt;color:#dce9f7;">
                                / {{ $criteria->perfect_score }} pts
                            </span>
                        </th>
                    @endforeach
                    <th width="12%" style="font-size:9pt;padding:4px;text-align:center;background:#27ae60;color:#fff;">
                        AVERAGE<br />
                        <span style="font-weight:normal;font-size:7pt;">/ {{ $criteria->perfect_score }} pts</span>
                    </th>
                    <th width="10%" style="font-size:9pt;padding:4px;text-align:center;color:#27ae60;">RANKING</th>
                </tr>
                @endif
            </thead>
            <tbody>
                @forelse ($grands as $item)
                    @php $hasScore = array_sum($item['judge_scores']) > 0; @endphp
                    <tr class="{{ $hasScore ? 'winner-' . $item['ordinal_rank'] : '' }}">
                        <td class="text-center" style="font-size:9pt;padding:3px;">{{ $item['participant_no'] }}</td>
                        <td style="font-size:9pt;padding:3px;">{{ $item['participant'] }}</td>
                        @foreach ($judges as $judge)
                            <td class="text-center" style="font-size:9pt;padding:3px;">
                                {{ ($item['judge_scores'][$judge->user_id] ?? 0) > 0 ? bong_format($item['judge_scores'][$judge->user_id]) : '-' }}
                            </td>
                            @if ($isRank)
                            <td class="text-center" style="font-size:9pt;padding:3px;font-weight:bold;">
                                {{ ($item['judge_scores'][$judge->user_id] ?? 0) > 0 ? bong_ordinal($item['judge_rank_' . $judge->user_id] ?? 0) : '-' }}
                            </td>
                            @endif
                        @endforeach
                        @if ($isRank)
                        <td class="text-center" style="font-size:12pt;padding:3px;">
                            {{ $hasScore ? $item['total_rank'] : '-' }}
                        </td>
                        <td class="text-center" style="font-size:12pt;color:green;font-weight:bold;padding:3px;">
                            {{ $hasScore ? bong_ordinal($item['ordinal_rank']) : '-' }}
                        </td>
                        @else
                        <td class="text-center" style="font-size:10pt;font-weight:bold;padding:3px;background:#eaf4ea;">
                            {{ $hasScore ? bong_format($item['grand']) : '-' }}
                        </td>
                        <td class="text-center" style="font-size:10pt;color:green;font-weight:bold;padding:3px;">
                            {{ $hasScore ? bong_ordinal($item['ordinal_rank']) : '-' }}
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $judges->count() + 4 }}" class="text-center" style="padding:10px;">
                            No Data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Judge signature strip --}}
        @if ($judges->isNotEmpty())
            <div style="margin-top:30px;">
                <table style="width:100%;">
                    <tr>
                        @foreach ($judges as $judge)
                            <td style="text-align:center;vertical-align:bottom;padding:0 10px;">
                                <div style="margin-bottom:4px;font-size:9pt;font-weight:bold;">
                                    JUDGE #{{ $judge->nickname }}
                                </div>
                                <div style="border-top:1px solid black;padding-top:2px;">
                                    <span style="text-transform:uppercase;font-size:9pt;">{{ $judge->judge }}</span><br />
                                    <i style="font-size:8pt;color:#555;">Signature over Printed Name</i>
                                </div>
                            </td>
                            @if ($loop->iteration % 4 == 0 && !$loop->last)
                    </tr>
                    <tr style="height:30px;"></tr>
                    <tr>
                            @endif
                        @endforeach
                    </tr>
                </table>
            </div>
        @endif
    </main>
</body>

</html>
