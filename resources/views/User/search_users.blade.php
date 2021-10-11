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
            <div style="text-align:right">
                <a href="/" style="border:solid; border-color:black;">ホーム</a>
            </div>
            
            <br/>
            <div style="text-align:center">
              検索方法
          </div>
          
          <div style="text-align:center">
              <form method="GET" action="/users/search">
                <div style="display:inline-block;text-align:left;">
                  <input type="radio" id="id" name="for" value="id" {{$for=='id' ? "checked='checked'" : ""}}/><label for="id">id</label><br/>
                  <input type="radio" id="name" name="for" value="name" {{$for=='name' ? "checked='checked'" : ""}}/><label for="name">ユーザーネーム</label><br/>
                  <input type="radio" id="bio" name="for" value="bio" {{$for=='bio' ? "checked='checked'" : ""}}/><label for="bio">bio</label><br/>
                </div>
                
                <br/>
                <br/>
                <input type="search" name="query" value="{{$query}}">
                <br/>
                <br/>
                <input type="submit" value="検索"><br/><br/>
              </form>
          </div>
            
          @if(is_null($users) || count($users)==0)
          <div style="text-align:center">
            該当するユーザーはいません。
          </div>
          @else
              <table border="1" style="border-collapse:collapse;" align="center">
                <tr>
                  <th>name</th><th>bio</th>
                </tr>
                @foreach($users as $user)
                <tr>
                  <td><a href="users/{{$user->id}}/profile">{{$user->name}}</a></td><td>{{$user->biography}}</td>
                </tr>  
                @endforeach
              </table>
          @endif
          
        </div>
        
    </body>
</html>
