@extends('layout.master')

@section('content')

<div>
    <form action="{{ url('upload') }}" method="post" enctype="multipart/form-data">
        <label>
            <input name="datei" type="file" size="50"> 
        </label>  
        <button>… und ab geht die Post!</button>
    </form>

</div>

@endsection
