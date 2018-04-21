@extends('layout.master')

@section('content')

<div>
    <h1>@lang('h1') {{ $product['name'] }}</h1>

    @if(true)
        @include('component')
    @endif

</div>

@endsection
