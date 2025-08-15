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
    <div id="watermark">
        <img src="{{ convert_image(public_path() . '/img/watermark.png') }}" width="50%">
    </div>
    <div id="content">
        <table class="table">
            <tr>
                <td class="text-start" style="vertical-align: top;" width="30%">
                    <img src="{{ convert_image(public_path() . '/img/cdo_email.png') }}" width="80">
                    <img src="{{ convert_image(public_path() . '/img/goldencdo_email.png') }}" width="150">

                </td>
                <td class="text-center">
                    <div style="font-size: 20pt;font-weight:bold;">HIGALAAY FESTIVAL</div>
                    <div style="font-size: 15pt;font-weight:bold;color: #26a75c;">CAGAYAN DE ORO at 75</div>
                    <div style="font-size: 13pt;">Proud of our Roots. Bold in our Dreams</div>
                    <div style="font-size: 13pt;">{{ date('F d, Y') }}</div>
                </td>
                <td class="text-end" width="30%">
                    <img src="{{ convert_image(public_path() . '/img/higalaay_email.png') }}" width="120">
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
        <table class="table bordered" style="padding-top: 20px;">
            <thead>
                <tr>
                    <th class="text-center p-2 bold" style="font-size:10pt;">RANK</th>
                    <th class="text-center  p-2 bold" style="font-size:10pt;">CONTESTANT</th>
                    <th class="text-center p-2 bold" style="font-size:10pt;">NUMBER</th>
                    @foreach ($judges as $judge)
                        <th class="text-center  p-2 bold" style="font-size:10pt;">
                            {{ $judge->judge }}
                        </th>
                    @endforeach
                    @if (auth()->user()->role == 'admin')
                        <th class="text-center  p-2 bold"style="font-size:10pt;">DEDUCTION</th>
                        <th class="text-center  p-2 bold"style="font-size:10pt;">TIME</th>
                        <th class="text-center  p-2 bold"style="font-size:10pt;">REMARKS</th>
                        <th class="text-center  p-2 bold"style="font-size:10pt;">TOTAL</th>
                    @endif
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
                        <td class="text-center" style="padding:5px;color:black;{{ $font }};">{{ $item->getHigalaayScoreByJudge($judge->id, $category, $criteria) }}</td>
                    @endforeach
                    @if (auth()->user()->role == 'admin')
                        <td class="text-center" style="font-weight: bold;color:black;{{ $font }}">{{ $item->higalaayDeduction?->deduction == 0 ? '-' : bong_format($item->higalaayDeduction?->deduction) }}</td>
                        <td class="text-center" style="font-weight: bold;color:black;{{ $font }}">{{ $item->higalaayDeduction?->duration }}</td>
                        <td class="text-start" style="padding:5px;font-weight: bold;color:black;{{ $font }}">{{ $item->higalaayDeduction?->remarks }}</td>
                        <td class="text-center" style="font-weight: bold;color:black;{{ $font }}">{{ bong_format($item->averageHigalaay($category, $criteria)) }}</td>
                    @endif
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
    </div>
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $text = __("Page :pageNum of :pageCount", ["pageNum" => $PAGE_NUM, "pageCount" => $PAGE_COUNT]);
                $font = null;
                $size = 9;
                $color = array(0,0,0);
                $word_space = 0.0;  //  default
                $char_space = 0.0;  //  default
                $angle = 0.0;   //  default
 
                // Compute text width to center correctly
                $textWidth = $fontMetrics->getTextWidth($text, $font, $size);
 
                $x = ($pdf->get_width() - $textWidth) / 2;
                $y = $pdf->get_height() - 35;
 
                $pdf->text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            ');
        }
    </script>
</body>

</html>
