<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>MC Winners Script</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        .table {
            width: 100%;
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

        #watermark {
            position: fixed;
            top: 10%;
            width: 100%;
            text-align: center;
            transform-origin: 50% 50%;
            opacity: .07;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            height: 50px;
            z-index: 1000;
        }

        .divider {
            border: none;
            border-top: 2px solid #333;
            margin: 20px 0;
        }

        .winner-block {
            margin-bottom: 35px;
            page-break-inside: avoid;
        }

        .placement {
            font-size: 13pt;
            font-weight: bold;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }

        .participant-name {
            font-size: 26pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 0;
            border-bottom: 2px dashed #ccc;
        }

        .rank-1 .placement { color: #b8860b; }
        .rank-1 .participant-name { color: #b8860b; }
        .rank-2 .placement { color: #666; }
        .rank-2 .participant-name { color: #444; }
        .rank-3 .placement { color: #8b4513; }
        .rank-3 .participant-name { color: #8b4513; }
        .rank-4 .placement { color: #4682b4; }
        .rank-4 .participant-name { color: #4682b4; }

        .footer-note {
            text-align: center;
            font-size: 9pt;
            color: #aaa;
            margin-top: 40px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <main class="content">
        <div style="color: black;">
        @php
            use App\Models\Setting;
            $titlePrefix = Setting::get('report_header_title', '');
            $venue       = Setting::get('report_header_venue', '');
            $time        = Setting::get('report_header_time', '');
            $datetime    = $time ? date('F d, Y') . ' | ' . $time : date('F d, Y');
        @endphp
        @include('generated_pdf._header', [
            'headerTitle'    => trim(($titlePrefix ? $titlePrefix . ': ' : '') . ($categoryDesc ?? 'COMPETITION')),
            'headerVenue'    => $venue,
            'headerDatetime' => $datetime,
        ])

        <table class="table">
            <tr>
                <td class="text-center">
                    <div style="font-size: 15pt;font-weight:bold;text-transform:uppercase;padding-top: 10px;">
                        MC WINNERS SCRIPT
                    </div>
                </td>
            </tr>
        </table>

        <hr class="divider">

        <p style="font-size: 11pt; color: #555; margin-bottom: 25px; text-align: center;">
            <em>Announce in order from bottom to top (4th Place first, Champion last)</em>
        </p>

        @foreach ($winners as $w)
            <div class="winner-block rank-{{ $w['rank'] }}">
                <div class="placement">{{ $w['label'] }}</div>
                <div class="participant-name">
                    {{ $w['participant']->participant }}
                </div>
            </div>
        @endforeach

        <div class="footer-note">
            Generated {{ date('F d, Y h:i A') }} &mdash; {{ $categoryDesc }}
        </div>
        </div>
    </main>
</body>

</html>
