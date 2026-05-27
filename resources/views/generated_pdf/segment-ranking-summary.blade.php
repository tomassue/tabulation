<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Segment Ranking Report</title>
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
            $isBangga    = $category->category == 'bangga-sa-daygon';
            $titlePrefix = Setting::get('report_header_title', '');
            $venue       = $isBangga
                ? Setting::get('report_header_venue_alt', 'Cagayan de Oro City Hall Building - Tourism Hall')
                : Setting::get('report_header_venue', '');
            $time        = $isBangga
                ? Setting::get('report_header_time_alt', '4:00 PM')
                : Setting::get('report_header_time', '');
            $datetime    = $time ? date('F d, Y') . ' | ' . $time : date('F d, Y');
        @endphp
        @include('generated_pdf._header', [
            'headerTitle'    => $titlePrefix ? $titlePrefix . ': ' . $category->description : $category->description,
            'headerVenue'    => $venue,
            'headerDatetime' => $datetime,
        ])

        {{-- Report title block --}}
        <table class="table">
            <tr>
                <td style="vertical-align: top;" width="100%">
                    <div style="text-align:center;padding-top:10px;padding-bottom:5px;">
                        <div style="font-size:15pt;"><i>Ranking Scoring Sheet &mdash; By Segment</i></div>
                        <div style="font-size:20pt;text-transform:uppercase;color:#266da7;font-weight:bold;">
                            {{ $category->description }}
                        </div>
                        <div style="margin-top:4px;">
                            <span style="background:#dce9f7;border:1px solid #aec6e8;padding:3px 12px;font-size:11pt;font-weight:bold;text-transform:uppercase;">
                                {{ $segmentName }}
                            </span>
                            <span style="color:#c0392b;font-size:10pt;margin-left:6px;">{{ $segWeight }}% weight</span>
                            <span style="color:#555;font-size:9pt;margin-left:6px;">— max {{ $segMax }} pts per judge</span>
                        </div>
                        <div style="font-size:8pt;color:#555;margin-top:3px;">
                            Criteria:
                            @foreach ($segCriterias as $c)
                                <strong>{{ $c->criteria }}</strong> ({{ $c->perfect_score }} pts){{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Main ranking table: score + rank per judge, total rank, final rank --}}
        <table class="table bordered">
            <thead>
                <tr>
                    <th style="width:3%;" rowspan="2">#</th>
                    <th width="35%" rowspan="2" style="font-size:9pt;">CONTINGENT</th>
                    @foreach ($judges as $judge)
                        <th style="text-transform:uppercase;font-size:9pt;text-align:center;" colspan="2">
                            {{ $judge->judge }}
                            <div style="color:#27ae60;font-size:7pt;font-weight:normal;">(wtd score)</div>
                        </th>
                    @endforeach
                    <th width="7%" rowspan="2" style="font-size:9pt;text-align:center;">TOTAL<br />RANK</th>
                    <th width="8%" rowspan="2" style="font-size:9pt;text-align:center;color:green;">FINAL<br />RANK</th>
                </tr>
                <tr>
                    @foreach ($judges as $judge)
                        <th style="font-size:8pt;text-align:center;">Wtd Score</th>
                        <th style="font-size:8pt;text-align:center;">Rank</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($grands as $item)
                    <tr class="winner-{{ $item['ordinal_rank'] }}">
                        <td class="text-center" style="font-size:10pt;">{{ $item['participant_no'] }}</td>
                        <td style="font-size:9pt;padding:2px;">{{ $item['participant'] }}</td>
                        @foreach ($judges as $judge)
                            <td class="text-center" style="font-size:9pt;">
                                {{ bong_format($item['subtotals'][$judge->user_id] ?? 0) }}
                            </td>
                            <td class="text-center" style="font-weight:bold;font-size:9pt;">
                                {{ ($item['judge_scores'][$judge->user_id] ?? 0) != 0
                                    ? bong_ordinal($item['judge_scores'][$judge->user_id])
                                    : '-' }}
                            </td>
                        @endforeach
                        <td class="text-center" style="font-size:12pt;">{{ $item['grand'] }}</td>
                        <td class="text-center" style="font-size:12pt;color:green;font-weight:bold;">
                            {{ bong_ordinal($item['ordinal_rank']) }}
                        </td>
                    </tr>
                @empty
                    @php $cols = $judges->count() * 2 + 4; @endphp
                    <tr>
                        <td colspan="{{ $cols }}" class="text-center" style="padding:10px;">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Judge signature strip --}}
        <table class="table" style="padding-top:5px;">
            <tr>
                @foreach ($judges as $judge)
                    <td style="text-align:right;vertical-align:top;">&nbsp;</td>
                    <td style="text-align:center;height:110px;width:300px;">
                        <div style="text-align:center;margin-bottom:30px;font-weight:bold;">
                            JUDGE #{{ $judge->nickname }}
                        </div>
                        <span style="text-transform:uppercase;font-weight:bold;">{{ $judge->judge }}</span>
                        <div class="text-center p-2" style="border-top:1px solid black;">
                            <i>Full Name and Signature</i>
                        </div>
                    </td>
                    <td width="20px;">&nbsp;</td>
                    @if ($loop->iteration % 3 == 0)
                </tr>
                <tr>
                    @endif
                @endforeach
            </tr>
        </table>
    </main>
</body>

</html>
