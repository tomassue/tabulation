@extends('layouts.app')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Marching Band</h1>
        </div><!-- End Page Title -->

        @livewire('higalaay', ['type' => 'band', 'winner' => 3])

    </main>
@endsection
