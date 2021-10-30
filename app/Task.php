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
    ];
    
    public static function getTasksByProjectId($project_id){
        $tasks = DB::table('tasks')->where('project_id',$project_id)->orderBy('order_index')->get();
        return $tasks;
    }
    
    public static function saveFromInput($input){
        DB::beginTransaction();
        //$inputの内容
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
                ];
            //$this->fill($data)->save();
            $task = new Task($data);
            $task->save();
            
            $start_datetime->modify('+1day');
            $complete_datetime->modify('+1day');
        }
        
        
        if(Task::checkFailed($exception)){
            DB::rollBack();
            throw $exception;
        } else{
            DB::commit();
        }
    }
    public function update(array $attributes = [], array $options = []){
        DB::beginTransaction();
        
        parent::update($attributes,$options);
        
        if(Task::checkFailed($exception)){
            DB::rollBack();
            throw $exception;
        } else{
            DB::commit();
        }
    }
    public function updateTask($input){
        $name = $input['name'];
        $started_on = $input['started_on'];
        $completed_on = $input['completed_on'];
        $pv = $input['planned_value'];
        $ev = $input['earned_value'];
        $ac = $input['actual_cost'];
        
        $old_start_scheduled_on = $this->start_scheduled_on;
        $old_complete_scheduled_on = $this->complete_scheduled_on;
        $new_start_scheduled_on = $input['start_scheduled_on'];
        $new_complete_scheduled_on = $input['complete_scheduled_on'];
        
        
        DB::beginTransaction();
        
        //dd($old_start_scheduled_on);
        
        /*
        プロジェクトIDで絞る。
        編集対称のタスクをtと呼称する。
        
        タスクを3つの領域（ABC）に分ける。
        Aは変更前のtよりも前のタスク。
        Bは変更前のtよりも後で変更後のtよりも前のタスク。
        Cは変更後のtよりも後のタスク。
        
        Aのorder_indexは変える必要はない。
        
        Cのorder_indexを変える必要はない。
        */
        
        //後方に移動する(1)
        function isMoveToPosterior($new_start_scheduled_on,$old_start_scheduled_on,$new_complete_scheduled_on,$old_complete_scheduled_on){
            return ($new_start_scheduled_on > $old_start_scheduled_on) ||
            ($new_start_scheduled_on == $old_start_scheduled_on && $new_complete_scheduled_on > $old_complete_scheduled_on);
        }
        
        //前方に移動する(2)
        function isMoveToAnterior($new_start_scheduled_on,$old_start_scheduled_on){
            return $new_start_scheduled_on < $old_start_scheduled_on;
        }
        
        if(isMoveToPosterior($new_start_scheduled_on,$old_start_scheduled_on,$new_complete_scheduled_on,$old_complete_scheduled_on)){
            //Bの取得
            $B = DB::table('tasks')->where('project_id',$this->project_id)
                ->where('order_index','>',$this->order_index)
                ->where('complete_scheduled_on','<=',$new_start_scheduled_on);
                
            //Bの数の取得
            $Bcount = count($B->get() ?? []);
                
            //Bのorder_indexの修正
            $B->decrement('order_index');
            
            //tの修正
            $newOrderIndex = $this->order_index + $Bcount;
            $data = [
                'id'=>$this->id,
                'name'=>$name,
                'project_id'=>$this->project_id,
                'order_index'=>$newOrderIndex,
                'start_scheduled_on'=>$new_start_scheduled_on,
                'complete_scheduled_on'=>$new_complete_scheduled_on,
                'started_on'=>$started_on,
                'completed_on'=>$completed_on,
                'planned_value'=>$pv,
                'earned_value'=>$ev,
                'actual_cost'=>$ac,
                ];
            $this->fill($data)->parentSave();
        } elseif(isMoveToAnterior($new_start_scheduled_on,$old_start_scheduled_on)){
            //Bの取得
            $B = DB::table('tasks')->where('project_id',$this->project_id)
                ->where('order_index','<',$this->order_index)
                ->where('start_scheduled_on','>=',$new_complete_scheduled_on);
                
            //Bの数の取得
            $Bcount = count($B->get() ?? []);
            
            //Bのorder_indexの修正
            $B->increment('order_index');
            
            //tの修正
            $newOrderIndex = $this->order_index - $Bcount;
            $data = [
                'id'=>$this->id,
                'name'=>$name,
                'project_id'=>$this->project_id,
                'order_index'=>$newOrderIndex,
                'start_scheduled_on'=>$new_start_scheduled_on,
                'complete_scheduled_on'=>$new_complete_scheduled_on,
                'started_on'=>$started_on,
                'completed_on'=>$completed_on,
                'planned_value'=>$pv,
                'earned_value'=>$ev,
                'actual_cost'=>$ac,
                ];
            $this->fill($data)->parentSave();
            
        } else{
            //tの順番に変更はなし
            $data = [
                'id'=>$this->id,
                'name'=>$name,
                'project_id'=>$this->project_id,
                'order_index'=>$this->order_index,
                'start_scheduled_on'=>$new_start_scheduled_on,
                'complete_scheduled_on'=>$new_complete_scheduled_on,
                'started_on'=>$started_on,
                'completed_on'=>$completed_on,
                'planned_value'=>$pv,
                'earned_value'=>$ev,
                'actual_cost'=>$ac,
                ];
            $this->fill($data)->parentSave();
        }
        
        if(Task::checkFailed($exception)){
            DB::rollBack();
            throw $exception;
        } else{
            DB::commit();
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
    private static function getOrderedTasksByProjectId($project_id){
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
        
        return $extractedTasks;
    }
    public function save(array $options = [])//Override
    {
        DB::beginTransaction();
        parent::save();
        if(Task::checkFailed($exception)){
            DB::rollBack();
            throw $exception;
        } else{
            DB::commit();
        }
    }
    //制約の確認。テーブルに操作を加えるメソッドはすべて中で
    //トランザクションでこのメソッドを最後に実装する。
    //親クラスのsaveなどもオーバーライドして同様に実装する。
    private static function checkFailed(&$exception):bool{
        /*
        1. start_scheduled_onは、一つ前のタスクのcomplete_scheduled_onまたはそれ以降
        2. (start_scheduled_on,complete_scheduled_on)は、order_indexで並び替えたもの(A)と
            start_scheduled_on、complete_scheduled_onの順に並び変えたもの(B)の
            全てのレコードに対して、AのフィールドとBのフィールドが一致する。
        3. 一つのプロジェクトに対して、order_indexは重複しない。
        4. 一つのプロジェクトに対して、order_indexは0から始まる連番である。
        */
        
        //1
        //project_id、order_indexで並び替えたサブクエリ
        $q1 = DB::table('tasks')->select('order_index','project_id','start_scheduled_on',)->orderBy('project_id')->orderBy('order_index')->toSql();
        //project_id、order_indexで並び替え、取得したidに1を加えたサブクエリ
        $q2 = DB::table('tasks')->selectRaw("order_index+1 as order_index_pp,project_id,complete_scheduled_on")->orderBy('project_id')->orderBy('order_index')->toSql();
        //それらを結合する
        $result1 = DB::table(DB::Raw('('.$q1.') as c1'))->join(DB::Raw('('.$q2.') as c2'),function($join){
            $join->on("c1.order_index","=","c2.order_index_pp")//ここが違うので直す。order_indexを0か1から順の連番にしてそれを使う。
            ->on("c1.project_id","=","c2.project_id")
            ->on("c1.start_scheduled_on","<","c2.complete_scheduled_on");
        })->first();
        //この結果がnullになっていれば正常。nullでなければ前のタスクの終了日が開始日よりも後になっているものが存在する。
        //それはおかしいのでtrueを返す。
        if(!is_null($result1)){
            $exception = new \Exception("start_scheduled_onは、一つ前のタスクのcomplete_scheduled_onまたはそれ以降である必要があります。");
            
            $a = DB::table('tasks')->orderBy('project_id')->orderBy('order_index')->get();
            dd($a);
            return true;
        }
        
        
        //2
        //order_indexで並び替えたサブクエリ
        $idQuery = DB::table('tasks')->select('id','project_id','start_scheduled_on','complete_scheduled_on')->orderBy('project_id')->orderBy('order_index')->toSql();
        //日付で並び替えたサブクエリ
        $dateQuery = DB::table('tasks')->select('id','project_id','start_scheduled_on','complete_scheduled_on')->orderBy('project_id')->orderBy('start_scheduled_on')->orderBy('complete_scheduled_on')->toSql();
        //それらを結合する
        $result2 = DB::table(DB::Raw('('.$idQuery.') as c1'))->join(DB::Raw('('.$dateQuery.') as c2'),function ($join) {
            $join->on("c1.id","=","c2.id")
            ->on("c1.start_scheduled_on","!=","c2.start_scheduled_on")
            ->on("c1.complete_scheduled_on","!=","c2.complete_scheduled_on");
        })->first();
        //この結果がnullになっていれば正常。nullでなければorder_indexの並びがおかしいのでtrueを返す。
        if(!is_null($result2)){
            $exception = new \Exception("order_indexの並び順がおかしいです。");
            return true;
        }
        

        //3
        //もし特定のプロジェクトに対してorder_indexに重複があれば、
        //project_idとorder_indexの組み合わせでcountが2以上になるものが存在するはず。それがあったらおかしいのでtrueを返す。
        $result3 = DB::table('tasks')->selectRaw('count(order_index)')->groupBy('project_id', 'order_index')->havingRaw('count(order_index)>1')->get();
        if(count($result3)>0){
            $exception = new \Exception("あるプロジェクトに対してorder_indexが重複しているタスクがあります。");
            return true;
        }
        
        //4
        //order_indexの最小値が1、最大値がタスクの数になっていればよい（重複がないことは3で既に保証済みなので）
        $result4 = DB::table('tasks')->groupBy('project_id')->selectRaw('min(order_index) as min, max(order_index) as max, count(order_index) as count')->havingRaw('min != 1 or max != count')->get();
        if(count($result4)>0){
            $exception = new \Exception("order_indexが連番になっていません。");
            return true;
        }
        return false;
    }
    public static function updateOrders($idArray,$project_id){
        DB::beginTransaction();
        
        //old_order_indexの列を取得する。
        $old_ordered_tasks = Task::getOrderedTasksByProjectId($project_id);
        for ($i = 0; $i < count($idArray); $i++) {
            $old_order_index = $old_ordered_tasks[$i]->order_index;
            $id = $idArray[$i];
            
            //taskのorder_indexのみ登録しなおす。
            $task=Task::find($id);
            $input = [
                'id'=>$task->id,
                'name'=>$task->name,
                'project_id'=>$task->project_id,
                'order_index'=>$old_order_index,
                'start_scheduled_on'=>$task->start_scheduled_on,
                'complete_scheduled_on'=>$task->complete_scheduled_on,
                'planned_value'=>$task->planned_value,
                'earned_value'=>$task->earned_value,
                'actual_cost'=>$task->actual_cost,
                ];
            $task->fill($input)->parentSave();
        }
        
        if(Task::checkFailed($exception)){
            DB::rollBack();
            throw $exception;
        } else{
            DB::commit();
        }
        
    }
    private function parentSave(){
        parent::save();
    }
    public static function add($input){
        $name = $input['name'];
        $started_on = $input['started_on'];
        $completed_on = $input['completed_on'];
        $pv = $input['planned_value'];
        $ev = $input['earned_value'];
        $ac = $input['actual_cost'];
        
        $old_start_scheduled_on = $this->start_scheduled_on;
        $old_complete_scheduled_on = $this->complete_scheduled_on;
        $new_start_scheduled_on = $input['start_scheduled_on'];
        $new_complete_scheduled_on = $input['complete_scheduled_on'];
        
        //comment
    }
}
