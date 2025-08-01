<div>
    <section class="section quiz">
        <div class="row">
            <div class="col-lg-12">
                <section class="section oratorical">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-10 mx-auto">
                                <div class="card">
                                    <div class="card-header toolbar mb-3  d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">Add User</h5>
                                        <div class="d-flex">
                                            <div class="mx-2">
                                                <select name="selectedStatus" wire:model.live="selectedStatus" class="form-select" id="selectedStatus">
                                                    <option value="">--- Status (All) ---</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                            <button type="button" class="btn btn-primary" wire:click="addUser">
                                                <div wire:loading.remove wire:target="addUser">
                                                    <i class="bi bi-plus-circle"></i>
                                                </div>
                                                <div wire:loading wire:target="addUser">
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
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Role</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($users as $item)
                                                    <tr>
                                                        <td>#</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->email }}</td>
                                                        <td>{{ $item->role }}</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- End Table with hoverable rows -->
                                            <div>
                                                <!-- pagination -->
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
        <div class="modal fade" id="criteriaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="clear"></button>
                    </div>
                    <form wire:submit.prevent="saveModule">
                        <div class="modal-body">
                            @include('layouts.message')
                            <div class="mb-3">
                                <label for="category" class="form-label">Category Name</label>
                                <input type="text" class="form-control" wire:model="category" id="category" placeholder="Enter category name">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description Name</label>
                                <input type="text" class="form-control" wire:model="description" id="description" placeholder="Enter description name">
                            </div>
                            <div class="mb-3">
                                <label for="is_active">Is Active?</label>
                                <select wire:model="is_active" id="is_active" class="form-select">
                                    <option value="">--- SELECT ---</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="clear">Close</button>
                            <button type="submit" class="btn btn-primary">
                                <div wire:loading.remove wire:target="saveModule">
                                    Save changes
                                </div>
                                <div wire:loading wire:target="saveModule">
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
            var myModal = new bootstrap.Modal(document.getElementById('criteriaModal'));
            myModal.show();
        });

        window.addEventListener('hideModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('criteriaModal'));
            myModal.hide();
        });
    </script>
    @endscript
</div>