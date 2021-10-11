<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
        <!-- Styles -->
        <style>
          .body{
            margin:0px;
          }
          
            .top{
                border:solid;
              text-align:center;
            }
          
        </style>
    </head>
    <body class="body">
        
        <div class="top">フォロワー一覧</div>
        
        <div style="width:80%; margin:0 auto;">
            
          <br/>
          <div style="text-align:center">
            <a href="/users/{{$user->id}}/profile">{{$user->name}}</a>  
          </div>
          
            <br/>
            @if(is_null($followers) or count($followers) == 0)
            <div style="text-align:center">フォロワーはいません。</div>
            @else
            <table border="1" style="border-collapse: collapse; margin:0 auto;">
                @foreach($followers as $follower)
                    <tr><td><a href="/users/{{$follower->id}}/profile">{{$follower->name}}</a></th></tr>
                @endforeach
            </table>
            @endif
            
            
            
            
        </div>
        
        
      
    </body>
</html>
