<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(){
        $userId = request()->user()->id;
        $tasks = Task::where('user_id', '=', $userId )->orderBy('created_at', 'desc')->get();

        return view('dashboard', ['tasks' => $tasks]);
    }

    public function store(){
        $userId = request()->user()->id;
        $attributes = request()->validate([
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ]);
        $attributes['user_id']=$userId;

        $tasks = Task::create($attributes);
        return to_route('task.index', ['tasks' => $tasks])->with('message', 'Tarefa criada com sucesso.');
    }

    public function update(Task $task){
        // echo '<pre>';
        // print_r($task->is_done);
        // echo '</pre>';
        // exit;
        $task->update(['is_done' => $task->is_done == 1 ? false : true]);
        $msg = $task->is_done == 0 ? 'Tarefa atualizada com sucesso.' : 'Parabéns, tarefa concluída com sucesso.';

        return to_route('task.index')->with('message', $msg);
    }
    public function delete(Task $task){
        $task->delete();
        return to_route('task.index')->with('message', 'Tarefa apaga com sucesso.');
    }
}
