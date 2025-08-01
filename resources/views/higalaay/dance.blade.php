@extends('layouts.app')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dance Competition</h1>
    </div><!-- End Page Title -->

    @livewire('higalaay', ['type' => 'dance'])

</main>
@endsection