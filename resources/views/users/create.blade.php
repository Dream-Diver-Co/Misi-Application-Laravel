@extends('adminlte::page')

@section('content')
    <div class="p-5">
        {{-- <div class="text-center">
            <h1>Create New User</h1>
        </div> --}}


        <form action="{{ route('users.store') }}" method="POST" id="create-user-form" class="">
            @csrf
            <div class="row justify-content-between">
                <div class="col-md-5">
                    <div class="form-group row">
                        <label for="name" class="form-label col-4 text-right">Name:</label>
                        <div class="col-7"><input type="text" id="name" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="first_name" class="form-label col-4 text-right">Email:</label>
                        <div class="col-7"><input type="email" id="email" class="form-control" name="email"></div>
                    </div>
                    <div class="form-group row">
                        <label for="dob" class="form-label col-4 text-right">Date of Birth:</label>
                        @php
                            $config = ['format' => 'DD-MM-YYYY'];
                        @endphp
                        <div class="col-7">
                            <x-adminlte-input-date name="dob" :config="$config" placeholder="Choose a date..."
                                id="dob">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="form-label col-4 text-right">Status:</label>
                        <div class="col-7">
                            <select name="status" id="status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="password" class="form-label col-4 text-right">Password:</label>
                        <div class="col-7"><input type="password" name="password" id="password" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-5">

                    <div class="form-group row">
                        <label for="user_name " class="form-label col-4 text-right">User Name:</label>
                        <div class="col-7"><input type="text" id="user_name" class="form-control" name="user_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="first_name" class="form-label col-4 text-right">Phone:</label>
                        <div class="col-7"><input type="text" id="phone" class="form-control" name="phone"></div>
                    </div>
                    <div class="form-group row">
                        <label for="sex" class="form-label col-4 text-right">Sex:</label>
                        <div class="col-7">
                            <select name="sex" id="sex" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="marital_status" class="form-label col-4 text-right">Marital status:</label>
                        <div class="col-7">
                            <select name="marital_status" id="marital_status" class="form-control">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorceed">divorced</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="roles" class="form-label col-4 text-right">Select Group:</label>
                        <div class="col-7">
                            <select class="form-control selectpicker" id="roles" name="roles[]" multiple
                                data-live-search="true">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>



                </div>

            </div>
            <div class="d-flex justify-content-end align-items-center mt-5">
                <button type="submit" class="btn btn-success w-25">Submit</button>
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
                    type: 'POST',
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
