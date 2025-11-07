<?php

namespace App\Services;

use App\Models\{Race, RaceCheckpoint, RaceLog, TeamMember};
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RaceLogService
{
    public function record(int $raceId, int $memberId, int $checkpointId, string $reachedAt): RaceLog
    {
        return DB::transaction(function () use ($raceId, $memberId, $checkpointId, $reachedAt) {
            $race = Race::with('checkpoints')->findOrFail($raceId);
            $member = TeamMember::findOrFail($memberId);
            $checkpoint = RaceCheckpoint::where('race_id', $raceId)->findOrFail($checkpointId);

            if ($member->race_id !== $raceId) {
                throw ValidationException::withMessages(['member_id'=>'Member is not registered in this race.']);
            }

            if (RaceLog::where(['race_id'=>$raceId,'member_id'=>$memberId,'checkpoint_id'=>$checkpointId])->exists()) {
                throw ValidationException::withMessages(['checkpoint_id'=>'Already marked for this checkpoint.']);
            }

            $currentOrder = $checkpoint->order_no;
            if ($currentOrder > 1) {
                $prevMissing = RaceCheckpoint::where('race_id', $raceId)
                    ->where('order_no','<',$currentOrder)
                    ->whereDoesntHave('logs', fn($q)=>$q->where('member_id',$memberId))
                    ->exists();
                if ($prevMissing) {
                    throw ValidationException::withMessages(['checkpoint_id'=>'Cannot skip or jump checkpoints.']);
                }
            }

            $maxOrder = $race->checkpoints->max('order_no');
            if ($currentOrder === $maxOrder && $maxOrder > 2) {
                $middleOk = RaceCheckpoint::where('race_id',$raceId)
                    ->whereBetween('order_no', [2, $maxOrder-1])
                    ->whereDoesntHave('logs', fn($q)=>$q->where('member_id',$memberId))
                    ->doesntExist();
                if (!$middleOk) {
                    throw ValidationException::withMessages(['checkpoint_id'=>'All middle checkpoints must be logged before the end.']);
                }
            }

            return RaceLog::create([
                'race_id'=>$raceId,
                'member_id'=>$memberId,
                'checkpoint_id'=>$checkpointId,
                'reached_at'=>$reachedAt,
            ]);
        });
    }
}