@extends('adminlte::page')

@section('content')
    <div class="container mt-5">
        <div class="text-center">
            <h1>User Information</h1>
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



        {{-- {!! Form::open(['route' => 'users.store', 'method' => 'POST']) !!}
        <div class="row mt-5">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Password:</strong>
                    {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-xs-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Role:</strong>
                            {!! Form::select('roles[]', $roles, [], ['class' => 'form-control', 'multiple']) !!}
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-12 col-md-4 text-center align-self-center">
                        <div class="d-flex flex-direction-row">
                            <a class="btn btn-info mr-2" href="{{ route('users.index') }}"> Back</a>
                            <button type="submit" class="btn btn-primary ml-2">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!} --}}


        <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" id="create-user-form">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" class="form-control" name="name"
                            value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="first_name">Email:</label>
                        <input type="email" id="email" class="form-control" name="email"
                            value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth:</label>
                        @php
                            $config = ['format' => 'DD-MM-YYYY'];
                        @endphp
                        <x-adminlte-input-date name="dob" :config="$config" placeholder="Choose a date..."
                            id="dob" :value="$user->date_of_birth">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-gradient-primary">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $user->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="user_name">User Name:</label>
                        <input type="text" id="user_name" class="form-control" name="user_name"
                            value="{{ $user->user_name }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" class="form-control" name="phone"
                            value="{{ $user->phone }}">
                    </div>
                    <div class="form-group">
                        <label for="sex">Sex:</label>
                        <select name="sex" id="sex" class="form-control">
                            <option value="Male" {{ $user->status == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $user->status == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ $user->status == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="marital_status">Marital status:</label>
                        <select name="marital_status" id="marital_status" class="form-control">
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorceed">divorced</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="roles">Select Group:</label>
                        <select class="form-control selectpicker" id="roles" name="roles[]" multiple
                            data-live-search="true">
                            @foreach ($roles as $role)
                                @php
                                    $roleName = $role->name;
                                    $suggested_array = json_decode($assignedRoles) ?? [];
                                    $isSelected = in_array($roleName, $suggested_array);
                                @endphp
                                <option value="{{ $role->name }}" {{ $isSelected ? 'selected' : '' }}>
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>



                </div>

            </div>
            <div class="d-flex justify-content-end align-items-center mt-5">
                <button type="submit" class="btn btn-success w-25">Save</button>
            </div>
        </form>
    </div>

@endsection

@section('js')
    <script>
        // submit form
        $(document).ready(function() {
            $('#create-user-form').submit(function(event) {
                event.preventDefault(); // Prevent form submission

                var formData = $(this).serialize(); // Serialize form data
                // console.log(formData);

                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                        // Toast.fire({
                        //     icon: 'success',
                        //     title: 'Patient succesfully created'
                        // });
                        Swal.fire('Success!', 'Request successful', 'success');

                    },
                    error: function(xhr) {
                        // Handle error response
                        console.log(xhr.responseText);
                        // Toast.fire({
                        //     icon: 'error',
                        //     title: 'Patient not created'
                        // });
                        Swal.fire('Error!', 'Request failed', 'error');
                    }
                });
            });
        });
    </script>
@stop
