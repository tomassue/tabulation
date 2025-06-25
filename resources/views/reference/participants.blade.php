@extends('layouts.app')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Participants</h1>
    </div><!-- End Page Title -->

    @livewire('reference.participants')

</main>
@endsection