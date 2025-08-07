<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $led?->category }} WINNERS</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body {

        background-color: #f6f6e9;
    }

    h5 {
        color: #004a32;
        font-size: 50px;
    }

    .card1 {
        border-color: #004a32;
        background-color: transparent;
        border: solid;
    }
</style>

<body>
    <div class="card" style="
            background-color: transparent;
            background-image: url('{{ asset('img/bg.png') }}');
            background-repeat: no-repeat;
            background-position: top right;
            background-size: 1000px;
            height: 100vh;">
        <div class="card-header row d-flex justify-content-center border-0">
            <div class="col-md-8 mt-3">
                <h1 class="text-center text-uppercase" style="font-family:cursive;font-size: 40pt;color: #EE4B2B">{{ $led?->category }} WINNERS</h1>
            </div>
        </div>
        <div class="card-body d-flex align-items-center justify-content-center">
            <div class="container">
                @php
                    $image = ['img/1st.png', 'img/2nd.png', 'img/3rd.png'];
                    $color = ['#ebba64', '#aaaaaa', '#5d412d'];
                    $font = ['70px', '60px', '50px'];
                @endphp
                @if (isset($position) && $position && $position != null)
                    @php
                        $position = $position - 1;
                        $image = [$image[$position]];
                        $font = [$font[$position]];
                        $color = [$color[$position]];
                    @endphp
                @endif
                <div style="height: 100%;">
                    @foreach ($participants as $index => $item)
                        <div class="row mb-3 justify-content-center align-items-center bg-white rounded" style="min-height: 200px;">
                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                <img src="{{ $image[$index] }}" class="img-fluid" style="max-height: 120px;" alt="1st Place">
                            </div>
                            <div class="col-md-10 d-flex align-items-center">
                                <div class="col-md-2 fw-bold" style="font-size: {{ $font[$index] }}; color:{{ $color[$index] }};">
                                    #{{ $item->participant_no }}
                                </div>
                                <div class="col-md-8 fw-bold" style="font-size: {{ $font[$index] }}; color:{{ $color[$index] }};">
                                    <div style="color: {{ $color[$index] }}; text-decoration: none; font-size: {{ $font[$index] }};">
                                        <i>{{ $item->participant }}</i>
                                    </div>
                                </div>
                                <div class="col fw-bold" style="font-size: {{ $font[$index] }}; color:{{ $color[$index] }};">
                                    {{ bong_format($item->averageOral()) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>

</html>
