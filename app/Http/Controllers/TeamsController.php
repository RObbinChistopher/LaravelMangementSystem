<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeamMembersResource;
use App\Http\Resources\TeamResource;
use App\Models\TeamMember;
use App\Models\TeamName;
use App\Models\Teams;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    // teams 


    public function showTeam()
    {
        $team = Teams::paginate(9);
        return TeamResource::collection($team);
    }

    public function showAllTeam()
    {
        $team = Teams::all();
        return TeamResource::collection($team);
    }
    public function storeTeamName(Request $request)
    {
        $team = new Teams();
        $team->team_name = $request->team_name;
        $team->save();

        return response()->json(['success' => 'Team Create successfully']);
    }
    public function editTeam(string $id)
    {
        $team = Teams::findOrFail($id);
        return new TeamResource($team);
    }
    public function updateTeamName(Request $request, string $id)
    {
        $team = Teams::findOrFail($id);
        $team->team_name = $request->team_name;
        $team->save();

        return response()->json(['success' => 'Team Update successfully']);
    }
    public function DeleteTeam(string $id)
    {
        $team = Teams::findOrFail($id);
        $team->delete();
        return response()->json(['success' => 'Team Delete successfully']);
    }


    // teams members

    public function showTeamMembrs(string $id)
    {
        $member = TeamMember::where('team_id', $id)->paginate(10);
        return TeamMembersResource::collection($member);
    }
    public function editTeamMembrs(string $id)
    {
        $member = TeamMember::findOrFail($id);
        return new TeamMembersResource($member);
    }
    public function storeTeamMembrs(Request $request)
    {
        $member = new TeamMember();
        $member->team_id = $request->team_id;
        $member->member_id = $request->member_id;
        $member->project_id = $request->project_id;
        $member->assigned_date = $request->assigned_date;
        $member->save();
        return response()->json(['success' => 'Team Member Create successfully']);
    }
    public function updateTeamMembrs(Request $request, string $id)
    {
        $member = TeamMember::findOrFail($id);
        $member->team_id = $request->team_id;
        $member->member_id = $request->member_id;
        $member->project_id = $request->project_id;
        $member->assigned_date = $request->assigned_date;
        $member->save();
        return response()->json(['success' => 'Team Member Update successfully']);
    }
    public function deleteTeamMembrs(string $id)
    {
        $member = TeamMember::findOrFail($id);
        $member->delete();
        return response()->json(['success' => 'Team Member delete successfully']);
    }
}
