@extends('main.main')

@section('content')
    <div class="container">
        <div class="row vh-100  align-content-center">
            <div class="col-12 text-center">
                <h1>Create User</h1>
            </div>
            <div x-data="createUser()" class="col-6 mx-auto">
                <form>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input x-model="first_name" id="first_name" type="text" name="name" class="form-control"
                                   placeholder="First Name">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input x-model="last_name" id="last_name" type="text" name="last_name" class="form-control"
                                   placeholder="Last Name">
                        </div>

                        <div class="col-12 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input x-model="email" id="email" type="email" name="email" class="form-control"
                                   placeholder="email">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input x-model="password" id="password" type="password" name="password" class="form-control"
                                   placeholder="Password">
                            <small>Password must be at least 8 chars long 1 capital letter 1 small letter and 1
                                number</small>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select x-model="role" name="role" id="role" class="form-control">
                                <option disabled value="Role">Role</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                                <option value="6">New</option>
                            </select>
                        </div>
                        <div class="col-4  mb-3">
                            <button @click.prevent="submitUser()" type="submit"
                                    class="btn btn-success">Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection