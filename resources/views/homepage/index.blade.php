@extends('main.main')

@section('content')
    @for($i = 1; $i <=5 ; $i++)
        @php
            echo "<br>";
        @endphp
        @foreach($daysOfWeek as $day)
            {{ $day }}
        @endforeach
    @endfor

@endsection

