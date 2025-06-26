<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Oratorical</title>
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
                <img src="{{ convert_image(public_path()."/img/cdo_email.png") }}" width="70" >
                <img src="{{ convert_image(public_path()."/img/tourism_email.png") }}" width="75" >
            </td>
            <td class="text-center">
                <div style="font-size: 12pt;font-weight:bold;">1st Mayor Rolando <i><span style="color: green;">“Klarex”</span></i> Uy </div>
                <div style="font-size: 13pt;font-weight:bold;">KINAADMAN SA KASAYSAYAN</div>
                <div style="font-size: 12pt;"> A Literary and Speech Contest</div>
                <div style="font-size: 9pt;">June 27, 2025, 1:00 PM | 5F SM CDO Downtown</div>
            </td>
            <td class="text-end" width="30%">
                <img src="{{ convert_image(public_path()."/img/goldencdo_email.png") }}"  width="120">
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-center">
                
                <div style="font-size: 15pt;font-weight:bold;text-transform:uppercase;padding-top: 20px;">POSTER SCORE REPORT</div>
            </td>
        </tr>
    </table>
    <table class="table bordered" style="padding-top: 20px;" >
        <thead>
            <tr>
                <th class="text-center p-2 bold" style="font-size:10pt;">RANK</th>
                <th class="text-center p-2 bold" style="font-size:10pt;">NUMBER</th>
                <th class="text-center  p-2 bold"style="font-size:10pt;">CONTESTANT</th>
                @foreach ($judges as $judge)
                <th class="text-center  p-2 bold"style="font-size:10pt;">
                    {{$judge->judge}}
                </th>
                @endforeach
                <th class="text-center  p-2 bold"style="font-size:10pt;">TOTAL</th>
            </tr>
        </thead>
        @foreach ($participants as $item)
            <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td class="text-center" style="padding:5px;font-size:12pt;">{{$item->participant_no}}</td>
                <td class="text-start" style="padding:5px;font-size:12pt;">{{$item->participant}}</td>
                @foreach ($judges as $judge)
                <td class="text-center" style="padding:5px;font-size:12pt;">{{$item->getPosterScore($judge->id)}}</td>
                @endforeach
                <td class="text-center"  style="font-weight: bold">{{number_format($item->judgePosterTotalScore()/ 3, 2)}}</td>
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
                <span style="text-transform: uppercase;font-weight: bold">{{$judge->judge}}</span>
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