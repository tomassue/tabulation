@extends('layouts.app')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Quiz</h1>
    </div><!-- End Page Title -->

    <section class="section quiz">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add Score</h5>
                            <!-- Vertical Form -->
                            <form class="row g-3">
                                <div class="col-12">
                                    <label for="inputNanme4" class="form-label">Participants</label>
                                    <input type="text" class="form-control" id="inputNanme4">
                                </div>
                                <div class="col-12">
                                    <label for="inputEmail4" class="form-label">Round</label>
                                    <input type="email" class="form-control" id="inputEmail4">
                                </div>
                                <div class="col-12">
                                    <label for="inputPassword4" class="form-label">Score</label>
                                    <input type="password" class="form-control" id="inputPassword4">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form><!-- Vertical Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection