<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Score Report</title>
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

        .top3 {
            font-weight: bold;
            font-size: 13pt;
            background-color: #26a75c;
            color: white;
        }

        .rest {
            font-size: 12pt;
            background-color: #fff;
            color: black;
        }

        #watermark {
            position: fixed;
            top: 10%;
            width: 100%;
            text-align: center;
            /* transform: rotate(330deg); */
            transform-origin: 50% 50%;
            opacity: .07;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            /* Pull content into margin area */
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
    </style>
</head>

<body>
    <footer class="footer">
        <table style="opacity: 0.5;">
            <tr>
                <td colspan="2" style="vertical-align: bottom;font-weight: bold;"><i>CMISID Tabulation System</i></td>
            </tr>
            <tr>
                <td style="vertical-align: middle;"><i>Powered by:</i></td>
                <td style="vertical-align: bottom;"><img src="{{ convert_image(public_path() . '/img/ict.png') }}" width="30"></td>
            </tr>
        </table>
    </footer>
    <div id="watermark">
        <img src="{{ convert_image(public_path() . '/img/final-pasko-de-oro.png') }}" width="50%">
    </div>
    <main class="content">
        <div style="color: black;">
            <table class="table">
                <tr>
                    <td class="text-start" style="vertical-align: top;" width="30%">
                        <img src="{{ convert_image(public_path() . '/img/cdo_email.png') }}" width="80">
                        <img src="{{ convert_image(public_path() . '/img/goldencdo_email.png') }}" width="150">

                    </td>
                    <td class="text-center">
                        <div style="font-size: 20pt;font-weight:bold;">Pasko de Oro 2025</div>
                        <div style="font-size: 15pt;font-weight:bold;color: #26a75c;">Beyond Higala</div>
                        <div style="font-size: 13pt;">...Pamilya</div>
                        <div style="font-size: 13pt;">{{ date('F d, Y') }}</div>
                    </td>
                    <td class="text-end" width="30%">
                        <img src="{{ convert_image(public_path() . '/img/final-pasko-de-oro.png') }}" width="75">
                        <img src="{{ convert_image(public_path() . '/img/tourism_email.png') }}" width="75">
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">

                        <div style="font-size: 15pt;font-weight:bold;text-transform:uppercase;padding-top: 20px;">
                            <div>{{ $categoryName ?? 'COMPETITION' }} SCORE REPORT</div>
                            <div>{{ $criteria ? '(BEST IN ' . $criteria->criteria . ')' : '' }}</div>
                            <div style="font-size: 9pt;">{{ $judges->count() == 1 ? '(JUDGE: ' . $judges->first()->judge . ')' : '' }}</div>
                        </div>
                    </td>
                </tr>
            </table>
            <div>
                <table class="table bordered" style="padding-top: 20px;">
                    <thead>
                        <tr>
                            <th class="text-center p-2 bold" style="font-size:10pt;width: 10%;">SEQUENCE NUMBER</th>
                            <th class="text-center  p-2 bold" style="font-size:10pt;width: 20%;">CONTESTANT</th>
                            <th class="text-center p-2 bold" style="font-size:10pt;width: 5%;">RANK</th>
                            @foreach ($judges as $judge)
                                <th class="text-center  p-2 bold" style="font-size:10pt;width: 10%;">
                                    {{ $judge->judge }}
                                </th>
                            @endforeach
                            @if (auth()->user()->role == 'admin')
                                @if (!$criteria)
                                    <th class="text-center  p-2 bold"style="font-size:10pt;width: 10%;">DEDUCTION</th>
                                    <th class="text-center  p-2 bold"style="font-size:10pt;width: 10%;">TIME</th>
                                    <th class="text-center  p-2 bold"style="font-size:10pt;">REMARKS</th>
                                @endif
                                <th class="text-center  p-2 bold"style="font-size:10pt;width: 10%;">TOTAL</th>
                            @endif
                        </tr>
                    </thead>
                    @foreach ($participants as $position => $item)
                        <tr>
                            @if ($item->current_rank <= $winner)
                                @php
                                    $class = 'top3';
                                @endphp
                            @else
                                @php
                                    $class = 'rest';
                                @endphp
                            @endif
                            <td class="text-center  {{ $class }}" style="padding:5px;">{{ $item->participant_no }}</td>
                            <td class="text-start  {{ $class }}" style="padding:5px;min-height: 40px;height: 40px;font-weight: bold;">{{ $item->participant }}</td>
                            <td class="text-center {{ $class }}">
                                <span>{{ bong_ordinal($item->current_rank) }}</span>
                            </td>
                            @foreach ($judges as $judge)
                                <td class="text-center  {{ $class }}" style="padding:5px;">{{ bong_format($item->getHigalaayScoreByJudge($judge->id, $category, $criteria)) }}</td>
                            @endforeach
                            @if (auth()->user()->role == 'admin')
                                @if (!$criteria)
                                    @php
                                        $deducted = \App\Models\HigalaayDeduction::where('participant_id', $item->id)->where('category', $category)->first();
                                    @endphp
                                    <td class="text-center {{ $class }}">{{ $deducted?->deduction == 0 ? '-' : bong_format($deducted?->deduction) }}</td>
                                    <td class="text-center {{ $class }}">{{ $deducted?->duration ?? '-' }}</td>
                                    <td class="text-start {{ $class }}" style="padding:5px;">{{ $deducted?->remarks }}</td>
                                @endif
                                <td class="text-center {{ $class }}">{{ bong_format($item->averageHigalaay($category, $criteria)) }}</td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
            <table class="table" style="padding-top: 100px;">
                <tr>
                    @foreach ($judges as $judge)
                        <td style="text-align: right; vertical-align: top;">
                            &nbsp;
                        </td>
                        <td style="text-align: center;height: 120px;width: 300px">
                            <span style="text-transform: uppercase;font-weight: bold">{{ $judge->judge }}</span>
                            <div class="text-center p-2" style="border-top: 1px solid black;">
                                <i>Signature over printed name</i>
                            </div>
                            <span>JUDGE</span>
                        </td>
                        <td width="20px;">
                            &nbsp;
                        </td>
                        @if ($loop->iteration % 3 == 0)
                </tr>
                <tr>
                    @endif
                    @endforeach
                </tr>
            </table>
        </div>
    </main>
</body>

</html>
