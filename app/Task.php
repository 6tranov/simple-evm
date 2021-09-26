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
        'started_on',
        'completed_on',
        'planned_value',
        'earned_value',
        'actual_cost',
        'project_id',
        'order_index',
        //'previous_task_id',
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
        //$previous_task_id = NULL;
        $start_datetime = new \DateTime($start);
        $complete_datetime = new \DateTime($start);
        for ($i = 0; $i < $dateSpan; $i++) {
            $order_index = $i+1;
            $data = [
                'name' => $task_name[$i],
                'start_scheduled_on' =>$start_datetime->format('Y/m/d'),
                'complete_scheduled_on' => $complete_datetime->format('Y/m/d'),
                'planned_value' => $planned_value,
                'earned_value'=>0,
                'actual_cost'=>0,
                'project_id' => $project_id,
                'order_index' => $order_index,
                //'previous_task_id' => $previous_task_id,
                ];
            //$this->fill($data)->save();
            $task = new Task($data);
            $task->save();
            
            $start_datetime->modify('+1day');
            $complete_datetime->modify('+1day');
            //$previous_task_id = $task->id;
        }
    }
    
    public static function getFirstTaskByProjectId($project_id){
        return DB::table('tasks')->where('project_id',$project_id)->orderBy('order_index')->first();
    }
    public static function getLastTaskByProjectId($project_id){
        //DB::enableQueryLog();
        return DB::table('tasks')->where('project_id',$project_id)->orderBy('order_index','desc')->first();
        /*
        return  DB::table('tasks')->where('project_id',$project_id)->whereNotIn('id',function($query){
            $query->select('previous_task_id')->from('tasks')->whereNotNull('previous_task_id');
        })->first();
        */
        //dd(DB::getQueryLog());
        //return $result;
    }
    public function getProject(){
        return DB::table('projects')->where('id',$this->project_id)->first();
    }
    public static function getOrderedTasksArrayByProjectId($project_id){
        //順番を変えられる（開始予定と完了予定が等しい）タスクを取得する。
        //そして日付ごとに配列にして、2次元の配列をreturnする。
        $tasks = DB::table('tasks')->where('project_id',$project_id)->whereColumn('start_scheduled_on','complete_scheduled_on')->orderBy('order_index')->get();
    
        //2つ以上同じ日付のものがあるタスクに絞る
        //まず、2つ以上存在する日付を抽出する。
        $is_extracted = false;
        $formerDate = NULL;
        $extractedDates = [];
        foreach ($tasks as $task) {
            if(($formerDate == $task->start_scheduled_on) && !$is_extracted){
                $extractedDates[]=$task->start_scheduled_on;
                $is_extracted = true;
            } elseif ($formerDate !== $task->start_scheduled_on){
                $is_extracted = false;
            }
            $formerDate = $task->start_scheduled_on;
        }
        
        function hasExtractedDate($task,$extractedDates){
            foreach ($extractedDates as $date) {
                if($date == $task->start_scheduled_on) return true;
            }
            return false;
        }
        
        //抽出された日付を持つタスクだけを抽出する。
        $extractedTasks = [];
        foreach ($tasks as $task) {
            if(hasExtractedDate($task,$extractedDates)){
                $extractedTasks[]=$task;
            }
        }
        
        if(count($extractedTasks) == 0)return [];
        
    
        //日付ごとに分割する
        $i = 0;
        $formerDate = $extractedTasks[0]->start_scheduled_on;
        $result = [];
        foreach ($extractedTasks as $task) {
            if($formerDate !== $task->start_scheduled_on) $i++;
            $result[$i][] = $task;
            $formerDate = $task->start_scheduled_on;
        }
        
        return $result;
    }
}
