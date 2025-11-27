<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Score Report</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
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
            top: 10%;
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
                    <div style="font-size: 20pt;font-weight:bold;text-transform: uppercase;">MARCHING BAND COMPETITION 2025</div>
                    <div style="font-size: 13pt;">Rodelsa Circle - Velez - Tirso Neri - Capistrano - Gaerlan Streets</div>
                    <div style="font-size: 13pt;">{{ date('F d, Y') }}</div>
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td>
                    <div style="text-align: center;padding-top:20px;">
                        <div style="font-size: 15pt;font-weight:bold;"><i>Ranking Scoring Sheet</i></div>
                        <div style="font-size: 25pt;text-transform: uppercase;color: red;font-weight:bold;">FINAL TABULATION </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table bordered ">
            <thead>
                <tr>
                    <th style="font-size: 11pt;" rowspan="2">#</th>
                    <th style="font-size: 11pt;" rowspan="2">CONTINGENT</th>
                    <th style="text-transform: uppercase;" colspan="2"><span style="font-size: 9pt;color: blue;">{{ $category1->description }}</span> </th>
                    <th style="text-transform: uppercase;" colspan="2"><span style="font-size: 9pt;color: red;">{{ $category2->description }}</span></th>
                    <th style="font-size: 9pt;" rowspan="2">RANK <br />TOTAL</th>
                    <th style="font-size: 9pt;color: green;" rowspan="2">FINAL <br />RANK</th>
                </tr>
                <tr>
                    <th style="font-size: 8pt;">SCORE</th>
                    <th style="font-size: 8pt;">RANK</th>
                    <th style="font-size: 8pt;">SCORE</th>
                    <th style="font-size: 8pt;">RANK</th>
                </tr>
            </thead>
            @foreach ($grands as $key => $item)
                <tr>
                    <td class="text-center" style="font-size: 11pt;font-weight: bold;padding: 5px;" width="3%">{{ $item['participant_no'] }}</td>
                    <td style="font-size: 9pt;font-weight: bold;padding: 5px;">{{ $item['participant'] }}</td>
                    <td class="text-center" width="8%">{{ bong_format($item['cat1']) }} </td>
                    <td class="text-center" style="font-weight: bold" width="8%">{{ bong_ordinal($item['cat1_ordinal_rank']) }}</td>
                    <td class="text-center" width="8%">{{ bong_format($item['cat2']) }} </td>
                    <td class="text-center" style="font-weight: bold;" width="8%">{{ bong_ordinal($item['cat2_ordinal_rank']) }}</td>
                    <td class="text-center" style="font-weight: bold" width="10%">{{ $item['cat1_ordinal_rank'] + $item['cat2_ordinal_rank'] }}</td>
                    <td class="text-center" style="font-weight: bold;color: green;" width="10%">{{ bong_ordinal($item['ordinal_rank']) }} </td>
                </tr>
            @endforeach
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
                        <div>Time: _______________</div>
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
