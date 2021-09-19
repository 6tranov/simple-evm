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
          
          .form-area{
            width:90%;
            margin:0 auto;
          }
          
        </style>
    </head>
    <body class="body">
        
        <div class="top">プロジェクト作成</div>
       <br>
      
      <div class="form-area">
      <form action="/projects" method="POST">
            @csrf
              プロジェクト名<br>
                <input type="text" name="project[name]" placeholder="プロジェクト名"/><br><br>
              開始予定日<br>
                <input type="date" name="project[start_scheduled_on]"><br><br>
              完了予定日<br>
              <input type="date" name="project[complete_scheduled_on]"><br><br>
              1日当たりの時間<br>
              <input type="number" name="project[time_per_day]"><br><br>
              タスクの総量(ページ数など)<br>
              <input type="number" name="project[total_cost]"><br><br>
              <div style="text-align:center">
            <input type="submit" value="作成"/>
        </form>
        </div>
      
      <br>
      <div style="text-align:center">
        <a href="/projects" class="back-to-projects">プロジェクト一覧に戻る</a>
      </div>
      
      
      
    </body>
</html>
