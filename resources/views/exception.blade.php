@extends('layout.master')

@section('content')
    <h1>{{ $message }}</h1>

    <pre>
        @foreach($lines as $line)
            <code>{{ $line }}</code>
        @endforeach
    </pre>

@endsection