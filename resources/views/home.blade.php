@extends('layout.master')

@section('content')

<div>
    <h1>{{ $text }}</h1>  
    <p>bla</p>
    @if (true && false)
    <form action="{{ url('upload', array('dito' => 'peter')) }}" method="post" enctype="multipart/form-data">
        <label>
            <input name="datei" type="file" size="50">   
        </label>  
        <button>… und ab geht die Post!</button>
    </form>
    @elseif (true)
        @foreach(array('hallo' ,'tschüß', 'peter') as $bla => $test) {{ $test }} @endforeach

    @endif
</div>

@endsection
