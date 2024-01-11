<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskRecord;
use Illuminate\Console\View\Components\Task;
use Carbon\Carbon;

class TaskRecordController extends Controller
{
    public function getAllData(){
        $taskData = TaskRecord::get();
        $formattedTaskData = $taskData->map(function ($task) {
            if($task['deadline']) $task['deadline'] = Carbon::parse($task['deadline'])->format('Y-m-d H:i');
            return $task;
        });
        return $formattedTaskData;
    }

    public function insert(Request $request){
        $task = $request->task;
        \DB::beginTransaction();

        try {
            if($task){
                $newTask = new TaskRecord();
                $newTask->task_name = $task['task_name'];
                $newTask->status = $task['status'];
                $newTask->deadline = $task['deadline'];
                $newTask->created_by = 'user';
                $newTask->save();
                \DB::commit();
                return 'success';
            }
        } catch (\Exception $e) {
            \DB::rollback();
            return $e->getMessage();
        }

    }

    public function update(Request $request){
        $taskToUpdate = $request->task;
        \DB::beginTransaction();
        try {
            if($taskToUpdate){
                $newTask = TaskRecord::find($taskToUpdate['id']);
                if($newTask->exists()){
                    $newTask->task_name = $taskToUpdate['task_name'];
                    $newTask->status = $taskToUpdate['status'];
                    $newTask->deadline = $taskToUpdate['deadline'];
                    $newTask->created_by = 'user';
                    $newTask->save();
                    \DB::commit();
                    return 'success';
                }else{
                    return 'data not existing';
                }
            }
        } catch (\Exception $e) {
            \DB::rollback();
            return $e->getMessage();
        }
    }

    public function delete(Request $request){
        $taskToDelete = $request->task;
        \DB::beginTransaction();
        try {
            if($taskToDelete){
                $newTask = TaskRecord::find($taskToDelete['id']);
                if($newTask->exists()) $newTask->delete();
                \DB::commit();
                return 'success';
            }
        } catch (\Exception $e) {
            \DB::rollback();
            return $e->getMessage();
        }
    }
}
