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
                                                <input type="search" wire:model.live="search" class="form-control" placeholder="Search...">
                                            </div>
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
                                                            <td>
                                                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                                            </td>
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ $item->email }}</td>
                                                            <td>{{ $item->role }}</td>
                                                            <td>
                                                                <span class="badge {{ $item->is_active == 1 ? 'text-bg-success' : 'text-bg-danger' }}">
                                                                    {{ $item->is_active == 1 ? 'Active' : 'Inactive' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                                    <button wire:key="edit-{{ $item->id }}" wire:target="editUser({{ $item->id }})" wire:loading.attr="disabled" type="button" class="btn btn-primary" wire:click="editUser({{ $item->id }})">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </button>
                                                                    <button wire:key="reset-{{ $item->id }}" wire:target="resetOpen({{ $item->id }})" wire:loading.attr="disabled" type="button" class="btn btn-warning" wire:click="resetOpen({{ $item->id }})">
                                                                        <i class="bi bi-arrow-clockwise"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- End Table with hoverable rows -->
                                            <div>
                                                {{ $users->links() }}
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
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="clear"></button>
                    </div>
                    <form wire:submit.prevent="saveUser">
                        <div class="modal-body">
                            @include('layouts.message')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" wire:model.live="name" id="name" placeholder="Enter name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Email</label>
                                <input type="text" class="form-control" wire:model="email" id="name" placeholder="Enter name">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-select" wire:model.live="role">
                                    <option value="">--- SELECT ---</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            @if ($editMode)
                                <div class="mb-3">
                                    <label for="is_active">Is Active?</label>
                                    <select wire:model="is_active" id="is_active" class="form-select">
                                        <option value="">--- SELECT ---</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            @endif
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
        <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="clear"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12 mb-3">
                                <label for="password">Current Password</label>
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" wire:model="old_password">
                                @error('old_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <hr class="my-4" />
                            <div class="form-group col-md-12 mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" wire:model="password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" wire:model="password_confirmation">
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="clear">Close</button>
                                <button type="submit" wire:click="savePassword()" class="btn btn-primary">Change password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @script
        <script>
            window.addEventListener('openModal', event => {
                var myModal = new bootstrap.Modal(document.getElementById('userModal'));
                myModal.show();
            });

            window.addEventListener('hideModal', event => {
                var myModal = new bootstrap.Modal(document.getElementById('userModal'));
                myModal.hide();
            });
            window.addEventListener('openResetModal', event => {
                var myModal = new bootstrap.Modal(document.getElementById('resetModal'));
                myModal.show();
            });
            window.addEventListener('hideResetModal', event => {
                var myModal = new bootstrap.Modal(document.getElementById('resetModal'));
                myModal.hide();
            });
        </script>
    @endscript
</div>
