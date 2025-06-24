@extends('layouts.app')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Participants</h1>
    </div><!-- End Page Title -->

    <section class="section participants">
        <div class="row">
            <div class="col-lg-12">
                <section class="section oratorical">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-10 mx-auto">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Add Participants</h5>
                                        <div class="toolbar mb-3 d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#participantModal">
                                                Add
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <!-- Table with hoverable rows -->
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">
                                                            Participant 1
                                                        </th>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary">
                                                                Edit
                                                            </button>
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
            </div>
        </div>
    </section>
</main>

<!-- Modal -->
<div class="modal fade" id="participantModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="participantsName" class="form-label">Participant's Name</label>
                        <input type="text" class="form-control" id="participantsName" placeholder="Enter participant's name">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection