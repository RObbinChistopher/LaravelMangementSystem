<?php

namespace App\Http\Controllers;

use App\Http\Resources\MilestoneResource;
use App\Models\Milestones;
use Illuminate\Http\Request;

class MilestonesController extends Controller
{
    public function getAllMilestones()
    {
        $milestones = Milestones::all();
        return MilestoneResource::collection($milestones);
    }
    public function allMilestones()
    {
        $milestones = Milestones::orderBy('id', 'desc')->paginate(10);
        return MilestoneResource::collection($milestones);
    }

    public function createMilestones(Request $request)
    {
        $milestone = new Milestones();

        $milestone->name = $request->name;
        $milestone->projectId = $request->projectId;
        $milestone->deadline = $request->deadline;
        $milestone->status = $request->status;
        $milestone->description = $request->description;
        $milestone->save();

        return response()->json(['success' => 'Milestores Create SuccessFully']);
    }

    public function editMileStone(string $id)
    {
        $milestone = Milestones::findOrFail($id);
        return new MilestoneResource($milestone);
    }
    public function updateMilestones(Request $request, string $id)
    {
        $milestone = Milestones::findOrFail($id);

        $milestone->name = $request->name;
        $milestone->projectId = $request->projectId;
        $milestone->deadline = $request->deadline;
        $milestone->status = $request->status;
        $milestone->description = $request->description;
        $milestone->save();

        return response()->json(['success' => 'Milestores Update SuccessFully']);
    }
    public function deleteMileStone(string $id)
    {
        $milestone = Milestones::findOrFail($id);
        $milestone->delete();
        return response()->json(['success' => 'MileStone Delete Successfully']);
    }


    public function updateStatusMilestone(Request $request, string $id)
    {
        $milestone = Milestones::findOrFail($id);
        if ($request->status) {
            $milestone->status = $request->status;
        }
        $milestone->save();
        return response()->json(['success' => 'Milestone Status Update SuccessFully']);
    }

    public function MilestonesStatus($status)
    {
        $milestone = Milestones::where('status', $status)->paginate(10);
        return MilestoneResource::collection($milestone);
    }

    public function MilestonesSearch(Request $request)
    {
        // Adjust to access the nested query
        $query = $request->input('query.query');

        if (!$query) {
            return response()->json(['message' => 'Query parameter is missing.'], 400);
        }
        $results = Milestones::select('milestones.*')
            ->join('projects', 'milestones.projectId', '=', 'projects.id')
            ->where('milestones.name', 'like', "%$query%")
            ->orWhere('projects.name', 'like', "%$query%")
            ->limit(9)
            ->get();

        return MilestoneResource::collection($results);
    }
}
