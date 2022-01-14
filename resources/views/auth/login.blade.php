@extends('main.main')

@section('content')
    @php
        use App\Core\Session\Session;
    @endphp
    <div class="container">
        <div class="row vh-100  align-content-center">
            @if(Session::getFlashed('authError') !== null)
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{Session::getFlashed('authError')[0] }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div class="col-12 text-center">
                <h1>Calendar</h1>
            </div>
            <div class="col-6 mx-auto">
                <form action="login" method="POST">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" class="form-control" placeholder="email">
                            @if ($session::getFlashed('errors') !== null && isset(Session::getFlashed('errors')['email']) )
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
                            @if (Session::getFlashed('errors') !== null && isset(Session::getFlashed('errors')['password']))
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
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <div class="col-md-8 col-12 text-end my-auto  mb-3">
                            <a href="{{$authFacebookUri}}" class="btn fb connect">Continue With Facebook</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

