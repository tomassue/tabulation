<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Display Configuration</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle text-center mt-4">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 25%">Category</th>
                                <th>All</th>
                                <th>First</th>
                                <th>Second</th>
                                <th>Third</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="fw-semibold text-uppercase mb-2">{{ $led?->category }}</div>
                                    <select name="category" id="category" wire:model="category" wire:change="changeCategory" class="form-select form-select-sm w-auto mx-auto">
                                        <option value="">--- SELECT ---</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->category }}">{{ $item->category }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <div class="mb-1">{{ $led?->show_all ? 'Shown' : 'Hidden' }}</div>
                                    <button class="btn btn-outline-primary btn-sm" wire:click="changeAll">Update</button>
                                </td>
                                <td>
                                    <div class="mb-1">{{ $led?->show_first ? 'Shown' : 'Hidden' }}</div>
                                    <button class="btn btn-outline-success btn-sm" wire:click="changeFirst">Update</button>
                                </td>
                                <td>
                                    <div class="mb-1">{{ $led?->show_second ? 'Shown' : 'Hidden' }}</div>
                                    <button class="btn btn-outline-warning btn-sm" wire:click="changeSecond">Update</button>
                                </td>
                                <td>
                                    <div class="mb-1">{{ $led?->show_third ? 'Shown' : 'Hidden' }}</div>
                                    <button class="btn btn-outline-danger btn-sm" wire:click="changeThird">Update</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
