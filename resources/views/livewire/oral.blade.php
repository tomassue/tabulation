  <section class="section oratorical">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Scores</h5>
                            <div class="row d-flex justify-content-center mb-3">
                                <div class="col-md-6">
                                    <input type="search" wire:model.live="search"  list="datalistOptions" name="search" id="search" class="form-control" placeholder="Search participant....">
                                    <datalist id="datalistOptions">
                                        @foreach ($part as $item)
                                            <option value="{{$item->participant}}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <!-- Table with hoverable rows -->
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Participant</th>
                                            @foreach ($judges as $item)
                                                <th scope="col">
                                                    <div>{{$item->judge}}</div>
                                                    <span class="small text-muted">Judge {{$loop->iteration}}</span>
                                                </th>
                                            @endforeach
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($participants as $participant)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <th scope="row">{{$participant->participant}}</th>
                                            @foreach ($judges as $judge)
                                                <td>
                                                    @foreach ($criterias as $criteria)
                                                    @php
                                                        $score = \App\Models\Oral::where('participant_id', $participant->id)->where('criteria_id', $criteria->id)->where('judge_id', $judge->id)->first();
                                                    @endphp
                                                    <div class="mb-2">
                                                        <label for="">{{$criteria->criteria}}</label>
                                                        <input type="text" class="form-control" wire:change="saveScore({{$participant->id}},{{$criteria->id}},{{$judge->id}},$event.target.value)" value="{{ $score ? $score->score : '' }}" placeholder="Score">
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
    </section>