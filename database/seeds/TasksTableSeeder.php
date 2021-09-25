<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // 初期化
        DB::table('tasks')->delete();
        
        //最初のプロジェクトのidを取得
        $projects = DB::table('projects')->get();
        
        for ($i = 0; $i < 3; $i++) {
             $project_id = $projects[$i]->id;
            // タスクのレコードをそれぞれのプロジェクトに対して3つずつ挿入
            DB::table('tasks')->insert(
                [
                    'start_scheduled_on' => '2021-1-1',
                    'complete_scheduled_on' => '2021-1-1',
                    'planned_value' => 30,
                    'project_id' => $project_id,
                    'order_index' => 1,
                    'name' => 'task1',
                ]
            );
        
            //$tasks = DB::table('tasks')->get();
            //$first_task_id = $tasks[0]->id;
        
            DB::table('tasks')->insert(
                [
                    'start_scheduled_on' => '2021-1-2',
                    'complete_scheduled_on' => '2021-1-2',
                    'planned_value' => 30,
                    'project_id' => $project_id,
                    //'previous_task_id' => $first_task_id,
                    'order_index' => 2,
                    'name' => 'task2',
                ]
            );
        
            //$tasks = DB::table('tasks')->get();
            //$second_task_id = $tasks[1]->id;
        
            DB::table('tasks')->insert(
                [
                    'start_scheduled_on' => '2021-1-3',
                    'complete_scheduled_on' => '2021-1-3',
                    'planned_value' => 30,
                    'project_id' => $project_id,
                    //'previous_task_id' => $second_task_id,
                    'order_index' => 3,
                    'name' => 'task3',
                ]
            );
        }
        
    }
}
