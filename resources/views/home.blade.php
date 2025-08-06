@extends('layouts.app')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">

    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row justify-content-center">
            <!-- Left side columns -->
            <div class="col-lg-8">
                @livewire('home')
            </div>
            <!-- End Left side columns -->
        </div>
    </section>
</main>
@endsection