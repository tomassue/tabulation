<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @php
        if (auth()->user()->role == 'admin') {
        $events = \App\Models\Category::where('is_active', 1)->get();
        } else {
        $events = \App\Models\Category::whereIn('category', auth()->user()->judge->category)
        ->where('is_active', 1)
        ->get();
        }
        @endphp
        @if (config('settings.module') != 'higalaay')
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-card-heading"></i>
                <span>Dashboard</span>
            </a>
        </li>
        @endif
        @foreach ($events as $item)
        <li class="nav-item">
            <a class="nav-link {{ request()->is('show-event/' . $item->category) ? '' : 'collapsed' }}" href="{{ route('event', $item->category) }}">
                {{-- {!! $item->icon !!} --}}
                @if (request()->is('show-event/' . $item->category))
                <i class="bi bi-award-fill fs-5"></i>
                @else
                <i class="bi bi-award fs-5"></i>
                @endif

                <span>{{ $item->description }}</span>
            </a>
        </li>
        @endforeach
        <hr>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'report-generator' ? '' : 'collapsed' }}" href="{{ route('report-generator') }}">
                <i class="bi bi-filetype-pdf"></i>
                <span>Report Generator</span>
            </a>
        </li>
        @if (auth()->user()->role == 'admin')
        <hr>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('reference*') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Reference</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse {{ request()->is('reference*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('reference.criteria') }}" class="{{ Route::currentRouteName() == 'reference.criteria' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Criteria</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reference.judges') }}" class="{{ Route::currentRouteName() == 'reference.judges' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Judges</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reference.participants') }}" class="{{ Route::currentRouteName() == 'reference.participants' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Participants</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reference.deductions') }}" class="{{ Route::currentRouteName() == 'reference.deductions' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Deductions</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('settings*') ? '' : 'collapsed' }}" data-bs-target="#modules-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gear"></i><span>Settings</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="modules-nav" class="nav-content collapse {{ request()->is('settings*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('settings.modules') }}" class="{{ Route::currentRouteName() == 'settings.modules' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Modules</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings.import-export') }}" class="{{ Route::currentRouteName() == 'settings.import-export' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>DB Export/Import</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Components Nav -->

        <hr>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'settings.user-management' ? '' : 'collapsed' }}" href="{{ route('settings.user-management') }}">
                <i class="bi bi-person-workspace"></i>
                <span>User Management</span>
            </a>
        </li>

        <hr>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'logs' ? '' : 'collapsed' }}" href="{{ route('logs') }}">
                <i class="bi bi-activity"></i>
                <span>Logs</span>
            </a>
            <a class="nav-link {{ Route::currentRouteName() == 'display-management' ? '' : 'collapsed' }}" href="{{ route('display-management') }}">
                <i class="bi bi-activity"></i>
                <span>LED Management</span>
            </a>
        </li>
        @endif
    </ul>

</aside><!-- End Sidebar-->