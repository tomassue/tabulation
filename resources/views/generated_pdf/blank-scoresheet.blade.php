<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Blank Score Sheet</title>
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

        #watermark {
            position: fixed;
            top: 10%;
            width: 100%;
            text-align: center;
            transform-origin: 50% 50%;
            opacity: .07;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            height: 50px;
            z-index: 1000;
        }

        .page-break {
            page-break-after: always;
            page-break-inside: avoid;
        }

        .striped td {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <main class="content">
        <div style="color: black;">
            @php
                use App\Models\Setting;
                $titlePrefix = Setting::get('report_header_title', '');
                $venue       = Setting::get('report_header_venue', '');
                $time        = Setting::get('report_header_time', '');
                $datetime    = $time ? date('F d, Y') . ' | ' . $time : date('F d, Y');
            @endphp

            @php
                // Pages: one per judge. If no judges, render a single generic page.
                $judgePages = $judges->count() ? $judges : collect([null]);
            @endphp

            @foreach ($judgePages as $judge)
                <div class="{{ !$loop->last ? 'page-break' : '' }}">
                    @include('generated_pdf._header', [
                        'headerTitle'    => trim(($titlePrefix ? $titlePrefix . ': ' : '') . ($categoryName ?? 'COMPETITION') . ' SCORE SHEET'),
                        'headerVenue'    => $venue,
                        'headerDatetime' => $datetime,
                    ])

                    <table class="table" style="margin-top: 8px;">
                        <tr>
                            <td class="text-center">
                                <div style="font-size: 14pt;font-weight:bold;text-transform:uppercase;letter-spacing:0.5px;">
                                    Official Score Sheet
                                </div>
                                <div style="font-size: 11pt;padding-top: 4px;">
                                    Judge:
                                    <span style="font-weight:bold;text-transform:uppercase;">{{ $judge?->judge ?? '________________________' }}</span>
                                </div>
                                <div style="font-size: 8.5pt;font-style: italic;color: #333;padding-top: 6px;">
                                    Write the score for each criterion. Total perfect score:
                                    {{ $criterias->sum('perfect_score') ?: 100 }} pts.
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div>
                        <table class="table bordered" style="margin-top: 12px;">
                            <thead>
                                <tr>
                                    <th class="text-center p-2 bold" style="font-size:9.5pt;width: 7%;">NO.</th>
                                    <th class="text-start p-2 bold" style="font-size:9.5pt;width: 23%;">CONTESTANT</th>
                                    @forelse ($criterias as $criteria)
                                        <th class="text-center p-2 bold" style="font-size:8.5pt;line-height:1.2;">
                                            {{ strtoupper($criteria->criteria) }}
                                            <div style="font-weight: normal;font-size:8pt;color:#333;">({{ $criteria->perfect_score }} pts)</div>
                                        </th>
                                    @empty
                                        <th class="text-center p-2 bold" style="font-size:9.5pt;">SCORE</th>
                                    @endforelse
                                    <th class="text-center p-2 bold" style="font-size:9.5pt;width: 11%;">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($participants as $item)
                                    <tr class="{{ $loop->iteration % 2 == 0 ? 'striped' : '' }}">
                                        <td class="text-center bold" style="padding:5px;font-size:10pt;">{{ $item->participant_no }}</td>
                                        <td class="text-start" style="padding:5px;height: 40px;">
                                            <span style="font-weight: bold;font-size:10pt;">{{ $item->participant }}</span>
                                            @if (!empty($item->school) && trim(strtolower($item->school)) !== trim(strtolower($item->participant)))
                                                <div style="font-size:8pt;color:#555;">{{ $item->school }}</div>
                                            @endif
                                        </td>
                                        @forelse ($criterias as $criteria)
                                            <td style="height: 40px;">&nbsp;</td>
                                        @empty
                                            <td style="height: 40px;">&nbsp;</td>
                                        @endforelse
                                        <td style="height: 40px;">&nbsp;</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center p-3" style="font-style:italic;color:#555;" colspan="{{ 3 + max($criterias->count(), 1) }}">
                                            No contestants are assigned to this category yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <table class="table" style="padding-top: 80px;">
                        <tr>
                            <td width="58%">&nbsp;</td>
                            <td style="text-align: center;height: 110px;">
                                <span style="text-transform: uppercase;font-weight: bold;font-size:10pt;">{{ $judge?->judge ?? '&nbsp;' }}</span>
                                <div class="text-center p-2" style="border-top: 1px solid black;font-size:9pt;">
                                    <i>Signature over Printed Name</i>
                                </div>
                                <span style="font-size:9pt;letter-spacing:1px;">JUDGE</span>
                            </td>
                            <td width="5%">&nbsp;</td>
                        </tr>
                    </table>
                </div>
            @endforeach
        </div>
    </main>
</body>

</html>
