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
            font-size: 15pt;
            /* background-color: #26a75c; */
            color: #2b754a;
            padding: 5px;
        }

        .rest {
            font-size: 12pt;
            background-color: #fff;
            color: black;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            /* Pull content into margin area */
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
            /* transform: rotate(330deg); */
            transform-origin: 50% 50%;
            opacity: .07;
        }

        .hr-with-text {
            display: flex;
            /* Enables flexbox for easy centering */
            align-items: center;
            /* Vertically centers the content */
            text-align: center;
            /* Horizontally centers inline content like text */
            width: 100%;
            /* Ensures the div spans the full width */
        }

        .hr-with-text::before,
        .hr-with-text::after {
            content: "";
            /* Required for pseudo-elements */
            flex-grow: 1;
            /* Makes the lines expand to fill available space */
            border-top: 1px dotted #080808;
            /* Creates the dotted line */
            margin: 0 10px;
            /* Adds spacing between lines and text */
        }

        .hr-with-text span {
            white-space: nowrap;
            /* Prevents text from wrapping */
            padding: 0 10px;
            /* Adds padding around the text */
        }
    </style>
</head>

<body>
    <footer class="footer">
        <img src="{{ convert_image(public_path() . '/img/footer-marching.png') }}" alt="" style="opacity: 0.5;" width="100%">
    </footer>
    <div id="watermark">
        <img src="{{ convert_image(public_path() . '/img/final-pasko-de-oro.png') }}" width="70%">
    </div>
    <main>
        <table class="table">
            <tr>
                <td class="text-start" style="vertical-align: top;">
                    <img src="{{ convert_image(public_path() . '/img/cdo_email.png') }}" width="70">
                    <img src="{{ convert_image(public_path() . '/img/goldencdo_email.png') }}" width="150">
                    <img src="{{ convert_image(public_path() . '/img/risebig.png') }}" width="150">
                </td>
                <td></td>
                <td class="text-end">
                    <img src="{{ convert_image(public_path() . '/img/final-pasko-de-oro.png') }}" width="150">
                </td>
            </tr>
        </table>
        <table class="table" style="margin-top:-100px;">
            <tr>
                <td class="text-center">
                    <div style="font-size: 20pt;font-weight:bold;text-transform: uppercase;">{{ $category->description }} COMPITITION 2025</div>
                    <div style="font-size: 13pt;">Rodelsa Circle - Velez - Tirso Neri - Capistrano - Gaerlan Streets</div>
                    <div style="font-size: 13pt;">{{ date('F d, Y') }}</div>
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td style="vertical-align: bottom;" width="20%">
                    <div>
                        @forelse ($judges as $index => $judge)
                            <div style="text-align: center;margin-bottom: 30px;font-weight: bold;">JUDGE #{{ $judge->nickname }}</div>
                            <div style="text-align: center; height: 100px;width: 200px">

                                <span style="text-transform: uppercase;font-weight: bold; font-size: 9pt;">{{ $judge->judge }}</span>
                                <div class="text-center" style="border-top: 1px solid black;margin-bottom: -5px">
                                    <div><i style="font-size: 10pt;">Full Name and Signature</i></div>

                                    <div>Time: _______________</div>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center;margin-bottom: 30px;font-weight: bold;">NO JUDGES</div>
                        @endforelse
                    </div>
                </td>
                <td style="vertical-align: top;" width="85%">
                    <div style="text-align: center;padding-top:20px;padding-bottom:20px;">
                        <div style="font-size: 15pt;"><i>Scoring Sheet</i></div>
                        <div style="font-size: 20pt;text-transform: uppercase;color: #266da7;font-weight: bold;">{{ $category->description }}
                            @if ($percentage)
                                (<span style="color: red;">{{ $percentage }}%</span>)
                            @endif
                        </div>
                    </div>
                    <table class="table bordered">
                        <thead>
                            <tr>
                                <th width="30%" style="font-size: 9pt;">CONTINGENT</th>
                                @foreach ($judges as $judge)
                                    <th>J{{ $judge->nickname }}</th>
                                @endforeach
                                <th width="10%" style="font-size: 9pt;">TOTAL</th>
                                <th width="10%" style="font-size: 9pt;">
                                    DEMERIT <div style="color:red;font-size: 8pt;">(5 Points per deduction / violation)</div>
                                </th>
                                <th width="10%" style="font-size: 9pt;">HIGHEST POINTS</th>
                                <th width="10%" style="font-size: 9pt;">AVERAGE SCORE</th>
                                <th width="10%" style="font-size: 9pt;">PERCENTAGE <div style="color:red;">(Ranking)</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($participants as $item)
                                <tr>
                                    <td style="font-size: 10pt;font-weight: bold">{{ $item['participant'] }}</td>
                                    @foreach ($judges as $judge)
                                        <td class="text-center">{{ bong_format($item->getHigalaayScoreByJudge($judge->id, $category->category)) }}</td>
                                    @endforeach
                                    <td class="text-center">{{ bong_format($item->higalaayJudgesTotalScore($category->category)) }}</td>
                                    @php
                                        $deducted = \App\Models\HigalaayDeduction::where('participant_id', $item->id)->where('category', $category->category)->first();
                                    @endphp
                                    <td class="text-center" style="font-weight: bold">{{ $deducted?->deduction == 0 ? '-' : bong_format($deducted?->deduction) }}</td>
                                    <td class="text-center" style="font-weight: bold">{{ bong_format($item->geTheHighestPoints($category->category)) }}</td>
                                    <td class="text-center" style="font-weight: bold">{{ bong_format($item->averageHigalaay($category->category)) }}</td>
                                    <td class="text-center" style="font-weight: bold">{{ bong_ordinal($item->current_rank) }}</td>
                                </tr>
                            @empty
                                @php
                                    $count = $judges->count() + 6;
                                @endphp
                                <tr>
                                    <td colspan="{{ $count }}" class="text-center">No Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <div style="text-align: right;font-weight: bold;opacity: 0.5;margin-top: 20px;"><i>CMISID Tabulation System</i></div>
    </main>
</body>

</html>
