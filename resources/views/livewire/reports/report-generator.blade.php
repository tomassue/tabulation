<div>
    <section class="section">
        <div class="row">

            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Report Content (Single Event)</h5>

                        <form id="reportForm">

                            <!-- Single Participant Section -->
                            <div class="mb-4">
                                {{-- <h6 class="card-subtitle mb-3">E</h6> --}}
                                <!-- Initial participant row -->
                                <div class="row mb-3 participant-row g-2">
                                    <div class="col-sm-12 row g-2">
                                        <div class="col-sm-3">
                                            <label for="" class="form-label">Report</label>
                                            <select class="form-select" wire:model="reportType" required>
                                                <option value="">-- Select report --</option>
                                                <option value="1">Champion</option>
                                                <option value="2">Special Awards</option>
                                            </select>
                                            @error('reportType')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="" class="form-label">Category</label>
                                            <select class="form-select" wire:model="selectedCategory" required>
                                                <option value="">-- Select category --</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->category }}">{{ $item->description }}</option>
                                                @endforeach
                                            </select>
                                            @error('selectedCategory')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="" class="form-label">Type</label>
                                            <select class="form-select" wire:model="selectedType" required>
                                                <option value="">ALL</option>
                                                <option value="1">Champion Only</option>
                                                <option value="2">To 1st Runner Up</option>
                                                <option value="3">To 2nd Runner Up</option>
                                                @for ($i = 4; $i < 10; $i++)
                                                    <option value="{{ $i }}">{{ bong_ordinal($i - 1) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="runnerups" class="form-label">Winners up to?</label>
                                            <input type="number" class="form-control" wire:model="runnerups" id="runnerups" placeholder="Enter custom count">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center pt-3">
                                <button type="button" class="btn btn-primary" wire:click="generateReport">
                                    <div wire:loading.remove wire:target="generateReport">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                        </svg>
                                        Generate Report
                                    </div>
                                    <div wire:loading wire:target="generateReport">
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Report Generator</h5>
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Report</label>
                            <select class="form-select" wire:model.live="selectedReports" required>
                                <option value="">-- Select report --</option>
                                <option value="multiple_event">Average Report (Multiple Event)</option>
                                <option value="average">Ranking By Judge (Average)</option>
                                <option value="rank">Ranking By Judge (Rank)</option>
                                <option value="criteria">Criteria By Judge</option>
                            </select>
                        </div>
                        <div class="row">
                            @if ($selectedReports == 'multiple_event')
                                <div class="col-lg-12">
                                    @livewire('reports.component.event-average-report')
                                </div>
                            @elseif ($selectedReports == 'average')
                                <div class="col-lg-12">
                                    @livewire('reports.component.event-ranking-by-judge')
                                </div>
                            @elseif ($selectedReports == 'rank')
                                <div class="col-lg-12">
                                    @livewire('reports.component.event-ranking-by-rank')
                                </div>
                            @elseif ($selectedReports == 'criteria')
                                <div class="col-lg-12">
                                    @livewire('reports.component.event-criteria-by-judge')
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="reportModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Report
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($base64pdf)
                        <iframe src="data:application/pdf;base64,{{ $base64pdf }}" width="100%" height="600" type="application/pdf" frameborder="0"></iframe>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        window.addEventListener('openModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('reportModal'));
            myModal.show();
        });
    </script>
@endscript
