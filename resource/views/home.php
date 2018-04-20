@extends('layout.master')

@section('content')

<div>
    <h1>@lang('h1') {{ $var }}</h1>
    <?php $array = array('hallo', 'tschuess'); ?>

    @foreach($array as $var)
        @if(true)
            @include('component')
        @endif
    @endforeach

</div>

@endsection
