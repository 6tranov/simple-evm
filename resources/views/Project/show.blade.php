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
          
            .top-container{
                display:grid;
              grid-template-columns:1fr auto 1fr auto;
              grid-template-areas:
                ". project-name . edit";
            }
          .project-name{
            grid-area:project-name;
            text-align:center;
          }
          .edit{
            grid-area:edit;
            text-align:center;
            border:solid;
          }
          
          .back-to-projects{
            border:solid;
            border-color:black;
          }
          
          .project-table{
            margin:0 auto;
            border-collapse:collapse;
            width:80%;
            text-align:center;
          }
          .tasks-table{
            margin:0 auto;
            border-collapse:collapse;
            width:80%;
            text-align:center;
          }
          
        </style>
    </head>
    <body class="body">
        
        <div class="top">プロジェクト詳細</div>
        
      <br>
      <div class="top-container">
        <div class="project-name">{{$project->name}}</div>
        <div class="edit"><a href="/projects/{{$project->id}}/edit">編集</a></div>
      </div>
      
      <br>
      <table border="1" class="project-table">
        <tr><th>SPI</th><th>CPI</th><th>開始予定日</th><th>完了予定日</th><th>開始日</th><th>完了日</th></tr>
        <tr><td>{{$project->cpi()}}</td><td>{{$project->spi()}}</td><td>{{$project->start_scheduled_on}}</td><td>{{$project->complete_scheduled_on}}</td><td>{{$project->started_on}}</td><td>{{$project->completed_on}}</td></tr>
      </table>
      
      <br>
      <div style="text-align:center">
        <a href="/projects" class="back-to-projects">プロジェクト一覧に戻る</a>
      </div>
      
      <br>
      <table border="1" class="tasks-table">
        <tr><th>タスク名</th><th>予定日</th><th>実施日</th><th>PV</th><th>EV</th><th>AC</th></tr>
        @foreach ($tasks as $task)
        <tr><td><a href="/tasks/{{$task->id}}">{{$task->name}}</a></td><td>{{$task->due_on}}</td><td>{{$task->done_on}}</td><td>{{$task->planned_value}}</td><td>{{$task->earned_value}}</td><td>{{$task->actual_cost}}</td></tr>
        @endforeach
      </table>
      
    </body>
</html>
