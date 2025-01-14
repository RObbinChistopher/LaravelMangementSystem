<?php

namespace App\Http\Controllers;

use App\Http\Resources\TasksResource;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Mail\TasksMail;

class TasksController extends Controller
{
    public function sendTaskEmail(Request $request)
    {
        // Get the task data from the request
        $task = [
            'name' => $request->input('name'),
            'milestoneId' => $request->input('milestoneId'),
            'deadline' => $request->input('deadline'),
            'userId' => $request->input('userId'),
            'priority' => $request->input('priority'),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
            'email' => $request->input('email'),  // Dynamic email
            'position' => $request->input('position'),  // Dynamic position
            'userName' => $request->input('userName'),  // Dynamic position
        ];
    
        // Get recipient email
        $recipientEmail = $task['email'];
    
        // Send email using a Mailable class
        Mail::to($recipientEmail)->send(new TasksMail($task));
    
        return response()->json(['message' => 'Email sent successfully']);
    }    


    public function ShowTasks(Request $request)
    {
        $user = auth()->user();
        if ($user->role == 'Team-Member') {
            $tasks = Tasks::where('userId', $user->id)
                ->orderBy("id", "desc")
                ->paginate(10);
        } else {
            $tasks = Tasks::orderBy("id", "desc")
                ->paginate(10);
        }

        return TasksResource::collection($tasks);
    }


    public function storeTasks(Request $request)
    {
        $task = new Tasks();

        $task->name = $request->name;
        $task->milestoneId = $request->milestoneId;
        $task->userId = $request->userId;
        $task->deadline = $request->deadline;
        $task->priority = $request->priority;
        $task->status = $request->status;
        $task->description = $request->description;

        $task->save();

        return response()->json(['Success' => 'Task Create Successfully']);
    }

    public function editTasks(string $id)
    {
        $tasks = Tasks::findOrFail($id);
        return new TasksResource($tasks);
    }
    public function UpdateTasks(Request $request, string $id)
    {
        $task = Tasks::findOrFail($id);

        $task->name = $request->name;
        $task->milestoneId = $request->milestoneId;
        $task->userId = $request->userId;
        $task->deadline = $request->deadline;
        $task->priority = $request->priority;
        $task->status = $request->status;
        $task->description = $request->description;

        $task->save();

        return response()->json(['Success' => 'Task Update Successfully']);
    }
    public function deleteTasks(string $id)
    {
        $tasks = Tasks::findOrFail($id);
        $tasks->delete();
        return response()->json(['Success' => 'Task Delete Successfully']);
    }

    public function FilttleTasks($task)
    {
        $tasks = Tasks::where('priority', $task)->paginate(10);
        return TasksResource::collection($tasks);
    }

    public function searchTasks(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['message' => 'Query parameter is missing.'], 400);
        }
        $results = Tasks::select('tasks.*')
            ->join('users', 'tasks.userId', '=', 'users.id')
            ->where('tasks.name', 'like', "%$query%")
            ->orWhere('users.name', 'like', "%$query%")
            ->limit(9)
            ->get();

        return TasksResource::collection($results);
    }
    public function UpdateStatusTasks(Request $request, string $id)
    {
        $tasks = Tasks::findOrFail($id);

        if ($request->status) {
            $tasks->status = $request->status;
        }
        if ($request->priority) {
            $tasks->priority = $request->priority;
        }
        $tasks->save();

        return response()->json(['Success' => 'Tasks Update Successfully']);
    }
}
