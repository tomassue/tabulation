@extends('layouts.app')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Best Band Majorette</h1>
        </div><!-- End Page Title -->

        @livewire('higalaay', ['type' => 'majorette', 'winner' => 1])

    </main>
@endsection
