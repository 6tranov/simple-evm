<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
        
            
        <div id="appDraggable">
            
            <draggable :options="{animation: 200}" :move="onmove" @start="onstart" @add="onadd" @remove="onremove" @update="onupdate" @end="onend" @choose="onchoose" @sort="onsort" @filter="onfilter" @clone="onclone">
                <p>A<input type="hidden" name="order[]" value="1"></p>
                <p>B<input type="hidden" name="order[]" value="2"></p>
                <p>C<input type="hidden" name="order[]" value="3"></p>
                <p>D<input type="hidden" name="order[]" value="4"></p>
            </draggable>
            <br/>
            <draggable :options="{animation: 200}" :move="onmove" @start="onstart" @add="onadd" @remove="onremove" @update="onupdate" @end="onend" @choose="onchoose" @sort="onsort" @filter="onfilter" @clone="onclone">
                <p>A<input type="hidden" name="order[]" value="5"></p>
                <p>B<input type="hidden" name="order[]" value="6"></p>
                <p>C<input type="hidden" name="order[]" value="7"></p>
                <p>D<input type="hidden" name="order[]" value="8"></p>
            </draggable>
        </div>
        
            
        <script src="{{mix('js/app.js')}}"></script>
    </body>
</html>
