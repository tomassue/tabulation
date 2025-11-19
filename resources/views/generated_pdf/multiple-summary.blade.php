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
                    <div style="font-size: 20pt;font-weight:bold;text-transform: uppercase;">MARCHING BAND COMPETITION 2025</div>
                    <div style="font-size: 13pt;">Rodelsa Circle - Velez - Tirso Neri - Capistrano - Gaerlan Streets</div>
                    <div style="font-size: 13pt;">{{ date('F d, Y') }}</div>
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td colspan="3">
                    <div style="text-align: center;padding-top:20px;">
                        <div style="font-size: 15pt;font-weight:bold;">Scoring Sheet </div>
                        <div style="font-size: 25pt;text-transform: uppercase;color: red;font-weight:bold;">FINAL TABULATION </div>
                        <div><i>(Percentage Ranking)</i></div>
                    </div>
                </td>
            </tr>
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
                <td style="vertical-align: top;">
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

                            // After collecting all participants, sort by grand total to get rankings
                            usort($grands, function ($a, $b) {
                                return $b['grand'] <=> $a['grand']; // Descending order (highest first)
                            });

                            // After sorting by grand total
                            $rank = 1;
                            $previousScore = null;

                            // Add ordinal ranking
                            foreach ($grands as $index => &$participantData) {
                                // if ($previousScore !== null && $participantData['grand'] != $previousScore) {
                                //     $rank = $index + 1;
                                // }
                                if ($previousScore === null) {
                                    // First participant
                                    $participantData['ordinal_rank'] = $rank;
                                } else {
                                    if ($participantData['grand'] == $previousScore) {
                                        // Same grand total, same rank
                                        $participantData['ordinal_rank'] = $rank;
                                    } else {
                                        // Different grand total, next sequential rank
                                        $rank++;
                                        $participantData['ordinal_rank'] = $rank;
                                    }
                                }

                                $participantData['ordinal_rank'] = $rank;
                                $previousScore = $participantData['grand'];
                            }
                        @endphp
                    @endforeach

                    <table class="table bordered ">
                        <thead>
                            <tr>
                                <th style="font-size: 9pt;">CONTINGENT</th>
                                <th style="text-transform: uppercase;"><span style="color:blue;font-size: 9pt;">{{ $category1->description }}</span> <br />(<span style="color:red;">50%</span>)</th>
                                <th style="text-transform: uppercase;"><span style="color: green;font-size: 9pt;">{{ $category2->description }}</span> <br />(<span style="color:red;">50%</span>)</th>
                                <th style="font-size: 9pt;">GRAND <br />TOTAL</th>
                                <th style="font-size: 9pt;">RANK</th>
                            </tr>
                        </thead>
                        @foreach ($grands as $key => $item)
                            <tr>
                                <td style="font-size: 11pt;font-weight: bold">{{ $item['participant'] }}</td>
                                <td class="text-center" style="font-weight: bold;color: blue;" width="15%">{{ bong_format($item['cat1']) }}</td>
                                <td class="text-center" style="font-weight: bold;color: green;" width="15%">{{ bong_format($item['cat2']) }}</td>
                                <td class="text-center" style="font-weight: bold" width="10%">{{ bong_format($item['grand']) }}</td>
                                <td class="text-center" style="font-weight: bold" width="10%">{{ bong_ordinal($item['ordinal_rank']) }} </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                <td style="vertical-align: bottom;" width="20%">
                    <div>
                        @forelse ($judges as $index => $judge)
                            <div style="text-align: center;margin-bottom: 30px;font-weight: bold;">TABULATOR #{{ $loop->iteration }}</div>
                            <div style="text-align: center; height: 100px;width: 200px">

                                <span style="text-transform: uppercase;font-weight: bold; font-size: 9pt;">&nbsp;</span>
                                <div class="text-center" style="border-top: 1px solid black;margin-bottom: -5px">
                                    <div><i style="font-size: 10pt;">Full Name and Signature</i></div>

                                    <div>Time: _______________</div>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center;margin-bottom: 30px;font-weight: bold;">NO TABULATOR</div>
                        @endforelse
                    </div>
                </td>
            </tr>
        </table>
    </main>
</body>

</html>
