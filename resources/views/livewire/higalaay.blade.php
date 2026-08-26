<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-10 mx-auto">
                <div class="card" wire:loading.class="opacity-50 pe-none">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="text-uppercase">{{ $categoryName?->description }} SCORE TABLE</h5>
                            <div>
                                <div class="input-group">
                                    <select name="criteria_id" wire:model.live="criteria_id" class="form-select" id="criteria_id">
                                        <option value="">ALL CRITERIA</option>
                                        @foreach ($criterias as $item)
                                            <option value="{{ $item->id }}">{{ $item->criteria }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-primary" wire:click="generateReport">
                                        <div wire:loading.remove wire:target="generateReport">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                            </svg>
                                        </div>
                                        <div wire:loading wire:target="generateReport">
                                            <div class="spinner-border spinner-border-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($locked && auth()->user()->role != 'admin')
                            <div class="alert alert-warning text-center fw-bold mb-3">
                                <i class="bi bi-lock-fill me-1"></i> Scoring is locked. You can view results but cannot modify scores.
                            </div>
                        @endif
                        <div class="row d-flex justify-content-center my-3">
                            <div class="col-md-4 mb-3">
                                <label for="">PARTICIPANT</label>
                                <input type="search" wire:model.live="search" @focus="showDropdown = true" list="datalistOptions" name="search" id="search" class="form-control" placeholder="Search participant....">
                                @if ($showDropdown && count($suggestions) > 0)
                                    <ul class="list-group">
                                        @foreach ($suggestions as $item)
                                            <li wire:click="selectSuggestion({{ $item->id }})" class="list-group-item list-group-item-action" style="cursor: pointer">
                                                {{ $item->participant_no }} - {{ $item->participant }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            @if (auth()->user()->role == 'admin')
                                <div class="col-md-4 mb-3">
                                    <label for="">JUDGES</label>
                                    <select name="judge_id" wire:model.live="judge_id" class="form-select" id="judge_id">
                                        <option value="">ALL</option>
                                        @foreach ($jud as $item)
                                            <option value="{{ $item->id }}">{{ $item->judge }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                        {{-- Judge progress bar strip --}}
                        <div class="d-flex gap-3 flex-wrap mb-3 px-1">
                            @foreach ($judges as $item)
                                @php $percent = $item->getHigalaayPercent($type); @endphp
                                <div class="flex-grow-1" style="min-width:160px;">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="fw-semibold">{{ $item->judge }}</small>
                                        <small class="text-muted">{{ $percent }}%</small>
                                    </div>
                                    <div class="progress" style="height:6px;">
                                        <div class="progress-bar bg-success" style="width:{{ $percent }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @php
                            $hasSeg = $criterias->whereNotNull('segment')->isNotEmpty();
                            $segments = $hasSeg
                                ? $criterias->whereNotNull('segment')->pluck('segment')->unique()->values()
                                : collect();
                        @endphp

                        {{-- Segment filter tabs (only when segments exist) --}}
                        <div x-data="{ activeSeg: '' }">
                        @if ($hasSeg)
                            <div class="d-flex gap-2 flex-wrap mb-3">
                                <button class="btn btn-sm"
                                    :class="activeSeg === '' ? 'btn-primary' : 'btn-outline-secondary'"
                                    @click="activeSeg = ''">
                                    ALL SEGMENTS
                                </button>
                                @foreach ($segments as $seg)
                                    @php $sw = $criterias->firstWhere('segment', $seg)?->segment_weight; @endphp
                                    <button class="btn btn-sm"
                                        :class="activeSeg === @js($seg) ? 'btn-primary' : 'btn-outline-secondary'"
                                        @click="activeSeg = @js($seg)">
                                        {{ $seg }}
                                        @if ($sw)
                                            <span class="badge bg-warning text-dark ms-1">{{ $sw }}%</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        {{-- Participant scoring cards --}}
                        <div class="scoring-cards">
                            @foreach ($participants as $participant)
                                <div class="card mb-3 shadow-sm border-0 participant-card"
                                    x-data="{ revealed: true }"
                                    :class="{ 'scores-hidden': !revealed }">

                                    {{-- Card header: participant identity + totals --}}
                                    <div class="card-header d-flex align-items-center justify-content-between py-2 px-3 bg-white border-bottom">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="badge bg-primary fs-6 px-3 py-2">#{{ $participant->participant_no }}</span>
                                            @if ($categoryName?->display_participant || auth()->user()->role == 'admin')
                                                <span class="fw-bold fs-6">{{ $participant->participant }}</span>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                @click="revealed = !revealed"
                                                :title="revealed ? 'Hide scores' : 'Show scores'">
                                                <i class="bi" :class="revealed ? 'bi-eye-slash' : 'bi-eye'"></i>
                                            </button>
                                            @if (auth()->user()->role == 'admin')
                                                <span class="total-mask-wrap position-relative">
                                                    <span class="text-success fw-bold fs-5" x-show="revealed">{{ bong_format($participant->averageHigalaay($type)) }}</span>
                                                    <span class="text-success fw-bold fs-5 total-mask" x-show="!revealed" aria-hidden="true">••••</span>
                                                </span>
                                                @php $deduction = \App\Models\HigalaayDeduction::where('participant_id', $participant->id)->where('category', $type)->first(); @endphp
                                                <div class="d-flex align-items-center gap-1">
                                                    <small class="text-muted me-1">Deduction</small>
                                                    <div class="input-group input-group-sm" style="width:140px;">
                                                        <input type="number" wire:change="saveDeduction({{ $participant->id }},$event.target.value)" value="{{ $deduction ? $deduction->deduction : '' }}" class="form-control">
                                                        <button class="btn btn-outline-secondary btn-sm" wire:click="showDeductionDetails({{ $participant->id }})"><i class="bi bi-three-dots"></i></button>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="total-mask-wrap position-relative">
                                                    <span class="text-success fw-bold fs-5" x-show="revealed">{{ bong_format($participant->getHigalaayScoreByJudge(auth()->user()->judge?->id, $type)) }}</span>
                                                    <span class="text-success fw-bold fs-5 total-mask" x-show="!revealed" aria-hidden="true">••••</span>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Score grid: criteria rows × judge columns --}}
                                    @php
                                        $judgeCount = count($judges);
                                        $criteriaWidth = match(true) {
                                            $judgeCount <= 1 => '60%',
                                            $judgeCount <= 2 => '40%',
                                            $judgeCount <= 3 => '30%',
                                            default          => '220px',
                                        };
                                    @endphp
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm mb-0 scoring-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="criteria-col px-3 py-2 text-muted fw-semibold" style="width:{{ $criteriaWidth }};">CRITERIA</th>
                                                        @foreach ($judges as $judge)
                                                            <th class="text-center py-2">
                                                                <div class="fw-semibold">{{ $judge->judge }}</div>
                                                                <small class="text-muted">Judge #{{ $judge->nickname }}</small>
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $grouped = $hasSeg
                                                            ? $criterias->groupBy(fn($c) => $c->segment ?? '')
                                                            : collect(['' => $criterias]);
                                                    @endphp
                                                    @foreach ($grouped as $segmentName => $segCriterias)
                                                        @if ($hasSeg && $segmentName !== '')
                                                            @php $segWeight = $segCriterias->first()->segment_weight; @endphp
                                                            <tr class="segment-header-row"
                                                                x-show="activeSeg === '' || activeSeg === @js($segmentName)">
                                                                <td colspan="{{ count($judges) + 1 }}" class="px-3 py-2 fw-bold text-uppercase text-white bg-secondary small">
                                                                    {{ $segmentName }}
                                                                    @if ($segWeight)
                                                                        <span class="badge bg-warning text-dark ms-2">{{ $segWeight }}%</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @foreach ($segCriterias as $criteria)
                                                            <tr x-show="@js($criteria->segment ?? '') === '' || activeSeg === '' || activeSeg === @js($criteria->segment ?? '')">
                                                                <td class="px-3 py-2 align-middle bg-light">
                                                                    <div class="fw-semibold criteria-label">{{ $criteria->criteria }}</div>
                                                                    <small class="text-muted">Max: {{ $criteria->perfect_score }}</small>
                                                                </td>
                                                                @foreach ($judges as $judge)
                                                                    @php
                                                                        $score = \App\Models\Higalaay::where('participant_id', $participant->id)->where('category', $type)->where('criteria_id', $criteria->id)->where('judge_id', $judge->id)->first();
                                                                    @endphp
                                                                    <td class="text-center align-middle p-2">
                                                                        <div class="score-input-wrap position-relative">
                                                                            @php $isDisabled = $locked && auth()->user()->role != 'admin'; @endphp
                                                                            <input type="number"
                                                                                class="form-control form-control-lg text-center fw-bold score-input {{ $score ? 'scored' : '' }}"
                                                                                wire:change="saveScore({{ $participant->id }},{{ $criteria->id }},{{ $judge->id }},$event.target.value)"
                                                                                value="{{ $score ? $score->score : '' }}"
                                                                                placeholder="—"
                                                                                min="0"
                                                                                max="{{ $criteria->perfect_score }}"
                                                                                {{ $isDisabled ? 'disabled' : '' }}
                                                                                oninput="
                                                                                    const max = {{ $criteria->perfect_score }};
                                                                                    const value = parseFloat(this.value) || 0;
                                                                                    const correctedValue = value > max || value < 0 ? max : value;
                                                                                    if (value !== correctedValue) {
                                                                                        this.value = correctedValue;
                                                                                        this.dispatchEvent(new Event('change'));
                                                                                    }
                                                                                " />
                                                                            @if ($score)
                                                                                <div class="score-mask" x-show="!revealed" aria-hidden="true">••••</div>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        </div>{{-- end x-data segment filter --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reportModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Report
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($base64pdf)
                        <iframe src="data:application/pdf;base64,{{ $base64pdf }}" width="100%" height="600" type="application/pdf" frameborder="0"></iframe>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="paticipantDetails" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Deduction Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('layouts.message')
                    <div class="mb-3">
                        <label for="participant" class="form-label">Participant</label>
                        <input type="text" readonly class="form-control-plaintext fs-3" id="participant" value="{{ $deductionModel?->participant?->participant }}">
                    </div>
                    @if ($refDeductions && count($refDeductions) > 0)
                        <div class="mb-3 card">
                            <div class="card-body">
                                <div class="row p-3">
                                    <div class="col-md-8">
                                        @foreach ($refDeductions as $index => $item)
                                            <div class="form-check">
                                                <input type="checkbox" id="deduction-{{ $item['id'] }}" wire:model.live="refDeductions.{{ $index }}.checked" class="form-check-input w-5 h-5 text-blue-600 rounded focus:ring-blue-500 mb-3">
                                                <label for="deduction-{{ $item['id'] }}" class="ml-3 font-medium">{{ $item['deduction_name'] }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <span>DEDUCTION</span>
                                        @if ($totalDeductions == 0)
                                            <h1 class="text-success">{{ $totalDeductions }}</h1>
                                        @else
                                            <h1 class="text-danger">-{{ $totalDeductions }}</h1>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="participant" class="form-label">Duration in minutes</label>
                        <input type="text" wire:model.live="duration" class="form-control @error('duration') is-invalid @enderror" id="participant">
                        @error('duration')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="participant" class="form-label">Remarks</label>
                        <textarea remarks="remarks" wire:model.live="remarks" class="form-control mt-2 @error('remarks') is-invalid @enderror" rows="2"></textarea>
                        @error('remarks')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button class="btn btn-primary" wire:click="saveCustomDeductions">
                        <div wire:loading.remove wire:target="saveCustomDeductions">
                            Update Deduction
                        </div>
                        <div wire:loading wire:target="saveCustomDeductions">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Scoring card */
        .participant-card {
            border-radius: 10px;
            overflow: hidden;
        }
        .participant-card .card-header {
            background: #f8f9fa;
        }

        /* Score input */
        .score-input {
            border-radius: 8px;
            font-size: 1.2rem;
            min-width: 80px;
            max-width: 120px;
            margin: 0 auto;
            border-color: #dee2e6;
            transition: border-color .15s, background .15s;
        }
        .score-input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13,110,253,.15);
        }
        .score-input.scored {
            background: #f0fff4;
            border-color: #28a745;
            color: #155724;
        }

        /* Criteria column */
        .scoring-table .criteria-col {
            min-width: 180px;
        }

        /* Sticky criteria header inside each card */
        .scoring-table thead th {
            position: sticky;
            top: 0;
            z-index: 5;
        }

        /* Score masking */
        .score-input-wrap {
            display: inline-block;
        }
        .score-mask {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            letter-spacing: .15rem;
            color: #155724;
            background: #f0fff4;       /* match .score-input.scored background so it reads as a filled cell */
            border: 1px solid #28a745;
            border-radius: 8px;
            pointer-events: none;       /* clicks pass through to the input so the judge can still focus/edit */
            user-select: none;
        }
        /* When card is hidden, blank the real digits as a fallback (covers focus state) */
        .scores-hidden .score-input {
            color: transparent;
            text-shadow: none;
        }
        .scores-hidden .score-input:focus {
            color: inherit;            /* reveal real value only while actively editing */
        }
    </style>
</section>
@assets
    <link rel="stylesheet" href="{{ asset('css/responsive-table.css') }}" />
@endassets
@script
    <script>
        window.addEventListener('openModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('reportModal'));
            myModal.show();
        });
        window.addEventListener('openDetailsModal', event => {
            var myDetailsModal = new bootstrap.Modal(document.getElementById('paticipantDetails'));
            myDetailsModal.show();
        });
    </script>
@endscript
