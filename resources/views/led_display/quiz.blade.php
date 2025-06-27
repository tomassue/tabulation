<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZ BOWL WINNERS</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body{

        background-color: #f6f6e9;
    }

    h5{
        color: #004a32;
        font-size: 50px;
    }

    .card1{
        border-color: #004a32;
        background-color: transparent;
        border: solid;
    }

</style>


<body>
    <div class="card" 
         style="
            background-color: transparent;
            background-image: url('{{ asset('img/bg.png') }}');
            background-repeat: no-repeat;
            background-position: top right;
            background-size: 1000px;
           
        ">
   <div class="container mt-5">
    <div class="row mb-4">
        <div class="col text-center">
            <img src="{{ asset('img/text.png') }}" class="img-fluid" alt="Logo">
        </div>
    </div>

   </div>
   {{-- end of container --}}
    <div class="">
        @php
            $image = [
                'img/1st.png',
                'img/2nd.png',
                'img/3rd.png',
            ];
            $color = [
                '#ebba64',
                '#aaaaaa',
                '#5d412d',
            ];
            $font = [
                '80px',
                '70px',
                '60px',
            ]
        @endphp
        @if (isset($position) && $position  && $position != null)
            @php
                $position = $position - 1;
                $image = [$image[$position]];
                $font = [$font[$position]];
                $color = [$color[$position]];
            @endphp
        @endif
        @foreach ($participants as $index => $item)
            <div class="row mb-3 justify-content-center align-items-center">
                <div class="col-md-2 d-flex align-items-center justify-content-center">
                    <img src="{{ $image[$index] }}" class="img-fluid" style="max-height: 120px;" alt="1st Place">
                </div>
                
                <div class="col-12 col-md-10 d-flex align-items-center">
                    <div class="col-md-10 d-flex align-items-center">
                    <div class="col-md-1 fw-bold" style="font-size: {{$font[$index]}}; color:{{$color[$index]}};">
                    #{{$item->participant_no}} 
                </div>
                <div class="col-md-10 fw-bold" style="font-size: {{$font[$index]}}; color:{{$color[$index]}};">
                     <button type="button" class="btn show-poster fw-bold"
                            data-bs-toggle="modal"
                            data-bs-target="#fullscreenModal{{ $item->id }}"
                            style="color: {{ $color[$index] }}; text-decoration: none; font-size: {{$font[$index]}};">
                        <i>{{ $item->school }}</i>
                    </button>
                </div>
                <div class="col fw-bold" style="font-size: {{$font[$index]}}; color:{{$color[$index]}};">
                   {{bong_format($item->total_score)}}
                </div>
                </div>
            </div>
        @endforeach
    </div>
    
<div class="row my-5 px-5">
    <div class="d-flex justify-content-center align-items-center flex-wrap gap-4">
        <img src="{{ asset('img/cdo-seal.png') }}" alt="Logo 1" class="img-fluid" style="max-height: 150px;">
        <img src="{{ asset('img/seallogo.png') }}" alt="Logo 2" class="img-fluid" style="max-height: 120px;">
        <img src="{{ asset('img/risebig.png') }}" alt="Logo 3" class="img-fluid" style="max-height: 100px;">
        <img src="{{ asset('img/logo1.png') }}" alt="Logo 4" class="img-fluid" style="max-height: 100px;">
        <img src="{{ asset('img/tourismlogo.png') }}" alt="Logo 5" class="img-fluid" style="max-height: 100px;">
        <img src="{{ asset('img/ictlogo.png') }}" alt="Logo 6" class="img-fluid" style="max-height: 100px;">
        <img src="{{ asset('img/kinaadman.png') }}" alt="Logo 6" class="img-fluid" style="max-height: 200px;">
    </div>
</div>


    






    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
