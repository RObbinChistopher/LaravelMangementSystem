<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function allPorjects()
    {
        $project = Project::paginate(10);

        return ProjectResource::collection($project);
    }

    public function createProject(Request $request)
    {
        $project = new Project();

        $project->name = $request->name;
        $project->client_name = $request->clientName;
        $project->deadline = $request->deadline;
        $project->percentage = $request->percentage;
        $project->description = $request->description;

        $project->save();
        return response()->json(['Success' => 'Project Create SuccessFully']);
    }

    public function editPorjects(string $id)
    {
        $project = Project::findOrFail($id);
        return new ProjectResource($project);
    }
    public function UpdateProject(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $project->name = $request->name;
        $project->client_name = $request->clientName;
        $project->deadline = $request->deadline;
        $project->percentage = $request->percentage;
        $project->description = $request->description;

        $project->save();
        return response()->json(['Success' => 'Project Update SuccessFully']);
    }

    public function deleteProject(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['success' => 'Project is Delete Successfully']);
    }

    public function updatePercentage(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        if ($request->percentage) {
            $project->percentage = $request->percentage;
        }
        $project->save();
        return response()->json(['Success' => 'Project Update SuccessFully']);
    }

    public function filterPercentage($percentage)
    {
        $project = Project::where('percentage', $percentage)->paginate(10);
        return ProjectResource::collection($project);
    }
    public function ProjectSearch(Request $request)
    {
        $query = $request->input('query');

        $results = Project::where('name', 'like', "%$query%")
            ->orWhere('client_name', 'like', "%$query%")
            ->limit(5)
            ->get();

        return ProjectResource::collection($results);
    }
}
