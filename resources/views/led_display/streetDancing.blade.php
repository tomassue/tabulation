<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <title>Street Dancing</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: #fffbf1;
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
            opacity: 0.1;
            /* adjust opacity 0 → 1 */
            z-index: -1;
            /* keeps it behind content */
        }

        .logo {
            height: 250px;
            margin-top: 2%;
            /* adjust size here */
        }

        .rise-logo {
            height: 180px;
            /* adjust only this */
        }

        .higalaay-logo {
            height: 300px;
        }

        .footer-logo {
            position: fixed;
            bottom: 0;
            height: 250px;
            width: auto;
            z-index: 1000;
        }

        .footer-left {
            left: 0;
        }

        .footer-right {
            right: 0;
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

        .card {
            background-color: #a0a0a021;
            border: none;
        }
    </style>
</head>

<body>

    {{-- <!-- Top Left -->
    <img src="{{ asset('img/confettil.png') }}" class="corner-img position-fixed" style="top: 10px; left: 10px;">

    <!-- Top Right -->
    <img src="{{ asset('img/confettir.png') }}" class="corner-img position-fixed" style="top: 10px; right: 10px;"> --}}

    @if ($participants && $participants->count() > 0)

        <div class="wrapper">
            @for ($i = 0; $i < 150; $i++)
                <div class="confetti"
                    style="
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

    @endif


    <div class="container-fluid">
        <div class="content">
            @php
                $image = ['img/grandchamp.png', 'img/1runner-up.png', 'img/2runner-up.png'];

            @endphp
            @if (isset($position) && $position && $position != null)
                @php
                    $position = $position - 1;
                    $image = [$image[$position]];

                @endphp
            @endif


            <div class="row">
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <img src="{{ asset('img/cdo-seal.png') }}" alt="CDO Seal" class="img-fluid logo">
                    <img src="{{ asset('img/logo1.png') }}" alt="Logo 1" class="img-fluid logo">
                    <img src="{{ asset('img/higalaay2025.gif') }}" alt="Higalaay 2025"
                        class="img-fluid logo higalaay-logo">
                    <img src="{{ asset('img/risedako.png') }}" alt="Rise Big" class="img-fluid logo rise-logo">
                </div>
            </div>
            {{-- <div class="row mt-2">
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <img src="{{ asset('img/congrats.png') }}" alt="CDO Seal" class="img-fluid logo"
                        style="height: 90px; width: auto;">
                </div>
            </div> --}}



            <div class="row mt-3">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="container-fluid">

                        <div style="height: 100%;">
                            @foreach ($participants as $index => $item)
                                <div class="row mt-2">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <img src="{{ $image[$index] }}" alt="CDO Seal" class="img-fluid logo"
                                            style="height: 130px; width: auto;">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <div class="col-md-10 d-flex flex-column justify-content-center align-items-center rounded"
                                        style="min-height: 200px; text-align: center;">

                                        <div class="fw-bold"
                                            style="font-size: 11rem; color: #033A62; line-height:240px; font-family: 'Anton'; text-shadow: 8px 8px #c4c1c1;">
                                            {{ $item->participant }}
                                        </div>


                                    </div>
                                </div>
                            @endforeach
                        </div>



                    </div>
                </div>
            </div>

            <img src="{{ asset('img/footer-left.png') }}" alt="CDO Seal" class="img-fluid footer-logo footer-left">

            <img src="{{ asset('img/footer-right.png') }}" alt="CDO Seal" class="img-fluid footer-logo footer-right">

        </div>
    </div>


</body>

</html>
