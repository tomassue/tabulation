@extends('layouts.app')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Float Competition</h1>
        </div><!-- End Page Title -->

        @livewire('higalaay', ['type' => 'float', 'winner' => 3])

    </main>
@endsection
