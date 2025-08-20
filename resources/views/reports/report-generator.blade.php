@extends('layouts.app')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Report Generator</h1>
    </div><!-- End Page Title -->

    @livewire('reports.report-generator')

</main>
@endsection