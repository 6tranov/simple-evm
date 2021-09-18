<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    //
    public function spi(){
        $evSum = DB::table('tasks')->where('project_id',$this->id)->sum('earned_value') ?? 0;
        $pvSum = DB::table('tasks')->where('project_id',$this->id)->sum('planned_value');
        return $evSum / $pvSum;
    }
    public function cpi(){
        $evSum = DB::table('tasks')->where('project_id',$this->id)->sum('earned_value') ?? 0;
        $acSum = DB::table('tasks')->where('project_id',$this->id)->sum('actual_cost') ?? 0;
        if($acSum === 0){
            return 0;
        } else{
            return $evSum / $acSum;
        }
    }
    public function getByLimit(int $limit_count = 10){
        return $this->limit($limit_count)->get();
    }
    public function getPaginateByLimit(int $limit_count = 10){
        return $this->paginate($limit_count);
    }
}
