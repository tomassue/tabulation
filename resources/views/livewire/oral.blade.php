<section class="section oratorical">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-10 mx-auto">
                <div class="card" wire:loading.class="opacity-50 pe-none">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="">ORATORICAL SCORE TABLE</h5>
                            <div>
                                <div class="input-group">
                                    <button class="btn btn-primary" wire:click="generateReport">
                                        <div wire:loading.remove wire:target="generateReport">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
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
                            <div class="col-md-4">
                                <input type="search" wire:model.live="search" list="datalistOptions" name="search" id="search" class="form-control" placeholder="Search participant....">
                                <datalist id="datalistOptions">
                                    @foreach ($part as $item)
                                    <option value="{{$item->participant_no}}">
                                        @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-4">
                                <select name="judge_id" wire:model.live="judge_id" class="form-select" id="judge_id">
                                    <option value="">ALL</option>
                                    @foreach ($jud as $item)
                                    <option value="{{$item->id}}">{{$item->judge}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="table-wrapper" style="max-height: 600px; overflow-y: auto;">
                            <!-- Table with hoverable rows -->
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Participant</th>
                                        @foreach ($judges as $item)
                                        <th scope="col">
                                            <div>{{$item->judge}}</div>
                                            <span class="small text-muted">Judge {{$loop->iteration}}</span>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: {{$item->getOralPercent()}}%"></div>
                                            </div>
                                            <small> {{$item->getOralPercent()}}%</small>
                                        </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($participants as $participant)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <th scope="row">
                                            <h4>{{$participant->participant_no}}</h4>
                                            <small>{{$participant->participant}}</small>
                                            @php
                                            $deduction = \App\Models\OralDeduction::where('participant_id', $participant->id)->first();
                                            @endphp
                                            <div class="my-2">
                                                <label class="text-muted small">Deduction</label>
                                                <input type="number" wire:change="saveDeduction({{$participant->id}},$event.target.value)" value="{{ $deduction ? $deduction->deduction : '' }}" class="form-control">
                                            </div>
                                            <div class="text-success fw-bold">{{bong_format($participant->averageOral())}}</div>
                                        </th>
                                        @foreach ($judges as $judge)
                                        <td>
                                            @foreach ($criterias as $criteria)
                                            @php
                                            $score = \App\Models\Oral::where('participant_id', $participant->id)->where('criteria_id', $criteria->id)->where('judge_id', $judge->id)->first();
                                            @endphp
                                            <div class="mb-2">
                                                <label for="" class="text-muted small">{{$criteria->criteria}} ({{$criteria->perfect_score}} points)</label>
                                                <input type="number" class="form-control" wire:change="saveScore({{$participant->id}},{{$criteria->id}},{{$judge->id}},$event.target.value)" value="{{ $score ? $score->score : '' }}" placeholder="Score">
                                            </div>
                                            @endforeach
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
        <!-- Modal Body -->
        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
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
</section>
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
</style>
@script
<script>
    window.addEventListener('openModal', event => {
        var myModal = new bootstrap.Modal(document.getElementById('reportModal'));
        myModal.show();
    });
</script>
@endscript