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
        </style>
    </head>
    <body class="body">
        
      <div class="top">タスク編集</div>
      <div class="form-container">
        <form action="/tasks/{{$task->id}}" method="POST">
          @csrf
          @method('PUT')
          
          @if(count($errors)>0)
            タスク名<br>
        <input type="text" name="task[name]" value="{{old('task.name')}}"><br>
        <p style="color:red">{{ $errors->first('task.name') }}</p>
        開始予定日<br>
        <input type="date" name="task[start_scheduled_on]" value="{{old('task.start_scheduled_on')}}"><br>
          <p style="color:red">{{ $errors->first('task.start_scheduled_on') }}</p>
        完了予定日<br>
        <input type="date" name="task[complete_scheduled_on]" value="{{old('task.complete_scheduled_on')}}"><br>
          <p style="color:red">{{ $errors->first('task.complete_scheduled_on') }}</p>
        開始日<br>
        <input type="date" name="task[started_on]" value="{{old('task.started_on')}}"><br>
          <p style="color:red">{{ $errors->first('task.started_on') }}</p>
        完了日<br>
        <input type="date" name="task[completed_on]" value="{{old('task.completed_on')}}"><br>
          <p style="color:red">{{ $errors->first('task.completed_on') }}</p>
        PV<br>
        <input type="number" name="task[planned_value]" value="{{old('task.planned_value')}}"><br>
          <p style="color:red">{{ $errors->first('task.planned_value') }}</p>
        EV<br>
        <input type="number" name="task[earned_value]" value="{{old('task.earned_value')}}"><br>
          <p style="color:red">{{ $errors->first('task.earned_value') }}</p>
        AC<br>
        <input type="number" name="task[actual_cost]" value="{{old('task.actual_cost')}}"><br>
          <p style="color:red">{{ $errors->first('task.actual_cost') }}</p>
          @else
            タスク名<br>
        <input type="text" name="task[name]" value="{{$task->name}}"><br>
        <p style="color:red">{{ $errors->first('task.name') }}</p>
        開始予定日<br>
        <input type="date" name="task[start_scheduled_on]" value="{{$task->start_scheduled_on}}"><br>
          <p style="color:red">{{ $errors->first('task.start_scheduled_on') }}</p>
        完了予定日<br>
        <input type="date" name="task[complete_scheduled_on]" value="{{$task->complete_scheduled_on}}"><br>
          <p style="color:red">{{ $errors->first('task.complete_scheduled_on') }}</p>
        開始日<br>
        <input type="date" name="task[started_on]" value="{{$task->started_on}}"><br>
          <p style="color:red">{{ $errors->first('task.started_on') }}</p>
        完了日<br>
        <input type="date" name="task[completed_on]" value="{{$task->completed_on}}"><br>
          <p style="color:red">{{ $errors->first('task.completed_on') }}</p>
        PV<br>
        <input type="number" name="task[planned_value]" value="{{$task->planned_value}}"><br>
          <p style="color:red">{{ $errors->first('task.planned_value') }}</p>
        EV<br>
        <input type="number" name="task[earned_value]" value="{{$task->earned_value}}"><br>
          <p style="color:red">{{ $errors->first('task.earned_value') }}</p>
        AC<br>
        <input type="number" name="task[actual_cost]" value="{{$task->actual_cost}}"><br>
          <p style="color:red">{{ $errors->first('task.actual_cost') }}</p>
          @endif
          
        
        <div style="text-align:center;">
          <button type="submit" >登録</button>
        </div>
      </form>
      </div>
      
      <div style="text-align:center;">
        <br/>
      <a href="/projects/{{$project->id}}" style="border:solid;border-color:black;">プロジェクト詳細に戻る</a>
      </div>
      <br/>
      <form action="/tasks/{{$task->id}}" method="POST" style="text-align:center;">
        <button type="submit"　onSubmit="return taskDeleteCheck()">削除</button>
      </form>
      
      <script type="text/javascript">
        function taskDeleteCheck(){
          if(window.confirm('タスクを削除します。よろしいですか？')) return true;
          
          window.alert('キャンセルされました。');
          return false;
        }
      </script>
    </body>
</html>
