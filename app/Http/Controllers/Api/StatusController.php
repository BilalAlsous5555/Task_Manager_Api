<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StatusController extends Controller
{

    public function index()
    {
        if(Gate::allows('is_Admin')){
            return response()->json(['message'=>'Welcome Admin Here are list of Status',
            'Status_list'=>Status::with(['tasks'])->get()]);
        }
        return response()->json([ 'message' => "you are not the admin so will show only your status" ,
        'Your Tasks_With_Status'=>Task::where('user_id', Auth::user()->id)->with(['status', 'comments'])->get()]) ;
    }


    public function store(Request $request)
    {
        // Admin give tasks for users
        if(Gate::allows('is_Admin')){
            $validated = $request->validate([
                'state'=>'boolean|required',
            ]);
            $status = Status::create($validated);
            return response()->json([
                'message'=>'Status Stored Successfully By Admin',
                'Task' => $status,
                201
            ]);
        }
        return response()->json([ 'message' => "You are not Authorized to store any status" ,403]) ;
    }


    public function show(string $id)
    {
        $status = Status::find($id);
        // user can only show his own status but admin can show any task
        if(Gate::denies('is_Admin'))
        {
            return response()->json([ 'message' => "You are not Authorized to show others status" ,403]) ;
        }
        return $status? response()->json([
            'message' => 'status found successfully',
            'Status' => $status ,
        ])
        :
        response()->json([
            'message' => 'status does not fuond ',
        ]);
    }

    public function update(Request $request, string $id)
    {   // Admin update status for users
        if(Gate::allows('is_Admin')){
            $status = Status::find($id);
            $validated = $request->validate([
                'state'=>'boolean|required',
            ]);
            $status->update($validated);
            return response()->json(['message' => 'the status was updated by admin !', 'Status' => $status]);
        }
        return response()->json([ 'message' => "You are not Authorized to update any status" ,403]) ;
    }

    public function destroy(string $id)
    {
        if(Gate::allows('is_Admin')){
            $status = Status::find($id);
            $status->delete();
            return response()->json(['message' => 'the stauts was deleted by admin !']);
        }
        return response()->json([ 'message' => "You are not Authorized to delete any status" ,403]) ;
    }
}
