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
          .back-to-project{
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
        
        <div class="top">プロジェクト編集</div>
      
      
      <form method="POST" action="/projects/{{$project->id}}">
          @csrf
          @method('PUT')
          
          プロジェクト名<br/>
        <input type="text" name="project[name]" value="{{$project->name}}"><br/>
        @error('project.name')
        <input type="text" name="project[name]" value="{{ old('project.name') }}"><br/>
        @enderror
        <p style="color:red">{{ $errors->first('project.name') }}</p>
        <div style="text-align:center">
          <input type="submit" value="完了">
        </div>
      </form>
      
      
      <br>
      <div style="text-align:center">
        <a href="/projects" class="back-to-projects">プロジェクト一覧に戻る</a>
        <a href="/projects/{{$project->id}}" class="back-to-project">プロジェクト詳細に戻る</a>
      </div>
      
      <br>
      <table border="1" class="tasks-table">
        <tr><th>タスク名</th><th>開始予定日</th><th>完了予定日</th><th>開始日</th><th>完了日</th><th>PV</th><th>EV</th><th>AC</th></tr>
        @foreach ($tasks as $task)
        <tr><td><a href="/tasks/{{$task->id}}">{{$task->name}}</a></td><td>{{$task->start_scheduled_on}}</td><td>{{$task->complete_scheduled_on}}</td><td>{{$task->started_on}}</td><td>{{$task->completed_on}}</td><td>{{$task->planned_value}}</td><td>{{$task->earned_value}}</td><td>{{$task->actual_cost}}</td></tr>
        @endforeach
      </table>
      
      <br/>
      <form action="/projects/{{ $project->id }}"  method="post" style="text-align:center;">
        @csrf
        @method('DELETE')
        <button type="submit">プロジェクト削除</button> 
      </form>
      
    </body>
</html>
