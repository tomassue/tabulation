    <section class="section poster">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Score</h5>
                            <div class="table-responsive">
                                <!-- Table with hoverable rows -->
                                <table class="table table-hover">
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
                                        @foreach ($participants as $item)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <th scope="row">{{$item->participant}}</th>
                                           @foreach ($judges as $item)
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Score">
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