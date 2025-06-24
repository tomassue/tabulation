@extends('layouts.app')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Quiz</h1>
    </div><!-- End Page Title -->

     @livewire('quiz')

</main>
@endsection