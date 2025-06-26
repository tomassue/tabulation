  <section class="section oratorical">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5 class="">ORATORICAL SCORE TABLE</h5>
                                <div>
                                    <div class="input-group">
                                        <button class="btn btn-primary" wire:click="generateReport">Export PDF</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row d-flex justify-content-center my-3">
                                <div class="col-md-4">
                                    <input type="search" wire:model.live="search"  list="datalistOptions" name="search" id="search" class="form-control" placeholder="Search participant....">
                                    <datalist id="datalistOptions">
                                        @foreach ($part as $item)
                                            <option value="{{$item->participant_no}}">
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-md-4">
                                    <select name="judge_id" wire:model.live="judge_id" class="form-select" id="judge_id">
                                        <option value="">ALL</option>
                                        @foreach ($jud  as $item)
                                            <option value="{{$item->id}}">{{$item->judge}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
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
                                                <div class="small text-muted fw-lighter">{{$participant->school}}</div>
                                                @php
                                                    $deduction = \App\Models\OralDeduction::where('participant_id', $participant->id)->first();
                                                @endphp
                                                 <div class="my-2">
                                                    <label class="text-danger small">Deduction</label>
                                                    <input type="number" wire:change="saveDeduction({{$participant->id}},$event.target.value)" value="{{ $deduction ? $deduction->deduction : '' }}" class="form-control">
                                                 </div>
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
        </div>
        <!-- Modal Body -->
        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
        <div class="modal fade" id="reportModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Modal title
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe src="data:application/pdf;base64,{{ $base64pdf }}" width="100%" height="600"  type="application/pdf"  frameborder="0"></iframe>
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
@script
<script>
    window.addEventListener('openModal', event => {
        var myModal = new bootstrap.Modal(document.getElementById('reportModal'));
        myModal.show();
    });
</script>
@endscript