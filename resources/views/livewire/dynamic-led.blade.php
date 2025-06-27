<div wire:poll>
    @if ($led->category == "quiz")
        @include('led_display.quiz')
    @endif
    @if ($led->category == "poster")
        @include('led_display.poster')
    @endif
    @if ($led->category == "oral")
        @include('led_display.oral')
    @endif
    <script>
        const refreshInterval = 2000; 
        setInterval(() => {
            location.reload(true); // true forces reload from server (not cache)
        }, refreshInterval);
    </script>
</div>



