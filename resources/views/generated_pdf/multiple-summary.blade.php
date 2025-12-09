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
                    <div style="font-size: 20pt;font-weight:bold;text-transform: uppercase;">PASKO DE ORO 2025: MARCHING BAND COMPETITION</div>
                    @if ($category1->category != 'bangga-sa-daygon')
                        <div style="font-size: 13pt;">Amphitheater - Capistrano - Gaerlan Streets</div>
                        <div style="font-size: 13pt;font-weight: bold;">{{ date('F d, Y') }} | 6:30 AM – 10:00 AM</div>
                    @else
                        <div style="font-size: 13pt;font-weight: bold;">{{ date('F d, Y') }}</div>
                    @endif
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td colspan="3">
                    <div style="text-align: center;padding-top:20px;">
                        <div style="font-size: 25pt;text-transform: uppercase;color: red;font-weight:bold;">FINAL TABULATION </div>
                    </div>
                </td>
            </tr>
        </table>
        <table style="width: 100%;">
            <tr>
                <td style="width: 10%">
                    <table class="table" style="padding-top: 10px;">
                        @foreach ($judges as $judge)
                            <tr>
                                <td style="text-align: right; vertical-align: top;">
                                    &nbsp;
                                </td>
                                <td style="text-align: center;height: 120px;width: 200px">
                                    <div style="text-align: center;margin-bottom: 30px;font-weight: bold;">JUDGE #{{ $judge->nickname }}</div>
                                    <span style="text-transform: uppercase;font-weight: bold">{{ $judge->judge }}</span>
                                    <div class="text-center p-2" style="border-top: 1px solid black;">
                                        <i>Full Name & Signature</i>
                                    </div>
                                </td>
                                <td width="20px;">
                                    &nbsp;
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                <td style="width:80%;">
                    <table class="table bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="font-size: 12pt;">CONTINGENT</th>
                                <th style="text-transform: uppercase;background: #e2efd9;color:#00b050;"><span style="font-size: 9pt;">{{ $category1->description }}</span> <br />(50%)</th>
                                <th style="text-transform: uppercase;background: #fbe4d5;color: #ed7d31;"><span style="font-size: 9pt;">{{ $category2->description }}</span> <br />(50%)</th>
                                <th style="font-size: 9pt;">TOTAL</th>
                                <th style="font-size: 9pt;">RANK</th>
                            </tr>
                        </thead>
                        @foreach ($grands as $key => $item)
                            <tr>
                                <td class="text-center" style="font-size: 10pt;font-weight: bold" width="5%">{{ $item['participant_no'] }}</td>
                                <td style="font-size: 10pt;font-weight: bold;padding: 3px;">{{ $item['participant'] }}</td>
                                <td class="text-center" style="font-weight: bold;color: black;background: #e2efd9;" width="15%">{{ bong_format($item['cat1']) }}</td>
                                <td class="text-center" style="font-weight: bold;color: black;background: #fbe4d5;" width="15%">{{ bong_format($item['cat2']) }}</td>
                                <td class="text-center" style="font-weight: bold" width="10%">{{ bong_format($item['grand']) }}</td>
                                <td class="text-center" style="font-weight: bold" width="10%">{{ bong_ordinal($item['ordinal_rank']) }} </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                <td style="width: 10%">
                    <table class="table" style="padding-top: 10px;">
                        @php
                            $tabulators = ['CHRISTINE B. DAGUPLO', 'MIKE JUN R. ZABALLERO', 'JEVONIE M. VILLARIN'];
                        @endphp
                        @foreach ($tabulators as $tabulator)
                            <tr>
                                <td style="text-align: right; vertical-align: top;">
                                    &nbsp;
                                </td>
                                <td style="text-align: center;height: 120px;width: 200px">
                                    <div style="text-align: center;margin-bottom: 30px;font-weight: bold;">TABULATOR #{{ $loop->iteration }}</div>
                                    <span style="text-transform: uppercase;font-weight: bold">{{ $tabulator }}</span>
                                    <div class="text-center p-2" style="border-top: 1px solid black;">
                                        <i>Full Name & Signature</i>
                                    </div>
                                </td>
                                <td width="20px;">
                                    &nbsp;
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>
    </main>
</body>

</html>
