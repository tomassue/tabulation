<div class="container d-flex flex-column align-items-center justify-content-center min-vh-100 py-5">
    <div class="card shadow-lg border-0 w-100" style="max-width: 800px;">
        <div class="card-body text-center p-5">
            {{-- Welcome Section --}}
            <h1 class="display-5 fw-bold mb-2">Welcome, {{ Auth::user()->name ?? 'Guest' }}!</h1>
            <p class="lead text-muted mb-5">Choose where you want to go</p>

            @php
                if (auth()->user()->role == 'admin') {
                    $events = \App\Models\Category::where('is_active', 1)->get();
                } else {
                    $events = \App\Models\Category::whereIn('category', auth()->user()->judge->category)
                        ->where('is_active', 1)
                        ->get();
                }

                $colors = ['primary', 'success', 'warning', 'info', 'danger', 'secondary'];
            @endphp

            {{-- Navigation Buttons --}}
            <div class="row g-3 justify-content-center">
                @foreach ($events as $index => $item)
                    <div class="col-12 col-md-4">
                        <a href="{{ route('event', $item->category) }}" class="btn btn-{{ $colors[$index % count($colors)] }} w-100 py-3 fw-semibold shadow-sm d-flex justify-content-between align-items-center btn-auto-size">

                            <span class="text-truncate">{{ $item->description }}</span>

                            {{-- Percentage Here Sir Bongs --}}
                            <span class="badge bg-light text-dark ms-2">
                                {{ $item->getPercent() ?? 0 }}%
                            </span>
                        </a>
                    </div>
                @endforeach

                {{-- Logout Button --}}
                <div class="col-12 col-md-4">
                    <a href="{{ route('logout') }}" class="btn btn-dark w-100 py-3 fw-semibold shadow-sm" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
