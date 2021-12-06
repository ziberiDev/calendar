@extends('main.main')

@section('content')
    @php
        use App\Core\Session\Session;
    @endphp
    <div class="container">

        <div class="row vh-100  align-content-center">
            @if(Session::get('authError') !== null)
                <div class="col-12">
                    <div class="alert alert-danger" role="alert">
                        {{Session::get('authError')[0] }}
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
                            @if (Session::get('errors') !== null && isset(Session::get('errors')['email']) )
                                @foreach(Session::get('errors')['email'] as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                        </div>
                        <div class="col-12 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" name="password" class="form-control"
                                   placeholder="Password">
                            @if (Session::get('errors') !== null && isset(Session::get('errors')['password']))
                                @foreach(Session::get('errors')['password'] as $message)
                                    {{$message}}
                                @endforeach
                            @endif
                        </div>
                        <div class="col-4  mb-3">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <div class="col-8 text-end my-auto  mb-3">
                            <a href="register"><small> Dont have an account yet? Please register here.</small></a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

