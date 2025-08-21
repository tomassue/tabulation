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
                    <div style="font-size: 20pt;font-weight:bold;">HIGALAAY FESTIVAL</div>
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
            <h2 style="text-transform: uppercase">{{ $category->description }} WINNERS</h2>
        </div>
        <table class="table">
            <tbody>
                @foreach ($participants as $item)
                    @if ($item->current_rank <= $category->winners)
                        @php
                            $class = 'top3';
                            $style = 'font-size: ' . (18 - $item->current_rank) . 'pt;';
                        @endphp
                    @else
                        @php
                            $style = '';
                            $class = 'rest';
                        @endphp
                    @endif
                    <tr>
                        <td class="{{ $class }}" style="text-align: center; {{ $style }}">
                            @if ($reportType == 2)
                                <span style="text-transform: uppercase;">{{ $category->description }}</span>
                            @else
                                <span>
                                    {{ bong_ordinal_new($item->current_rank) }}
                                </span>
                            @endif

                        </td>
                        <td class="{{ $class }}" style="{{ $style }}">
                            {{ $item->participant }}
                        </td>
                        <td class="{{ $class }}" style="text-align: right;{{ $style }}">{{ bong_format($item->averageHigalaay($category->category)) }}</td>
                    </tr>
                    @if ($type == $item->current_rank)
                        @break
                    @endif
                    @if ($runnerups == $loop->iteration)
                        @break
                    @endif
                    @if ($item->current_rank == 3)
                        @if ($category->category == 'band')
                            @php
                                $service = new App\Services\ReportService('majorette');
                                $majorette = $service->generateTopParticipants()->first();
                                $service1 = new App\Services\ReportService('major');
                                $major = $service1->generateTopParticipants()->first();
                                $service2 = new App\Services\ReportService('costume');
                                $costume = $service2->generateTopParticipants()->first();
                            @endphp
                            <tr>
                                <td colspan="3" style="text-align: center;padding-top: 10px;padding-bottom: 10px;">
                                    <span style="color: orange; font-weight: bold;">SPECIAL AWARDS</span>
                                    <div style="border-style: dotted;border-width: 1px;border-color: black;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; font-weight: bold;color: rgb(38, 38, 224);">Best Band Majorette</td>
                                <td style="color: rgb(38, 38, 224);">{{ $majorette?->participant }}</td>
                                <td style="text-align: right;color: rgb(38, 38, 224);">{{ bong_format($majorette?->averageHigalaay('majorette')) }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; font-weight: bold;color: rgb(38, 38, 224);">Best Band Major</td>
                                <td style="color: rgb(38, 38, 224);">{{ $major?->participant }}</td>
                                <td style="text-align: right;color: rgb(38, 38, 224);">{{ bong_format($major?->averageHigalaay('major')) }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; font-weight: bold;color: rgb(38, 38, 224);">Best in Costume</td>
                                <td style="color: rgb(38, 38, 224);">{{ $costume?->participant }}</td>
                                <td style="text-align: right;color: rgb(38, 38, 224);">{{ bong_format($costume?->averageHigalaay('costume')) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="3" style="text-align: center;padding-top: 10px;padding-bottom: 10px;">
                                <span style="color:red; font-weight: bold;">RUNNER-UPS</span>
                                <div style="border-style: dotted;border-width: 1px;border-color: black;"></div>
                            </td>
                        </tr>
                    @endif
                    @if ($reportType == 2)
                        @break
                    @endif
                @endforeach
            </tbody>
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
