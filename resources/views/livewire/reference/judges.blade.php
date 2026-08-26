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
                                        <div class="mx-2">
                                            <select name="selectedStatus" wire:model.live="selectedStatus" class="form-select" id="selectedStatus">
                                                <option value="">--- Status (All) ---</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
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
                                        <table class="table table-hover  table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width:3%">#</th>
                                                    <th scope="col" style="width:12%">Judge No.</th>
                                                    <th scope="col">Judge Name</th>
                                                    <th scope="col">Events</th>
                                                    <th scope="col" style="width:10%" class="text-center">Status</th>
                                                    <th scope="col" style="width:14%" class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($judges as $item)
                                                    <tr>
                                                        <td>{{ ($judges->currentPage() - 1) * $judges->perPage() + $loop->iteration }}</td>
                                                        <td>
                                                            <span class="badge text-bg-secondary fs-6">#{{ $item->nickname }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="fw-semibold">{{ $item->judge }}</span>
                                                        </td>
                                                        <td>
                                                            @foreach ($item->category as $cat)
                                                                <span class="badge text-bg-primary me-1 mb-1 text-capitalize">{{ $cat }}</span>
                                                            @endforeach
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge {{ $item->is_active ? 'text-bg-success' : 'text-bg-danger' }}">
                                                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <button wire:key="toggle-{{ $item->id }}" wire:target="toggleStatus({{ $item->id }})" wire:loading.attr="disabled" wire:click="toggleStatus({{ $item->id }})" class="btn btn-sm {{ $item->is_active ? 'btn-warning' : 'btn-success' }}" title="{{ $item->is_active ? 'Deactivate' : 'Activate' }}">
                                                                <div wire:loading.remove wire:target="toggleStatus({{ $item->id }})">
                                                                    <i class="bi {{ $item->is_active ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                                                                </div>
                                                                <div wire:loading wire:target="toggleStatus({{ $item->id }})">
                                                                    <div class="spinner-border spinner-border-sm" role="status">
                                                                        <span class="visually-hidden">Loading...</span>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                            <button wire:key="edit-{{ $item->id }}" wire:target="editJudge({{ $item->id }})" wire:loading.attr="disabled" class="btn btn-sm btn-primary" wire:click="editJudge({{ $item->id }})">
                                                                <div wire:loading.remove wire:target="editJudge({{ $item->id }})">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </div>
                                                                <div wire:loading wire:target="editJudge({{ $item->id }})">
                                                                    <div class="spinner-border spinner-border-sm" role="status">
                                                                        <span class="visually-hidden">Loading...</span>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                            <button wire:key="delete-{{ $item->id }}" wire:target="deleteJudge({{ $item->id }})" wire:loading.attr="disabled" wire:click="deleteJudge({{ $item->id }})" class="btn btn-danger btn-sm">
                                                                <div wire:loading.remove wire:target="deleteJudge({{ $item->id }})">
                                                                    <i class="bi bi-trash"></i>
                                                                </div>
                                                                <div wire:loading wire:target="deleteJudge({{ $item->id }})">
                                                                    <div class="spinner-border spinner-border-sm" role="status">
                                                                        <span class="visually-hidden">Loading...</span>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr class="text-center">
                                                        <td colspan="6" class="text-muted py-3">-- NO DATA --</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <!-- End Table with hoverable rows -->
                                        <div>
                                            {{ $judges->links() }}
                                        </div>
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
                            <label for="NickName" class="form-label">Judge Number</label>
                            <input type="number" class="form-control" wire:model="nickname" id="NickName" placeholder="Enter judge's number">
                        </div>
                        <div class="mb-3">
                            <label for="judgeName" class="form-label">Judge Name</label>
                            <input type="text" class="form-control" wire:model="judge" id="judgeName" placeholder="Enter judge's name">
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
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select wire:model="is_active" id="is_active" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('is_active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure to delete this deduction?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('layouts.message')
                    <div class="mb-3">
                        <label for="password" class="col-form-label">Type Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" wire:model="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" wire:click="executeDelete()">Delete</button>
                </div>
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
            var myModal = bootstrap.Modal.getInstance(document.getElementById('judgeModal'));
            if (myModal) myModal.hide();
        });
        window.addEventListener('openDeleteModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            myModal.show();
        });
        window.addEventListener('hideDeleteModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            myModal.hide();
        });
    </script>
@endscript
