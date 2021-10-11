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
        
        <div class="top">プロフィール</div>
        
        <div style="width:80%; margin:0 auto;">
            <br/>
            <div style="text-align:right">
              <a href="/users/search" style="border:solid; border-color:black;">ユーザー検索</a>
                <a href="/" style="border:solid; border-color:black;">ホーム</a>
            </div>
            
            <br/>
            <div style="text-align:center">
                {{$user->name}}
            </div>
            
            <br/>
            <div style="text-align:center">
                <a href="/users/{{$user->id}}/follows" style="border:solid; border-color:black;">フォロー一覧</a>
            </div>
            
            <br/>
            <div style="text-align:center">
                <a href="/users/{{$user->id}}/followers" style="border:solid; border-color:black;">フォロワー一覧</a>
            </div>
            
            <br/>
            <div style="margin:0 auto; text-align:center; border:solid;  display:table;">
                <div style="border-bottom:solid;">bio</div>
                <div >{{$user->biography}}</div>
            </div>
            
            <br/>
          <div style="text-align:center;">
            @if($isFollowing == true)
              <form method="post" action="/follows">
                @csrf
                @method('DELETE')
                <input type="submit" value="フォロー解除する">
                <input type="hidden" name="followed_id" value="{{$user->id}}">
              </form>
            @else
              <form method="post" action="/follows">
                @csrf
                <input type="submit" value="フォローする">
                <input type="hidden" name="followed_id" value="{{$user->id}}">
              </form>
            @endif
           </div>
        </div>
        
        
      
    </body>
</html>
