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
          
          .form-container{
            width:80%;
            margin:0 auto;
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
        
      <div class="top">タスクの順番編集</div>
      @if(count($tasksArray)==0)
          <br>
          <div style="text-align:center">該当のタスクはありません。</div>
      @else
      <div class="form-container">
        <form action="/projects/{{$project->id}}/task-orders" method="POST">
          @csrf
          @method('PUT')
         
          @foreach ($tasksArray as $tasks)
            <br>
            <table border="1" class="tasks-table">
              <tr><th>タスク名</th><th>開始予定日</th><th>完了予定日</th><th>開始日</th><th>完了日</th><th>PV</th><th>EV</th><th>AC</th></tr>
              @foreach ($tasks as $task)
                <tr><td><a href="/tasks/{{$task->id}}">{{$task->name}}</a></td><td>{{$task->start_scheduled_on}}</td><td>{{$task->complete_scheduled_on}}</td><td>{{$task->started_on}}</td><td>{{$task->completed_on}}</td><td>{{$task->planned_value}}</td><td>{{$task->earned_value}}</td><td>{{$task->actual_cost}}</td></tr>
                <input type="hidden" name="old_task_order[]" value="{{$task->order_index}}">
                <input type="hidden" name="new_task_order[]" value="{{$task->order_index}}">
                <input type="hidden" name="id[]" value="{{$task->id}}">
              @endforeach
            </table>
          @endforeach
          
          <br>
        <div style="text-align:center;">
          <button type="submit" >登録</button>
        </div>
      </form>
      </div>
      @endif
      
      <div style="text-align:center;">
        <br/>
      <a href="/projects/{{$project->id}}" style="border:solid;border-color:black;">プロジェクト詳細に戻る</a>
      </div>
    </body>
</html>
