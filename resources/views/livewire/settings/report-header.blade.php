<div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Report Header — Text</h5>
                        @if (session('textSaved'))
                            <div class="alert alert-success py-2">{{ session('textSaved') }}</div>
                        @endif
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <label class="form-label fw-bold">Event Title Prefix</label>
                                <input type="text" class="form-control" wire:model="headerTitle"
                                    placeholder="e.g. PASKO DE ORO 2025">
                                <small class="text-muted">Appears as the first bold line. Category/criteria name is
                                    appended automatically per report.</small>
                            </div>
                            <div class="col-sm-8">
                                <label class="form-label fw-bold">Default Venue</label>
                                <input type="text" class="form-control" wire:model="headerVenue"
                                    placeholder="e.g. Amphitheater - Capistrano - Gaerlan Streets">
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label fw-bold">Default Time</label>
                                <input type="text" class="form-control" wire:model="headerTime"
                                    placeholder="e.g. 6:30 AM – 10:00 AM">
                            </div>
                            <div class="col-sm-8">
                                <label class="form-label fw-bold">Alternate Venue <small class="text-muted">(for
                                        bangga-sa-daygon)</small></label>
                                <input type="text" class="form-control" wire:model="headerVenueAlt"
                                    placeholder="e.g. Cagayan de Oro City Hall Building - Tourism Hall">
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label fw-bold">Alternate Time</label>
                                <input type="text" class="form-control" wire:model="headerTimeAlt"
                                    placeholder="e.g. 4:00 PM">
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary" wire:click="saveText" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="saveText">Save Text</span>
                                <span wire:loading wire:target="saveText">
                                    <span class="spinner-border spinner-border-sm"></span> Saving...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Report Header — Images</h5>
                        @if (session('imagesSaved'))
                            <div class="alert alert-success py-2">{{ session('imagesSaved') }}</div>
                        @endif
                        @error('logoLeft1Upload')  <div class="alert alert-danger py-1">{{ $message }}</div> @enderror
                        @error('logoLeft2Upload')  <div class="alert alert-danger py-1">{{ $message }}</div> @enderror
                        @error('logoRight1Upload') <div class="alert alert-danger py-1">{{ $message }}</div> @enderror
                        @error('logoRight2Upload') <div class="alert alert-danger py-1">{{ $message }}</div> @enderror
                        @error('watermarkUpload')  <div class="alert alert-danger py-1">{{ $message }}</div> @enderror
                        @error('footerUpload')     <div class="alert alert-danger py-1">{{ $message }}</div> @enderror

                        <div class="row g-3">

                            {{-- Left Logo 1 --}}
                            <div class="col-sm-4">
                                <label class="form-label fw-bold">Left Logo 1</label>
                                @if ($logoLeft1)
                                    <div class="mb-2 d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/report-header/' . $logoLeft1) }}" height="50"
                                            style="object-fit:contain;">
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="removeImage('report_logo_left_1')">Remove</button>
                                    </div>
                                @endif
                                @if ($logoLeft1Upload)
                                    <img src="{{ $logoLeft1Upload->temporaryUrl() }}" height="50" class="mb-2"
                                        style="object-fit:contain;">
                                @endif
                                <input type="file" class="form-control" wire:model="logoLeft1Upload" accept="image/*">
                            </div>

                            {{-- Left Logo 2 --}}
                            <div class="col-sm-4">
                                <label class="form-label fw-bold">Left Logo 2</label>
                                @if ($logoLeft2)
                                    <div class="mb-2 d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/report-header/' . $logoLeft2) }}" height="50"
                                            style="object-fit:contain;">
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="removeImage('report_logo_left_2')">Remove</button>
                                    </div>
                                @endif
                                @if ($logoLeft2Upload)
                                    <img src="{{ $logoLeft2Upload->temporaryUrl() }}" height="50" class="mb-2"
                                        style="object-fit:contain;">
                                @endif
                                <input type="file" class="form-control" wire:model="logoLeft2Upload" accept="image/*">
                            </div>

                            {{-- Right Logo 1 --}}
                            <div class="col-sm-4">
                                <label class="form-label fw-bold">Right Logo 1</label>
                                @if ($logoRight1)
                                    <div class="mb-2 d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/report-header/' . $logoRight1) }}" height="50"
                                            style="object-fit:contain;">
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="removeImage('report_logo_right')">Remove</button>
                                    </div>
                                @endif
                                @if ($logoRight1Upload)
                                    <img src="{{ $logoRight1Upload->temporaryUrl() }}" height="50" class="mb-2"
                                        style="object-fit:contain;">
                                @endif
                                <input type="file" class="form-control" wire:model="logoRight1Upload" accept="image/*">
                            </div>

                            {{-- Right Logo 2 --}}
                            <div class="col-sm-4">
                                <label class="form-label fw-bold">Right Logo 2</label>
                                @if ($logoRight2)
                                    <div class="mb-2 d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/report-header/' . $logoRight2) }}" height="50"
                                            style="object-fit:contain;">
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="removeImage('report_logo_right_2')">Remove</button>
                                    </div>
                                @endif
                                @if ($logoRight2Upload)
                                    <img src="{{ $logoRight2Upload->temporaryUrl() }}" height="50" class="mb-2"
                                        style="object-fit:contain;">
                                @endif
                                <input type="file" class="form-control" wire:model="logoRight2Upload" accept="image/*">
                            </div>

                            {{-- Watermark --}}
                            <div class="col-sm-4">
                                <label class="form-label fw-bold">Watermark</label>
                                @if ($watermark)
                                    <div class="mb-2 d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/report-header/' . $watermark) }}" height="50"
                                            style="object-fit:contain;">
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="removeImage('report_watermark')">Remove</button>
                                    </div>
                                @endif
                                @if ($watermarkUpload)
                                    <img src="{{ $watermarkUpload->temporaryUrl() }}" height="50" class="mb-2"
                                        style="object-fit:contain;">
                                @endif
                                <input type="file" class="form-control" wire:model="watermarkUpload" accept="image/*">
                            </div>

                            {{-- Footer Image --}}
                            <div class="col-sm-4">
                                <label class="form-label fw-bold">Footer Image</label>
                                @if ($footer)
                                    <div class="mb-2 d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/report-header/' . $footer) }}" height="50"
                                            style="object-fit:contain;">
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="removeImage('report_footer')">Remove</button>
                                    </div>
                                @endif
                                @if ($footerUpload)
                                    <img src="{{ $footerUpload->temporaryUrl() }}" height="50" class="mb-2"
                                        style="object-fit:contain;">
                                @endif
                                <input type="file" class="form-control" wire:model="footerUpload" accept="image/*">
                            </div>

                        </div>

                        <div class="mt-3">
                            <button class="btn btn-primary" wire:click="saveImages" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="saveImages">Save Images</span>
                                <span wire:loading wire:target="saveImages">
                                    <span class="spinner-border spinner-border-sm"></span> Uploading...
                                </span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
</div>