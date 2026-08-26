<section class="section dashboard">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h5 class="mb-0 fw-bold">LED Display Control</h5>
            <small class="text-muted">Manually assign winners per placement, then choose what to show on the public screen.</small>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-warning" wire:click="generateMcReport">
                <div wire:loading.remove wire:target="generateMcReport">
                    <i class="bi bi-file-earmark-text me-1"></i> MC Script
                </div>
                <div wire:loading wire:target="generateMcReport">
                    <div class="spinner-border spinner-border-sm" role="status"></div>
                </div>
            </button>
            <a href="{{ route('display_led') }}" target="_blank" class="btn btn-primary">
                <i class="bi bi-display me-1"></i> Open LED Screen
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Step 1: Category --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom fw-semibold py-3">
                    <i class="bi bi-layers me-1 text-primary"></i> Step 1 — Select Event Category
                </div>
                <div class="card-body d-flex align-items-center mt-3 gap-3 flex-wrap">
                    <select wire:model="category" wire:change="changeCategory" class="form-select" style="max-width:300px;">
                        <option value="">— Select Category —</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->category }}">{{ $item->description }}</option>
                        @endforeach
                    </select>
                    @if ($led && $led->category)
                        <span class="badge bg-primary text-uppercase fs-6 px-3 py-2">{{ $led->category }}</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Step 2: Assign winners --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom fw-semibold py-3">
                    <i class="bi bi-person-check me-1 text-success"></i> Step 2 — Assign Winners
                </div>
                <div class="card-body  mt-3">
                    @if (!$category)
                        <p class="text-muted fst-italic mb-0">Select a category first to assign winners.</p>
                    @else
                        <div class="row g-3">

                            @php
                                $slots = [['key' => 'first_id', 'emoji' => '🥇', 'label' => 'Champion', 'rel' => 'firstParticipant'], ['key' => 'second_id', 'emoji' => '🥈', 'label' => '2nd Place', 'rel' => 'secondParticipant'], ['key' => 'third_id', 'emoji' => '🥉', 'label' => '3rd Place', 'rel' => 'thirdParticipant'], ['key' => 'fourth_id', 'emoji' => '🏅', 'label' => '4th Place', 'rel' => 'fourthParticipant']];
                            @endphp

                            @foreach ($slots as $slot)
                                @php
                                    $takenIds = collect([$first_id, $second_id, $third_id, $fourth_id])
                                        ->filter()
                                        ->diff([$slot['key'] === 'first_id' ? $first_id : ($slot['key'] === 'second_id' ? $second_id : ($slot['key'] === 'third_id' ? $third_id : $fourth_id))])
                                        ->values();
                                @endphp
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">
                                        <span class="me-1">{{ $slot['emoji'] }}</span> {{ $slot['label'] }}
                                    </label>
                                    <select wire:model="{{ $slot['key'] }}" class="form-select">
                                        <option value="">— Select participant —</option>
                                        @foreach ($participants as $p)
                                            @if (!$takenIds->contains((string) $p->id))
                                                <option value="{{ $p->id }}">#{{ $p->participant_no }} {{ $p->participant }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($led?->{$slot['rel']})
                                        <div class="mt-1 text-success small">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            Saved: <strong>#{{ $led->{$slot['rel']}->participant_no }} {{ $led->{$slot['rel']}->participant }}</strong>
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                        </div>

                        <div class="mt-3">
                            <button wire:click="savePlacements" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Save Assignments
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Step 3: Display control --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom fw-semibold py-3 d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-display me-1 text-warning"></i> Step 3 — Control the Screen</span>
                    @if ($led && ($led->show_first || $led->show_second || $led->show_third || $led->show_fourth || $led->show_all))
                        <button wire:click="hideAll" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-eye-slash me-1"></i> Hide All
                        </button>
                    @endif
                </div>
                <div class="card-body  mt-3">

                    @php
                        $displaySlots = [
                            ['emoji' => '🏆', 'label' => 'All Top 4', 'flag' => 'show_all', 'method' => 'changeAll', 'color' => 'success', 'participant' => null],
                            ['emoji' => '🥇', 'label' => 'Champion', 'flag' => 'show_first', 'method' => 'changeFirst', 'color' => 'warning', 'participant' => $led?->firstParticipant],
                            ['emoji' => '🥈', 'label' => '2nd Place', 'flag' => 'show_second', 'method' => 'changeSecond', 'color' => 'secondary', 'participant' => $led?->secondParticipant],
                            ['emoji' => '🥉', 'label' => '3rd Place', 'flag' => 'show_third', 'method' => 'changeThird', 'color' => 'danger', 'participant' => $led?->thirdParticipant],
                            ['emoji' => '🏅', 'label' => '4th Place', 'flag' => 'show_fourth', 'method' => 'changeFourth', 'color' => 'info', 'participant' => $led?->fourthParticipant],
                        ];
                    @endphp

                    <div class="row g-3">
                        @foreach ($displaySlots as $slot)
                            @php $isActive = $led?->{$slot['flag']}; @endphp
                            <div class="col-sm-6 col-xl">
                                <div class="rounded-3 border h-100 p-3 d-flex flex-column gap-2
                                    {{ $isActive ? 'border-' . $slot['color'] . ' bg-' . $slot['color'] . ' bg-opacity-10' : 'bg-light border-light' }}">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fs-3 lh-1">{{ $slot['emoji'] }}</span>
                                        <div class="fw-semibold">{{ $slot['label'] }}</div>
                                    </div>
                                    <div class="text-muted small flex-grow-1">
                                        @if ($slot['label'] === 'All Top 4')
                                            Show all four winners at once
                                        @elseif ($slot['participant'])
                                            <span class="text-dark fw-semibold">
                                                #{{ $slot['participant']->participant_no }} {{ $slot['participant']->participant }}
                                            </span>
                                        @else
                                            <span class="fst-italic">No winner assigned</span>
                                        @endif
                                    </div>
                                    <button wire:click="{{ $slot['method'] }}" @if ($slot['label'] !== 'All Top 4' && !$slot['participant']) disabled @endif class="btn btn-sm w-100 {{ $isActive ? 'btn-' . $slot['color'] : 'btn-outline-' . $slot['color'] }}">
                                        @if ($isActive)
                                            <i class="bi bi-eye-fill me-1"></i> Showing — Hide
                                        @else
                                            <i class="bi bi-eye me-1"></i> Show
                                        @endif
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3 text-muted small d-flex align-items-start gap-1">
                        <i class="bi bi-info-circle mt-1 flex-shrink-0"></i>
                        <span>Assign winners in Step 2 before showing individual placements. Only one option can be active at a time.</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- MC Script Report Modal --}}
    <div class="modal fade" id="mcReportModal" tabindex="-1" data-bs-backdrop="static" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">MC Winners Script</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if ($base64pdf)
                        <iframe src="data:application/pdf;base64,{{ $base64pdf }}" width="100%" height="600" frameborder="0"></iframe>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>
@script
    <script>
        window.addEventListener('openMcReportModal', event => {
            var modal = new bootstrap.Modal(document.getElementById('mcReportModal'));
            modal.show();
        });
    </script>
@endscript
