@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>{{ $message }}</h3>
                <h4>{{ $file }}</h4>
                <h5>{{ $line }}</h5>
            </div>
        </div>
    </div>
@endsection