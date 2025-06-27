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
            @php
            $color = [
            '#ebba64',
            '#aaaaaa',
            '#5d412d',
            ];
            $width = [
            'width: 48px; height: 48px;',
            'width: 40px; height: 40px;',
            'width: 36px; height: 36px;',
            ];
            $font = [
            '1.25rem',
            '1rem',
            '0.9rem',
            ]
            @endphp
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="fw-bold text-primary mb-3">Top Scores</h5>
                </div>

                <div class="col-xxl-4 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold mb-3">Quiz <span class="text-muted fs-6">| Top 3</span></h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($topQuiz as $index => $item)
                                <li class="list-group-item d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle"
                                        style="background-color: {{$color[$index]}}; {{ $width[$index] }} font-size: {{$font[$index]}};">
                                        <strong>{{$loop->iteration}}</strong>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{$item->school}}</div>
                                        <div class="text-muted small">{{$item->total_score ?? 0}} pts</div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold mb-3">Oratorical <span class="text-muted fs-6">| Top 3</span></h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($topOral as $index => $item)
                                <li class="list-group-item d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle"
                                        style="background-color: {{$color[$index]}}; {{ $width[$index] }} font-size: {{$font[$index]}};">
                                        <strong>{{$loop->iteration}}</strong>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{$item->participant}}</div>
                                        <div class="text-muted small">{{bong_format($item->averageOral())}} pts</div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold mb-3">Poster <span class="text-muted fs-6">| Top 3</span></h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($topPoster as $index => $item)
                                <li class="list-group-item d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle"
                                        style="background-color: {{$color[$index]}}; {{ $width[$index] }} font-size: {{$font[$index]}};">
                                        <strong>{{$loop->iteration}}</strong>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{$item->participant}}</div>
                                        <div class="text-muted small">{{bong_format($item->averagePoster())}} pts</div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="fw-bold text-primary mb-3">Oratorical Judges Completion Rate</h5>
                </div>
                @php    
                    $oralJudges = $judges->where('category', 'oral');
                @endphp
                @foreach ($oralJudges as $item)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title text-secondary mb-2">{{$item->judge}}</h6>
                            <div class="progress mb-2" style="height: 20px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{$item->getOralPercent()}}%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                    {{$item->getOralPercent()}}%
                                </div>
                            </div>
                            <div class="text-muted small">{{$item->getOralPercent()}}% completed</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="fw-bold text-primary mb-3">Poster Judges Completion Rate</h5>
                </div>
                @php    
                    $posterJudges = $judges->where('category', 'poster');
                @endphp
                @foreach ($posterJudges as $item)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title text-secondary mb-2">{{$item->judge}}</h6>
                            <div class="progress mb-2" style="height: 20px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$item->getPercent()}}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                     {{$item->getPercent()}}%
                                </div>
                            </div>
                            <div class="text-muted small">{{$item->getPercent()}}% completed</div>
                        </div>
                    </div>
                </div>
                @endforeach
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

        makeDonut("quizChart",  {{bong_format($quizProgress)}});
        makeDonut("oratoricalChart", {{bong_format($oralProgress)}});
        makeDonut("posterChart", {{bong_format($posterProgress)}});
    });
</script>