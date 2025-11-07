<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Models\Team;

class TeamController extends Controller
{
    public function __construct(){  $this->middleware(['auth', \App\Http\Middleware\EnsureAdmin::class]); }

    public function index(){ $teams = Team::withCount('members')->paginate(10); return view('admin.teams.index', compact('teams')); }
    public function create(){ return view('admin.teams.create'); }
    public function store(StoreTeamRequest $req){ Team::create($req->validated()); return redirect()->route('admin.teams.index')->with('ok','Team created'); }
    public function edit(Team $team){ return view('admin.teams.edit', compact('team')); }
    public function update(StoreTeamRequest $req, Team $team){ $team->update($req->validated()); return back()->with('ok','Updated'); }
    public function destroy(Team $team){ $team->delete(); return back()->with('ok','Deleted'); }
}