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
                    <img src="{{ convert_image(public_path() . '/img/cdo_email.png') }}" width="100">
                    <img src="{{ convert_image(public_path() . '/img/goldencdo_email.png') }}" width="150">
                    <img src="{{ convert_image(public_path() . '/img/risebig.png') }}" width="150">
                </td>
                <td></td>
                <td class="text-end">
                    <img src="{{ convert_image(public_path() . '/img/final-pasko-de-oro.png') }}" width="150">
                </td>
            </tr>
        </table>
        <table class="table" style="margin-top:-70px;">
            <tr>
                <td class="text-center">
                    <div style="font-size: 20pt;font-weight:bold;text-transform: uppercase;">PASKO DE ORO 2025: MARCHING BAND COMPETITION</div>
                    <div style="font-size: 13pt;">Amphitheater - Capistrano - Gaerlan Streets</div>
                    <div style="font-size: 13pt;">{{ date('F d, Y') }} | 6:30 AM – 10:00 AM</div>
                </td>
            </tr>
        </table>
        <div style="text-align: center;padding:10px;">
            <div style="text-transform: uppercase;font-weight: bold;font-size: 15pt;">CRITERIA</div>
            <div style="font-size: 20pt;font-weight: bold;text-transform: uppercase;">BEST IN MUSICALITY</div>
        </div>
        <table class="table bordered">
            <thead>
                <tr>
                    <th class="text-center" style="font-size: 11pt;padding: 5px;">NO.</th>
                    <th class="text-center" style="font-size: 11pt;padding: 5px;">PARTICIPANT</th>
                    <th class="text-center" style="font-size: 11pt;padding: 5px; text-transform: uppercase;width: 12%;background: #e2efd9;color:#00b050;">{{ $category1->description }} <br /> (50%)</th>
                    <th class="text-center" style="font-size: 11pt;padding: 5px; text-transform: uppercase;width: 12%;background: #fbe4d5;color: #ed7d31;">{{ $category2->description }} <br /> (50%)</th>
                    <th class="text-center" style="font-size: 11pt;padding: 5px;">SCORE</th>
                    <th class="text-center" style="font-size: 11pt;padding: 5px;">RANKING</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grands as $item)
                    <tr>
                        <td class="text-center" style="font-size: 11pt;padding: 5px;" width="3%">{{ $item['participant_no'] }}</td>
                        <td style="font-size: 11pt;padding: 5px;font-weight: bold;">{{ $item['participant'] }}</td>
                        <td class="text-center" style="background: #e2efd9;color:#00b050;">{{ bong_format($item['cat1']) }}</td>
                        <td class="text-center" style="background: #fbe4d5;color: #ed7d31;">{{ bong_format($item['cat2']) }}</td>
                        <td class="text-center" style="font-weight: bold" width="7%">{{ bong_format($item['grand']) }}</td>
                        <td class="text-center" style="font-weight: bold" width="7%">{{ bong_ordinal($item['ordinal_rank']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class="table" style="padding-top: 20px;">
            <tr>
                @foreach ($judges as $index => $judge)
                    <td style="text-align: right; vertical-align: top;">
                        &nbsp;
                    </td>
                    <td style="text-align: center; height: 100px;width: 300px">
                        <span style="text-transform: uppercase;font-weight: bold">{{ $judge->judge }}</span>
                        <div class="text-center" style="border-top: 1px solid black;margin-bottom: -5px">
                            <div><i style="font-size: 10pt;">Signature over printed name</i></div>
                            <span>JUDGE</span>
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
