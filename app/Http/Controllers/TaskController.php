<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
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
            'completed_at' => 'nullable|date',
            'user_id' => 'required|exists:users,id'
        ]);

        $task = Task::create($data);

        return response()->json($task, Response::HTTP_CREATED);
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
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'attached_files' => 'nullable|array',
            'completed' => 'boolean',
            'completed_at' => 'nullable|date',
            'user_id' => 'required|exists:users,id'
        ]);

        $array_update = [
            'title' => $data['title'] ?? $task->title,
            'description' => $data['description'] ?? $task->description,
            'attached_files' => $data['attached_files'] ?? $task->attached_files,
            'completed' => $data['completed'] ?? $task->completed,
            'completed_at' => $data['completed_at'] ?? Carbon::now(),
            'user_id' => $data['user_id'] ?? $task->user_id
        ];

        $task->update($array_update);
        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
