@extends('layouts.app')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Modules</h1>
    </div><!-- End Page Title -->

    @livewire('settings.modules')

</main>
@endsection