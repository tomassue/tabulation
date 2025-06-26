    <section class="section participants">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add Participants</h5>
                            <div class="toolbar mb-3 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" wire:click="addParticipant">
                                    <div wire:loading.remove wire:target="addParticipant">
                                        Add
                                    </div>
                                    <div wire:loading wire:target="addParticipant">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <div class="table-responsive">
                                <!-- Table with hoverable rows -->
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th scope="col">Participant's No.</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">School</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($participants as $item)
                                        <tr>
                                            <td scope="row">
                                                {{$loop->iteration}}
                                            </td>
                                            <td scope="row">
                                                {{$item->participant_no}}
                                            </td>
                                            <td scope="row">
                                                {{$item->participant}}
                                            </td>
                                            <td scope="row">
                                                {{$item->school}}
                                            </td>
                                            <td scope="row" class="text-capitalize">
                                                {{$item->category}}
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button class="btn btn-sm btn-primary" wire:click="editParticipant({{$item->id}})">
                                                        <div wire:loading.remove wire:target="editParticipant({{$item->id}})">
                                                            Edit
                                                        </div>
                                                        <div wire:loading wire:target="editParticipant({{$item->id}})">
                                                            <div class="spinner-border spinner-border-sm" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <button class="btn btn-sm btn-warning" wire:click="addPoster({{$item->id}})" style="display: {{ $item->category == 'poster' ? '' : 'none' }};">
                                                        <div wire:loading.remove wire:target="addPoster({{$item->id}})">
                                                            Upload
                                                        </div>
                                                        <div wire:loading wire:target="addPoster({{$item->id}})">
                                                            <div class="spinner-border spinner-border-sm" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6">-- NO DATA --</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!-- End Table with hoverable rows -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="participantModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="saveParticipant">
                        <div class="modal-body">
                            @include('layouts.message')
                            <div class="mb-3">
                                <label for="participant_no" class="form-label">Participant's No.</label>
                                <input type="text" class="form-control" id="participant_no" wire:model="participant_no" placeholder="Enter participant's number">
                            </div>
                            <div class="mb-3">
                                <label for="participantsName" class="form-label">Participant's Name</label>
                                <input type="text" class="form-control" id="participantsName" wire:model="participant" placeholder="Enter participant's name">
                            </div>
                            <div class="mb-3">
                                <label for="school" class="form-label">Participant's School</label>
                                <input type="text" class="form-control" id="school" wire:model="school" placeholder="Enter participant's school">
                            </div>
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select wire:model="category" id="category" class="form-select">
                                    <option value="">--- SELECT ---</option>
                                    <option value="oral">Oral</option>
                                    <option value="poster">Poster</option>
                                    <option value="quiz">Quiz</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                <div wire:loading.remove wire:target="saveParticipant">
                                    Save changes
                                </div>
                                <div wire:loading wire:target="saveParticipant">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="uploadPosterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload File</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="saveParticipant">
                        <div class="modal-body">
                            @include('layouts.message')
                            <div class="mb-3">
                                <label for="poster_file" class="form-label">
                                    Poster
                                    <div wire:loading>
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </label>
                                <input type="file" class="form-control" id="poster_file" wire:model="poster_file" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                <div wire:loading.remove wire:target="saveParticipant">
                                    Upload
                                </div>
                                <div wire:loading wire:target="saveParticipant">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @script
    <script>
        window.addEventListener('openModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('participantModal'));
            myModal.show();
        });
        window.addEventListener('hideModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('participantModal'));
            myModal.show();
        });
        window.addEventListener('openPosterModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('uploadPosterModal'));
            myModal.show();
        });
    </script>
    @endscript