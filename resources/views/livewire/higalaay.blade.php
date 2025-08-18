<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-10 mx-auto">
                <div class="card" wire:loading.class="opacity-50 pe-none">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="text-uppercase">{{ $categoryName }} SCORE TABLE</h5>
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
                        <div class="table-wrapper" style="max-height: 600px; overflow-y: auto;">
                            <!-- Table with hoverable rows -->
                            <table class="table table-hover table-bordered table-striped table-mobile-responsive table-mobile-sided">
                                <thead>
                                    <tr>
                                        <th scope="col" width="5%">#</th>
                                        <th scope="col">Participant</th>
                                        @foreach ($judges as $item)
                                            <th scope="col">
                                                <div>{{ $item->judge }}</div>
                                                <span class="small text-muted">{{ $item->nickname }}</span>
                                                @php
                                                    $percent = $item->getHigalaayPercent($type);
                                                @endphp
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" style="width: {{ $percent }}%"></div>
                                                </div>
                                                <small> {{ $percent }}% complete</small>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($participants as $participant)
                                        <tr scope="row">
                                            <th data-content="#">{{ $loop->iteration }}</th>
                                            <th data-content="Participant">
                                                <div class="row">
                                                    <h5 class="col-12 fs-6">Participant #{{ $participant->participant_no }}</h5>
                                                    <h4 class="col-12 fw-bold">{{ $participant->participant }}</h4>
                                                    @if (auth()->user()->role == 'admin')
                                                        <div class="col-12 text-success fw-bold">{{ bong_format($participant->averageHigalaay($type)) }}</div>
                                                        @php
                                                            $deduction = \App\Models\HigalaayDeduction::where('participant_id', $participant->id)->where('category', $type)->first();
                                                        @endphp
                                                        <div class="my-2 col-12">
                                                            <label class="text-muted small">Deduction</label>
                                                            <div class="input-group">
                                                                <input type="number" wire:change="saveDeduction({{ $participant->id }},$event.target.value)" value="{{ $deduction ? $deduction->deduction : '' }}" class="form-control">
                                                                <button class="btn btn-primary btn-sm" wire:click="showDeductionDetails({{ $participant->id }})"><i class="bi bi-three-dots"></i></button>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-12 text-success fw-bold">{{ bong_format($participant->getHigalaayScoreByJudge(auth()->user()->judge?->id, $type)) }}</div>
                                                    @endif
                                                </div>
                                            </th>
                                            @foreach ($judges as $judge)
                                                <td data-content="{{ $judge->judge }}">
                                                    <div class="row w-100">
                                                        @foreach ($criterias as $criteria)
                                                            @php
                                                                $score = \App\Models\Higalaay::where('participant_id', $participant->id)->where('category', $type)->where('criteria_id', $criteria->id)->where('judge_id', $judge->id)->first();
                                                            @endphp

                                                            <div class="col-12 mb-2">
                                                                <label for="" class="text-muted small">{{ $criteria->criteria }} <span class="badge bg-secondary">{{ $criteria->perfect_score }} points</span></label>
                                                                <input type="number" class="form-control" wire:change="saveScore({{ $participant->id }},{{ $criteria->id }},{{ $judge->id }},$event.target.value)" value="{{ $score ? $score->score : '' }}" placeholder="your score..." min="0" max="{{ $criteria->perfect_score }}"
                                                                    oninput="
                                                                    const max = {{ $criteria->perfect_score }};
                                                                    const value = parseFloat(this.value) || 0;
                                                                    const correctedValue = value > max ? max : value;
                                                                    
                                                                    if (value !== correctedValue) {
                                                                        this.value = correctedValue;
                                                                        this.dispatchEvent(new Event('change'));
                                                                    }
                                                                    " />
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Table with hoverable rows -->
                        </div>
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
                    <div class="mb-3 card">

                        <div class="card-body">
                            @isset($refDeductions)
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
                                            <h1 class="text-success">{{ $oldDeductions ?? 0 }}</h1>
                                        @else
                                            <h1 class="text-danger">-{{ $totalDeductions }}</h1>
                                        @endif

                                    </div>
                                </div>
                            @endisset
                        </div>
                    </div>
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
        .table-wrapper {
            max-height: 600px;
            /* or whatever fits your layout */
            overflow-y: auto;
        }

        /* Make header sticky */
        .table-wrapper thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .without_ampm::-webkit-datetime-edit-ampm-field {
            display: none;
        }

        input[type=time]::-webkit-clear-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            -o-appearance: none;
            -ms-appearance: none;
            appearance: none;
            margin: -10px;
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
