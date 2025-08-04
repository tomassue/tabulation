@extends('layouts.app')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ $category->description }}</h1>
        </div><!-- End Page Title -->

        @livewire('higalaay', ['type' => $category->category, 'winner' => $category->winners])

    </main>
@endsection
