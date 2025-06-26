<section class="section poster">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-10 mx-auto">
                <div class="card" wire:loading.class="opacity-50 pe-none">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="">POSTER SCORE TABLE</h5>
                            <div>
                                <div class="input-group">
                                    <button class="btn btn-primary" wire:click="generateReport">
                                        <div wire:loading.remove wire:target="generateReport">Export PDF</div>
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
                                                <div class="progress-bar bg-success" style="width: {{$item->getPercent()}}%"></div>
                                            </div>
                                            <small> {{$item->getPercent()}}%</small>
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
                                            <div class="text-success fw-bold">{{bong_format($participant->averagePoster())}}</div>
                                        </th>
                                        @foreach ($judges as $judge)
                                        <td>
                                            @foreach ($criterias as $criteria)
                                            @php
                                            $score = \App\Models\Poster::where('participant_id', $participant->id)->where('criteria_id', $criteria->id)->where('judge_id', $judge->id)->first();
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
</section>
@script
<script>
    window.addEventListener('openModal', event => {
        var myModal = new bootstrap.Modal(document.getElementById('reportModal'));
        myModal.show();
    });
</script>
@endscript