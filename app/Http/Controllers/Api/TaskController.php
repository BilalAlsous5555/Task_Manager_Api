<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class TaskController extends Controller
{

    public function index()
    {
        if(Gate::allows('is_Admin')){
            return response()->json(['message'=>'Welcome Admin Here are list of tasks',
            'Tasks_list_with_status_and_comments'=>Task::with(['status','comments'])->get()]);
        }
        return response()->json([ 'message' => "you are not the admin so will show only your tasks" ,
        'Your Tasks'=>Task::where('user_id', Auth::user()->id)->with(['status', 'comments'])->get()]) ;
    }


    public function store(StoreTaskRequest $request)
    {
        // Admin give tasks for users
        if(Gate::allows('is_Admin')){
            $validated =$request->validated();
            $task = Task::create($validated);
            return response()->json([
                'message'=>'Task Stored Successfully By Admin',
                'Task' => $task,
                201
            ]);
        }
        return response()->json([ 'message' => "You are not Authorized to store any task" ,403]) ;
    }


    public function show(string $id)
    { 
        $task = Task::find($id);
        // user can only show his own tasks but admin can show any task
        if(Gate::denies('task_show',$task))
        {
            return response()->json([ 'message' => "You are not Authorized to show others tasks" ,403]) ;
        }
        return $task? response()->json([
            'message' => 'task found successfully',
            'Task' => $task ,
        ])
        :
        response()->json([
            'message' => 'task does not fuond ',
        ]);
    }


    public function update(UpdateTaskRequest $request, string $id)
    {   // Admin update tasks for users
        if(Gate::allows('is_Admin')){
            $task = Task::find($id);
            $task->update($request->validated());
            return response()->json(['message' => 'the task was updated by admin !', 'Task' => $task]);
        }
        return response()->json([ 'message' => "You are not Authorized to update any task" ,403]) ;
    }


    public function destroy(string $id)
    {
        if(Gate::allows('is_Admin')){
            $task = Task::find($id);
            $task->delete();
            return response()->json(['message' => 'the task was deleted by admin !' ]);
        }
        return response()->json([ 'message' => "You are not Authorized to delete any task" ,403]) ;
    }

    public function search()
    {
        if (Gate::allows('is_Admin')) {
            $search = request('key');
    
            if ($search !== null) {
                $tasks = Task::where('task_content', 'like', "%{$search}%")
                    ->orWhere('priority', 'like', "%{$search}%")
                    ->orWhere('user_id', $search)
                    ->orWhere('status_id', $search)
                    ->get();
    
                if ($tasks->isNotEmpty()) {
                    return response()->json([
                        'message' => 'Tasks found by admin!',
                        'Tasks' => $tasks
                    ]);
                }
    
                return response()->json([
                    'message' => 'No tasks found for the given search key'
                ]);
            }
    
            return response()->json([
                'message' => 'Search key is required'
            ], 422);
        }
    
        return response()->json([
            'message' => 'You are not authorized to search tasks'
        ], 403);
    }
    
}
