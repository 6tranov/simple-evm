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
        
        <div class="top">フォロー申請済み一覧</div>
        
        <div style="width:80%; margin:0 auto;">
            
            <br/>
            @if(is_null($users) or count($users) == 0)
            <div style="text-align:center">フォロー申請はしていません。</div>
            @else
            <table border="1" style="border-collapse: collapse; margin:0 auto;">
                @foreach($users as $user)
                    <tr>
                      <td><a href="/users/{{$user->id}}/profile">{{$user->name}}</a></td>
                      <td>
                        <form method="POST" action="/follows/application">
                          @csrf
                          @method('DELETE')
                          <input type="hidden" name="followed_id" value="{{$user->id}}">
                          <input type="submit" value="申請を取り消す">
                        </form>
                      </td>
                    </tr>
                @endforeach
            </table>
            @endif
            
        </div>
      
    </body>
</html>
