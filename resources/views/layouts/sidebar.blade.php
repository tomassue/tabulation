<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'quiz' ? '' : 'collapsed' }}" href="{{ route('quiz') }}">
                <i class="bi bi-grid"></i>
                <span>Quiz</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'oral' ? '' : 'collapsed' }}" href="{{ route('oral') }}">
                <i class="bi bi-grid"></i>
                <span>Oral</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'poster' ? '' : 'collapsed' }}" href="{{ route('poster') }}">
                <i class="bi bi-grid"></i>
                <span>Poster</span>
            </a>
        </li>

        <hr>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('reference*') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Reference</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse {{ request()->is('reference*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('reference.criteria') }}">
                        <i class="bi bi-circle"></i><span>Criteria</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reference.judges') }}">
                        <i class="bi bi-circle"></i><span>Judges</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reference.participants') }}">
                        <i class="bi bi-circle"></i><span>Participants</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reference.round') }}">
                        <i class="bi bi-circle"></i><span>Round</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Components Nav -->

    </ul>

</aside><!-- End Sidebar-->