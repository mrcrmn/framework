@extends('layout.master')

@section('content')

<div>
    <h1>Hallo {{ $product }}</h1>

    @include('component')

</div>

@endsection
