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
        
        <div class="top">フォロー一覧</div>
        
        <div style="width:80%; margin:0 auto;">
          <br/>
          <div style="text-align:center">
            <a href="/users/{{$user->id}}/profile">{{$user->name}}</a>  
          </div>
            
            <br/>
            @if(is_null($followingUsers) or count($followingUsers) == 0)
            <div style="text-align:center">フォローしているユーザーがいません。</div>
            @else
            <table border="1" style="border-collapse: collapse; margin:0 auto;">
                @foreach($followingUsers as $followingUser)
                    <tr><td><a href="/users/{{$followingUser->id}}/profile">{{$followingUser->name}}</a></th></tr>
                @endforeach
            </table>
            @endif
            
            
            
            
        </div>
        
        
      
    </body>
</html>
