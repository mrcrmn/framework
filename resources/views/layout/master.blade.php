<!DOCTYPE html>
<html>
    
    @include('layout.head')

    <body>
        <div id="app">
            
            @yield('content')
            
            <script src="{{ asset('js/app.js', true) }}"></script>
        </div>
    </body>
</html>