@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Hello isn't me you looking for?</p>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

        {{-- <script>
            // Automatically hide the success message after 20 seconds
            setTimeout(function() {
                document.getElementById("success-alert").style.display = "none";
            }, 5000); // 20,000 milliseconds = 20 seconds
        </script> --}}
    @endif


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('adminlte_css')
    @yield('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('js')
    <script>
        console.log('Hi!');
    </script>

    {{-- <script>
        // Automatically hide the success message after 20 seconds
        setTimeout(function() {
            document.getElementById("success-alert").style.display = "none";
        }, 20000); // 20,000 milliseconds = 20 seconds
    </script> --}}

@stop
