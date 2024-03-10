@extends('adminlte::page')
@section('content')
    <div class="pt-5">
        {{-- <h1>User Management</h1> --}}
        <div class="pull-right mt-5">
            <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
        </div>
        <div class="mt-2 datatable-container">
            <x-adminlte-datatable id="table1" :heads="$heads" striped hoverable bordered compressed with-buttons
                beautify>
                @foreach ($config['data'] as $row)
                    <tr>
                        @foreach ($row as $cell)
                            <td>{!! $cell !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@endsection
