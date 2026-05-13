<section class="section" wire:loading.class="opacity-75 pe-none">

    {{-- ═══════════════════════ PAGE HEADER ═══════════════════════ --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h5 class="mb-0 fw-bold text-uppercase">{{ $categoryName?->description }} — Technical Scoring</h5>
            <small class="text-muted">Each judge scores their assigned category • Scores are totalled for final result</small>
        </div>
        <div class="d-flex gap-2">
            @if ($isAdmin)
                <button class="btn btn-sm {{ $activeTab === 'scoring' ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="$set('activeTab','scoring')">Scoring</button>
                <button class="btn btn-sm {{ $activeTab === 'summary' ? 'btn-success' : 'btn-outline-success' }}" wire:click="$set('activeTab','summary')">Summary / Rankings</button>
                <button class="btn btn-sm {{ $activeTab === 'setup' ? 'btn-secondary' : 'btn-outline-secondary' }}" wire:click="$set('activeTab','setup')">Setup</button>
            @endif
        </div>
    </div>

    @include('layouts.message')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show py-2">{{ session('status') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- ═══════════════════════ SCORING TAB ═══════════════════════ --}}
    @if ($activeTab === 'scoring')
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">

                {{-- Category tabs --}}
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <ul class="nav nav-tabs border-0 gap-1 flex-wrap">
                        @foreach ($technicalCategories as $tc)
                            @php
                                $isActiveTab = $activeTechnicalCategoryId == $tc->id;
                                $assignedJudge = $tc->judgeAssignments->first()?->judge;
                                $pct = $tc->completionPercent($type);
                            @endphp
                            @if ($isAdmin || $activeTechnicalCategoryId == $tc->id)
                                <li class="nav-item">
                                    <button wire:click="$set('activeTechnicalCategoryId', {{ $tc->id }})" class="nav-link py-1 px-3 {{ $isActiveTab ? 'active fw-semibold' : '' }}">
                                        {{ $tc->name }}
                                        <span class="badge {{ $isActiveTab ? 'bg-primary' : 'bg-secondary' }} ms-1">{{ $tc->max_score }}pts</span>
                                        <small class="ms-1 text-muted d-block" style="font-size:0.7rem;">{{ $pct }}% done</small>
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                    {{-- Participant search --}}
                    <div style="width:260px;" class="position-relative">
                        <input type="search" wire:model.live="search" class="form-control form-control-sm" placeholder="Search participant…">
                        @if ($showDropdown && count($suggestions) > 0)
                            <ul class="list-group position-absolute w-100 z-3 shadow-sm">
                                @foreach ($suggestions as $item)
                                    <li wire:click="selectSuggestion({{ $item['id'] }})" class="list-group-item list-group-item-action py-1 px-2" style="cursor:pointer;font-size:.875rem;">
                                        {{ $item['participant_no'] }} — {{ $item['participant'] }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                @if (!$activeCategory)
                    <div class="p-4 text-center text-muted">
                        No judging categories set up yet.
                        @if ($isAdmin)
                            <button wire:click="$set('activeTab','setup')" class="btn btn-sm btn-outline-secondary ms-2">Go to Setup</button>
                        @endif
                    </div>
                @else
                    @php
                        $subCriterias = $activeCategory->subCriterias;
                        $groups = $subCriterias->groupBy(fn($s) => $s->sub_group ?? '__none__');
                        $judgeId = $activeCategoryJudge?->id;
                    @endphp

                    {{-- Judge badge --}}
                    <div class="px-3 pt-3 pb-1 d-flex align-items-center gap-2">
                        <span class="text-muted small">Assigned judge:</span>
                        @if ($activeCategoryJudge)
                            <span class="badge bg-info text-dark">{{ $activeCategoryJudge->judge }}</span>
                        @else
                            <span class="badge bg-warning text-dark">No judge assigned</span>
                        @endif
                        <span class="text-muted small ms-3">Max score: <strong>{{ $activeCategory->max_score }}</strong></span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0 align-middle technical-table">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-3" style="min-width:180px;">PARTICIPANT</th>
                                    @foreach ($groups as $groupName => $subs)
                                        @if ($groupName !== '__none__')
                                            <th colspan="{{ $subs->count() }}" class="text-center bg-light border-bottom-0 text-uppercase fw-bold" style="font-size:.75rem;letter-spacing:.05em;">
                                                {{ $groupName }}
                                            </th>
                                        @else
                                            @foreach ($subs as $s)
                                                <th class="text-center" style="min-width:90px;">
                                                    <div class="fw-semibold" style="font-size:.8rem;">{{ $s->name }}</div>
                                                    <small class="text-muted">Max&nbsp;{{ $s->max_score }}</small>
                                                </th>
                                            @endforeach
                                        @endif
                                    @endforeach
                                    @foreach ($groups as $groupName => $subs)
                                        @if ($groupName !== '__none__')
                                            {{-- spacer: actual sub-headers come from next thead row --}}
                                        @endif
                                    @endforeach
                                    <th class="text-center" style="min-width:90px;">TOTAL</th>
                                    @if ($isAdmin)
                                        <th class="text-center" style="min-width:90px;">DEDUCTIONS</th>
                                    @endif
                                </tr>
                                {{-- Sub-group sub-headers --}}
                                @php $hasGroups = $groups->keys()->contains(fn($k) => $k !== '__none__'); @endphp
                                @if ($hasGroups)
                                    <tr class="table-secondary">
                                        <th></th>
                                        @foreach ($groups as $groupName => $subs)
                                            @if ($groupName !== '__none__')
                                                @foreach ($subs as $s)
                                                    <th class="text-center py-1" style="min-width:90px;font-size:.78rem;">
                                                        {{ $s->name }}<br><small class="text-muted">Max&nbsp;{{ $s->max_score }}</small>
                                                    </th>
                                                @endforeach
                                            @endif
                                        @endforeach
                                        <th></th>
                                        @if ($isAdmin)
                                            <th></th>
                                        @endif
                                    </tr>
                                @endif
                            </thead>
                            <tbody>
                                @forelse($participants as $participant)
                                    @php
                                        $catTotal = 0;
                                        $totalDeduction = \App\Models\TechnicalDeduction::totalFor($participant->id, $type);
                                    @endphp
                                    <tr>
                                        <td class="px-3 bg-light">
                                            <span class="badge bg-primary me-1">#{{ $participant->participant_no }}</span>
                                            @if ($categoryName?->display_participant || $isAdmin)
                                                <span class="fw-semibold">{{ $participant->participant }}</span>
                                            @endif
                                        </td>
                                        @foreach ($groups as $groupName => $subs)
                                            @foreach ($subs as $s)
                                                @php
                                                    $existing = \App\Models\TechnicalScore::where('participant_id', $participant->id)->where('sub_criteria_id', $s->id)->where('judge_id', $judgeId)->where('competition_category', $type)->first();
                                                    $catTotal += $existing?->score ?? 0;
                                                @endphp
                                                <td class="text-center p-1">
                                                    @if ($judgeId)
                                                        <input type="number" class="form-control form-control-sm text-center fw-bold score-input {{ $existing ? 'scored' : '' }}" wire:change="saveScore({{ $participant->id }}, {{ $s->id }}, {{ $judgeId }}, $event.target.value)" value="{{ $existing ? $existing->score : '' }}" placeholder="—" min="0" max="{{ $s->max_score }}" step="0.5"
                                                            oninput="
                                                                const mx={{ $s->max_score }};
                                                                const v=parseFloat(this.value)||0;
                                                                if(v>mx||v<0){this.value=v>mx?mx:0;this.dispatchEvent(new Event('change'));}
                                                            " />
                                                    @else
                                                        <span class="text-muted small">—</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        @endforeach
                                        <td class="text-center fw-bold text-success">{{ number_format($catTotal, 1) }}</td>
                                        @if ($isAdmin)
                                            <td class="text-center">
                                                <button class="btn btn-outline-danger btn-sm" wire:click="openDeductionModal({{ $participant->id }})">
                                                    {{ $totalDeduction > 0 ? '-' . number_format($totalDeduction, 1) : 'Add' }}
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="99" class="text-center text-muted py-3">No participants found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- ═══════════════════════ SUMMARY / RANKINGS TAB ═══════════════════════ --}}
    @if ($activeTab === 'summary' && $isAdmin)
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0 fw-bold">Final Rankings — {{ $categoryName?->description }}</h6>
                    <small class="text-muted">Grand Total = sum of all judging category scores − deductions</small>
                </div>
                <button class="btn btn-primary btn-sm" wire:click="generateReport" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="generateReport">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-filetype-pdf me-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
                        </svg>
                        Export PDF
                    </span>
                    <span wire:loading wire:target="generateReport">
                        <span class="spinner-border spinner-border-sm me-1"></span> Generating…
                    </span>
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" style="width:60px;">RANK</th>
                                <th class="px-3">PARTICIPANT</th>
                                @foreach ($technicalCategories as $tc)
                                    <th class="text-center" style="min-width:100px;">
                                        <div style="font-size:.75rem;">{{ $tc->name }}</div>
                                        <small class="text-muted">Max {{ $tc->max_score }}</small>
                                    </th>
                                @endforeach
                                <th class="text-center">GROSS</th>
                                <th class="text-center text-danger">DEDUCTION</th>
                                <th class="text-center text-success">FINAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($summaryData ?? [] as $row)
                                <tr class="{{ $row['rank'] <= $winner ? 'table-warning' : '' }}">
                                    <td class="text-center fw-bold">
                                        @if ($row['rank'] == 1)
                                            <span class="badge bg-warning text-dark">🥇 1st</span>
                                        @elseif($row['rank'] == 2)
                                            <span class="badge bg-secondary">🥈 2nd</span>
                                        @elseif($row['rank'] == 3)
                                            <span class="badge bg-danger">🥉 3rd</span>
                                        @else
                                            {{ $row['rank'] }}
                                        @endif
                                    </td>
                                    <td class="px-3 fw-semibold">
                                        <span class="badge bg-primary me-1">#{{ $row['participant']->participant_no }}</span>
                                        {{ $row['participant']->participant }}
                                    </td>
                                    @foreach ($technicalCategories as $tc)
                                        <td class="text-center">{{ number_format($row['categoryScores'][$tc->id] ?? 0, 1) }}</td>
                                    @endforeach
                                    <td class="text-center">{{ number_format($row['grandTotal'], 1) }}</td>
                                    <td class="text-center text-danger">
                                        {{ $row['totalDeduction'] > 0 ? '-' . number_format($row['totalDeduction'], 1) : '—' }}
                                    </td>
                                    <td class="text-center fw-bold text-success fs-6">{{ number_format($row['finalScore'], 1) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="99" class="text-center text-muted py-3">No scores recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- ═══════════════════════ SETUP TAB ═══════════════════════ --}}
    @if ($activeTab === 'setup' && $isAdmin)
        @if (session('setup_status'))
            <div class="alert alert-success alert-dismissible fade show py-2">{{ session('setup_status') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <div class="row g-3">
            {{-- Add judging category --}}
            <div class="col-md-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-semibold">Judging Categories</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small">Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="newCatName" class="form-control form-control-sm @error('newCatName') is-invalid @enderror" placeholder="e.g. Basic Elements / Motions & Dance">
                            @error('newCatName')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col">
                                <label class="form-label small">Slug <span class="text-danger">*</span></label>
                                <input type="text" wire:model="newCatSlug" class="form-control form-control-sm @error('newCatSlug') is-invalid @enderror" placeholder="dance">
                                @error('newCatSlug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label class="form-label small">Max Score</label>
                                <input type="number" wire:model="newCatMaxScore" class="form-control form-control-sm" min="1">
                            </div>
                            <div class="col">
                                <label class="form-label small">Order</label>
                                <input type="number" wire:model="newCatOrder" class="form-control form-control-sm" min="0">
                            </div>
                        </div>
                        <button wire:click="addTechnicalCategory" class="btn btn-primary btn-sm">Add Category</button>

                        <hr>
                        <ul class="list-group list-group-flush">
                            @foreach ($technicalCategories as $tc)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <span class="fw-semibold">{{ $tc->name }}</span>
                                        <span class="badge bg-light text-dark ms-1">{{ $tc->max_score }}pts</span>
                                        <small class="text-muted d-block">{{ $tc->subCriterias->count() }} sub-criteria</small>
                                    </div>
                                    <button wire:click="deleteTechnicalCategory({{ $tc->id }})" wire:confirm="Delete '{{ $tc->name }}' and all its sub-criteria?" class="btn btn-outline-danger btn-sm">Delete</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Add sub-criteria --}}
            <div class="col-md-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-semibold">Sub-Criteria</div>
                    <div class="card-body">
                        <div class="row g-2 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small">Judging Category <span class="text-danger">*</span></label>
                                <select wire:model="newSubCatId" class="form-select form-select-sm @error('newSubCatId') is-invalid @enderror">
                                    <option value="">— select —</option>
                                    @foreach ($technicalCategories as $tc)
                                        <option value="{{ $tc->id }}">{{ $tc->name }}</option>
                                    @endforeach
                                </select>
                                @error('newSubCatId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Sub-group (optional)</label>
                                <input type="text" wire:model="newSubGroup" class="form-control form-control-sm" placeholder="e.g. Standing Tumbling">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="newSubName" class="form-control form-control-sm @error('newSubName') is-invalid @enderror" placeholder="e.g. Difficulty">
                                @error('newSubName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Max Score</label>
                                <input type="number" wire:model="newSubMax" class="form-control form-control-sm" step="0.5" min="0.5">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">Order</label>
                                <input type="number" wire:model="newSubOrder" class="form-control form-control-sm" min="0">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button wire:click="addSubCriteria" class="btn btn-primary btn-sm w-100">Add</button>
                            </div>
                        </div>

                        {{-- Sub-criteria list --}}
                        @foreach ($technicalCategories as $tc)
                            @if ($tc->subCriterias->count() > 0)
                                <div class="mb-3">
                                    <p class="mb-1 fw-semibold text-uppercase small text-muted">{{ $tc->name }}</p>
                                    <table class="table table-sm table-bordered mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Sub-group</th>
                                                <th>Name</th>
                                                <th>Max</th>
                                                <th>Order</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tc->subCriterias as $s)
                                                <tr>
                                                    <td>{{ $s->sub_group ?? '—' }}</td>
                                                    <td>{{ $s->name }}</td>
                                                    <td>{{ $s->max_score }}</td>
                                                    <td>{{ $s->display_order }}</td>
                                                    <td>
                                                        <button wire:click="deleteSubCriteria({{ $s->id }})" wire:confirm="Delete this sub-criteria?" class="btn btn-outline-danger btn-sm py-0 px-1">✕</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Judge assignments --}}
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-header bg-white fw-semibold">Judge Assignments</div>
                    <div class="card-body">
                        <div class="row g-2 mb-3">
                            <div class="col">
                                <label class="form-label small">Judge</label>
                                <select wire:model="assignJudgeId" class="form-select form-select-sm">
                                    <option value="">— select judge —</option>
                                    @foreach ($allJudges as $j)
                                        <option value="{{ $j->id }}">{{ $j->judge }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label small">Judging Category</label>
                                <select wire:model="assignTechCatId" class="form-select form-select-sm">
                                    <option value="">— select category —</option>
                                    @foreach ($technicalCategories as $tc)
                                        <option value="{{ $tc->id }}">{{ $tc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto d-flex align-items-end">
                                <button wire:click="assignJudge" class="btn btn-primary btn-sm">Assign</button>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($technicalCategories as $tc)
                                @php $assignment = $tc->judgeAssignments->first(); @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <span class="fw-semibold">{{ $tc->name }}</span>
                                        @if ($assignment?->judge)
                                            <span class="badge bg-info text-dark ms-2">{{ $assignment->judge->judge }}</span>
                                        @else
                                            <span class="badge bg-warning text-dark ms-2">No judge</span>
                                        @endif
                                    </div>
                                    @if ($assignment)
                                        <button wire:click="removeJudgeAssignment({{ $tc->id }})" wire:confirm="Remove judge assignment?" class="btn btn-outline-secondary btn-sm">Remove</button>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ═══════════════════════ DEDUCTION MODAL ═══════════════════════ --}}
    <div class="modal fade" id="technicalDeductionModal" tabindex="-1" data-bs-backdrop="static" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deductions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @foreach (\App\Models\TechnicalDeduction::$labels as $type => $label)
                        <div class="mb-3 p-3 border rounded">
                            <label class="form-label fw-semibold">{{ $label }}</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <label class="form-label small text-muted">Count</label>
                                    <input type="number" wire:model.defer="deductionInputs.{{ $type }}" class="form-control form-control-sm text-center" min="0" value="0">
                                </div>
                                <div class="col-8">
                                    <label class="form-label small text-muted">Remarks</label>
                                    <input type="text" wire:model.defer="deductionRemarks.{{ $type }}" class="form-control form-control-sm" placeholder="Optional notes…">
                                </div>
                            </div>
                            @php
                                $pts = \App\Models\TechnicalDeduction::$pointsMap[$type];
                                $cnt = (int) ($deductionInputs[$type] ?? 0);
                            @endphp
                            <small class="text-danger mt-1 d-block">
                                = {{ $cnt * $pts }} pts deducted
                            </small>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" wire:click="saveDeductions">
                        <span wire:loading.remove wire:target="saveDeductions">Save Deductions</span>
                        <span wire:loading wire:target="saveDeductions"><span class="spinner-border spinner-border-sm"></span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════ PDF REPORT MODAL ═══════════════════════ --}}
    <div class="modal fade" id="technicalReportModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Technical Scoring — PDF Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0" style="min-height:500px;">
                    @if($base64pdf)
                        <iframe src="data:application/pdf;base64,{{ $base64pdf }}" width="100%" height="650" frameborder="0"></iframe>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .score-input {
            border-radius: 6px;
            font-size: 1rem;
            min-width: 68px;
            max-width: 90px;
            margin: 0 auto;
            transition: border-color .15s, background .15s;
        }

        .score-input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, .15);
        }

        .score-input.scored {
            background: #f0fff4;
            border-color: #28a745;
            color: #155724;
        }

        .technical-table thead th {
            position: sticky;
            top: 0;
            z-index: 4;
        }
    </style>
</section>



@assets
    <link rel="stylesheet" href="{{ asset('css/responsive-table.css') }}" />
@endassets

@script
    <script>
        window.addEventListener('openDeductionModal', () => {
            new bootstrap.Modal(document.getElementById('technicalDeductionModal')).show();
        });
        window.addEventListener('closeDeductionModal', () => {
            const el = document.getElementById('technicalDeductionModal');
            bootstrap.Modal.getInstance(el)?.hide();
        });
        window.addEventListener('openReportModal', () => {
            new bootstrap.Modal(document.getElementById('technicalReportModal')).show();
        });
    </script>
@endscript
