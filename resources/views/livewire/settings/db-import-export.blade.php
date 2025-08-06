<div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <!-- Card -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white text-center rounded-top-4">
                        <h4 class="mb-0">Database Import & Export</h4>
                    </div>
                    <div class="card-body p-4">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="mb-4 text-center">
                            <h6>Export Database</h6>
                        </div>
                        <div class="mb-4 text-center">
                            <h6>CATEGORY</h6>
                            <select name="category_name" id="category_name" wire:model.live="category_name" class="form-select @error('category_name') is-invalid @enderror">
                                <option value=""> --- SELECT CATEGORY ---</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->category }}">{{ $loop->iteration }} - {{ $item->description }}</option>
                                @endforeach
                            </select>
                            @error('category_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4 text-center">
                            <h6>JUDGE</h6>
                            <select name="judge_id" id="judge_id" wire:model="judge_id" wire:change="updatedJudge" class="form-select @error('judge_id') is-invalid @enderror">
                                <option value=""> --- SELECT JUDGE ---</option>
                                @foreach ($judges as $item)
                                    <option value="{{ $item->id }}">{{ $loop->iteration }} - {{ $item->judge }}</option>
                                @endforeach
                            </select>
                            @error('judge_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- <div class="mb-4 text-center">
                            data found : {{ $count }}
                        </div> --}}
                        <!-- Export Section -->
                        <div class="mb-4 text-center">
                            <button class="btn btn-success px-4" type="button" wire:click="exportDatabase">
                                <i class="bi bi-download me-1"></i> Export Now
                            </button>
                        </div>
                        <hr>
                        <!-- Import Section -->
                        <div class="text-center">
                            <h6>Import Database</h6>
                            <form method="POST" wire:submit.prevent="importDatabase" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <input type="file" class="form-control @error('excel_file') is-invalid @enderror" wire:model="excel_file">
                                    @error('excel_file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button class="btn btn-primary px-4" type="submit">
                                    <i class="bi bi-upload me-1"></i> Import
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
