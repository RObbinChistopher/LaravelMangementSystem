<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Milestones;
use App\Models\Project;
use App\Models\Tasks;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function ShowMilestonesCount()
    {
        $milestoneCounts = [
            'complete' => Milestones::where('status', 'complete')->count(),
            'progress' => Milestones::where('status', 'progress')->count(),
            'incomplete' => Milestones::where('status', 'in-complete')->count(),
        ];

        $taskCounts = [
            'urgent' => Tasks::where('priority', 'urgent')->count(),
            'lower' => Tasks::where('priority', 'lower')->count(),
            'medium' => Tasks::where('priority', 'medium')->count(),
        ];

        $project = Project::all();

        return [
            'milestones' => $milestoneCounts,
            'tasks' => $taskCounts,
            'project' => ProjectResource::collection($project),
        ];
    }
}
