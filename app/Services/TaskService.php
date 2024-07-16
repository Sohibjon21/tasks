<?php

namespace App\Services;

use App\Models\Task;
use Carbon\Carbon;
use Exception;

class TaskService
{
    public function index($validator, $request)
    {
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        $tasks = Task::query();

        if ($request->has('status')) {
            $tasks->where('status', '=', $data['status']);
        }

        if ($request->has('deadline_from')) {
            $tasks->whereDate('deadline', '>=', Carbon::parse($data['deadline_from']));
        }

        if ($request->has('deadline_to')) {
            $tasks->whereDate('deadline', '<=', Carbon::parse($data['deadline_to']));
        }

        return $tasks->get();
    }

    public function store($validator)
    {
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            Task::create($validator->validated());
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return true;
    }

    public function update($validator, $task, $request)
    {
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!$request->hasAny(['title', 'description', 'status', 'deadline'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Хотя бы одно из полей должно быть изменено.'
            ]);
        }

        try {
            $task->update($validator->validated());
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return true;
    }

    public function destroy($task)
    {
        try {
            $task->delete();
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        return true;
    }
}
