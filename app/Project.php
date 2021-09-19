<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    //
    protected $fillable = [
        "name",
        "start_scheduled_on",
        "complete_scheduled_on",
        "user_id",
        ];
    public function spi(){
        $evSum = DB::table('tasks')->where('project_id',$this->id)->sum('earned_value') ?? 0;
        $pvSum = DB::table('tasks')->where('project_id',$this->id)->sum('planned_value');
        if($pvSum === 0) return 0;
        return $evSum / $pvSum;
    }
    public function cpi(){
        $evSum = DB::table('tasks')->where('project_id',$this->id)->sum('earned_value') ?? 0;
        $acSum = DB::table('tasks')->where('project_id',$this->id)->sum('actual_cost') ?? 0;
        if($acSum === 0) return 0;
        return $evSum / $acSum;
    }
    public function getByLimit(int $limit_count = 10){
        return $this->limit($limit_count)->get();
    }
    public function getPaginateByLimit(int $limit_count = 10,bool $isUsersRecords = true){
        if($isUsersRecords) return $this->where('user_id',Auth::id())->paginate($limit_count);
        return $this->paginate($limit_count);
    }
    public function saveFromInput($input){
        //projectsにレコードを追加
        $data = [
        'name' => $input['name'],
        'start_scheduled_on' => $input['start_scheduled_on'],
        'complete_scheduled_on' => $input['complete_scheduled_on'],
        'user_id' => Auth::id(),
        ];
        $this->fill($data)->save();
        
        //tasksにレコードを追加
        $data = [
            'start_scheduled_on' => $input['start_scheduled_on'],
            'complete_scheduled_on' => $input['complete_scheduled_on'],
            'time_per_day' => $input['time_per_day'],
            'total_cost' => $input['total_cost'],
            'project_id' => $this->id,//$project->id,
        ];
        Task::saveFromInput($data);
    }
    
}
