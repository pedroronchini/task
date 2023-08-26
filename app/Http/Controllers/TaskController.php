<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index()
    {

        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'attached_files' => 'nullable|array',
            'completed' => 'boolean',
            'user_id' => 'required|exists:users,id'
        ]);

        $task = Task::create($data);

        return response()->json($task);
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, $id) 
    {
        $task = Task::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'attached_files' => 'nullable|array',
            'completed' => 'boolean',
            'user_id' => 'required|exists:users,id'
        ]);

        $task->update($data);
        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
