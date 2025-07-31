@extends('layouts.app')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Best in Costume</h1>
        </div><!-- End Page Title -->

        @livewire('higalaay', ['type' => 'costume'])

    </main>
@endsection
