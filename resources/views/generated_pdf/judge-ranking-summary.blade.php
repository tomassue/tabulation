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

        /* Style for all odd rows (1st, 3rd, 5th, etc.) */
        table.bordered tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
            /* A light gray color */
        }

        /* Style for all even rows (2nd, 4th, 6th, etc.) */
        table.bordered tbody tr:nth-child(even) {
            background-color: #ffffff;
            /* A white color (optional, as it's the default) */
        }

        .hr-with-text span {
            white-space: nowrap;
            /* Prevents text from wrapping */
            padding: 0 10px;
            /* Adds padding around the text */
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
            /* or #FFD700 */
        }

        .winner-2 {
            background: silver !important;
            color: black !important;
            font-weight: bold !important;
            /* or #C0C0C0 */
        }

        .winner-3 {
            background: #fcd6b0 !important;
            color: black;
            font-weight: bold !important;
            /* no keyword for a good bronze */
        }
    </style>
</head>

<body>
    <div id="developer">
        <div><i>CMISID Tabulation System</i></div>
    </div>
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
                    <div style="font-size: 20pt;font-weight:bold;text-transform: uppercase;">PASKO DE ORO 2025: {{ $category->description }}</div>
                    @if ($category->category != 'bangga-sa-daygon')
                        <div style="font-size: 13pt;">Amphitheater - Capistrano - Gaerlan Streets</div>
                        <div style="font-size: 13pt;font-weight: bold;">{{ date('F d, Y') }} | 6:30 AM – 10:00 AM</div>
                    @else
                        <div style="font-size: 13pt;">Cagayan de Oro City Hall Building - Tourism Hall</div>
                        <div style="font-size: 13pt;font-weight: bold;">{{ date('F d, Y') }} | 4:00 PM</div>
                    @endif
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td style="vertical-align: top;" width="85%">
                    <div style="text-align: center;padding-top:20px;padding-bottom:10px;">
                        <div style="font-size: 20pt;font-weight:bold;">
                            @if ($percentage)
                                Tabulation Sheet
                            @else
                                Final Tabulation
                            @endif
                        </div>
                        <div style="font-size: 20pt;text-transform: uppercase;color: #266da7;font-weight: bold;">{{ $category->description }}
                            @if ($percentage)
                                (<span style="color: red;">50%</span>)
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table bordered">
            <thead>
                <tr>
                    <th style="width: 3%;">#</th>
                    <th width="30%" style="font-size: 11pt;">CONTINGENT</th>
                    @foreach ($judges as $judge)
                        <th style="text-transform: uppercase;font-size: 9pt;">{{ $judge->judge }}</th>
                    @endforeach
                    @if ($showDeduction == true)
                        <th width="10%" style="font-size: 9pt;">RAW AVERAGE SCORE</th>
                        <th width="10%" style="font-size: 9pt;">
                            DEMERIT <div style="color:red;font-size: 8pt;">(2 Points per deduction / violation)</div>
                        </th>
                    @endif
                    <th width="10%" style="font-size: 9pt;">TOTAL<br />AVERAGE</th>
                    @if ($percentage)
                        <th width="10%" style="font-size: 9pt;text-transform: uppercase;">
                            {{ $category->description }} <div style="color:blue;">(50%)</div>
                        </th>
                    @else
                        <th width="10%" style="font-size: 9pt;">
                            AVERAGE <div style="color:red;">(Ranking)</div>
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($grands as $item)
                    <tr class="winner-{{ $item['ordinal_rank'] }}">
                        <td class="text-center" style="font-size: 9pt;">{{ $item['participant_no'] }}</td>
                        <td style="font-size: 9pt;padding: 3px;">{{ $item['participant'] }}</td>
                        @foreach ($judges as $judge)
                            <td class="text-center">{{ bong_format($item['judge_scores'][$judge->user_id]) }}</td>
                        @endforeach
                        @if ($showDeduction == true)
                            <td class="text-center">{{ bong_format($item['subtotals']) }}</td>
                            <td class="text-center" style="{{ $item['deduction'] == 0 ? '' : 'color: red;' }}">{{ $item['deduction'] == 0 ? '-' : bong_format($item['deduction']) }}</td>
                        @endif
                        <td class="text-center">{{ bong_format($item['grand']) }}</td>
                        @if ($percentage)
                            <td class="text-center">{{ bong_format($item['grand'] * 0.5) }}</td>
                        @else
                            <td class="text-center">{{ bong_ordinal($item['ordinal_rank']) }}</td>
                        @endif
                    </tr>
                @empty
                    @php
                        $count = $judges->count() + 6;
                        if ($showDeduction == false) {
                            $count -= 2;
                        }
                    @endphp
                    <tr>
                        <td colspan="{{ $count }}" class="text-center">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <table class="table" style="padding-top: 10px;">
            <tr>
                @foreach ($judges as $judge)
                    <td style="text-align: right; vertical-align: top;">
                        &nbsp;
                    </td>
                    <td style="text-align: center;height: 120px;width: 300px">
                        <div style="text-align: center;margin-bottom: 30px;font-weight: bold;">JUDGE #{{ $judge->nickname }}</div>
                        <span style="text-transform: uppercase;font-weight: bold">{{ $judge->judge }}</span>
                        <div class="text-center p-2" style="border-top: 1px solid black;">
                            <i>Full Name and Signature</i>
                        </div>
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

    </main>
</body>

</html>
