{{--
Shared PDF report header partial.
Accepts optional variables (all fall back to DB settings):
$headerTitle    — full title line (e.g. "PASKO DE ORO 2025: MARCHING BAND")
$headerVenue    — venue line
$headerDatetime — date + time line (e.g. "April 06, 2026 | 6:30 AM – 10:00 AM")
Layout: [Left Logo 1 | Left Logo 2] | [Title / Venue / Datetime] | [Right Logo 1 | Right Logo 2]
--}}
@php
    use App\Models\Setting;
    $imgDir = public_path('storage/report-header/');
    $ll1 = Setting::get('report_logo_left_1');
    $ll2 = Setting::get('report_logo_left_2');
    $lr1 = Setting::get('report_logo_right');
    $lr2 = Setting::get('report_logo_right_2');
    $wm  = Setting::get('report_watermark');
    $ft  = Setting::get('report_footer');

    $title    = $headerTitle ?? Setting::get('report_header_title', '');
    $venue    = $headerVenue ?? Setting::get('report_header_venue', '');
    $datetime = $headerDatetime ?? null;
    if ($datetime === null) {
        $time     = Setting::get('report_header_time', '');
        $datetime = $time ? date('F d, Y') . ' | ' . $time : date('F d, Y');
    }
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
        {{-- Left: 2 logos --}}
        <td class="text-start" style="vertical-align: middle;" width="25%">
            @if ($ll1) <img src="{{ convert_image($imgDir . $ll1) }}" height="70" style="max-width:48%;object-fit:contain;"> @endif
            @if ($ll2) <img src="{{ convert_image($imgDir . $ll2) }}" height="70" style="max-width:48%;object-fit:contain;"> @endif
        </td>
        {{-- Center: title, venue, datetime --}}
        <td class="text-center" style="vertical-align: middle;">
            @if ($title)
                <div style="font-size: 20pt;font-weight:bold;text-transform:uppercase;">{{ $title }}</div>
            @endif
            @if ($venue)
                <div style="font-size: 13pt;">{{ $venue }}</div>
            @endif
            @if ($datetime)
                <div style="font-size: 13pt;font-weight:bold;">{{ $datetime }}</div>
            @endif
        </td>
        {{-- Right: 2 logos --}}
        <td class="text-end" style="vertical-align: middle;" width="25%">
            @if ($lr1) <img src="{{ convert_image($imgDir . $lr1) }}" height="70" style="max-width:48%;object-fit:contain;"> @endif
            @if ($lr2) <img src="{{ convert_image($imgDir . $lr2) }}" height="70" style="max-width:48%;object-fit:contain;"> @endif
        </td>
    </tr>
</table>