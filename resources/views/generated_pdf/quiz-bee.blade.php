<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QuizBee Report</title>
    <style>
        *{
            font-family: Arial, Helvetica, sans-serif;
        }
        .table{
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
        .text-center{
            text-align: center;
        }
        .text-start{
            text-align: left;
        }
        .text-end{
            text-align: right;
        }
        .bold{
            font-weight: bold;
        }
        .p-2{
            padding: 5px;
        }
        .p-3{
            padding: 10px;
        }
        #watermark {
            position: fixed;
            top: 20%;
            width: 100%;
            text-align: center;
            /* transform: rotate(330deg); */
            transform-origin: 50% 50%;
            opacity: .2;
        }
    </style>
</head>
<body>
    <table class="table">
        <tr>
            <td class="text-start" width="30%">
                <img src="{{ $participants->first()->convert(public_path()."/img/cdo_email.png") }}" width="90" >
                <img src="{{ $participants->first()->convert(public_path()."/img/tourism_email.png") }}" width="95" >
            </td>
            <td class="text-center">
                <div style="font-size: 13pt;">Republic of the Philippines</div>
                <div style="font-size: 13pt;">City of Cagayan de Oro</div>
                <div style="font-size: 12pt;font-weight:bold;">CITY TOURISM AND CULTURAL OFFICE</div>
            </td>
            <td class="text-end" width="30%">
                <img src="{{ $participants->first()->convert(public_path()."/img/goldencdo_email.png") }}"  width="120">
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-center">
                
                <div style="font-size: 15pt;font-weight:bold;text-transform:uppercase;">QUIZBEE SCORE SHEET</div>
            </td>
        </tr>
    </table>
    <table class="table bordered" style="padding-top: 10px;" >
        <thead>
            <tr>
                <th class="text-center  p-2 bold"style="font-size:10pt;" rowspan="2">PARTICIPANT</th>
                <th class="text-center p-2 bold" style="font-size:10pt;" colspan="10">ROUND 1</th>
                <th class="text-center p-2 bold" style="font-size:10pt;" rowspan="2">TOTAL</th>
                <th class="text-center p-2 bold" style="font-size:10pt;" colspan="10">ROUND 2</th>
                <th class="text-center p-2 bold" style="font-size:10pt;" rowspan="2">TOTAL</th>
                <th class="text-center p-2 bold" style="font-size:10pt;" colspan="5">ROUND 3</th>
                <th class="text-center p-2 bold" style="font-size:10pt;" rowspan="2">TOTAL</th>
                <th class="text-center p-2 bold" style="font-size:10pt;" colspan="5">CLINCHER</th>
                <th class="text-center p-2 bold" style="font-size:10pt;" rowspan="2">TOTAL</th>
                <th class="text-center p-2 bold" style="font-size:10pt;" rowspan="2">OVER ALL TOTAL</th>
            </tr>
            <tr>
                @for ($i = 1; $i <= 10; $i++)
                    <th class="text-center p-2 bold" style="font-size:10pt;">Q{{$i}}</th>
                @endfor
                @for ($i = 1; $i <= 10; $i++)
                    <th class="text-center p-2 bold" style="font-size:10pt;">Q{{$i}}</th>
                @endfor
                @for ($i = 1; $i <= 5; $i++)
                    <th class="text-center p-2 bold" style="font-size:10pt;">Q{{$i}}</th>
                @endfor
                @for ($i = 1; $i <= 5; $i++)
                    <th class="text-center p-2 bold" style="font-size:10pt;">C{{$i}}</th>
                @endfor
            </tr>
        </thead>
        @foreach ($participants as $item)
            <tr>
                <td class="text-start" style="padding:5px;font-size:12pt;">{{$item->participant}}</td>
                 @for ($i = 1; $i <= 10; $i++)
                    @php
                        $score = \App\Models\QuizBee::where('participant_id', $item->id)->where('round_id', '1')->where('question_number', $i)->first();
                    @endphp
                    <td class="text-center" style="padding-left:5px;font-size:12pt;">{{$score ? $score->score : ''}}</td>
                @endfor
                <td class="text-center" style="padding-left:5px;font-size:12pt;">{{$item->sumRound1()}}</td>
                @for ($i = 1; $i <= 10; $i++)
                    @php
                        $score = \App\Models\QuizBee::where('participant_id', $item->id)->where('round_id', '2')->where('question_number', $i)->first();
                    @endphp
                    <td class="text-center" style="padding-left:5px;font-size:12pt;">{{$score ? $score->score : ''}}</td>
                @endfor
                <td class="text-center" style="padding-left:5px;font-size:12pt;">{{$item->sumRound2()}}</td>
                @for ($i = 1; $i <= 5; $i++)
                    @php
                        $score = \App\Models\QuizBee::where('participant_id', $item->id)->where('round_id', '3')->where('question_number', $i)->first();
                    @endphp
                    <td class="text-center" style="padding-left:5px;font-size:12pt;">{{$score ? $score->score : ''}}</td>
                @endfor
                <td class="text-center" style="padding-left:5px;font-size:12pt;">{{$item->sumRound3()}}</td>
                @for ($i = 1; $i <= 5; $i++)
                    @php
                        $score = \App\Models\QuizBee::where('participant_id', $item->id)->where('round_id', '4')->where('question_number', $i)->first();
                    @endphp
                    <td class="text-center" style="padding-left:5px;font-size:12pt;">{{$score ? $score->score : ''}}</td>
                @endfor
                <td class="text-center" style="padding-left:5px;font-size:12pt;">{{$item->sumRound4()}}</td>
                <td class="text-center" style="padding-left:5px;font-size:12pt;font-weight:bold;">{{$item->total_score}}</td>
            </tr>
        @endforeach
    </table>
    <table class="table" style="margin-top: 100px;">
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                <label for="">SCORE KEEPER:</label>
                <div class="text-center p-2" style="border-top: 1px solid black;margin-top:10px;">
                   &nbsp;
                </div>
            </td>
            <td style="width: 10%;">
                &nbsp;
            </td>
            <td>
                <label for="">CHIEF JUDGE:</label>
                <div class="text-center p-2" style="border-top: 1px solid black;margin-top:10px;">
                    &nbsp;
                </div>
            </td>
             <td>
                &nbsp;
            </td>
        </tr>
    </table>
</body>
</html>