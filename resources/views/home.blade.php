@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
                
                
            </div>
            
            <br/>
            <div style="text-align:center; padding:0 auto;">
                <a href="/profile" style="border:solid; text-align:center; padding:0 auto;">プロフィール</a>
            </div>
            <br/>
            <div style="text-align:center; padding:0 auto;">
                <a href="/projects" style="border:solid; text-align:center; padding:0 auto;">プロジェクト一覧</a>
            </div>
            
        </div>
    </div>
</div>
@endsection
