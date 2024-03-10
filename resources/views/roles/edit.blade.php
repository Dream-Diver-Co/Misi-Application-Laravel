@extends('adminlte::page')
@section('content')
    <div class="content-wraper">


        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Role</h2>
                </div>
                {{-- <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                </div> --}}
            </div>
        </div>


        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {!! Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id]]) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Permission:</strong>
                    <br />
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <br />
                    <?php //dd($permission);
                    ?>




                    <div class="row">

                        @foreach ($permission->chunk(30) as $value)
                            <div class="column col-md-3">
                                @foreach ($value as $item)
                                    <div class="item">

                                        <input type="checkbox" name="permission[]" class="name"
                                            value="{{ $item->id }}" <?php echo in_array($item->id, $rolePermissions) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">{{ $item->name }}</label>


                                    </div>
                                @endforeach
                            </div>

                            <br />
                        @endforeach


                    </div>


                </div>
            </div>
            {{-- <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div> --}}
        </div>
        {!! Form::close() !!}

    </div>
@endsection
