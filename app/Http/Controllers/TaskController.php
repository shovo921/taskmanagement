<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function showtodotask(){
        $task= Task::where('status',1)->get();
        return response()->json($task);
    }
    public function showprogresstask(){
        $task= Task::where('status',2)->get();
        return response()->json($task);
    }
    public function showdonetask(){
        $task= Task::where('status',3)->get();
        return response()->json($task);
    }

    public function inserttask(Request $request)
    {
        // $name=$request->name;
        // $status =$request->status;

        $data =Task::insert([
            'name' =>$request->taskname,
            'status' =>1,
    
             ]);
             return response()->json($data);
      


    }
    public function update(Request $request,$id){

    
        $data=Task::findorfail($id)->update([
        'status' =>$request->status,
  
        ]);
        return response()->json($data);
     
        }
}
