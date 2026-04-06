{{--
Shared PDF report header partial.
Accepts optional variables (all fall back to DB settings):
$headerTitle — full title line (e.g. "PASKO DE ORO 2025: MARCHING BAND")
$headerVenue — venue line
$headerDatetime — date + time line (e.g. "April 06, 2026 | 6:30 AM – 10:00 AM")
$headerMarginTop — negative margin to pull title up under logos (default: -80px)
--}}
@php
    use App\Models\Setting;
    $imgDir = public_path('storage/report-header/');
    $ll1 = Setting::get('report_logo_left_1');
    $ll2 = Setting::get('report_logo_left_2');
    $ll3 = Setting::get('report_logo_left_3');
    $lr = Setting::get('report_logo_right');
    $wm = Setting::get('report_watermark');
    $ft = Setting::get('report_footer');

    $title = $headerTitle ?? Setting::get('report_header_title', '');
    $venue = $headerVenue ?? Setting::get('report_header_venue', '');
    $datetime = $headerDatetime ?? null;
    if ($datetime === null) {
        $time = Setting::get('report_header_time', '');
        $datetime = $time ? date('F d, Y') . ' | ' . $time : date('F d, Y');
    }
    $marginTop = $headerMarginTop ?? '-80px';
@endphp

@if ($wm)
    <div id="watermark">
        <img src="{{ convert_image($imgDir . $wm) }}" width="70%">
    </div>
@endif

@if ($ft)
    <footer class="footer">
        <img src="{{ convert_image($imgDir . $ft) }}" alt="" style="opacity: 0.5;" width="100%">
    </footer>
@endif

<table class="table">
    <tr>
        <td class="text-start" style="vertical-align: top;">
            @if ($ll1) <img src="{{ convert_image($imgDir . $ll1) }}" width="80"> @endif
            @if ($ll2) <img src="{{ convert_image($imgDir . $ll2) }}" width="200"> @endif
            @if ($ll3) <img src="{{ convert_image($imgDir . $ll3) }}" width="150"> @endif
        </td>
        <td></td>
        <td class="text-end">
            @if ($lr) <img src="{{ convert_image($imgDir . $lr) }}" width="150"> @endif
        </td>
    </tr>
</table>

@if ($title || $venue || $datetime)
    <table class="table" style="margin-top: {{ $marginTop }};">
        <tr>
            <td class="text-center">
                @if ($title)
                    <div style="font-size: 20pt;font-weight:bold;text-transform: uppercase;">{{ $title }}</div>
                @endif
                @if ($venue)
                    <div style="font-size: 13pt;">{{ $venue }}</div>
                @endif
                @if ($datetime)
                    <div style="font-size: 13pt;font-weight: bold;">{{ $datetime }}</div>
                @endif
            </td>
        </tr>
    </table>
@endif