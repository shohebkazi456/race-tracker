<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRaceLogRequest;
use App\Models\{Race, TeamMember, RaceCheckpoint, RaceLog};
use App\Services\RaceLogService;
use Illuminate\Http\Request;

class RaceLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function create()
    {
        return view('logs.create', [
            'races' => Race::orderBy('race_name')->get(),
        ]);
    }

    public function store(StoreRaceLogRequest $req, RaceLogService $service)
    {
        $d = $req->validated();
        $service->record((int)$d['race_id'], (int)$d['member_id'], (int)$d['checkpoint_id'], $d['reached_at']);
        return back()->with('ok','Checkpoint recorded!');
    }

    public function members(Request $request)
    {
        $request->validate(['race_id' => 'required|exists:races,id']);
        $raceId = (int) $request->race_id;

        $members = TeamMember::with('team')
            ->where('race_id', $raceId)
            ->orderBy('member_name')
            ->get();

        return response()->json(
            $members->map(fn($m) => [
                'id'    => $m->id,
                'label' => "[{$m->team->team_name}] {$m->member_name}",
            ])
        );
    }


    public function next(Request $request)
    {
        $request->validate([
            'race_id'   => 'required|exists:races,id',
            'member_id' => 'required|exists:team_members,id',
        ]);

        $raceId   = (int) $request->race_id;
        $memberId = (int) $request->member_id;

        $member = TeamMember::findOrFail($memberId);
        if ($member->race_id !== $raceId) {
            return response()->json(['error' => 'Member is not registered in this race.'], 422);
        }

        $cps = RaceCheckpoint::where('race_id', $raceId)->orderBy('order_no')->get();
        $doneCpIds = RaceLog::where('race_id',$raceId)->where('member_id',$memberId)->pluck('checkpoint_id')->all();

        $next = $cps->first(fn($cp) => !in_array($cp->id, $doneCpIds));
        if (!$next) {
            return response()->json(['done' => true, 'message' => 'All checkpoints completed.']);
        }

        return response()->json([
            'id'    => $next->id,
            'label' => "#{$next->order_no} — {$next->checkpoint_name}",
        ]);
    }
}