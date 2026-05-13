@extends('layouts.app')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ $category->description }}</h1>
        </div><!-- End Page Title -->

        @if($category->tabulation_mode === 'technical')
            @livewire('technical.scoring', ['type' => $category->category, 'winner' => $category->winners])
        @else
            @livewire('higalaay', ['type' => $category->category, 'winner' => $category->winners])
        @endif

    </main>
@endsection
