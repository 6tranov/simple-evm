<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        
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
                "none1 create none2 top";
            }
          .none1{
            grid-area:none1;
          }
          .create{
            grid-area:create;
            border:solid;
            text-align:center;
          }
          .none2{
            grid-area:none2;
          }
          .top{
            grid-area:top;
            border:solid;
          }
          
          .container1{
            display:grid;
            grid-template-columns: 1fr auto;
            grid-template-areas:
              "name edit";
          }
          .container2{
            display:grid;
            grid-template-areas:
              "spi cpi";
          }
          .name{
            grid-area: name;
            border:solid;
            text-align:center;
          }
          .edit{
            grid-area:edit;
            border:solid;
            text-align:center;
          }
          .spi{
            grid-area:spi;
            border:solid;
            text-align:center;
          }
          .cpi{
            grid-area:cpi;
            border:solid;
            text-align:center;
          }
          
          .project{
            width: 50%;
            margin:0 auto;
          }
        </style>
    </head>
    <body class="body">
        
        <div class="top">プロジェクト一覧</div>
        
      <br>
      <div class="top-container">
        <div class="none1"></div>
        <div class="create"><a href="/projects/create">新規プロジェクト作成</a></div>
        <div class="none2"></div>
        <div class="top"><a href="/">トップ</a></div>
      </div>
      
        @foreach ($projects as $project)
      <br/>
      
          <div class="project">
              <div class="container1">
                  <div class="name"><a href="/projects/{{$project->id}}">{{$project->name}}</a></div>
                  <div class="edit"><a href="/projects/{{$project->id}}/edit">編集</a></div>
              </div>
              <div class="container2">
                  <div class="spi">SPI:{{$project->spi()}}</div>
                  <div class="cpi">CPI:{{$project->cpi()}}</div>
              </div>
          </div>
      
        @endforeach
      
      <br/>
        <div class="paginate">
            {{$projects->links()}}
        </div>
      
    </body>
</html>
