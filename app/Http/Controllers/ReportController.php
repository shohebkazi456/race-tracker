<?php

namespace App\Http\Controllers;

use App\Models\{Race, Team, TeamMember, RaceLog};

use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function __construct(){ $this->middleware(['auth', \App\Http\Middleware\EnsureAdmin::class])->only(['race','team']); }

    public function race(Race $race)
    {
        $checkpoints = $race->checkpoints()->get();
        $startOrder = $checkpoints->min('order_no');
        $endOrder   = $checkpoints->max('order_no');

        $members = TeamMember::where('race_id',$race->id)->with('team')->get()
            ->map(function($m) use ($race,$checkpoints,$startOrder,$endOrder){
                $logs = $m->logs()->where('race_id',$race->id)->get()->keyBy('checkpoint_id');
                $times = [];
                foreach($checkpoints as $cp){ $times[$cp->order_no] = $logs[$cp->id]->reached_at ?? null; }
                $startId = $checkpoints->where('order_no',$startOrder)->first()->id ?? null;
                $endId   = $checkpoints->where('order_no',$endOrder)->first()->id ?? null;
                $start = $startId ? ($logs[$startId]->reached_at ?? null) : null;
                $end   = $endId ? ($logs[$endId]->reached_at ?? null) : null;
                $dur = $start && $end ? $end->diff($start) : null;
                $durSec = $dur ? ($dur->days*86400 + $dur->h*3600 + $dur->i*60 + $dur->s) : null;
                return ['member'=>$m,'times'=>$times,'duration'=>$dur,'duration_seconds'=>$durSec];
            })
            ->sortBy(fn($r)=>$r['duration_seconds'] ?? PHP_INT_MAX)->values();

        return view('reports.race', compact('race','checkpoints','members'));
    }

    public function team(Race $race)
    {
        $checkpoints = $race->checkpoints()->get();
        $startOrder = $checkpoints->min('order_no');
        $endOrder   = $checkpoints->max('order_no');

        $teamStats = Team::with(['members'=>fn($q)=>$q->where('race_id',$race->id)])->get()
            ->map(function($team) use ($race,$checkpoints,$startOrder,$endOrder){
                $secs = [];
                foreach($team->members as $m){
                    $logs = $m->logs()->where('race_id',$race->id)->get()->keyBy('checkpoint_id');
                    $startId = $checkpoints->where('order_no',$startOrder)->first()->id ?? null;
                    $endId   = $checkpoints->where('order_no',$endOrder)->first()->id ?? null;
                    $start = $startId ? ($logs[$startId]->reached_at ?? null) : null;
                    $end   = $endId ? ($logs[$endId]->reached_at ?? null) : null;
                    if($start && $end){ $secs[] = $end->diffInSeconds($start); }
                }
                $avg = count($secs) ? array_sum($secs)/count($secs) : null;
                return ['team'=>$team,'avg_seconds'=>$avg];
            })
            ->filter(fn($t)=>!is_null($t['avg_seconds']))->sortBy('avg_seconds')->values();

        return view('reports.team', compact('race','teamStats'));
    }

    public function raceCsv(Race $race): StreamedResponse
{
    $checkpoints = $race->checkpoints()->orderBy('order_no')->get();
    $members = \App\Models\TeamMember::where('race_id', $race->id)->with('team')->get();

    return response()->streamDownload(function () use ($members, $checkpoints, $race) {
        $out = fopen('php://output', 'w');
        $header = ['Member','Team'];
        foreach ($checkpoints as $cp) { $header[] = "#{$cp->order_no} {$cp->checkpoint_name}"; }
        $header[] = 'Total Time (seconds)';
        fputcsv($out, $header);

        foreach ($members as $m) {
            $logs = $m->logs()->where('race_id',$race->id)->get()->keyBy('checkpoint_id');
            $row = [$m->member_name, $m->team->team_name];
            $start = $checkpoints->first()?->id;
            $end   = $checkpoints->last()?->id;
            $startAt = $start ? ($logs[$start]->reached_at ?? null) : null;
            $endAt   = $end   ? ($logs[$end]->reached_at ?? null)   : null;

            foreach ($checkpoints as $cp) {
                $row[] = optional($logs[$cp->id] ?? null)->reached_at?->format('Y-m-d H:i:s') ?? '';
            }

            $secs = ($startAt && $endAt) ? $endAt->diffInSeconds($startAt) : null;
            $row[] = $secs ?? '';
            fputcsv($out, $row);
        }
        fclose($out);
    }, 'race_report_'.$race->id.'.csv');
}

public function teamCsv(Race $race): StreamedResponse
{
    $teams = \App\Models\Team::with(['members' => fn($q) => $q->where('race_id',$race->id)])->get();
    $checkpoints = $race->checkpoints()->orderBy('order_no')->get();
    $start = $checkpoints->first()?->id;
    $end   = $checkpoints->last()?->id;

    return response()->streamDownload(function () use ($teams, $race, $start, $end) {
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Team','Avg Completion (sec)']);

        foreach ($teams as $team) {
            $secs = [];
            foreach ($team->members as $m) {
                $logs = $m->logs()->where('race_id',$race->id)->get()->keyBy('checkpoint_id');
                $s = $start ? ($logs[$start]->reached_at ?? null) : null;
                $e = $end   ? ($logs[$end]->reached_at ?? null)   : null;
                if ($s && $e) $secs[] = $e->diffInSeconds($s);
            }
            $avg = count($secs) ? array_sum($secs)/count($secs) : null;
            fputcsv($out, [$team->team_name, $avg ?? '']);
        }
        fclose($out);
    }, 'team_ranking_'.$race->id.'.csv');
}

}