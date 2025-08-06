<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Oratorical</title>
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
            top: 20%;
            width: 100%;
            text-align: center;
            /* transform: rotate(330deg); */
            transform-origin: 50% 50%;
            opacity: .07;
        }
    </style>
</head>

<body>
    {{-- <div id="watermark">
        <img src="{{ convert_image(public_path() . '/img/watermark.png') }}" width="50%">
    </div> --}}
    <table class="table">
        {{-- <tr>
            <td class="text-start" style="vertical-align: top;" width="30%">
                <img src="{{ convert_image(public_path() . '/img/cdo_email.png') }}" width="80">
                <img src="{{ convert_image(public_path() . '/img/goldencdo_email.png') }}" width="150">

            </td>
            <td class="text-center">
                <div style="font-size: 20pt;font-weight:bold;">HIGALAAY FESTIVAL</div>
                <div style="font-size: 11pt;font-weight:bold;color: #26a75c;">CAGAYAN DE ORO at 75</div>
                <div style="font-size: 12pt;">Proud of our Roots. Bold in our Dreams</div>
                <div style="font-size: 9pt;">August 27, 2025</div>
            </td>
            <td class="text-end" width="30%">
                <img src="{{ convert_image(public_path() . '/img/higalaay_email.png') }}" width="120">
                <img src="{{ convert_image(public_path() . '/img/tourism_email.png') }}" width="75">
            </td>
        </tr> --}}
        <tr>
            <td class="text-start" style="vertical-align: top;" width="30%">
                <img src="{{ convert_image(public_path() . '/img/cdo_email.png') }}" width="80">
                <img src="{{ convert_image(public_path() . '/img/goldencdo_email.png') }}" width="150">
            </td>
            <td class="text-center">
                <div style="font-size: 20pt;font-weight:bold;">KAHIGAYONAN 2025</div>
                <div style="font-size: 18pt;">Skills Training and Expo</div>
                <div style="font-size: 12pt;">Piyesta sa Dakbayan, Tabo sa Opportunidad Year 4</div>
                <div style="font-size: 9pt;">August 08, 2025</div>
            </td>
            <td class="text-end" width="30%">
                <img src="{{ convert_image(public_path() . '/img/risebig.png') }}" width="150">
                <img src="{{ convert_image(public_path() . '/img/oysda.png') }}" width="100">
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-center">

                <div style="font-size: 15pt;font-weight:bold;text-transform:uppercase;padding-top: 20px;">
                    {{ $categoryName ?? 'COMPETITION' }} SCORE REPORT
                    <div style="font-size: 9pt;">{{ $judges->count() == 1 ? 'PARTIAL' : 'FINAL' }}</div>
                </div>
            </td>
        </tr>
    </table>
    <table class="table bordered" style="padding-top: 20px;">
        <thead>
            <tr>
                <th class="text-center p-2 bold" style="font-size:10pt;">RANK</th>
                <th class="text-center  p-2 bold"style="font-size:10pt;">CONTESTANT</th>
                <th class="text-center p-2 bold" style="font-size:10pt;">NUMBER</th>
                @foreach ($judges as $judge)
                    <th class="text-center  p-2 bold"style="font-size:10pt;">
                        {{ $judge->judge }}
                    </th>
                @endforeach
                <th class="text-center  p-2 bold"style="font-size:10pt;">DEDUCTION</th>
                <th class="text-center  p-2 bold"style="font-size:10pt;">TOTAL</th>
            </tr>
        </thead>
        @foreach ($participants as $position => $item)
            <tr>
                @if ($item->current_rank <= $winner)
                    @php
                        $font = 'font-weight: bold;font-size: 12pt;background-color: #26a75c;color: white;';
                    @endphp
                @else
                    @php
                        $font = 'font-size: 12pt;';
                    @endphp
                @endif
                <td class="text-center" style="{{ $font }}">
                    <span style="{{ $font }}">{{ bong_ordinal($item->current_rank) }}</span>
                </td>
                <td class="text-start" style="padding:5px;color:black;{{ $font }};">{{ $item->participant }}</td>
                <td class="text-center" style="padding:5px;color:black;{{ $font }};">{{ $item->participant_no }}</td>
                @foreach ($judges as $judge)
                    <td class="text-center" style="padding:5px;color:black;{{ $font }};">{{ $item->getHigalaayScoreByJudge($judge->id, $category) }}</td>
                @endforeach

                <td class="text-center" style="font-weight: bold;color:black;{{ $font }}">{{ $item->higalaayDeduction?->deduction == 0 ? '-' : bong_format($item->higalaayDeduction?->deduction) }}</td>
                <td class="text-center" style="font-weight: bold;color:black;{{ $font }}">{{ bong_format($item->averageHigalaay($category)) }}</td>
            </tr>
        @endforeach
    </table>
    <table class="table" style="margin-top: 100px;">
        <tr>
            @foreach ($judges as $judge)
                <td style="text-align: right;margin-bottom:100px; vertical-align: top;">
                    <label for="">JUDGE:</label>&nbsp;
                </td>
                <td style="text-align: center;">
                    <span style="text-transform: uppercase;font-weight: bold">{{ $judge->judge }}</span>
                    <div class="text-center p-2" style="border-top: 1px solid black;">
                        Signature over printed name
                    </div>
                </td>
                <td width="20px;">
                    &nbsp;
                </td>
            @endforeach
        </tr>
    </table>
</body>

</html>
