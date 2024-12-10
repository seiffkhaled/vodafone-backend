<?php

namespace App\Http\Controllers\Api\user_tasks;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks ordered by creation date in descending order.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Task::class);
        $query = Task::query();
        $query->where('user_id', auth()->id());

        if ($request->has('status')) {
            $status = $request->input('status');
            if (in_array($status, Task::getTaskStatus())) {
                $query->where('status', $status);
            }
        }
        if ($request->has(['start_date', 'end_date'])) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('due_date', [$startDate, $endDate]);
        }
        $tasks = $query->paginate(5);
        return response()->json($tasks);
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'start_date' => 'required|date|before_or_equal:due_date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Pending,Completed,Overdue',
        ]);
        $task = Task::create($request->all());
        return response()->json([
            "message" => "Task created successfully",
            "task" => new TaskResource($task)
        ], 201);
    }
    public function show(Request $request, $id)
    {
        $task = Task::find($id);
        Gate::authorize('view', $task);
        return response()->json($task);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'start_date' => 'required|date|before_or_equal:due_date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Pending,Completed,Overdue',
        ]);
        $task = Task::find($id);
        Gate::authorize('update', $task);
        $task->update($request->all());
        return response()->json($task);
    }
    public function destroy(Request $request, $id)
    {

        $task = Task::find($id);
        Gate::authorize('delete', $task);
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
    public function batchDelete(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        Gate::authorize('delete', Task::class);
        $deletedCount = Task::where('user_id', auth()->id())
            ->whereBetween('due_date', [$validated['start_date'], $validated['end_date']])
            ->delete();

        return response()->json([
            'message' => "Tasks deleted successfully.",
            'deleted_count' => $deletedCount,
        ]);
    }
    public function restoreLast(Request $request)
    {
        $task = Task::onlyTrashed()
            ->where('user_id', auth()->id())
            ->latest('deleted_at')
            ->first();
        if (!$task) {
            return response()->json([
                'message' => 'No deleted tasks found to restore.',
            ], 404);
        }
        $task->restore();
        return response()->json([
            'message' => 'Task restored successfully.',
            'task' => $task,
        ]);
    }
}
