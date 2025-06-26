@extends('layouts.app')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Logs</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">

                <!-- User Filter -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Filter by User</h5>
                            <select class="form-select w-auto" style="min-width: 200px;">
                                <option selected>All Users</option>
                                <option>Sir Bong</option>
                                <option>Sir Mike</option>
                                <option>Tomms</option>
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
                                    <tr>
                                        <th>1</th>
                                        <td>Sir Bongs</td>
                                        <td><span class="badge bg-success">Added a score wew</td>
                                        <td>2025-06-22 09:34 AM</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

@endsection