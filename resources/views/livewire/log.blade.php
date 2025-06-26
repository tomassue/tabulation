    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">

                <!-- User Filter -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Filter by User</h5>
                            <select class="form-select w-auto" wire:model="user_id" style="min-width: 200px;">
                                <option selected>All Users</option>
                                @foreach ($users as $item)
                                     <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Activity Log Table -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Activity Log</h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $item)
                                    <tr>
                                        <th>{{($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration}}</th>
                                        <td>{{$item->user->name}}</td>
                                        <td><span class="badge bg-success">{{$item->activity}}</td>
                                        <td>{{$item->created_at}}</td>
                                    </tr>
                                    @endforeach
                                   
                                </tbody>
                            </table>
                            <div>
                                {{$logs->links('pagination::bootstrap-5')}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>