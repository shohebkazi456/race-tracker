<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamMemberRequest;
use App\Models\{Team, TeamMember, Race};

class TeamMemberController extends Controller
{
    public function __construct(){  $this->middleware(['auth', \App\Http\Middleware\EnsureAdmin::class]); }

    public function index(){ $members = TeamMember::with(['team','race'])->paginate(15); return view('admin.members.index', compact('members')); }
    public function create(){ return view('admin.members.create', ['teams'=>Team::all(),'races'=>Race::all()]); }
    public function store(StoreTeamMemberRequest $req){ TeamMember::create($req->validated()); return redirect()->route('admin.members.index')->with('ok','Member created'); }
    public function edit(TeamMember $member){ return view('admin.members.edit', ['member'=>$member,'teams'=>Team::all(),'races'=>Race::all()]); }
    public function update(StoreTeamMemberRequest $req, TeamMember $member){ $member->update($req->validated()); return back()->with('ok','Updated'); }
    public function destroy(TeamMember $member){ $member->delete(); return back()->with('ok','Deleted'); }
}