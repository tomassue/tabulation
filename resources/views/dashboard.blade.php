@extends('layouts.app')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
    </div>

    <section class="section dashboard">
        <div class="row justify-content-center"> <!-- Center all cards -->
            <div class="col-12">
                <h5 class="fw-bold text-primary mb-3">Progress Rate</h5>
            </div>

            <!-- Quiz Card -->
            <div class="col-xxl-4 col-md-6 mb-4">
                <div class="card info-card text-center py-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Quiz | Progress</h5>
                        <div class="d-flex justify-content-center">
                            <div id="quizChart" style="width: 120px; height: 120px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Oratorical Card -->
            <div class="col-xxl-4 col-md-6 mb-4">
                <div class="card info-card text-center py-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Oratorical | Progress</h5>
                        <div class="d-flex justify-content-center">
                            <div id="oratoricalChart" style="width: 120px; height: 120px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Poster Card -->
            <div class="col-xxl-4 col-md-6 mb-4">
                <div class="card info-card text-center py-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Poster | Progress</h5>
                        <div class="d-flex justify-content-center">
                            <div id="posterChart" style="width: 120px; height: 120px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="fw-bold text-primary mb-3">Top Scores</h5>
                </div>

                <div class="col-xxl-4 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold mb-3">Quiz <span class="text-muted fs-6">| Top 3</span></h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center">
                                    <span class="badge bg-warning text-dark rounded-circle me-3" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">1</span>
                                    <div>
                                        <div class="fw-semibold">Sir Bong</div>
                                        <div class="text-muted small">98 pts</div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <span class="badge bg-secondary rounded-circle me-3" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">2</span>
                                    <div>
                                        <div class="fw-semibold">Sir Mike</div>
                                        <div class="text-muted small">95 pts</div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <span class="badge bg-warning text-dark rounded-circle me-3" style="background-color: #cd7f32 !important;">3</span>
                                    <div>
                                        <div class="fw-semibold">Ma'am Willou</div>
                                        <div class="text-muted small">93 pts</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-success fw-bold mb-3">Oratorical <span class="text-muted fs-6">| Top 3</span></h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center">
                                    <span class="badge bg-warning text-dark rounded-circle me-3" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">1</span>
                                    <div>
                                        <div class="fw-semibold">Sir Bong</div>
                                        <div class="text-muted small">98 pts</div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <span class="badge bg-secondary rounded-circle me-3" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">2</span>
                                    <div>
                                        <div class="fw-semibold">Sir Mike</div>
                                        <div class="text-muted small">95 pts</div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <span class="badge bg-warning text-dark rounded-circle me-3" style="background-color: #cd7f32 !important;">3</span>
                                    <div>
                                        <div class="fw-semibold">Ma'am Willou</div>
                                        <div class="text-muted small">93 pts</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-danger fw-bold mb-3">Poster <span class="text-muted fs-6">| Top 3</span></h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center">
                                    <span class="badge bg-warning text-dark rounded-circle me-3" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">1</span>
                                    <div>
                                        <div class="fw-semibold">Sir Bong</div>
                                        <div class="text-muted small">98 pts</div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <span class="badge bg-secondary rounded-circle me-3" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">2</span>
                                    <div>
                                        <div class="fw-semibold">Sir Mike</div>
                                        <div class="text-muted small">95 pts</div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <span class="badge bg-warning text-dark rounded-circle me-3" style="background-color: #cd7f32 !important;">3</span>
                                    <div>
                                        <div class="fw-semibold">Ma'am Willou</div>
                                        <div class="text-muted small">93 pts</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="fw-bold text-primary mb-3">Judges Completion Rate</h5>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title text-secondary mb-2">Quiz</h6>
                            <div class="progress mb-2" style="height: 20px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                    80%
                                </div>
                            </div>
                            <div class="text-muted small">1 of 3 judges completed</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title text-secondary mb-2">Oratorical</h6>
                            <div class="progress mb-2" style="height: 20px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                    100%
                                </div>
                            </div>
                            <div class="text-muted small">1 of 3 judges completed</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title text-secondary mb-2">Poster</h6>
                            <div class="progress mb-2" style="height: 20px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                    60%
                                </div>
                            </div>
                            <div class="text-muted small">1 of 3 judges completed</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
@endsection

<style>
    .card.info-card {
        min-height: 250px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        border-radius: 1rem;
    }
</style>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const makeDonut = (elementId, value, color = '#0d6efd') => {
            echarts.init(document.getElementById(elementId)).setOption({
                series: [{
                    type: 'pie',
                    radius: ['70%', '90%'],
                    avoidLabelOverlap: false,
                    silent: true,
                    label: {
                        show: true,
                        position: 'center',
                        formatter: `${value}%`,
                        fontSize: 18,
                        fontWeight: 'bold',
                        color: '#333'
                    },
                    data: [{
                            value: value,
                            name: 'Used',
                            itemStyle: {
                                color
                            }
                        },
                        {
                            value: 100 - value,
                            name: 'Remaining',
                            itemStyle: {
                                color: '#e9ecef'
                            }
                        }
                    ]
                }]
            });
        };

        makeDonut("quizChart", 90);
        makeDonut("oratoricalChart", 100);
        makeDonut("posterChart", 99);
    });
</script>