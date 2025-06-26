    <section class="section quiz">
        <div class="row">
            <div class="col-lg-12">
                <!-- Table Card -->
                <div class="card" wire:loading.class="opacity-50 pe-none">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="">SCORE TABLE</h5>
                            <button class="btn btn-primary" wire:click="generateReport">
                                <div wire:loading.remove wire:target="generateReport">Export PDF</div>
                                <div wire:loading wire:target="generateReport">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="row d-flex justify-content-center mb-3">
                            <div class="col-md-6">
                                <input type="search" wire:model.live="search" list="datalistOptions" name="search" id="search" class="form-control" placeholder="Search participant....">
                                <datalist id="datalistOptions">
                                    @foreach ($part as $item)
                                    <option value="{{$item->participant}}">
                                        @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="table-container">
                            <table class="table table-hover fixed-column-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center bg-secondary text-white">Participant</th>
                                        <th colspan="10" class="text-center bg-primary text-white">ROUND 1</th>
                                        <th class="text-center bg-primary text-white">SUB TOTAL</th>
                                        <th colspan="10" class="text-center bg-warning text-white">ROUND 2</th>
                                        <th class="text-center bg-warning text-white">SUB TOTAL</th>
                                        <th colspan="5" class="text-center bg-danger text-white">ROUND 3</th>
                                        <th class="text-center bg-danger text-white">SUB TOTAL</th>
                                        <th colspan="5" class="text-center bg-dark text-white">CLINCHER</th>
                                        <th class="text-center bg-dark text-white">SUB TOTAL</th>
                                        <th class="bg-success text-white text-center">GRAND TOTAL</th>
                                        <th class="bg-info text-white text-center">COMPLETE %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($participants as $item)
                                    <tr>
                                        <td scope="row">{{$item->school}}</td>
                                        @for ($i = 1; $i <= 10; $i++)
                                            @php
                                            $score=\App\Models\QuizBee::where('participant_id', $item->id)->where('round_id', '1')->where('question_number', $i)->first();
                                            @endphp
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-primary text-white">Q{{$i}}</span>
                                                    <input type="number" max="1" wire:change="saveScore({{$item->id}}, '1', {{$i}}, $event.target.value)" class="form-control" value="{{ $score ? $score->score : '' }}" placeholder="Enter score" />
                                                </div>
                                            </td>
                                            @endfor
                                            <td class="text-end">{{$item->sumRound1()}}</td>
                                            @for ($i = 1; $i <= 10; $i++)
                                                @php
                                                $score=\App\Models\QuizBee::where('participant_id', $item->id)->where('round_id', '2')->where('question_number', $i)->first();
                                                @endphp
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-warning text-white">Q{{$i}}</span>
                                                        <input type="number" wire:change="saveScore({{$item->id}}, '2', {{$i}}, $event.target.value)" class="form-control" value="{{ $score ? $score->score : '' }}" placeholder="Enter score" />
                                                    </div>
                                                </td>
                                                @endfor
                                                <td class="text-end">{{$item->sumRound2()}}</td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @php
                                                    $score=\App\Models\QuizBee::where('participant_id', $item->id)->where('round_id', '3')->where('question_number', $i)->first();
                                                    @endphp
                                                    <td>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-danger text-white">Q{{$i}}</span>
                                                            <input type="number" wire:change="saveScore({{$item->id}}, '3', {{$i}}, $event.target.value)" class="form-control" value="{{ $score ? $score->score : '' }}" placeholder="Enter score" />
                                                        </div>
                                                    </td>
                                                    @endfor
                                                    <td class="text-end">{{$item->sumRound3()}}</td>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @php
                                                        $score=\App\Models\QuizBee::where('participant_id', $item->id)->where('round_id', '4')->where('question_number', $i)->first();
                                                        @endphp
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-dark text-white">C{{$i}}</span>
                                                                <input type="number" wire:change="saveScore({{$item->id}}, '4', {{$i}}, $event.target.value)" class="form-control" value="{{ $score ? $score->score : '' }}" placeholder="Enter score" />
                                                            </div>
                                                        </td>
                                                        @endfor
                                                        <td class="text-end">{{$item->sumRound4()}}</td>
                                                        <td class="text-end">{{$item->sumAll()}}</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-success" style="width: {{$item->getPercent()}}%"></div>
                                                            </div>
                                                            <small> {{$item->getPercent()}}%</small>
                                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Body -->
        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
        <div class="modal fade" id="reportModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
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
    </section>
    @assets
    <style>
        .table-container {
            position: relative;
            overflow: auto;
        }

        .fixed-column-table {
            min-width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .fixed-column-table th,
        .fixed-column-table td {
            vertical-align: middle;
            border-top: 1px solid #e0e0e0;
        }

        .fixed-column-table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            font-weight: 600;
            border: none;
        }

        .fixed-column-table tbody tr:nth-child(even) {
            background-color: rgba(67, 97, 238, 0.03);
        }

        .fixed-column-table tbody tr:hover {
            background-color: rgba(76, 201, 240, 0.08);
            transition: background-color 0.3s;
        }

        /* Fixed first column */
        .fixed-column-table th:first-child,
        .fixed-column-table td:first-child {
            position: sticky;
            left: 0;
            z-index: 5;
            min-width: 180px;
            font-weight: 600;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Scrollable columns */
        .fixed-column-table th:not(:first-child),
        .fixed-column-table td:not(:first-child) {
            min-width: 200px;
        }

        /* Fixed last column */
        .fixed-column-table th:last-child,
        .fixed-column-table td:last-child {
            position: sticky;
            right: 0;
            z-index: 5;
            min-width: 160px;
            background-color: white;
            /* Ensure it's not transparent */
            box-shadow: -3px 0 10px rgba(0, 0, 0, 0.05);
            /* Optional for subtle separation */
        }

        /* Status badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge-active {
            background: linear-gradient(90deg, #4ade80, #22c55e);
            color: white;
        }

        .badge-pending {
            background: linear-gradient(90deg, #fcd34d, #f59e0b);
            color: white;
        }

        .badge-completed {
            background: linear-gradient(90deg, #60a5fa, #3b82f6);
            color: white;
        }

        .progress {
            height: 10px;
            border-radius: 5px;
        }

        .scroll-hint {
            background: var(--primary-color);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            margin-top: 15px;
            font-size: 0.9rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 0.8;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.8;
            }
        }

        .features {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .feature-card {
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .footer {
            text-align: center;
            padding: 25px;
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {

            .fixed-column-table th,
            .fixed-column-table td {
                padding: 12px 15px;
                font-size: 0.9rem;
            }

            .fixed-column-table th:first-child,
            .fixed-column-table td:first-child {
                min-width: 150px;
            }

            .header h1 {
                font-size: 1.8rem;
            }
        }
    </style>
    @endassets
    @script
    <script>
        window.addEventListener('openModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('reportModal'));
            myModal.show();
        });
    </script>
    @endscript