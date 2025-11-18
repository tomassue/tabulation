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
            bottom: -20px;
            /* Pull content into margin area */
            left: 0;
            right: 0;
            text-align: center;
            height: 50px;
            z-index: 1000;
        }

        #watermark {
            position: fixed;
            top: 20%;
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
        <img src="{{ convert_image(public_path() . '/img/watermark.png') }}" width="50%">
    </div>
    <main>
        <table class="table">
            <tr>
                <td class="text-start" style="vertical-align: top;" width="30%">
                    <img src="{{ convert_image(public_path() . '/img/cdo_email.png') }}" width="70">
                    <img src="{{ convert_image(public_path() . '/img/goldencdo_email.png') }}" width="120">

                </td>
                <td class="text-center">
                    <div style="font-size: 20pt;font-weight:bold;">PASKO DE ORO</div>
                    <div style="font-size: 12pt;font-weight:bold;color: #26a75c;">CAGAYAN DE ORO at 75</div>
                    <div style="font-size: 10pt;">Proud of our Roots. Bold in our Dreams</div>
                    <div style="font-size: 10pt;">{{ date('F d, Y') }}</div>
                </td>
                <td class="text-end" width="30%">
                    <img src="{{ convert_image(public_path() . '/img/higalaay_email.png') }}" width="100">
                    <img src="{{ convert_image(public_path() . '/img/tourism_email.png') }}" width="60">
                </td>
            </tr>
        </table>
        <div style="text-align: center;padding-top:50px;">
            <h2 style="text-transform: uppercase">{{ $category1->description }} AND {{ $category2->description }} WINNERS</h2>
        </div>
        @php
            $service = new App\Services\ReportService($category1->category);
            $participants = $service->generateTopParticipants();
            $judges = $service->judges;
            $grands = [];
        @endphp

        @foreach ($participants as $item)
            @php
                //get the category1 and category2
                $cat1 = $item->averageHigalaay($category1->category);
                $cat2 = $item->averageHigalaay($category2->category);

                //get the grandtotal
                $grand = $cat1 * 0.5 + $cat2 * 0.5;

                //get the participant
                $participant = $item->participant;

                //add to array
                array_push($grands, ['participant' => $participant, 'cat1' => $cat1, 'cat2' => $cat2, 'grand' => $grand]);
            @endphp
        @endforeach

        <table class="table bordered ">
            <thead>
                <tr>
                    <th>Participant</th>
                    <th>{{ $category1->description }} (50%)</th>
                    <th>{{ $category2->description }} (50%)</th>
                    <th>GRAND TOTAL</th>
                </tr>
            </thead>
            @foreach ($grands as $item)
                <tr>
                    <td style="font-size: 10pt;">{{ $item['participant'] }}</td>
                    <td class="text-center">{{ bong_format($item['cat1']) }}</td>
                    <td class="text-center">{{ bong_format($item['cat2']) }}</td>
                    <td class="text-center">{{ bong_format($item['grand']) }}</td>
                </tr>
            @endforeach
        </table>
        <table class="table" style="padding-top: 100px;">
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
                    @if ($loop->iteration % 2 == 0)
            </tr>
            <tr>
                @endif
                @endforeach
            </tr>
        </table>
    </main>
</body>

</html>
