@extends('layouts.app')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>User Management</h1>
    </div><!-- End Page Title -->

    @livewire('settings.user-management')

</main>
@endsection