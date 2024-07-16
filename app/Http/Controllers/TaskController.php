<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new TaskService;
    }
    public function index(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'status' => 'nullable|in:todo,in_progress,completed',
            'deadline_from' => 'date',
            'deadline_to' => 'date',
        ]);

        $tasks = $this->service->index($validator, $request);

        return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => '',
            'status' => 'nullable|in:todo,in_progress,completed',
            'deadline' => 'nullable|date'
        ]);

        if ($this->service->store($validator)) {
            return response()->json([
                'status' => 'success'
            ],201);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'title' => '',
            'description' => '',
            'status' => 'nullable|in:in_progress,completed',
            'deadline' => 'nullable|date',
        ]);


        if ($this->service->update($validator, $task, $request)) {
            return response()->json(['status' => 'success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($this->service->destroy($task)) {
            return response()->json([
                'status' => 'success'
            ]);
        }
    }
}
