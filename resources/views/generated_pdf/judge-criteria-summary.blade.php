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
                    <img src="{{ convert_image(public_path() . '/img/final-pasko-de-oro.png') }}" width="150" style="z-index: 1000;">
                </td>
            </tr>
        </table>
        <table class="table" style="margin-top:-100px;">
            <tr>
                <td class="text-center">
                    <div style="font-size: 20pt;font-weight:bold;text-transform: uppercase;">{{ $category->description }} COMPETITION 2025</div>
                    <div style="font-size: 13pt;">Rodelsa Circle - Velez - Tirso Neri - Capistrano - Gaerlan Streets</div>
                    <div style="font-size: 13pt;font-weight: bold;">{{ date('F d, Y') }}</div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;" width="75%">
                    <div style="text-align: center;padding-top:20px;padding-bottom:20px;">
                        <div style="font-size: 15pt;"><i>Scoring Sheet</i></div>
                        <div style="font-size: 20pt;text-transform: uppercase;color: #266da7;font-weight: bold;">{{ $category->description }}</div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table bordered">
            <thead>
                <tr>
                    <th style="font-size: 13pt;" width="3%">#</th>
                    <th style="font-size: 13pt;">CONTINGENT</th>
                    @foreach ($criterias as $criteria)
                        <th width="10%" style="font-size: 10pt;text-transform: uppercase;">{{ $criteria->criteria }}<br />(<span style="color: red;">{{ $criteria->perfect_score }} Points</span> ) </th>
                    @endforeach
                    <th width="10%" style="font-size: 13pt;">TOTAL</th>
                    <th width="10%" style="font-size: 13pt;color:green;">RANKING</div>
                </tr>
            </thead>
            <tbody>
                @forelse ($grands as $item)
                    <tr class="winner-{{ $item['ordinal_rank'] }}">
                        <td class="text-center" style="font-size: 10pt;">{{ $item['participant_no'] }}</td>
                        <td style="font-size: 10pt;padding: 10px;">{{ $item['participant'] }}</td>
                        @foreach ($criterias as $criteria)
                            <td class="text-center">{{ bong_format($item['criteria_scores'][$criteria->id]) }}</td>
                        @endforeach
                        <td class="text-center">{{ bong_format($item['grand']) }}</td>
                        <td class="text-center" style="color:green;">{{ bong_ordinal($item['ordinal_rank']) }}</td>
                    </tr>
                @empty
                    @php
                        $count = $criterias->count() + 4;
                    @endphp
                    <tr>
                        <td colspan="{{ $count }}" class="text-center">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <table class="table" style="padding-top: 50px;">
            <tr>
                <td style="width: 40%;">&nbsp;</td>
                <td style="width: 40%;">&nbsp;</td>
                <td style="text-align: center;">
                    <div style="text-align: center; height: 100px;width: 270px">
                        <span style="text-transform: uppercase;font-weight: bold; font-size: 12pt;">{{ $judge->judge }}</span>
                        <div class="text-center" style="border-top: 1px solid black;margin-bottom: -5px">
                            <div><i style="font-size: 10pt;">Full Name and Signature</i></div>
                            <div>Time: _______________</div>
                        </div>
                    </div>
                </td>

            </tr>
        </table>
    </main>
</body>

</html>
