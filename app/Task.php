<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    //
    protected $fillable = [
        'name',
        'start_scheduled_on',
        'complete_scheduled_on',
        'planned_value',
        'project_id',
        'previous_task_id',
    ];
    
    public static function getTasksByProjectId($project_id){
        $tasks = DB::table('tasks')->where('project_id',$project_id)->get();
        return $tasks;
    }
    
    public static function saveFromInput($input){
        $start = $input['start_scheduled_on'];
        $complete = $input['complete_scheduled_on'];
        $planned_value = $input['time_per_day'];
        $project_id = $input['project_id'];
        $total_cost = $input['total_cost'];
        
        $dateSpan = (strtotime($complete) - strtotime($start)) / 86400 + 1;
        if($dateSpan < 0){
            throw new Exception('日付の順番がおかしいです。');
        }
        
        //1日当たりのcostの計算
        for ($i = 0; $i < $dateSpan; $i++) {
            $costs[$i] = (int)($total_cost / $dateSpan);
        }
        for ($i = $total_cost % $dateSpan-1; $i >= 0; $i--) {
            $costs[$i] += 1;
        }
        
        //コストの合計の計算
        $cost_sum[0] = $costs[0];
        for ($i = 1; $i < $dateSpan; $i++) {
             $cost_sum[$i] = $cost_sum[$i-1] + $costs[$i];
        }
        
        //タスク名の生成
        $task_name[0] = "タスク0(1～".$cost_sum[0].")";
        for ($i = 1; $i < $dateSpan; $i++) {
            $task_name[$i] = "タスク{$i}(".($cost_sum[$i-1]+1)."～".$cost_sum[$i].")";
        }
        
        //タスクの登録
        $previous_task_id = NULL;
        $start_datetime = new \DateTime($start);
        $complete_datetime = new \DateTime($complete);
        for ($i = 0; $i < $dateSpan; $i++) {
            $data = [
                'name' => $task_name[$i],
                'start_scheduled_on' =>$start_datetime->modify('+' .$i. 'day')->format('Y/m/d'),
                'complete_scheduled_on' => $complete_datetime->modify('+' .$i. 'day')->format('Y/m/d'),
                'planned_value' => $planned_value,
                'project_id' => $project_id,
                'previous_task_id' => $previous_task_id,
                ];
            //$this->fill($data)->save();
            $task = new Task($data);
            $task->save();
            $previous_task_id = $task->id;
        }
    }
    
    public static function getFirstTaskByProjectId($project_id){
        return DB::table('tasks')->where('project_id',$project_id)->where('previous_task_id',NULL)->first();
    }
    public static function getLastTaskByProjectId($project_id){
        //DB::enableQueryLog();
        return  DB::table('tasks')->where('project_id',$project_id)->whereNotIn('id',function($query){
            $query->select('previous_task_id')->from('tasks')->whereNotNull('previous_task_id');
        })->first();
        
        //dd(DB::getQueryLog());
        //return $result;
    }
}
