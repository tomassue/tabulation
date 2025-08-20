<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Street Dancing</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: #fcf0cf;
            /* fallback color */
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('img/higalaay2025.gif') }}") no-repeat center center fixed;
            background-size: cover;
            opacity: 0.2;
            /* adjust opacity 0 → 1 */
            z-index: -1;
            /* keeps it behind content */
        }

        .logo {
            height: 160px;
            /* adjust size here */
        }

        .container {
            padding-top: 2%;
        }

        .confetti {
            position: absolute;
            top: -10%;
            opacity: 0.9;
            animation-name: fall;
            animation-iteration-count: infinite;
        }

        @keyframes fall {
            to {
                top: 110%;
                transform: translateX(30px) rotate(720deg);
                /* added more drift */
            }
        }

        .corner-img {
            width: 28vw;
            /* 20% of viewport width */
            max-width: 600px;
            /* prevent it from getting too big */
            height: auto;
            z-index: 1;
        }
    </style>
</head>

<body>

    {{-- <!-- Top Left -->
    <img src="{{ asset('img/confettil.png') }}" class="corner-img position-fixed" style="top: 10px; left: 10px;">

    <!-- Top Right -->
    <img src="{{ asset('img/confettir.png') }}" class="corner-img position-fixed" style="top: 10px; right: 10px;"> --}}



    <div class="wrapper">
        @for ($i = 0; $i < 150; $i++)
            <div class="confetti" style="
                left: {{ rand(0, 100) }}%;
                width: {{ rand(10, 16) }}px; 
                height: {{ rand(4, 8) }}px;   
                background-color: {{ collect(['#d13447', '#ffbf00', '#263672'])->random() }};
                animation-duration: {{ rand(4, 7) }}s;
                animation-delay: {{ rand(0, 5) }}s;
                transform: rotate({{ rand(0, 360) }}deg);
             ">
            </div>
        @endfor
    </div>


    <div class="container">
        <div class="content">
            <div class="row">
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <img src="{{ asset('img/cdo-seal.png') }}" alt="CDO Seal" class="img-fluid logo">
                    <img src="{{ asset('img/logo1.png') }}" alt="Logo 1" class="img-fluid logo">
                    <img src="{{ asset('img/higalaay.png') }}" alt="Higalaay 2025" class="img-fluid logo">
                    <img src="{{ asset('img/risedako.png') }}" alt="Rise Big" class="img-fluid logo">
                </div>
            </div>

            <div class="row mt-5">
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
                                        <div class="col-md-7 fw-bold" style="font-size: {{ $font[$index] }}; color:{{ $color[$index] }};">
                                            <div style="color: {{ $color[$index] }}; text-decoration: none; font-size: {{ $font[$index] }};">
                                                <i>{{ $item->participant }}</i>
                                            </div>
                                        </div>
                                        <div class="col fw-bold" style="font-size: {{ $font[$index] }}; color:{{ $color[$index] }};">
                                            {{ bong_format($item->averageHigalaay($led?->category)) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
