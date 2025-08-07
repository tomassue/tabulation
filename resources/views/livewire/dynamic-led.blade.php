<div wire:poll>
    @if ($led->category == 'quiz')
        @include('led_display.quiz')
    @elseif ($led->category == 'poster')
        @include('led_display.poster')
    @elseif ($led->category == 'oral')
        @include('led_display.oral')
    @else
        @include('led_display.higalaay')
    @endif
    {{-- <script>
        const refreshInterval = 2000;
        setInterval(() => {
            location.reload(true); // true forces reload from server (not cache)
        }, refreshInterval);
    </script> --}}
</div>
