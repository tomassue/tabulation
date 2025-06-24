@extends('layouts.app')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Oratorical</h1>
    </div><!-- End Page Title -->

    <section class="section oratorical">
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
                                            <th scope="col">Participant</th>
                                            <th scope="col">Judge 1</th>
                                            <th scope="col">Judge 2</th>
                                            <th scope="col">Judge 3</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Participant 1</th>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Score">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Score">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Score">
                                            </td>
                                        </tr>
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
</main>
@endsection