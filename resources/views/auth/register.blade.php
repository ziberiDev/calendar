@extends('main.main')

@section('content')
    @php
        use App\Core\Session\Session;
    @endphp
    <div class="container">
        <div class="row vh-100  align-content-center">
            <div class="col-12 text-center">
                <h1>Calendar</h1>
            </div>
            <div class="col-6 mx-auto">
                <form action="register" method="POST">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input id="first_name" type="text" name="name" class="form-control"
                                   placeholder="First Name">
                            @if (Session::getFlashed('errors') !== null && isset(Session::getFlashed('errors')['name']) )
                                @foreach(Session::getFlashed('errors')['name'] as $message)
                                    <div class="alert alert-danger alert-dismissible p-1" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-12 mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input id="last_name" type="text" name="name" class="form-control" placeholder="Last Name">
                            @if (Session::getFlashed('errors') !== null && isset(Session::getFlashed('errors')['last_name']) )
                                @foreach(Session::getFlashed('errors')['last_name'] as $message)
                                    <div class="alert alert-danger alert-dismissible p-1" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="col-12 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" class="form-control" placeholder="email">
                            @if (Session::getFlashed('errors') !== null && isset(Session::getFlashed('errors')['email']) )
                                @foreach(Session::getFlashed('errors')['email'] as $message)
                                    <div class="alert alert-danger alert-dismissible p-1" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-12 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" name="password" class="form-control"
                                   placeholder="Password">
                            <small>Password must be at least 8 chars long 1 capital letter 1 small letter and 1
                                number</small>
                            @if (Session::getFlashed('errors') !== null && isset(Session::getFlashed('errors')['password']) )
                                @foreach(Session::getFlashed('errors')['password'] as $message)
                                    <div class="alert alert-danger alert-dismissible p-1" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-4  mb-3">
                            <button type="submit" class="btn btn-success">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection