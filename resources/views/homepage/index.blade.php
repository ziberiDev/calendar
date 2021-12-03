@extends('main.main')

@section('content')

    <form action="login" method="POST">
        <div class="row">
            <div class="col">
                <input type="email" name="email" class="form-control" placeholder="email">
            </div>
            <div class="col">
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="col">
                <button type="submit" class="bg-primary">Login</button>
            </div>
        </div>
    </form>
  {{--  @isset($errors['email'])
        @foreach($errors['email'] as $message)
            {{$message}}
        @endforeach
    @endisset--}}
@endsection

