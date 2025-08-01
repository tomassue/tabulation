@extends('layouts.app')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Database Import/Export</h1>
    </div><!-- End Page Title -->

    @livewire('settings.db-import-export')

</main>
@endsection