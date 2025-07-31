    <section class="section participants">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-header toolbar mb-3  d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Add Participants</h5>
                            <div class="d-flex">
                                <div class="mx-2">
                                    <select name="selectedCateg" wire:model.live="selectedCateg" class="form-select" id="selectedCateg">
                                        <option value="">--- SELECT ---</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->category }}">{{ $item->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary" wire:click="addParticipant">
                                    <div wire:loading.remove wire:target="addParticipant">
                                        <i class="bi bi-plus-circle"></i>
                                    </div>
                                    <div wire:loading wire:target="addParticipant">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- Table with hoverable rows -->
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th scope="col">Participant's No.</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">School/Organization</th>
                                            <th scope="col">Events</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($participants as $item)
                                            <tr>
                                                <td scope="row">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td scope="row">
                                                    {{ $item->participant_no }}
                                                </td>
                                                <td scope="row">
                                                    {{ $item->participant }}
                                                </td>
                                                <td scope="row">
                                                    {{ $item->school }}
                                                </td>
                                                <td scope="row" class="text-capitalize">
                                                    {{ implode(', ', $item->category) }}
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button class="btn btn-sm btn-primary" wire:click="editParticipant({{ $item->id }})">
                                                            <div wire:loading.remove wire:target="editParticipant({{ $item->id }})">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </div>
                                                            <div wire:loading wire:target="editParticipant({{ $item->id }})">
                                                                <div class="spinner-border spinner-border-sm" role="status">
                                                                    <span class="visually-hidden">Loading...</span>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <button class="btn btn-sm btn-warning" wire:click="addPoster({{ $item->id }})" style="display: {{ $item->category == 'poster' ? '' : 'none' }};">
                                                            <div wire:loading.remove wire:target="addPoster({{ $item->id }})">
                                                                <i class="bi bi-upload"></i>
                                                            </div>
                                                            <div wire:loading wire:target="addPoster({{ $item->id }})">
                                                                <div class="spinner-border spinner-border-sm" role="status">
                                                                    <span class="visually-hidden">Loading...</span>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <button wire:click="deleteParticipant({{ $item->id }})" class="btn btn-danger">
                                                            DELETE
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
                                <input type="number" class="form-control" id="participant_no" wire:model="participant_no" placeholder="Enter participant's number">
                            </div>
                            <div class="mb-3">
                                <label for="participantsName" class="form-label">Participant's Name</label>
                                <input type="text" class="form-control" id="participantsName" wire:model="participant" placeholder="Enter participant's name">
                            </div>
                            <div class="mb-3">
                                <label for="school" class="form-label">Participant's School/Organization</label>
                                <input type="text" class="form-control" id="school" wire:model="school" placeholder="Enter participant's school">
                            </div>
                            <div class="mb-3">
                                <label for="category">Event Participant</label>
                                @foreach ($categories as $item)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input w-5 h-5 text-blue-600 rounded focus:ring-blue-500" wire:model="selectedCategories" value="{{ $item->category }}">
                                        <label for="flexCheckDefault">
                                            {{ $item->description }}
                                        </label>
                                    </div>
                                @endforeach
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
                    <form wire:submit.prevent="uploadOutput">
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
                                <!-- <input type="file" class="form-control" id="poster_file" wire:model="poster_file" accept="image/*"> -->
                                <div wire:ignore>
                                    <input type="file" class="form-control upload_poster_file" accept="image/*">
                                </div>
                            </div>
                            <div class="my-4">
                                <!-- Poster Photo Preview Card -->
                                @if ($poster_photos)
                                    <div class="card shadow-sm border-0">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 text-primary fw-bold">Poster Image</h6>
                                            <span class="badge bg-info text-dark">Preview</span>
                                        </div>
                                        <div class="card-body text-center mt-4">
                                            <a href="{{ $poster_photos }}" data-lightbox="{{ $poster_photos }}" data-title="Poster Image">
                                                <img src="{{ $poster_photos }}" alt="Poster" class="img-thumbnail" style="max-height: 300px; object-fit: cover;">
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                <div wire:loading.remove wire:target="uploadOutput">
                                    Upload
                                </div>
                                <div wire:loading wire:target="uploadOutput">
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
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('layouts.message')
                        <p class="text-danger">Are you sure to delete this participant?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" wire:click="executeDeleteParticipant()">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @script
        <script>
            // Register the plugin 
            FilePond.registerPlugin(FilePondPluginFileValidateType); // for file type validation
            FilePond.registerPlugin(FilePondPluginFileValidateSize); // for file size validation
            FilePond.registerPlugin(FilePondPluginImagePreview); // for image preview

            // Turn input element into a pond with configuration options
            $('.upload_poster_file').filepond({
                // required: true,
                allowFileTypeValidation: true,
                acceptedFileTypes: ['image/jpeg', 'image/png'],
                labelFileTypeNotAllowed: 'File of invalid type',
                allowFileSizeValidation: true,
                maxFileSize: '50MB',
                labelMaxFileSizeExceeded: 'File is too large',
                server: {
                    // This will assign the data to the files[] property.
                    process: (fieldName, file, metadata, load, error, progress, abort) => {
                        @this.upload('poster_file', file, load, error, progress);
                    },
                    revert: (uniqueFileId, load, error) => {
                        @this.removeUpload('poster_file', uniqueFileId, load, error);
                    }
                }
            });

            $wire.on('reset-poster-files', () => {
                $('.upload_poster_file').each(function() {
                    $(this).filepond('removeFiles');
                });
            });

            /* -------------------------------------------------------------------------- */

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
            window.addEventListener('openDeleteModal', event => {
                var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                myModal.show();
            });
            window.addEventListener('hideDeleteModal', event => {
                var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                myModal.hide();
            });
            /* -------------------------------------------------------------------------- */
        </script>
    @endscript
