@extends('adminlte::page')
@section('content')
    <div class="">
        {{-- <h1>Roles Management</h1> --}}
        <div class="pull-right mt-5">
            <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
        </div>
        <div class="mt-2">
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
