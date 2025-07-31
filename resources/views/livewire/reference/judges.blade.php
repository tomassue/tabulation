<section class="section judges">
    <div class="row">
        <div class="col-lg-12">
            <section class="section oratorical">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-10 mx-auto">
                            <div class="card">
                                <div class="card-header toolbar mb-3  d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Add Judges</h5>
                                    <div class="d-flex">
                                        <div class="mx-2">
                                            <select name="selectedCateg" wire:model.live="selectedCateg" class="form-select" id="selectedCateg">
                                                <option value="">--- SELECT ---</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->category }}">{{ $item->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-primary" wire:click="addJudge">
                                            <div wire:loading.remove wire:target="addJudge">
                                                <i class="bi bi-plus-circle"></i>
                                            </div>
                                            <div wire:loading wire:target="addJudge">
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
                                                    <th scope="col">#</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Event</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($judges as $item)
                                                    <tr>
                                                        <th scope="row">
                                                            {{ $loop->iteration }}
                                                        </th>
                                                        <th scope="row">
                                                            {{ $item->judge }}
                                                            <span class="badge text-bg-secondary">{{ $item->nickname }}</span>
                                                        </th>
                                                        <th scope="row" class="text-capitalize">
                                                            {{ implode(', ', $item->category) }}
                                                        </th>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary" wire:click="editJudge({{ $item->id }})">
                                                                <div wire:loading.remove wire:target="editJudge({{ $item->id }})">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </div>
                                                                <div wire:loading wire:target="editJudge({{ $item->id }})">
                                                                    <div class="spinner-border spinner-border-sm" role="status">
                                                                        <span class="visually-hidden">Loading...</span>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </td>
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
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="judgeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="saveJudge">
                    <div class="modal-body">
                        @include('layouts.message')
                        <div class="mb-3">
                            <label for="judgeName" class="form-label">Judge Name</label>
                            <input type="text" class="form-control" wire:model="judge" id="judgeName" placeholder="Enter judge's name">
                        </div>
                        <div class="mb-3">
                            <label for="NickName" class="form-label">Nickname</label>
                            <input type="text" class="form-control" wire:model="nickname" id="NickName" placeholder="Enter judge's nickname">
                        </div>
                        <div class="mb-3">
                            <label for="category">Event Judge</label>
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
                            <div wire:loading.remove wire:target="saveJudge">
                                Save changes
                            </div>
                            <div wire:loading wire:target="saveJudge">
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
            var myModal = new bootstrap.Modal(document.getElementById('judgeModal'));
            myModal.show();
        });
        window.addEventListener('hideModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('judgeModal'));
            myModal.show();
        });
    </script>
@endscript
