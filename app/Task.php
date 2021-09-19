<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    //
    protected $fillable = [
        'name',
        'due_on',
        'planned_value',
        'project_id',
        'previous_task_id',
    ];
    
    public static function getTasksByProjectId($project_id){
        $tasks = DB::table('tasks')->where('project_id',$project_id)->get();
        return $tasks;
    }
    
    public static function saveFromInput($input){
        //(ok)due_on,(ok)planned_value,(ok)project_id,(ok)previous_task_id,(ok)name
        $planned_value = $input['time_per_day'];
        $dateSpan = (strtotime($input['complete_scheduled_on']) - strtotime($input['start_scheduled_on'])) / 86400 + 1;
        if($dateSpan < 0){
            throw new Exception('日付の順番がおかしいです。');
        }
        
        //1日当たりのcostの計算
        $total_cost = $input['total_cost'];
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
        $datetime = new \DateTime($input['start_scheduled_on']);
        for ($i = 0; $i < $dateSpan; $i++) {
            $data = [
                'name' => $task_name[$i],
                'due_on' =>$datetime->modify('+' .$i. 'day')->format('Y/m/d'),
                'planned_value' => $planned_value,
                'project_id' => $input['project_id'],
                'previous_task_id' => $previous_task_id,
                ];
            //$this->fill($data)->save();
            $task = new Task($data);
            $task->save();
            $previous_task_id = $task->id;
        }
    }
}
