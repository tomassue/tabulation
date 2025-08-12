<section class="section deductions">
    <div class="row">
        <div class="col-lg-12">
            <section class="section deductions">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-10 mx-auto">
                            <div class="card">
                                <div class="card-header toolbar mb-3  d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Add Deduction</h5>
                                    <div class="d-flex">
                                        <div class="mx-2">
                                            <select name="selectedCateg" wire:model.live="selectedCateg" class="form-select" id="selectedCateg">
                                                <option value="">--- SELECT ---</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->category }}">{{ $item->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-primary" wire:click="addDeduction">
                                            <div wire:loading.remove wire:target="addDeduction">
                                                <i class="bi bi-plus-circle"></i>
                                            </div>
                                            <div wire:loading wire:target="addDeduction">
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
                                                    <th scope="col">Deduction</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($deductions as $item)
                                                    <tr>
                                                        <th scope="row">
                                                            {{ $loop->iteration }}
                                                        </th>
                                                        <th scope="row">
                                                            {{ $item->deduction_name }}
                                                        </th>
                                                        <th scope="row" class="text-capitalize">
                                                            {{ $item->category }}
                                                        </th>
                                                        <td>
                                                            {{ $item->deduction }}
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary" wire:click="editDeduction({{ $item->id }})">
                                                                <div wire:loading.remove wire:target="editDeduction({{ $item->id }})">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </div>
                                                                <div wire:loading wire:target="editDeduction({{ $item->id }})">
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
    <div class="modal fade" id="deductionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="saveDeduction">
                    <div class="modal-body">
                        @include('layouts.message')
                        <div class="mb-3">
                            <label for="deduction_name" class="form-label">Deduction Name</label>
                            <input type="text" class="form-control" wire:model="deduction_name" id="deduction_name" placeholder="Enter deduction name">
                        </div>
                        <div class="mb-3">
                            <label for="category">Event</label>
                            <select wire:model="category" id="category" class="form-select">
                                <option value="">--- SELECT ---</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->category }}">{{ $item->category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deduction" class="form-label">Score Deduction</label>
                            <input type="text" class="form-control" wire:model="deduction" id="deduction" placeholder="Enter score deduction">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <div wire:loading.remove wire:target="saveCriteria">
                                Save changes
                            </div>
                            <div wire:loading wire:target="saveCriteria">
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
            var myModal = new bootstrap.Modal(document.getElementById('deductionModal'));
            myModal.show();
        });

        window.addEventListener('hideModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('deductionModal'));
            myModal.hide();
        });
    </script>
@endscript
