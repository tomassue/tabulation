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

</style>


<body>

   <div class="container">
    <div class="row mb-4">
        <div class="col text-center">
            <img src="{{ asset('img/text.png') }}" class="img-fluid" alt="Logo">
        </div>
    </div>

    <div class="row mb-3 justify-content-center align-items-center">
        <div class="col-md-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('img/1st.png') }}" class="img-fluid" style="max-height: 120px;" alt="1st Place">
        </div>
        <div class="col-md-4 d-flex align-items-center">
            <div class="fw-bold" style="font-size: 50px;">
                <i>Jevonie Villarin</i>
            </div>
        </div>
    </div>

    <div class="row mb-3 justify-content-center align-items-center">
        <div class="col-md-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('img/2nd.png') }}" class="img-fluid" style="max-height: 120px;" alt="2nd Place">
        </div>
        <div class="col-md-4 d-flex align-items-center">
            <div class="fw-bold" style="font-size: 40px;">
                <i>Rustom Abella</i>
            </div>
        </div>
    </div>

    <div class="row mb-3 justify-content-center align-items-center">
        <div class="col-md-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('img/3rd.png') }}" class="img-fluid" style="max-height: 120px;" alt="3rd Place">
        </div>
        <div class="col-md-4 d-flex align-items-center">
            <div class="fw-bold" style="font-size: 30px;">
                <i>Mike Jun R. Zaballero</i>
            </div>
        </div>
    </div>
</div>






    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
