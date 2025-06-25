    <section class="section quiz">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Scores</h5>
                            <div class="table-responsive">
                                <!-- Table with hoverable rows -->
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Participant</th>
                                            <th scope="col">Round 1</th>
                                            <th></th>
                                            <th scope="col">Round 2</th>
                                            <th></th>
                                            <th scope="col">Round 3</th>
                                            <th></th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($participants as $item)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <th scope="row">{{$item->participant}}</th>
                                            <td>28</td>
                                            <td>
                                                <a href="{{ route('quiz.view-details') }}" type="button" class="btn btn-sm btn-primary" target="_blank">
                                                    View
                                                </a>
                                            </td>
                                            <td>28</td>
                                            <td>
                                                <a href="{{ route('quiz.view-details') }}" type="button" class="btn btn-sm btn-primary" target="_blank">
                                                    View
                                                </a>
                                            </td>
                                            <td>28</td>
                                            <td>
                                                <a href="{{ route('quiz.view-details') }}" type="button" class="btn btn-sm btn-primary" target="_blank">
                                                    View
                                                </a>
                                            </td>
                                            <td>100</td>
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